<?php

    namespace App\Http\Requests\Api\Auth;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    use Illuminate\Validation\Validator;


    class RegisterRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
            return [
                'first_name' => [ 'required' , 'string' , 'max:255' ] ,
                'last_name' => [ 'required' , 'string' , 'max:255' ] ,
                'mobile' => [ 'required' , 'digits:11' , Rule::unique( 'users' , 'mobile' )->whereNull( 'deleted_at' ) ] ,
                'email' => [ 'required' , 'email' , Rule::unique( 'users' , 'email' )->whereNull( 'deleted_at' ) ] ,
                'password' => 'min:8|required_with:password_confirmation|same:password_confirmation' ,
                'password_confirmation' => 'min:8'
            ];
        }

    }
