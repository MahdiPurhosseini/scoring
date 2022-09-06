<?php

    namespace App\Repository\Api\Eloquent;

    use App\Events\EventNotification;
    use App\Http\Requests\Api\User\SetScoreRequest;
    use App\Http\Resources\User\UserResource;
    use App\Models\User;
    use App\Repository\Api\UserRepositoryInterface;
    use Illuminate\Support\Facades\DB;
    use JetBrains\PhpStorm\ArrayShape;
    use Symfony\Component\HttpFoundation\Response;

    class UserRepository extends AbstractRepository implements UserRepositoryInterface
    {

        /**
         * @param User $model
         */
        public function __construct( User $model )
        {
            $this->model = $model;
        }

        public function getById( $id ): User
        {
            return $this->model->findOrFail( $id );
        }

        public function getAll(): mixed
        {
            return $this->model->get();
        }

        public function getAllConfirmed(): mixed
        {
            return $this->model->confirmed()->get();
        }

        public function setScore( $request ): array
        {
            try {
                DB::beginTransaction();

                $user = $this->getById( $request["id"] );
                $user->score += $request["score"];
                $user->save();

                DB::commit();

                $message = __("the score added successfully");
                event( new EventNotification( $user->id , $message ) );
                return [
                    "status" => Response::HTTP_OK ,
                    "message" => $message ,
                    "data" => [
                        "user" => new UserResource( $user )
                    ]
                ];
            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
//                    "message" => $e->getMessage() ,
                    "message" => __( "there was a problem" )
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
                    "message" => __("user deleted successfully")
                ];
            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
//                    "message" => $e->getMessage() ,
                    "message" => __( "there was a problem" )
                ];
            }
        }

    }
