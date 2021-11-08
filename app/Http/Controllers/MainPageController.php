<?php

namespace App\Http\Controllers;

use App\Models\Flats;
use App\Plugins\Filter;
use Illuminate\Http\Request;

class MainPageController extends Controller
{
    /**
     * Показывает главную страницу
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('pages.home', ['data' => static::getAllFlats($request)]);
    }

    public function showFlatsSection(Request $request)
    {
        return view('includes.flats', ['data' => static::getAllFlats($request)]);
    }

    /**
     * Будет использоваться как для AJAX запроса, так и
     * в функции index().
     * Возвращает верстку только квартир, а не полную страницу
     * Попробую сделать с пагинацией
     * @param Request $request
     * @return array
     */
    public static function getAllFlats(Request $request): array
    {
        // Получение и обработка всех значений из запроса
        $allAttributes = Filter::getAllAttributes($request);

        // Запрос в базу - фильтрация
        $filteredFlats = Flats::where('company', 'like', $allAttributes['company'])
            ->where('area', 'like', $allAttributes['area'])
            ->where('city', 'like', $allAttributes['city'])
            ->whereBetween('price', [$allAttributes['min_price'], $allAttributes['max_price']])
            ->whereBetween('square', [$allAttributes['min_square'], $allAttributes['max_square']])
            ->get();

        // Заполнение массива данных
        $data["allCities"] = Filter::getUniqueColumnValues('city');
        $data["allCompanies"] = Filter::getUniqueColumnValues('company');
        $data["allAreas"] = Filter::getUniqueColumnValues('area');
        // "Отрезаем" лишние строковые атрибуты, которые не нужны на фронтенде
        $data["allValues"] = array_slice($allAttributes, Filter::getCountOfStringAttributes());

        // Заполняем массив всех квартир
        foreach ($filteredFlats as $flat) {
            $data['allFlats'][] = $flat->getAttributes();
        }

        return $data;
    }
}
