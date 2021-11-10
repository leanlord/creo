<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Models\Flats;
use App\Plugins\Filter;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    /**
     * Shows main page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('pages.home', ['data' => static::getAllFlats($request)]);
    }

    /**
     * Shows all flats (for AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showFlatsSection(Request $request)
    {
        return view('includes.flats', ['data' => static::getAllFlats($request)]);
    }

    /**
     * Returns all data about flats
     *
     * @param Request $request
     * @return array
     */
    public static function getAllFlats(Request $request): array
    {
        /*
         * Получение и обработка всех параметров
         * GET запроса для запроса в БД
         */
        $allAttributes = Filter::getAllAttributes($request);

        // Запрос в БД - фильтрация
        $filteredFlats = Flats::where('company_id', 'like', $allAttributes['company_id'])
            ->where('area_id', 'like', $allAttributes['area_id'])
            ->where('city_id', 'like', $allAttributes['city_id'])
            ->whereBetween('price', [$allAttributes['min_price'], $allAttributes['max_price']])
            ->whereBetween('square', [$allAttributes['min_square'], $allAttributes['max_square']])
            ->paginate(9);

        /*
         * Заполнение происходит таким образом:
         * выбираются только те значения столбцов,
         * которые используются в связанной таблице.
         * Если есть город, к которому не принадлежит
         * ни одна квартира, то такой город выведен не будет
         */
        $data["allCities"] = Filter::getUniqueColumnValues('city');
        $data["allCompanies"] = Filter::getUniqueColumnValues('company');
        $data["allAreas"] = Filter::getUniqueColumnValues('area');
        // "Отрезаем" лишние строковые атрибуты, которые не нужны на фронтенде
        $data["allValues"] = array_slice($allAttributes, Filter::getCountOfStringAttributes());

        // Заполняем массив всех квартир
        foreach ($filteredFlats as $flat) {
            $flatData = $flat->getAttributes();

            /*
             * Индекс городов в массиве $data["allCities"]
             * численно равен cities.id - 1 этого города в базе данных
            */
            $flatData["city"] = $data["allCities"] [$flat["city_id"] - 1];
            $flatData["company"] = $data["allCompanies"] [$flat["company_id"] - 1];
            $flatData["area"] = $data["allAreas"] [$flat["area_id"] - 1];

            $data["allFlats"][] = $flatData;
        }

        return $data;
    }
}
