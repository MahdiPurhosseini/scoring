<?php

    namespace App\Repository\Api;

    use App\Http\Requests\Api\Role\CreateRoleRequest;
    use App\Models\Role;
    use Illuminate\Http\Request;

    interface RoleRepositoryInterface
    {

        /**
         * @param $id
         * @return Role
         */
        public function getById( $id ): Role;

        /**
         * @return mixed
         */
        public function getAll(): mixed;

        /**
         * @param CreateRoleRequest $request
         * @return mixed
         */
        public function store(CreateRoleRequest $request): mixed;

        /**
         * @param $id
         * @return mixed
         */
        public function delete( $id ): mixed;
    }
