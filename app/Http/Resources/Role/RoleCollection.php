<?php

namespace App\Http\Resources\Role;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use JsonSerializable;

class RoleCollection extends ResourceCollection
{

    /**
     * @param Request $request
     * @return array|JsonSerializable|Arrayable
     */
    public function toArray( $request): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }

}
