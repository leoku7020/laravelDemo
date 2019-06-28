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
     * @api {post} /api/v1/member/register user register
     * @apiGroup User
     * @apiDescription Register New User
     * @apiHeader {string} Content-Type application/json
     * @apiHeader {string} Accept application/json
     * @apiParam {int} page page (default is 1)
     * @apiParam {int} page page (default is 1)
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
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
     * @apiErrorExample {json} Error-Response: user is exist
     *     HTTP/1.1 200 OK
     *     {
     *          "url": "http://backend.test/api/v1/member/register",
     *          "method": "POST",
     *          "code": 101,
     *          "message": "user is exist",
     *          "errors": []
     *     }
     * @apiErrorExample {json} Error-Response: db error
     *     HTTP/1.1 200 OK
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
