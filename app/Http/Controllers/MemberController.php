<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MemberRequest;
use App\Services\MemberService;
use App\Formatters\ApiOutput;

class MemberController extends Controller
{
    public function __construct(MemberService $service, ApiOutput $out)
    {
        $this->service = $service;
        $this->out = $out;
    }

    /**
     * @group User Register
     * Register New User
     * @apiHeader {string} Content-Type application/json
     * @apiHeader {string} Accept application/json
     * @bodyParam name string required Name
     * @bodyParam address string required Address
     * @bodyParam phone string required Number
     * @bodyParam account string required Account
     * @bodyParam password string required Password
     * @bodyParam mail string required Mail
     * @response
     *     {
     *          "url": "http://backend.test/api/v1/member/register",
     *          "method": "POST",
     *          "code": 100,
     *          "message": "Get something successful.",
     *          "data": {
     *              "name": "Eric",
     *              "address": "台北市一號",
     *              "phone": "0987123456",
     *              "account": "Eric.ku@gmail.com",
     *              "mail": "Eric.ku@gmail.com",
     *              "updated_at": "2019-06-28 02:23:12",
     *              "created_at": "2019-06-28 02:23:12",
     *              "id": 1
     *          }
     *     }
     * @response 101
     *     {
     *          "url": "http://backend.test/api/v1/member/register",
     *          "method": "POST",
     *          "code": 101,
     *          "message": "user is exist",
     *          "errors": []
     *     }
     * @response 500
     *     {
     *          "url": "http://backend.test/api/v1/member/register",
     *          "method": "POST",
     *          "code": 500,
     *          "message": "DB error",
     *          "errors": []
     *     }
     */
    public function register(MemberRequest $request)
    {
        $attributes = [
            'name' => $request->input('name', 'No Name'),
            'address' => $request->input('address', 'No Address'),
            'phone' => $request->input('phone', ''),
            'account' => $request->input('account'),
            'password' => $request->input('password'),
            'mail' => $request->input('mail')
        ];
        $result = $this->service->createMemer($attributes);

        return response()->json($this->out->successFormat($result));
    }
}
