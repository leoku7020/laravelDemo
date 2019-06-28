<?php

namespace App\Services;

use App\Repositories\MemberRepository;
use App\Exceptions\ErrorException;

class MemberService
{
    //
    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createMemer($attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        //確認account 唯一
        $checkAccount = $this->repository->findByAccount($attributes['account']);
        if ($checkAccount) {
             throw new ErrorException('user is exist', 101);
        }

        return $this->repository->create($attributes);
    }
}
