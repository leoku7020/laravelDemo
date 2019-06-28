<?php

namespace App\Repositories;

use App\Models\Member;

class MemberRepository
{
    //
    public function __construct(Member $model)
    {
        $this->model = $model;
    }

    public function create($attributes)
    {
        return $this->model->create($attributes);
    }

    public function findByAccount($account, $columns = ['*'])
    {
        return $this->model->where('account', $account)->get($columns);
    }
}
