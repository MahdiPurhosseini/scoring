<?php

    namespace App\Repository\Api\Eloquent;

    use App\Events\EventNotification;
    use App\Http\Resources\User\UserResource;
    use App\Models\User;
    use App\Repository\Api\AuthRepositoryInterface;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Symfony\Component\HttpFoundation\Response;

    class AuthRepository extends AbstractRepository implements AuthRepositoryInterface
    {

        /**
         * @param User $model
         */
        public function __construct( User $model )
        {
            $this->model = $model;
        }

        public function register( $request ): array
        {
            try {
                DB::beginTransaction();

                $activationCode = getActivationCode();

                $user = User::create( [
                    'first_name' => $request[ 'first_name' ] ,
                    'last_name' => $request[ 'last_name' ] ,
                    'email' => $request[ 'email' ] ,
                    'mobile' => $request[ 'mobile' ] ,
                    'mobile_activation_code' => $activationCode ,
                    'time_activation_code' => Carbon::now() ,
                    'password' => Hash::make( $request[ 'password' ] ) ,
                ] );

                $result = sendSmsKavenegar( $user->mobile , $user->mobile_activation_code );

                if ( ! $result ) {
                    return [
                        "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
                        "message" => __( "there was a problem for sending the code" )
                    ];
                }

                DB::commit();

                $message = __( "you registered successfully and active code send to you" );
                event( new EventNotification( $user , $message ) );

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

        public function login( $request ): array
        {
            if ( Auth::attempt( [ 'mobile' => $request[ 'mobile' ] , 'password' => $request[ 'password' ] ] ) ) {
                $user = Auth::user();

                if ( $user->mobile_verified_at == null ) {
                    return $this->sendCode( $user );
                }

                $token = $user->createToken( 'scoring-api' )->accessToken;
                $user->update( [
                    "mobile_verified_at" => Carbon::now() ,
                    "mobile_activation_code" => null ,
                    'time_activation_code' => null ,
                ] );

                $message = __( "you logged in successfully" );
                event( new EventNotification( $user , $message ) );
                return [
                    'status' => Response::HTTP_OK ,
                    'message' => $message ,
                    "data" => [
                        'token' => $token->token ,
                        "user" => new UserResource( $user )
                    ]
                ];
            } else {
                return [
                    'status' => Response::HTTP_NOT_FOUND ,
                    'message' => __( "your mobile or password is wrong" ) ,
                ];
            }
        }

        public function checkCode( $request ): array
        {
            try {
                DB::beginTransaction();

                $user = User::where( [ 'mobile' => $request[ 'mobile' ] , 'mobile_activation_code' => (int) $request[ 'active_code' ] , "mobile_verified_at" => null ] )->first();
                if ( $user != null ) {

                    $user->update( [
                        "mobile_verified_at" => Carbon::now() ,
                        "mobile_activation_code" => null ,
                        'time_activation_code' => null ,
                    ] );
                    DB::commit();

                    $message = __( "you activated successfully" );
                    event( new EventNotification( $user , $message ) );
                    return [
                        'status' => Response::HTTP_OK ,
                        'message' => $message ,
                        "data" => [
                            "user" => new UserResource( $user )
                        ]
                    ];

                } else {
                    return [
                        'status' => Response::HTTP_NOT_FOUND ,
                        'message' => __( "the active code is wrong" ) ,
                    ];
                }

            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
//                    "message" => $e->getMessage() ,
                    "message" => __( "there was a problem" )
                ];
            }
        }

        private function sendCode( $user ): array
        {
            if ( $user->time_activation_code == null or Carbon::now() > Carbon::create( $user->time_activation_code )->addMinutes( 2 ) ) {

                $activationCode = getActivationCode();
                $result = sendSmsKavenegar( $user->mobile , $activationCode );

                if ( $result ) {
                    $user->update( [
                        'mobile_activation_code' => $activationCode ,
                        'time_activation_code' => Carbon::now() ,
                    ] );
                    DB::commit();
                    return [
                        'status' => Response::HTTP_OK ,
                        'message' => __( "the active code send for you" ) ,
                        "data" => [
                            "user" => new UserResource( $user )
                        ]
                    ];
                } else {
                    return [
                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR ,
                        'message' => __( "there was a problem for sending active code for you" )
                    ];
                }

            } else {
                return [
                    'status' => Response::HTTP_BAD_REQUEST ,
                    'message' => __( "the active code was sent for you, try again 2 minutes later" )
                ];
            }
        }

    }
