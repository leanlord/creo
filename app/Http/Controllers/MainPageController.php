<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Plugins\Filters\BaseFilter;
use App\Plugins\Filters\NumericFilter;
use App\Plugins\Filters\StringFilter;
use App\Plugins\Settings\FlatsSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

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
        if ($request->ajax()) {
            return view('includes.flats', ['data' => static::getAllFlats($request)]);
        }

        return view('pages.home', ['data' => static::getAllFlats($request)]);
    }

    /**
     * Sends form data from main page
     *
     * @param Request $request
     */
    public function send(Request $request)
    {
        $validatedFields = $request->validate([
            'number' => 'required',
            'name' => 'required'
        ]);

        $message = new Message();
        $message->number = $validatedFields['number'];
        $message->name = $validatedFields['name'];

        $message->save();

        return redirect('/');
    }

    /**
     * Returns all data about flats
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    // TODO попробовать забиндить фильтры в service провайдере
    // TODO сделать фильтры под шаблон Decorator
    public static function getAllFlats(Request $request)
    {
        // Выбираем только необходимые аттрибуты
        $query = DB::table('flats')
            ->select(FlatsSettings::getFlatsAttributes());

        // Присоединение всех связанных таблиц
        foreach (FlatsSettings::getRelatedTables() as $table => $communicationField) {
            $query->leftJoin($table, 'flats.' . $communicationField, '=', $table . '.id');
        }

        $stringFilter = new StringFilter($request);
        $stringFilter->filter($query);
        $intFilter = new NumericFilter($request);
        $intFilter->filter($query);

        $allFlats = $query->paginate(9)->items();

        $data["flats"] = $allFlats;

        $prices = $squares = $cities = $companies = $areas = [];
        foreach ($allFlats as $flat) {
            // Заполнение массивов для выборки максимального\минимального значения
            $prices[] = $flat->price;
            $squares[] = $flat->square;
            $cities[] = $flat->city;
            $areas[] = $flat->area;
            $companies[] = $flat->company;
        }

        if (!empty($allFlats)) {
            $data["attributes"]["maxPrice"] = $intFilter->filteringValues['max_price'];
            $data["attributes"]["minPrice"] = $intFilter->filteringValues['min_price'];
            $data["attributes"]["maxSquare"] = $intFilter->filteringValues['max_square'];
            $data["attributes"]["minSquare"] = $intFilter->filteringValues['min_square'];

            // Вставление данных из связанных таблиц
            foreach (FlatsSettings::getRelatedTablesNames() as $table) {
                $data['attributes'][$table] = $$table;
            }

            // Делаем значения массивов уникальными
            foreach ($data["attributes"] as $attributeName => $attributeValues) {
                if (gettype($attributeValues) == 'array') {
                    $data["attributes"][$attributeName] = array_unique($attributeValues);
                }
            }
        }

        return $data;
    }
}
