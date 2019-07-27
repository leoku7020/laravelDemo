<?php

namespace App\Services;

use Ixudra\Curl\Facades\Curl;

class CompanyService
{
    //
    public function getName($bussinessNo)
    {
    	$response = Curl::to('http://data.gcis.nat.gov.tw/od/data/api/5F64D864-61CB-4D0D-8AD9-492047CC1EA6')
        ->withData( array( 
        	'$format' => 'json',
        	'$filter' => 'Business_Accounting_NO eq '.$bussinessNo,
        ) )
        ->get();
        
        return  json_decode($response);
    }
}
