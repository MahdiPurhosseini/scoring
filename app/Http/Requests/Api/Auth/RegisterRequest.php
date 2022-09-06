<?php

    namespace App\Http\Requests\Api\Auth;

    use App\Rules\MobileRule;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    use Illuminate\Validation\Validator;
    use JetBrains\PhpStorm\ArrayShape;


    class RegisterRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize(): bool
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        #[ArrayShape( [ 'first_name' => "string[]" , 'last_name' => "string[]" , 'mobile' => "array" , 'email' => "array" , 'password' => "string" , 'password_confirmation' => "string" ] )]
        public function rules(): array
        {
            return [
                'first_name' => [ 'required' , 'string' , 'max:255' ] ,
                'last_name' => [ 'required' , 'string' , 'max:255' ] ,
                'mobile' => [ 'required' , new MobileRule() , Rule::unique( 'users' , 'mobile' )->whereNull( 'deleted_at' ) ] ,
                'email' => [ 'required' , 'email' , Rule::unique( 'users' , 'email' )->whereNull( 'deleted_at' ) ] ,
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation' ,
                'password_confirmation' => 'min:8'
            ];
        }

    }
