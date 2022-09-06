<?php

    namespace App\Http\Requests\Api\User;

    use Illuminate\Foundation\Http\FormRequest;
    use JetBrains\PhpStorm\ArrayShape;

    class SetScoreRequest extends FormRequest
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
        #[ArrayShape( [ 'id' => "string[]" , 'score' => "string[]" ] )]
        public function rules(): array
        {
            return [
                'id' => [ 'required' , 'exists:users,id' ] ,
                'score' => [ 'required' , "integer" ]
            ];
        }

    }
