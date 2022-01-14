<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    interface Filter
    {
        public function __construct(Request $request);

        /**
         * Adding conditions to query
         *
         * @param $query
         * @return void
         */
        public function filter($query);
    }
