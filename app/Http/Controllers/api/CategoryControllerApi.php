<?php
//
//namespace App\Http\Controllers\api;
//
//use App\Http\Controllers\Controller;
//use App\Models\Category;
//use Illuminate\Http\Request;
//use Illuminate\Http\JsonResponse;
//use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\DB;
//use Exception;
//
//class CategoryControllerApi extends Controller
//{
//    /**
//     * Display a listing of the resource.
//     */
//    public function index(Request $request)
//    {
//        return response(Category::limit($request->perpage ?? 5)
//        ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
//        ->get());
//    }
//
//    public function total()
//    {
//        return response(Category::all()->count());
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
//
//
//
//    public function store(Request $request)
//    {
//        if (!Gate::allows('create-category')) {
//            return response()->json([
//                'code' => 1,
//                'message' => 'У вас нет прав на добавление категории',
//            ]);
//        }
//
//        $validated = $request->validate([
//            'name' => 'required|unique:categories|max:255',
//            'image' => 'required|file|image|max:10240'
//        ]);
//
//        $file = $request->file('image');
//        $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
//
//        DB::beginTransaction();
//        try {
//            // Используем S3Client напрямую
//            $s3Client = new \Aws\S3\S3Client([
//                'version' => 'latest',
//                'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
//                'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
//                'credentials' => [
//                    'key'    => env('AWS_ACCESS_KEY_ID'),
//                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
//                ],
//                'use_path_style_endpoint' => true,
//                'http' => [
//                    'verify' => false,
//                ],
//            ]);
//
//            // Загружаем файл в папку categories
//            $key = 'categories/' . $fileName;
//            $result = $s3Client->putObject([
//                'Bucket' => env('AWS_BUCKET'),
//                'Key'    => $key,
//                'Body'   => fopen($file->getRealPath(), 'r'),
//                'ACL'    => 'private',
//                'ContentType' => $file->getMimeType(),
//            ]);
//
//            // Создаем категорию
//            $category = Category::create([
//                'name' => $validated['name'],
//                'picture_url' => $key
//            ]);
//
//            DB::commit();
//
//            return response()->json([
//                'code' => 0,
//                'message' => 'Категория успешно добавлена в Yandex Cloud!',
//                'data' => [
//                    'category' => $category,
//                    'image_url' => $key,
//                    's3_result' => [
//                        'bucket' => env('AWS_BUCKET'),
//                        'key' => $key,
//                        'upload_success' => true
//                    ]
//                ]
//            ]);
//
//        } catch (Exception $e) {
//            DB::rollBack();
//
//            \Log::error('S3 upload failed: ' . $e->getMessage());
//
//            return response()->json([
//                'code' => 2,
//                'message' => 'Ошибка загрузки файла: ' . $e->getMessage(),
//            ], 500);
//        }
//    }
//
//
//
//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//        return response(Category::find($id));
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id)
//    {
//        //
//    }
//}


//// Новое
///


namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\DB;

class CategoryControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(Category::limit($request->perpage ?? 5)
            ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
            ->get());
    }

    public function total()
    {
        return response(Category::all()->count());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-category')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление категории',
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|unique:categories|max:255',
            'image' => 'required|file|image|max:10240'
        ]);

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

            // Загружаем файл в папку categories
            $key = 'categories/' . $fileName;
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

            // Создаем категорию с полным URL изображения
            $category = Category::create([
                'name' => $validated['name'],
                'picture_url' => $fullUrl  // Сохраняем полный URL (https://storage.yandexcloud.net/backet-web-tools/categories/файл.jpg)
            ]);

            DB::commit();

            return response()->json([
                'code' => 0,
                'message' => 'Категория успешно добавлена в Yandex Cloud!',
                'data' => [
                    'category' => $category,
                    'image_url' => $fullUrl,
                    's3_info' => [
                        'bucket' => $bucket,
                        'folder' => 'categories',
                        'file_name' => $fileName,
                        'key' => $key,
                        'full_url' => $fullUrl
                    ]
                ]
            ]);

        } catch (Exception $e) {
            DB::rollBack();

            \Log::error('S3 upload failed for category: ' . $e->getMessage());

            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки файла: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Category::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
