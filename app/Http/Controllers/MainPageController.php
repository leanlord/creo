<?php

namespace App\Http\Controllers;

use App\Plugins\Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $allFilteringAttributes = Filter::getAllAttributes($request);

        // Все квартиры
        $allFlats = DB::table('flats')
            ->leftJoin('cities', 'flats.city_id', '=', 'cities.id')
            ->leftJoin('companies', 'flats.company_id', '=', 'companies.id')
            ->leftJoin('areas', 'flats.area_id', '=', 'areas.id')
            ->get();

        // Фильтруем квартиры
        $data = [];
        foreach ($allFlats as $flat) {
            // Если квартира удовлетворяет всем условиям выборки
            if (
                str_contains($flat->city, $allFilteringAttributes['city']) &&
                str_contains($flat->company, $allFilteringAttributes['company']) &&
                str_contains($flat->area, $allFilteringAttributes['area']) &&
                $flat->price <= $allFilteringAttributes['max_price'] &&
                $flat->price >= $allFilteringAttributes['min_price'] &&
                $flat->square <= $allFilteringAttributes['max_square'] &&
                $flat->square >= $allFilteringAttributes['min_square']
            ) {
                // Приведение объекта STDClass к массиву
                $data["flats"][] = json_decode(json_encode($flat), true);
            }

            /*
             * Заполнение происходит таким образом:
             * выбираются только те значения столбцов,
             * которые используются в связанной таблице.
             * Если есть город, к которому не принадлежит
             * ни одна квартира, то такой город выведен не будет
             */
            $data["attributes"]["prices"][] = $flat->price;
            $data["attributes"]["squares"][] = $flat->square;
            $data["attributes"]["cities"][] = $flat->city;
            $data["attributes"]["areas"][] = $flat->area;
            $data["attributes"]["companies"][] = $flat->company;
        }

        // Вычисление максимальных\минимальных значений
        $data["attributes"]["maxPrice"] = max($data["attributes"]["prices"]);
        $data["attributes"]["minPrice"] = min($data["attributes"]["prices"]);
        $data["attributes"]["maxSquare"] = max($data["attributes"]["squares"]);
        $data["attributes"]["minSquare"] = min($data["attributes"]["squares"]);

        // Делаем значения массивов уникальными
        foreach ($data["attributes"] as $attributeName => $attributeValues) {
            if (gettype($attributeValues) == 'array') {
                $data["attributes"][$attributeName] = array_unique($attributeValues);
            }
        }

        return $data;
    }
}
