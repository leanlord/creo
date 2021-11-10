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
     * @return array|\Illuminate\Routing\Redirector
     */
    public static function getAllFlats(Request $request)
    {
        /*
         * Получение и обработка всех параметров
         * GET запроса для запроса в БД
         */
        $allFilteringAttributes = Filter::getAllAttributes($request);

        // Выборка всех квартир с заданными условиями фильтрации
        $allFlats = DB::table('flats')

            //Присоединение всех таблиц, относящихся к данной
            ->leftJoin('cities', 'flats.city_id', '=', 'cities.id')
            ->leftJoin('companies', 'flats.company_id', '=', 'companies.id')
            ->leftJoin('areas', 'flats.area_id', '=', 'areas.id')

            // Условия выборки строковых значений
            ->where('cities.city', 'like', $allFilteringAttributes['city'])
            ->where('companies.company', 'like', $allFilteringAttributes['company'])
            ->where('areas.area', 'like', $allFilteringAttributes['area'])

            // Условия выборки числовых значений в диапазоне
            ->whereBetween('flats.price', [
                $allFilteringAttributes['min_price'],
                $allFilteringAttributes['max_price']
            ])
            ->whereBetween('flats.square', [
                $allFilteringAttributes['min_square'],
                $allFilteringAttributes['max_square']
            ])
            ->paginate(9);

        if ($allFlats->isEmpty()) {
            return redirect('/');
        }

        $data = [];
        foreach ($allFlats as $flat) {
            // Приведение объекта STDClass к массиву
            $data["flats"][] = json_decode(json_encode($flat), true);

            /*
             * Заполнение происходит таким образом:
             * заносятся только те значения столбцов,
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
