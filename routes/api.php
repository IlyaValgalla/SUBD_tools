<?php
use App\Http\Controllers\api\CategoryControllerApi;
use App\Http\Controllers\api\EquipmentControllerApi;
use App\Http\Controllers\api\RentalControllerApi;
use App\Http\Controllers\api\UserControllerApi;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use http\Client\Request;




/////////////// ТЕСТОВЫЕ МАРШРУТЫ ///////////////////

Route::get('/debug-config-full', function () {
    return response()->json([
        'yandex_disk_config' => config('filesystems.disks.yandex'),
        'env_vars' => [
            'AWS_BUCKET' => env('AWS_BUCKET'),
            'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION'),
            'AWS_ENDPOINT' => env('AWS_ENDPOINT'),
            'AWS_USE_PATH_STYLE_ENDPOINT' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
            'AWS_ACCESS_KEY_ID_exists' => !empty(env('AWS_ACCESS_KEY_ID')),
            'AWS_SECRET_ACCESS_KEY_exists' => !empty(env('AWS_SECRET_ACCESS_KEY')),
        ],
        'storage_disks_available' => array_keys(config('filesystems.disks'))
    ]);
});

Route::get('/check-bucket-direct', function () {
    try {
        $s3Client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
            'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'use_path_style_endpoint' => true,
        ]);

        $result = $s3Client->headBucket([
            'Bucket' => env('AWS_BUCKET')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Бакет существует и доступен',
            'bucket' => env('AWS_BUCKET')
        ]);

    } catch (\Aws\Exception\AwsException $e) {
        return response()->json([
            'success' => false,
            'error_type' => 'AWS Error',
            'error_code' => $e->getAwsErrorCode(),
            'error_message' => $e->getAwsErrorMessage(),
            'suggestion' => 'Проверьте: 1) Существует ли бакет, 2) Правильные ли ключи доступа, 3) Правильный ли регион'
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error_type' => 'General Error',
            'error_message' => $e->getMessage()
        ], 500);
    }
});

Route::get('/test-credentials-fixed', function () {
    try {
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
                'verify' => false, // Отключаем SSL проверку
            ],
        ]);

        $result = $s3Client->listBuckets();
        $buckets = [];

        foreach ($result['Buckets'] as $bucket) {
            $buckets[] = $bucket['Name'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Ключи доступа работают',
            'available_buckets' => $buckets,
            'target_bucket' => env('AWS_BUCKET'),
            'bucket_exists' => in_array(env('AWS_BUCKET'), $buckets)
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'suggestion' => 'Проверьте ключи доступа в Yandex Cloud Console'
        ], 500);
    }
});

Route::get('/test-yandex-disk', function () {
    try {
        $storage = Storage::disk('yandex');

        $testPath = 'test-yandex-' . time() . '.txt';
        $testContent = 'Test from Laravel using yandex disk ' . date('Y-m-d H:i:s');

        $writeResult = $storage->put($testPath, $testContent);

        if ($writeResult) {
            $readContent = $storage->get($testPath);
            $fileExists = $storage->exists($testPath);

            return response()->json([
                'success' => true,
                'message' => 'Диск yandex работает!',
                'write_result' => $writeResult,
                'file_exists' => $fileExists,
                'content' => $readContent,
                'bucket' => env('AWS_BUCKET')
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Write failed'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'config' => [
                'bucket' => env('AWS_BUCKET'),
                'region' => env('AWS_DEFAULT_REGION'),
                'endpoint' => env('AWS_ENDPOINT'),
                'use_path_style' => env('AWS_USE_PATH_STYLE_ENDPOINT')
            ]
        ], 500);
    }
});


