<?php

namespace App\Plugins\Filters;

use App\Plugins\Settings\FlatsSettings;
use Illuminate\Http\Request;

class StringFilter extends BaseFilter
{
    /**
     * Attributes to filter with "like" operator
     *
     * @var string[]
     */
    protected array $filteringAttributes = [
        'city',
        'company',
        'area'
    ];

    /**
     * Returns attributes and tables in which they are located
     *
     * @return string[]
     */
    public function getFilteringColumns(): array
    {
        return array_combine(FlatsSettings::getRelatedTablesNames(), $this->filteringAttributes);
    }

    public function setFilteringValues(Request $request)
    {
        /*
         * Обработка всех строковых параметров запроса.
         * Если GET параметр существует, то задается
         * значение этого параметра, которое будет использовано
         * как условие в запросе к БД.
         * Иначе, задается "любое значение".
         * (в SQL '%' означает "последовательность любых символов любой длины")
         */
        foreach ($this->filteringAttributes as $stringAttribute) {
            $this->filteringValues[$stringAttribute] = $request->get($stringAttribute) ?? '%';
        }
    }

    public function filter($query): void
    {
        // Добавление условия на все строковые аттрибуты
        foreach (static::getFilteringColumns() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $this->filteringValues[$attribute]);
        }
    }
}
