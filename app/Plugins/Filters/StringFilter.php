<?php

namespace App\Plugins\Filters;

use App\Plugins\Settings\FlatsSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StringFilter extends BaseFilter
{
    /**
     * Attributes to filter with "like" operator
     *
     * @var string[]
     */
    protected static $filteringAttributes = [
        'city',
        'company',
        'area'
    ];

    /**
     * Returns attributes and tables in which they are located
     *
     * @return string[]
     */
    public static function getFilteringColumns(): array
    {
        return array_combine(FlatsSettings::getRelatedTablesNames(), self::$filteringAttributes);
    }

    public static function getFilteringValues(Request $request): array
    {
        $result = [];

        /*
         * Обработка всех строковых параметров запроса.
         * Если GET параметр существует, то задается
         * значение этого параметра, которое будет использовано
         * как условие в запросе к БД.
         * Иначе, задается "любое значение".
         * (в SQL '%' означает "последовательность любых символов любой длины")
         */
        foreach (static::$filteringAttributes as $stringAttribute) {
            $result[$stringAttribute] = $request->get($stringAttribute) ?? '%';
        }

        return $result;
    }

    public function filter($query): void
    {
        // Добавление условия на все строковые аттрибуты
        foreach (static::getFilteringColumns() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $this->filteringValues[$attribute]);
        }
    }
}
