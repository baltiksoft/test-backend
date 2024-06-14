<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdsAddRequest;
use App\Models\Ads;
use Illuminate\Http\Request;

/**
 * @class AdsController - контроллер, принимающий запросы по объявлениям
 */
class AdsController extends BaseController
{

    /**
     * Получение списка объявлений
     * @return \Illuminate\Http\JsonResponse
     */
    public function all($offset = 0, $limit = 10, $sort = 'created_at', $type = 'DESC') {
        return $this->sendResponse($this->service->all($offset, $limit, $sort, $type), 'Все объявления');
    }

    /**
     * Показать объявление
     * @param $ads - идентификатор
     * @param $fields - необязательный параметр, дополнительные поля
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($ads, $fields = '') {
        return $this->sendResponse($this->service->show($ads, $fields), "Обяъвление с идентификатором - {$ads}");
    }

    public function add(AdsAddRequest $request) {

        // валидация
        $data = $request->validated();

        // добавление в БД
        $result = $this->service->add($data);

        return $this->sendResponse($result, 'Запись добавлена', 201);
    }
}
