<?php

namespace App\Http\Controllers;

use App\Services\AdsService;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public $service;                // сервис

    public function __construct(AdsService $service) {
        $this->service = $service;
    }

    /**
     * success response method.
     * @param $result - возвращаемый результат
     * @param $message - текстовое описание возвращаемого результата
     * @param int $code - код ответа от сервера
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success' => true,          // Признак успешного выполнения (по ТЗ не нужно). В принципе, можно убрать и отслеживать код ответа.
            'data'    => $result,
            'message' => $message,      // текстовое сообщение (по ТЗ не нужно)
        ];

        // по ТЗ
        // $response = $result;

        return response()->json($response, $code);
    }

    /**
     * return error response.
     * @param $error - сообщение с текстом ошибки
     * @param array $errorMessages - список ошибок
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * Функция возвращает ответ, если маршрут не найден
     * @return \Illuminate\Http\JsonResponse
     */
    public static function notFound() {
        return response()->json([
            'success' => false,
            'message' => 'Функция не найдена.'
        ], 404);
    }
}
