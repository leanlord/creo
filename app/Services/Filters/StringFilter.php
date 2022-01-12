<?php

namespace App\Services\Filters;

use App\Services\Settings\FlatsSettings;
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
        return array_combine($this->settings->getRelatedTablesNames(), $this->filteringAttributes);
    }

    public function setFilteringValues(Request $request): void
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
        foreach ($this->getFilteringColumns() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $this->filteringValues[$attribute]);
        }
    }
}
