<?php

    namespace App\Services\Filters;

    use App\Services\Settings\FlatsSettings;

    trait HasJoins
    {
        /**
         * Instance of data-object class
         *
         * @var FlatsSettings
         */
        protected FlatsSettings $settings;

        /**
         * Joining all tables
         */
        protected function joinAll() {
            foreach ($this->settings->getRelatedTables() as $table => $communicationField) {
                $this->query->leftJoin(
                    $table,
                    'flats.' . $communicationField,
                    '=',
                    $table . '.id'
                );
            }
        }
    }
