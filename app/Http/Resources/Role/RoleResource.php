<?php

    namespace App\Http\Resources\Role;

    use Illuminate\Http\Resources\Json\JsonResource;
    use JetBrains\PhpStorm\ArrayShape;

    class RoleResource extends JsonResource
    {

        #[
            ArrayShape( [
            'id' => "mixed" ,
            'name' => "mixed" ,
            'from_rate' => "mixed" ,
            'to_rate' => "mixed" ,
            'updated_at' => "mixed" ,
            'created_at' => "mixed"
            ] )
        ]

        public function toArray( $request ): array
        {
            return [
                'id' => $this->id ,
                'name' => $this->name ,
                'from_rate' => $this->from_rate ,
                'to_rate' => $this->to_rate ,
                'updated_at' => $this->updated_at ,
                'created_at' => $this->created_at ,
            ];
        }
    }
