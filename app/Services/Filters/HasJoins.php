<?php

    namespace App\Services\Filters;

    use App\Services\Settings\FlatsSettings;

    // This trait is used, if entity has related tables
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
            foreach ($this->settings->getRelatedTables() as $table => $field) {
                $this->join($table, $field);
            }
        }

        /**
         * Determines, how to join table
         *
         * @param string $table
         * @param string $field
         */
        protected function join(string $table, string $field) {
            $this->query->leftJoin(
                $table,
                'flats.' . $field,
                '=',
                $table . '.id'
            );
        }
    }
