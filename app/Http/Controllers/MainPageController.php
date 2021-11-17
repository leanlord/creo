<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Plugins\Filter;
use App\Plugins\Settings\FlatsSettings;
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

        return view('pages.home', ['succes' => true]);
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
        $query = DB::table('flats')
            ->select(FlatsSettings::getFlatsAttributes());

        foreach (FlatsSettings::getRelatedTables() as $table => $communicationField) {
            $query->leftJoin($table, 'flats.' . $communicationField, '=', $table . '.id');
        }

        foreach (FlatsSettings::getStringFilteringAttributes() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $allFilteringAttributes[$attribute]);
        }

        foreach (FlatsSettings::getIntFilteringAttributes() as $attribute) {
            $query->whereBetween('flats.' . $attribute, [
                $allFilteringAttributes['min_' . $attribute],
                $allFilteringAttributes['max_' . $attribute]
            ]);
        }

        $allFlats = $query->paginate(9)->items();

        if (empty($allFlats)) {
            redirect('/');
            exit();
        }

        $data["flats"] = $allFlats;
        $prices = $squares = $cities = $companies = [];
        foreach ($allFlats as $flat) {

            // Приводим значения к массиву для удобного поиска
            // максимального\минимального значения
            $prices[] = $flat->price;
            $squares[] = $flat->square;
            $cities[] = $flat->city;
            $areas[] = $flat->area;
            $companies[] = $flat->company;
        }

        // Вычисление максимальных\минимальных значений
        $data["attributes"]["maxPrice"] = max($prices);
        $data["attributes"]["minPrice"] = min($prices);
        $data["attributes"]["maxSquare"] = max($squares);
        $data["attributes"]["minSquare"] = min($squares);

        foreach (FlatsSettings::getStringFilteringAttributes() as $attribute => $value) {
            $data['attributes'][$attribute] = $$attribute;
        }

        // Делаем значения массивов уникальными
        foreach ($data["attributes"] as $attributeName => $attributeValues) {
            if (gettype($attributeValues) == 'array') {
                $data["attributes"][$attributeName] = array_unique($attributeValues);
            }
        }

        return $data;
    }
}
