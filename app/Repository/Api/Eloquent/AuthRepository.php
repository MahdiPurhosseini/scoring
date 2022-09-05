<?php

    namespace App\Repository\Api\Eloquent;

    use App\Events\EventNotification;
    use App\Helper\SendSms;
    use App\Http\Requests\Api\Auth\CheckCodeRequest;
    use App\Http\Requests\Api\Auth\LoginRequest;
    use App\Http\Requests\Api\Auth\RegisterRequest;
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

        public function register( RegisterRequest $request ): array
        {
            try {
                DB::beginTransaction();

                $activationCode = getActivationCode();

                $user = User::create( [
                    'first_name' => $request->first_name ,
                    'last_name' => $request->last_name ,
                    'email' => $request->email ,
                    'mobile' => $request->mobile ,
                    'mobile_activation_code' => $activationCode ,
                    'time_activation_code' => Carbon::now() ,
                    'password' => Hash::make( $request->password ) ,
                ] );

                //TODO send activation_code for user

//                $api = new SendSms( 'kavenegar' );
//                $result = $api->verifyLookup( $user->mobile , $user->mobile_activation_code );

                $result = true; //For Testing

                if ( ! $result ) {
                    return [
                        "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
                        "message" => "ارسال کد تایید با مشکل رو به رو شد"
                    ];
                }

                DB::commit();

                $message = "ثبت نام شما با موفقیت انجام شد و کد تایید برای شما ارسال گردید";
                event( new EventNotification( $user->id , $message ) );
                return [
                    "status" => Response::HTTP_OK ,
                    "message" => $message ,
                    "user" => new UserResource( $user )
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

        public function login( LoginRequest $request ): array
        {
            $validated = $request->validated();
            if ( Auth::attempt( [ 'mobile' => $validated[ 'mobile' ] , 'password' => $validated[ 'password' ] ] ) ) {
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

                $message = "شما با موفقیت لاگین شدید";
                event( new EventNotification( $user->id , $message ) );
                return [
                    'status' => Response::HTTP_OK ,
                    'message' => $message ,
                    'token' => $token->token ,
                    'user' => new UserResource( Auth::user() ) ,
                ];
            } else {
                return [
                    'status' => Response::HTTP_NOT_FOUND ,
                    'message' => "تلفن همراه یا پسورد شما اشتباه است" ,
                ];
            }
        }

        public function checkCode( CheckCodeRequest $request ): array
        {
            try {
                DB::beginTransaction();

                $validated = $request->validated();
                $user = User::where( [ 'mobile' => $validated[ 'mobile' ] , 'mobile_activation_code' => (int) $validated[ 'active_code' ] , "mobile_verified_at" => null ] )->first();
                if ( $user != null ) {

                    $user->update( [
                        "mobile_verified_at" => Carbon::now() ,
                        "mobile_activation_code" => null ,
                        'time_activation_code' => null ,
                    ] );
                    DB::commit();

                    $message = "شما با موفقیت تایید شدید";
                    event( new EventNotification( $user->id , $message ) );
                    return [
                        'status' => Response::HTTP_OK ,
                        'message' => $message ,
                        'user' => new UserResource( $user ) ,
                    ];

                } else {
                    return [
                        'status' => Response::HTTP_NOT_FOUND ,
                        'message' => "کد تایید وارد شده اشتباه است" ,
                    ];
                }

            } catch ( \Exception $e ) {
                DB::rollBack();
                return [
                    "status" => Response::HTTP_INTERNAL_SERVER_ERROR ,
                    "message" => $e->getMessage() ,
//                    "message" => "مشکلی پیش آمده است"
                ];
            }
        }

        private function sendCode( $user ): array
        {
            if ( $user->time_activation_code == null or Carbon::now() > Carbon::create( $user->time_activation_code )->addMinutes( 2 ) ) {

//             TODO active kavenegar for sending code

//             $activationCode = getActivationCode();
//             $api = new SendSms( 'kavenegar' );
//             $result = $api->verifyLookup( $user->mobile , $activationCode );

                $activationCode = getActivationCode();
                $result = true;

                if ( $result ) {
                    $user->update( [
                        'mobile_activation_code' => $activationCode ,
                        'time_activation_code' => Carbon::now() ,
                    ] );
                    DB::commit();
                    return [
                        'status' => Response::HTTP_OK ,
                        'message' => "کد تایید جهت فعال کردن حساب کاربری برای شما ارسال شد" ,
                        'user' => new UserResource( $user )
                    ];
                } else {
                    return [
                        'status' => Response::HTTP_INTERNAL_SERVER_ERROR ,
                        'message' => "درارسال کد تایید جهت فعال کردن حساب کاربری مشکلی ایجاد، مجددا تلاتش کنید"
                    ];
                }

            } else {
                return [
                    'status' => Response::HTTP_BAD_REQUEST ,
                    'message' => "کد تایید جهت فعال کردن حساب کاربری برای شما ارسال شده است، بعد از 2 دقیقه دوباره تلاش نمایید"
                ];
            }
        }

    }
