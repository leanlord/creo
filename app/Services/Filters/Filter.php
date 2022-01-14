<?php

    namespace App\Services\Filters;

    use Illuminate\Http\Request;

    interface Filter
    {
        public function __construct(Request $request);

        public function filter($query);
    }
