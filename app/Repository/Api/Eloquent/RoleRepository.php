<?php

    namespace App\Repository\Api\Eloquent;

    use App\Http\Requests\Api\Role\CreateRoleRequest;
    use App\Http\Resources\Role\RoleResource;
    use App\Http\Resources\User\UserResource;
    use App\Models\Role;
    use App\Repository\Api\RoleRepositoryInterface;
    use Illuminate\Support\Facades\DB;
    use JetBrains\PhpStorm\ArrayShape;
    use Symfony\Component\HttpFoundation\Response;

    class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
    {

        /**
         * @param Role $model
         */
        public function __construct( Role $model )
        {
            $this->model = $model;
        }

        public function getById( $id ): Role
        {
            return $this->model->findOrFail( $id );
        }

        public function getAll(): mixed
        {
            return $this->model->get();
        }

        public function store(CreateRoleRequest $request): mixed
        {
            try {
                DB::beginTransaction();

                $role = $this->model->create([
                    "name"  => $request->name,
                    "from_rate"  => $request->from_rate,
                    "to_rate"  => $request->to_rate,
                ]);

                DB::commit();
                return [
                    "status" => Response::HTTP_OK ,
                    "message" => "نقش با موفقیت ایجاد شد" ,
                    "user" => new RoleResource($role)
                ];
            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
//                    "message" => $e->getMessage() ,
                    "message" => "مشکلی پیش آمده است"
                ];
            }
        }

        #[
            ArrayShape( [
                "status" => "int" ,
                "message" => "string"
            ] )
        ]
        public function delete( $id ): array
        {
            try {
                DB::beginTransaction();

                $this->getById( $id )->delete();

                DB::commit();
                return [
                    "status" => Response::HTTP_OK ,
                    "message" => "نقش با موفقیت حذف شد"
                ];
            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
//                    "message" => $e->getMessage() ,
                    "message" => "مشکلی پیش آمده است"
                ];
            }
        }

    }
