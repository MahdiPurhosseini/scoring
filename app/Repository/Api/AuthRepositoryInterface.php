<?php

    namespace App\Repository\Api;

    use App\Http\Requests\Api\Auth\CheckCodeRequest;
    use App\Http\Requests\Api\Auth\LoginRequest;
    use App\Http\Requests\Api\Auth\RegisterRequest;
    use App\Http\Requests\Api\Auth\SendCodeRequest;

    interface AuthRepositoryInterface
    {

        /**
         * @param RegisterRequest $request
         * @return array
         */
        public function register( RegisterRequest $request ): array;

        /**
         * @param LoginRequest $request
         * @return array
         */
        public function login( LoginRequest $request ): array;

        /**
         * @param CheckCodeRequest $request
         * @return array
         */
        public function checkCode( CheckCodeRequest $request ): array;


    }
