<?php

namespace App\Services\Settings;

class FlatsSettings
{
    /**
     * List of all related tables
     *
     * @var string[]
     */
    protected array $relatedTablesNames = [
        'cities',
        'companies',
        'areas',
    ];

    protected array $relations = [
      'city',
      'company',
      'area',
    ];

    /**
     * Columns that are used for tables communication
     *
     * @var string[]
     */
    protected array $communicationColumns = [
        'city_id',
        'company_id',
        'area_id'
    ];

    /**
     * Attributes, which can be counted
     *
     * @var array
     */
    protected array $countableAttributes = [];

    /**
     * Attributes that will be returned to view
     *
     * @var string[]
     */
    protected array $flatsAttributes = [
        'address',
        'square',
        'is_rented',
        'price',
        'city',
        'company',
        'area'
    ];

    /**
     * Returns related tables as keys
     * and communication columns as values
     *
     * @return string[]
     */
    public function getRelatedTables(): array
    {
        return array_combine($this->relatedTablesNames, $this->communicationColumns);
    }

    public function getRelatedTablesNames(): array
    {
        return $this->relatedTablesNames;
    }

    public function getFlatsAttributes(): array
    {
        return $this->flatsAttributes;
    }

    /**
     * @return array|string[]
     */
    public function getRelations(): array {
        return $this->relations;
    }
}
