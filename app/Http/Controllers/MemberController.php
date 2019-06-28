<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;

class MemberController extends Controller
{
    //
    public function register(MemberRequest $request)
    {
        return true;
    }
}
