<?php

    namespace App\Repository\Api;

    use App\Http\Requests\Api\User\SetScoreRequest;
    use App\Models\User;

    interface UserRepositoryInterface
    {

        /**
         * @param $id
         * @return User
         */
        public function getById( $id ): User;

        /**
         * @return mixed
         */
        public function getAll(): mixed;

        /**
         * @return mixed
         */
        public function getAllConfirmed(): mixed;

        /**
         * @param SetScoreRequest $request
         * @return array
         */
        public function setScore( SetScoreRequest $request ): array;

        /**
         * @param $id
         * @return mixed
         */
        public function delete( $id ): mixed;

    }
