<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Models\Message;
use App\Plugins\Filters\NumericFilter;
use App\Plugins\Filters\StringFilter;
use App\Plugins\Settings\FlatsSettings;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainPageController extends Controller
{
    protected StringFilter $stringFilter;
    protected NumericFilter $intFilter;
    protected Builder $query;

    public function __construct(Request $request) {

        $this->intFilter = new NumericFilter($request);
        $this->stringFilter = new StringFilter($request);

        // Выбираем только необходимые аттрибуты
        $this->query = DB::table('flats')
            ->select(FlatsSettings::getFlatsAttributes());
    }

    /**
     * Shows main page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request): \Illuminate\Contracts\View\View {
        if ($request->ajax()) {
            return view('includes.flats', ['data' => $this->getAllFlats($request)]);
        }

        return view('pages.home', ['data' => $this->getAllFlats($request)]);
    }

    /**
     * Sends form data from main page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
    // TODO сделать фильтры под шаблон Composite
    public function getAllFlats(Request $request)
    {
        $this->joinAll();

        $this->stringFilter->filter($this->query);
        $this->intFilter->filter($this->query);

        $data["flats"] = $this->query->paginate(9)->items();
        $data = $this->getAllRelatedData($data);

        if (!empty($data["flats"])) {
            $data = $this->getMaxValues($data);
            $data = $this->getMinValues($data);

            // Делаем значения массивов уникальными
            foreach ($data["attributes"] as $attributeName => $attributeValues) {
                if (gettype($attributeValues) == 'array') {
                    $data["attributes"][$attributeName] = array_unique($attributeValues);
                }
            }
        }

        return $data;
    }

    protected static function getAllRelatedData(array $data): array {
        $data["attributes"]["cities"] = City::all();
        $data["attributes"]["areas"] = Area::all();
        $data["attributes"]["companies"] = Company::all();

        return $data;
    }

    protected function getMaxValues(array $data): array {
        $data["attributes"]["maxPrice"] =
            $this->intFilter->getMinMaxValues("max_price");
        $data["attributes"]["maxSquare"] =
            $this->intFilter->getMinMaxValues("max_square");

        return $data;
    }

    protected function getMinValues(array $data): array {
        $data["attributes"]["minPrice"] =
            $this->intFilter->getMinMaxValues("min_price");
        $data["attributes"]["minSquare"] =
            $this->intFilter->getMinMaxValues("min_square");

        return $data;
    }

    protected function joinAll() {
        // Присоединение всех связанных таблиц
        foreach (FlatsSettings::getRelatedTables() as $table => $communicationField) {
            $this->query->leftJoin(
                $table,
                'flats.' . $communicationField,
                '=',
                $table . '.id'
            );
        }
    }
}
