<?php

    namespace App\Repository\Api;

    use App\Http\Requests\Api\Auth\CheckCodeRequest;
    use App\Http\Requests\Api\Auth\LoginRequest;
    use App\Http\Requests\Api\Auth\RegisterRequest;
    use App\Http\Requests\Api\Auth\SendCodeRequest;

    interface AuthRepositoryInterface
    {

        /**
         * @param $request
         * @return array
         */
        public function register( $request ): array;

        /**
         * @param $request
         * @return array
         */
        public function login( $request ): array;

        /**
         * @param $request
         * @return array
         */
        public function checkCode( $request ): array;


    }
