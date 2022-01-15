<?php

    namespace App\Http\Controllers;

    use App\Models\Area;
    use App\Models\City;
    use App\Models\Company;
    use App\Models\Flat;
    use App\Services\Filters\Filter;
    use App\Services\Filters\HasJoins;
    use App\Services\Filters\NumericFilter;
    use App\Services\Settings\FlatsSettings;
    use Illuminate\Http\Request;

    class FlatsController extends Controller
    {
        use HasJoins;

        protected Filter $filter;

        /**
         * Query, that is used to generate SQL request
         *
         * @var
         */
        protected $query;

        /**
         * @param Filter $filter
         */
        public function __construct(Filter $filter) {
            $this->filter = $filter;
            $this->settings = new FlatsSettings();
            $this->query = Flat::query()->withAll();
        }

        /**
         * Shows main page
         *
         * @param Request $request
         * @return \Illuminate\Contracts\View\View
         */
        public function index(Request $request): \Illuminate\Contracts\View\View {
            if ($request->ajax()) {
                return view('includes.flats', ['data' => $this->getAllFlats()]);
            }

            return view('pages.home', ['data' => $this->getAllFlats()]);
        }

        /**
         * Returns all data about flats
         *
         * @return array|\Illuminate\Http\JsonResponse
         */
        public function getAllFlats() {
            $this->joinAll();
            $data = $this->getMaxValues();
            $data = $this->getMinValues($data);

            $this->filter->filter($this->query);

            $data["flats"] = $this->query->paginate(6)->items();

            return $this->getAllRelatedData($data);
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
        protected function getMaxValues(array $data = []): array {
            $data["attributes"]["maxPrice"] =
                NumericFilter::getMinMaxValues("max_price");
            $data["attributes"]["maxSquare"] =
                NumericFilter::getMinMaxValues("max_square");

            return $data;
        }

        /**
         * Adding min values to response
         *
         * @param array $data
         * @return array
         */
        protected function getMinValues(array $data = []): array {
            $data["attributes"]["minPrice"] =
                NumericFilter::getMinMaxValues("min_price");
            $data["attributes"]["minSquare"] =
                NumericFilter::getMinMaxValues("min_square");

            return $data;
        }
    }
