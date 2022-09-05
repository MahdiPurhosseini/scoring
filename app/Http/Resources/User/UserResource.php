<?php

    namespace App\Http\Resources\User;

    use Illuminate\Http\Resources\Json\JsonResource;
    use JetBrains\PhpStorm\ArrayShape;

    class UserResource extends JsonResource
    {

        #[
            ArrayShape( [
            'id' => "mixed" ,
            'first_name' => "mixed" ,
            'last_name' => "mixed" ,
            'mobile' => "mixed" ,
            'email' => "mixed" ,
            'score' => "mixed" ,
            'role' => "role" ,
            'updated_at' => "mixed" ,
            'created_at' => "mixed"
            ] )
        ]

        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'first_name' => $this->first_name ,
                'last_name' => $this->last_name ,
                'mobile' => $this->mobile ,
                'email' => $this->email ,
                'score' => $this->score ,
                'role' => $this->role ,
                'updated_at' => $this->updated_at ,
                'created_at' => $this->created_at ,
            ];
        }
    }
