<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Api\User\SetScoreRequest;
    use App\Http\Resources\User\UserCollection;
    use App\Http\Resources\User\UserResource;
    use App\Repository\Api\Eloquent\UserRepository;
    use Illuminate\Http\JsonResponse;
    use Symfony\Component\HttpFoundation\Response;

    class UserController extends Controller
    {

        protected UserRepository $main;

        public function __construct(UserRepository $usersRepository)
        {
            $this->main = $usersRepository;
        }

        public function index(): JsonResponse
        {
            return response()->json( [
                'status' => Response::HTTP_OK ,
                'data' => [
                    'users' => new UserCollection( $this->main->getAll() )
                ]
            ] );
        }

        public function show($id): JsonResponse
        {
            return response()->json( [
                'status' => Response::HTTP_OK ,
                'data' => [
                    'user' => new UserResource( $this->main->getById($id) )
                ]
            ] );
        }

        public function score(SetScoreRequest $request): JsonResponse
        {
            return response()->json(
                $this->main->setScore($request->validated())
            );
        }

        public function delete($id): JsonResponse
        {
            return response()->json(
                $this->main->delete($id)
            );
        }

    }
