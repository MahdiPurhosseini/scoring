<?php

    namespace App\Http\Controllers\Api\Auth;


    use App\Http\Controllers\Controller;
    use App\Http\Requests\Api\Auth\CheckCodeRequest;
    use App\Http\Requests\Api\Auth\LoginRequest;
    use App\Http\Requests\Api\Auth\RegisterRequest;
    use App\Http\Requests\Api\Auth\SendCodeRequest;
    use App\Repository\Api\Eloquent\AuthRepository;
    use Illuminate\Http\JsonResponse;


    class AuthController extends Controller
    {

        protected AuthRepository $main;

        public function __construct(AuthRepository $authRepository)
        {
            $this->main = $authRepository;
        }

        public function register( RegisterRequest $request ): JsonResponse
        {
            return response()->json(
                $this->main->register( $request )
            );
        }

        public function login( LoginRequest $request ): JsonResponse
        {
            return response()->json(
                $this->main->login( $request )
            );
        }

        public function checkCode( CheckCodeRequest $request ): JsonResponse
        {
            return response()->json(
                $this->main->checkCode( $request )
            );
        }

    }
