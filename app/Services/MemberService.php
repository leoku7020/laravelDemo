<?php

namespace App\Services;

use App\Repositories\MemberRepository;

class MemberService
{
    //
    public function __construct(MemberRepository $repository)
    {
        $this->repository = $repository;
    }
}
