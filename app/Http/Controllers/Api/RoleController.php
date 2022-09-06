<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Api\Role\CreateRoleRequest;
    use App\Http\Resources\Role\RoleCollection;
    use App\Http\Resources\Role\RoleResource;
    use App\Repository\Api\Eloquent\RoleRepository;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;

    class RoleController extends Controller
    {

        protected RoleRepository $main;

        public function __construct(RoleRepository $roleRepository)
        {
            $this->main = $roleRepository;
        }

        public function index(): JsonResponse
        {
            return response()->json( [
                'status' => Response::HTTP_OK ,
                'data' => [
                    'roles' => new RoleCollection( $this->main->getAll() )
                ]
            ] );
        }

        public function show($id): JsonResponse
        {
            return response()->json( [
                'status' => Response::HTTP_OK ,
                'data' => [
                    'role' => new RoleResource( $this->main->getById($id) )
                ]
            ] );
        }

        public function store(CreateRoleRequest $request): JsonResponse
        {
            return response()->json(
                $this->main->store($request->validated())
            );
        }

        public function delete($id): JsonResponse
        {
            return response()->json(
                $this->main->delete($id)
            );
        }

    }