Route::get('/test-s3client-upload', function () {
    try {
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

        $testPath = 'test-s3client-' . time() . '.txt';
        $testContent = 'Test from S3Client ' . date('Y-m-d H:i:s');

        // Загружаем файл
        $result = $s3Client->putObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => $testPath,
            'Body'   => $testContent,
        ]);

        // Проверяем, что файл существует
        $existsResult = $s3Client->headObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => $testPath,
        ]);

        // Удаляем тестовый файл
        $deleteResult = $s3Client->deleteObject([
            'Bucket' => env('AWS_BUCKET'),
            'Key'    => $testPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'S3Client upload works!',
            'upload_result' => $result->toArray(),
            'exists_result' => $existsResult->toArray(),
            'delete_result' => $deleteResult->toArray(),
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

Route::get('/test-yandex-with-ssl-off', function () {
    try {
        $storage = Storage::disk('yandex');

        $testPath = 'test-yandex-ssl-off-' . time() . '.txt';
        $testContent = 'Test with SSL off ' . date('Y-m-d H:i:s');

        // Пробуем записать
        $writeResult = $storage->put($testPath, $testContent);

        if ($writeResult) {
            // Пробуем прочитать
            $readContent = $storage->get($testPath);
            $fileExists = $storage->exists($testPath);

            // Удаляем тестовый файл
            $storage->delete($testPath);

            return response()->json([
                'success' => true,
                'message' => 'Диск yandex работает с SSL off!',
                'write_result' => $writeResult,
                'file_exists' => $fileExists,
                'content' => $readContent,
                'bucket' => env('AWS_BUCKET')
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Write returned false'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});



/////////////// API маршруты  ///////////////////

    Route::post('login', [AuthController::class, 'login']);

    Route::get('/category/{id}', [CategoryControllerApi::class, 'show']);
    Route::get('/categories_total', [CategoryControllerApi::class, 'total']);

    Route::get('/equipment/{id}', [EquipmentControllerApi::class, 'show']);

    Route::get('/rental', [RentalControllerApi::class, 'index']);
    Route::get('/rental/{id}', [RentalControllerApi::class, 'show']);

    Route::get('/user/{id}', [UserControllerApi::class, 'show']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/equipment', [EquipmentControllerApi::class, 'index']);
        Route::get('/equipment_total', [EquipmentControllerApi::class, 'total']);
        Route::post('/create-equipment', [EquipmentControllerApi::class, 'store']);
        Route::put('/update-equipment/{id}', [EquipmentControllerApi::class, 'update']);
        Route::delete('/delete-equipment/{id}', [EquipmentControllerApi::class, 'destroy']);

        //Route::get('/user', [UserControllerApi::class, 'index']);//
        Route::get('/user', function (Request $request) {return $request->user();});

        Route::get('/category', [CategoryControllerApi::class, 'index']);
        Route::post('/create-category', [CategoryControllerApi::class, 'store']);


        Route::get('/logout', [AuthController::class, 'logout']);
    });


Route::get('/test-yandex-disk', function () {
    try {
        $storage = Storage::disk('yandex');

        // Пробуем записать файл
        $testPath = 'test-yandex-' . time() . '.txt';
        $testContent = 'Test from Laravel using yandex disk ' . date('Y-m-d H:i:s');

        $writeResult = $storage->put($testPath, $testContent);

        if ($writeResult) {
            $readContent = $storage->get($testPath);
            $fileExists = $storage->exists($testPath);

            return response()->json([
                'success' => true,
                'message' => 'Диск yandex работает!',
                'write_result' => $writeResult,
                'file_exists' => $fileExists,
                'content' => $readContent,
                'bucket' => env('AWS_BUCKET')
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Write failed'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'config' => [
                'bucket' => env('AWS_BUCKET'),
                'region' => env('AWS_DEFAULT_REGION'),
                'endpoint' => env('AWS_ENDPOINT'),
                'use_path_style' => env('AWS_USE_PATH_STYLE_ENDPOINT')
            ]
        ], 500);
    }
});

Route::get('/debug-config-full', function () {
    return response()->json([
        'yandex_disk_config' => config('filesystems.disks.yandex'),
        'env_vars' => [
            'AWS_BUCKET' => env('AWS_BUCKET'),
            'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION'),
            'AWS_ENDPOINT' => env('AWS_ENDPOINT'),
            'AWS_USE_PATH_STYLE_ENDPOINT' => env('AWS_USE_PATH_STYLE_ENDPOINT'),
            'AWS_ACCESS_KEY_ID_exists' => !empty(env('AWS_ACCESS_KEY_ID')),
            'AWS_SECRET_ACCESS_KEY_exists' => !empty(env('AWS_SECRET_ACCESS_KEY')),
        ],
        'storage_disks_available' => array_keys(config('filesystems.disks'))
    ]);
});




Route::get('/test-credentials', function () {
    try {
        // Создаем клиент без указания бакета
        $s3Client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION', 'ru-central1'),
            'endpoint' => env('AWS_ENDPOINT', 'https://storage.yandexcloud.net'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'use_path_style_endpoint' => true,
        ]);

        // Пробуем получить список бакетов
        $result = $s3Client->listBuckets();
        $buckets = [];

        foreach ($result['Buckets'] as $bucket) {
            $buckets[] = $bucket['Name'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Ключи доступа работают',
            'available_buckets' => $buckets,
            'target_bucket' => env('AWS_BUCKET'),
            'bucket_exists' => in_array(env('AWS_BUCKET'), $buckets)
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'suggestion' => 'Проверьте ключи доступа в Yandex Cloud Console'
        ], 500);
    }
});
