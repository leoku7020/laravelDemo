<?php

namespace App\Repositories;

use App\Model\Member;

class MemberRepository extends Model
{
    //
    public function __construct(Member $model)
    {
        $this->model = $model;
    }
}
