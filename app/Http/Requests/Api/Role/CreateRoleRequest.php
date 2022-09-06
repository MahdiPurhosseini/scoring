<?php

    namespace App\Http\Requests\Api\Role;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;
    use Illuminate\Validation\Validator;
    use JetBrains\PhpStorm\ArrayShape;


    class CreateRoleRequest extends FormRequest
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
        #[ ArrayShape([ 'name' => "string[]" ,'from_rate' => "string[]" , 'to_rate' => "string[]" ])]
        public function rules(): array
        {
            return [
                'name' => [ 'required' , "string" ] ,
                'from_rate' => [ 'required' , "integer" ] ,
                'to_rate' => [ 'required' , "integer" ] ,
            ];
        }

    }
