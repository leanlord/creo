<?php

    namespace App\Services\Filters;

    use App\Services\Settings\FlatsSettings;
    use Illuminate\Http\Request;

    abstract class AbstractFilter implements Filter
    {
        use HasAttributes;

        /**
         * Concrete values which will be used for filtering
         */
        protected $filteringValues = [];

        /**
         * Instance of data-object class
         *
         * @var FlatsSettings
         */
        protected FlatsSettings $settings;

        public function __construct(Request $request) {
            $this->request = $request;
            $this->setFilteringValues();
            $this->settings = new FlatsSettings();
        }

        /**
         * Defines, how filtering values will be
         * converted from get request to concrete values
         */
        abstract public function setFilteringValues(): void;

        abstract public function filter($query): void;

        /**
         * @return array
         */
        public function getFilteringValues(): array {
            return $this->filteringValues;
        }
    }
