<?php

    namespace App\Repository\Api\Eloquent;

    use Illuminate\Database\Eloquent\Model;

    abstract class AbstractRepository
    {

        protected Model $model;

        /**
         * @param Model $model
         */
        public function __construct( Model $model )
        {
            $this->model = $model;
        }

        /**
         * @param array $attributes
         * @return Model
         */
        public function getNew( array $attributes = [] ): Model
        {
            return $this->model->newInstance( $attributes );
        }
    }
