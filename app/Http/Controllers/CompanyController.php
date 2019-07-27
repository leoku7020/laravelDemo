<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use App\Formatters\ApiOutput;

class CompanyController extends Controller
{
    //
	public function __construct(CompanyService $service, ApiOutput $out)
	{
		$this->service = $service;
		$this->out = $out;
	}

	public function index()
	{
		return view('company');
	}

    public function getCompanyName(CompanyRequest $request)
    {
    	$bussinessNo = $request->input('Business_Accounting_NO');
    	$result = $this->service->getName($bussinessNo);

    	return response()->json($this->out->successFormat($result));
    }
}
