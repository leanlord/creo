<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Plugins\Filter;
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
     * @return array
     */
    public static function getAllFlats(Request $request): array
    {
        /*
         * Получение и обработка всех параметров
         * GET запроса для запроса в БД
         */
        $allFilteringAttributes = Filter::getAllAttributes($request);

        // Выбираем только необходимые аттрибуты
        $query = DB::table('flats')
            ->select(FlatsSettings::getFlatsAttributes());

        // Присоединение всех связанных таблиц
        foreach (FlatsSettings::getRelatedTables() as $table => $communicationField) {
            $query->leftJoin($table, 'flats.' . $communicationField, '=', $table . '.id');
        }

        // Добавление условия на все строковые аттрибуты
        foreach (FlatsSettings::getStringFilteringAttributes() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $allFilteringAttributes[$attribute]);
        }

        // Добавление условия всех минимальных\максимальных значений
        foreach (FlatsSettings::getIntFilteringAttributes() as $attribute) {
            $query->whereBetween('flats.' . $attribute, [
                $allFilteringAttributes['min_' . $attribute],
                $allFilteringAttributes['max_' . $attribute]
            ]);
        }

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
            $data["attributes"]["maxPrice"] = max($prices);
            $data["attributes"]["minPrice"] = min($prices);
            $data["attributes"]["maxSquare"] = max($squares);
            $data["attributes"]["minSquare"] = min($squares);

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
