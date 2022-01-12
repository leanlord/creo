<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Company;
use App\Services\Filters\NumericFilter;
use App\Services\Filters\StringFilter;
use App\Services\Settings\FlatsSettings;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlatsController extends Controller
{
    /**
     * Instance of string filter
     *
     * @var StringFilter
     */
    protected StringFilter $stringFilter;

    /**
     * Instance of numeric filter
     *
     * @var NumericFilter
     */
    protected NumericFilter $intFilter;

    /**
     * Query, that is used to generate SQL request
     *
     * @var Builder
     */
    protected Builder $query;

    /**
     * Instance of data-object class
     *
     * @var FlatsSettings
     */
    protected FlatsSettings $settings;

    /**
     * @param Request $request
     */
    public function __construct(Request $request) {

        $this->intFilter = new NumericFilter($request);
        $this->stringFilter = new StringFilter($request);

        $this->settings = new FlatsSettings();
        // Выбираем только необходимые аттрибуты
        $this->query = DB::table('flats')
            ->select($this->settings->getFlatsAttributes());
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
     * Returns all data about flats
     *
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    // TODO сделать фильтры под шаблон Composite
    public function getAllFlats(Request $request) {
        $this->joinAll();

        $this->stringFilter->filter($this->query);
        $this->intFilter->filter($this->query);

        $data["flats"] = $this->query->paginate(9)->items();
        $data = $this->getAllRelatedData($data);

        $data = $this->getMaxValues($data);
        $data = $this->getMinValues($data);

        return $data;
    }

    /**
     * Adding all data from related tables to response
     *
     * @param array $data
     * @return array
     */
    protected static function getAllRelatedData(array $data): array {
        $data["attributes"]["cities"] = City::all();
        $data["attributes"]["areas"] = Area::all();
        $data["attributes"]["companies"] = Company::all();

        return $data;
    }

    /**
     * Adding max values to response
     *
     * @param array $data
     * @return array
     */
    protected function getMaxValues(array $data): array {
        $data["attributes"]["maxPrice"] =
            $this->intFilter->getMinMaxValues("max_price");
        $data["attributes"]["maxSquare"] =
            $this->intFilter->getMinMaxValues("max_square");

        return $data;
    }

    /**
     * Adding min values to response
     *
     * @param array $data
     * @return array
     */
    protected function getMinValues(array $data): array {
        $data["attributes"]["minPrice"] =
            $this->intFilter->getMinMaxValues("min_price");
        $data["attributes"]["minSquare"] =
            $this->intFilter->getMinMaxValues("min_square");

        return $data;
    }

    /**
     * Joining all tables
     */
    protected function joinAll() {
        foreach ($this->settings->getRelatedTables() as $table => $communicationField) {
            $this->query->leftJoin(
                $table,
                'flats.' . $communicationField,
                '=',
                $table . '.id'
            );
        }
    }
}
