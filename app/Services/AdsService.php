<?php

namespace App\Services;

use App\Models\Ads;
use App\Models\Photos;
use Illuminate\Support\Str;

/**
 * @class AdsService - класс-сервис для выполнения бизнес-логики объявления.
 * Запись в Базу данных.
 */
class AdsService
{
    /**
     * Добавить объявление
     * @param $data - объект с данными объявлениями
     * @return Int - возвращает идентификатор добавленного объявления
     */
    public function add($data) { //:Int { по тз

        // запись объявления
        $ads = Ads::create($data);

        // проверка на количество файлов
        if (count($data) > 0) {
            $fileNames = $data['filenames'];
            $fileNamesCollection = collect();
            foreach ($fileNames as $fileName) {
                $photos = new Photos();
                $photos->filename = $fileName;
                $fileNamesCollection[] = $photos;
            }
            $ads->filenames()->saveMany($fileNamesCollection);
            //$ads->filenames()->attach($fileNames);
        }

        //return $ads;
        return $ads->id;
    }

    private function baseQuery() {
        return Ads::addSelect([
            'name',
            'filename' => Photos::select('filename')->whereColumn('ads_id', 'ads.id')
            ->latest()
            ->take(1),
            'price']);
    }

    /**
     * Показать все объявления
     * @return mixed
     */
    public function all($offset, $limit, $sort, $type) {

           return $this->baseQuery()
            ->orderBy($sort, $type)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    /**
     * Вывод конкретного объявления с именем
     * @param $ads - имя объявления
     * @param $fields - список показывающий дополнительные поля
     * @return mixed
     */
    public function show($ads, $fields) {
        $query = $this->baseQuery();

        if (Str::contains($fields, 'description')) {
            $query->addSelect('description');
        }

        if (Str::contains($fields, 'photo')) {
           $query->addSelect('id')->with(['filenames' => function ($query) {
               $query->select('ads_id', 'filename')->orderBy('id');
           }]);
        }

        return $query
                ->slug($ads)
                ->first();



        // если убрать slug, то запись сводится к более простой
        // return $this->baseQuery()
        //            ->findOrFail($ads);
    }
}
