<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainPageController extends Controller
{
    /**
     * Показывает главную страницу
     * @param Request $request
     */
    function index(Request $request) {
        //
    }

    /**
     * Будет использоваться как для AJAX запроса, так и
     * в функции index().
     * Возвращает верстку только квартир, а не полную страницу
     * @param Request $request
     */
    function allFlats(Request $request) {
        //
    }
}
