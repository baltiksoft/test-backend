## Тестовое задание

Необходимо создать сервис для хранения и подачи объявлений. Объявления должны храниться в базе данных. Сервис должен предоставлять API, работающее поверх HTTP в формате JSON.
1. Используем laravel 11.x + MySql 8 как БД.
2. 3 метода: получение списка объявлений, получение одного объявления, создание объявления.
3. Валидация полей (не больше 3 ссылок на фото, описание не больше 1000 символов, название не больше 200 символов).
4. Метод получения списка объявлений:
- Нужна пагинация, на одной странице должно присутствовать 10 объявлений
- Нужна возможность сортировки: по цене (возрастание/убывание) и по дате создания (возрастание/убывание)
- Поля в ответе: название объявления, ссылка на главное фото (первое в списке), цена
5. Метод получения конкретного объявления:
- Обязательные поля в ответе: название объявления, цена, ссылка на главное фото
- Опциональные поля (можно запросить, передав параметр fields): описание, ссылки на все фото
6. Метод создания объявления:
- Принимает все вышеперечисленные поля: название, описание, несколько ссылок на фотографии (сами фото загружать никуда не требуется), цена
- Возвращает ID созданного объявления и код результата (ошибка или успех)
7. Должны быть написаны unit тесты для backend части.
8. Сделать frontend на vuejs. В качестве оформления можно использовать любой css framework
9. Код должен быть выложен на github или gitlab.

## Результат выполнения
1. Реализованы методы API:
- создания объявления. _POST: /api/ads_ с параметрами:
  `{
  "name": "Новое объявление",
  "description": "Подробное описание объявления",
  "filenames": [
      "filename 1",
      "filename 2",
      "filename 3"
  ],
  "price": 111.0
  }`
При этом, генерируется уникальное поле **slug** по наименованию объявления для дальнейшей идентификации объявления.
- получения списка всех объявлений: _GET: /api/ads_
- получения списка всех объявлений с пагинацией: _GET: /api/ads/0/10_. Где 0 - первая запись, 10 - количество записей в ответе.
- получения списка всех объявлений с пагинацией и сортировкой: _GET: /api/ads/0/10/price/desc_. Где 0 - первая запись, 10 - количество записей в ответе, price - цена, desc - порядок сортировки.
- получение конкретного объявления: GET: _/api/ads/obieiavlenie-1_ . Где obieiavlenie-1 - уникальный идентификатор записи.
- получение конкретного объявления с дополнительными полями: GET: _/api/ads/obieiavlenie-1/fields/photos_ . Где obieiavlenie-1 - уникальный идентификатор записи, photos - поле, добавляющие ссылки в ответ.
2. Созданы unit-тесты. AdsAddText - тест проверяющие создание объявлений, AdsTest - получение объявлений.
