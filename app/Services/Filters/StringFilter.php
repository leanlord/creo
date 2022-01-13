<?php

namespace App\Services\Filters;

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
        'area',
    ];

    /**
     * Returns attributes and tables in which they are located
     *
     * @return string[]
     */
    public function getFilteringColumns(): array {
        return array_combine(
            $this->settings->getRelatedTablesNames(),
            $this->filteringAttributes
        );
    }

    /**
     * Обработка всех строковых параметров запроса.
     * Если GET параметр существует, то задается
     * значение этого параметра, которое будет использовано
     * как условие в запросе к БД.
     * Иначе, задается "любое значение".
     * (в SQL '%' означает "последовательность любых символов любой длины")
     *
     */
    public function setFilteringValues(): void {
        foreach ($this->filteringAttributes as $stringAttribute) {
            if ($this->has($this->request, $stringAttribute)) {
                $this->filteringValues[$stringAttribute] =
                    $this->request->get($stringAttribute);
            } else {
                $this->filteringValues[$stringAttribute] = '%';
            }
        }
    }

    /**
     * Добавление условия на все строковые аттрибуты
     *
     * @param $query
     */
    public function filter($query): void {
        foreach ($this->getFilteringColumns() as $table => $attribute) {
            $query->where($table . '.' . $attribute, 'like', $this->filteringValues[$attribute]);
        }
    }
}
