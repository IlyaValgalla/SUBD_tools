<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;

class EquipmentControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 5;
        $page = $request->page ?? 0;

        $equipment = Equipment::limit($perpage)
            ->offset($perpage * $page)
            ->get();

        return response()->json($equipment);
    }

    public function total()
    {
        $count = Equipment::count();
        return response()->json($count);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-equipment')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление товара',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'quantity_in_stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image' => 'required|file|image|max:10240'
        ]);

        // Проверяем существование категории
        $category = Category::find($validated['category_id']);
        if (!$category) {
            return response()->json([
                'code' => 2,
                'message' => 'Категория не найдена',
            ], 404);
        }

        $file = $request->file('image');
        $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

        DB::beginTransaction();
        try {
            // Используем S3Client напрямую
            $s3Client = new \Aws\S3\S3Client([
                'version' => 'latest',
                'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
                'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
                'credentials' => [
                    'key'    => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
                'use_path_style_endpoint' => true,
                'http' => [
                    'verify' => false,
                ],
            ]);

            // Загружаем файл в папку equipment
            $key = 'equipment/' . $fileName;
            $result = $s3Client->putObject([
                'Bucket' => env('AWS_BUCKET'),
                'Key'    => $key,
                'Body'   => fopen($file->getRealPath(), 'r'),
                'ACL'    => 'private',
                'ContentType' => $file->getMimeType(),
            ]);

            // Генерируем полный URL для Yandex Cloud Object Storage
            $bucket = env('AWS_BUCKET');
            $endpoint = env('AWS_ENDPOINT', 'https://storage.yandexcloud.net');
            $fullUrl = $endpoint . '/' . $bucket . '/' . $key;

            // Создаем товар с полным URL изображения
            $equipment = Equipment::create([
                'name' => $validated['name'],
                'category_id' => $validated['category_id'],
                'quantity_in_stock' => $validated['quantity_in_stock'],
                'price' => $validated['price'],
                'picture_url' => $fullUrl  // Сохраняем полный URL (https://storage.yandexcloud.net/backet-web-tools/equipment/файл.jpg)
            ]);

            DB::commit();

            return response()->json([
                'code' => 0,
                'message' => 'Товар успешно добавлен!',
                'data' => [
                    'equipment' => $equipment->load('category'),
                    'image_url' => $fullUrl,
                    's3_info' => [
                        'bucket' => $bucket,
                        'folder' => 'equipment',
                        'file_name' => $fileName,
                        'key' => $key,
                        'full_url' => $fullUrl
                    ]
                ]
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Equipment upload failed: ' . $e->getMessage());

            return response()->json([
                'code' => 3,
                'message' => 'Ошибка загрузки файла: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipment::with('category')->find($id);

        if (!$equipment) {
            return response()->json([
                'code' => 1,
                'message' => 'Товар не найден',
            ], 404);
        }

        return response()->json([
            'code' => 0,
            'data' => $equipment
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Gate::allows('update-equipment')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на обновление товара',
            ], 403);
        }

        $equipment = Equipment::find($id);
        if (!$equipment) {
            return response()->json([
                'code' => 2,
                'message' => 'Товар не найден',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|max:255',
            'category_id' => 'sometimes|exists:categories,id',
            'quantity_in_stock' => 'sometimes|integer|min:0',
            'price' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|file|image|max:10240'
        ]);

        DB::beginTransaction();
        try {
            // Если загружено новое изображение
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                // Используем S3Client
                $s3Client = new \Aws\S3\S3Client([
                    'version' => 'latest',
                    'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
                    'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
                    'credentials' => [
                        'key'    => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                    'use_path_style_endpoint' => true,
                    'http' => [
                        'verify' => false,
                    ],
                ]);

                // Загружаем новое изображение
                $key = 'equipment/' . $fileName;
                $result = $s3Client->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key'    => $key,
                    'Body'   => fopen($file->getRealPath(), 'r'),
                    'ACL'    => 'private',
                    'ContentType' => $file->getMimeType(),
                ]);

                // Удаляем старое изображение, если оно есть
                if ($equipment->picture_url) {
                    try {
                        $s3Client->deleteObject([
                            'Bucket' => env('AWS_BUCKET'),
                            'Key'    => $equipment->picture_url,
                        ]);
                    } catch (Exception $e) {
                        \Log::warning('Не удалось удалить старое изображение: ' . $e->getMessage());
                    }
                }

                $validated['picture_url'] = $key;
            }

            // Обновляем товар
            $equipment->update($validated);

            DB::commit();

            return response()->json([
                'code' => 0,
                'message' => 'Товар успешно обновлен',
                'data' => $equipment->load('category')
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Equipment update failed: ' . $e->getMessage());

            return response()->json([
                'code' => 3,
                'message' => 'Ошибка обновления товара: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!Gate::allows('destroy-equipment')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на удаление товара',
            ], 403);
        }

        $equipment = Equipment::find($id);
        if (!$equipment) {
            return response()->json([
                'code' => 2,
                'message' => 'Товар не найден',
            ], 404);
        }

        DB::beginTransaction();
        try {
            // Удаляем изображение из Yandex Cloud, если оно есть
            if ($equipment->picture_url) {
                $s3Client = new \Aws\S3\S3Client([
                    'version' => 'latest',
                    'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
                    'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
                    'credentials' => [
                        'key'    => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                    'use_path_style_endpoint' => true,
                    'http' => [
                        'verify' => false,
                    ],
                ]);

                try {
                    $s3Client->deleteObject([
                        'Bucket' => env('AWS_BUCKET'),
                        'Key'    => $equipment->picture_url,
                    ]);
                } catch (Exception $e) {
                    \Log::warning('Не удалось удалить изображение из Yandex Cloud: ' . $e->getMessage());
                }
            }

            // Удаляем товар из БД
            $equipment->delete();

            DB::commit();

            return response()->json([
                'code' => 0,
                'message' => 'Товар успешно удален'
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('Equipment delete failed: ' . $e->getMessage());

            return response()->json([
                'code' => 3,
                'message' => 'Ошибка удаления товара: ' . $e->getMessage(),
            ], 500);
        }
    }
}
