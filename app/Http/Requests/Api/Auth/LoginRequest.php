<?php

    namespace App\Http\Requests\Api\Auth;

    use App\Rules\MobileRule;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    use Illuminate\Validation\Validator;
    use JetBrains\PhpStorm\ArrayShape;


    class LoginRequest extends FormRequest
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
        #[ArrayShape( [ 'mobile' => "array" , 'password' => "string[]" ] )]
        public function rules(): array
        {
            return [
                'mobile' => [ 'required' , new MobileRule() ] ,
                'password' => [ 'min:8' , "string" ] ,
            ];
        }

    }
