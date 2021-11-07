<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flats;

class MainPageController extends Controller
{
    /**
     * Показывает главную страницу
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request) {

        $data['allFlats'] = self::allFlats($request);
        $data['cities'] = Flats::all('city'); // все города

        // и так далее

        return view('home', ['data' => $data]);
    }

    /**
     * Будет использоваться как для AJAX запроса, так и
     * в функции index().
     * Возвращает верстку только квартир, а не полную страницу
     * Попробую сделать с пагинацией
     * @param Request $request
     * @return array
     */
    public function allFlats(Request $request): array
    {
        $min_price = 0; // Извлечь из базы данных наименьшее значение цены
        $max_price = 100000000; // Извлечь из базы данных наибольшее значение цены
        $type = "%";

        // Проверка GET параметров (потом потестить и посмотреть функцией dd()
        if (!empty($request->get('min_price'))) {
            $min_price = $request->get('min_price');
        }

        if (!empty($request->get('type'))) {
            $type = $request->get('min_price');
        }
        // и так далее...
        return Flats::where('type', 'like', $type)
            ->between($min_price, $max_price) // короче все квартиры с ценами выше минимальной и ниже максимальной
            ->get();
    }
}
