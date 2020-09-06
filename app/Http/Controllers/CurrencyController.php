<?php

namespace App\Http\Controllers;

use Artisaninweb\SoapWrapper\SoapWrapper;
use App\Soap\Request\GetConversionAmount;
use App\Soap\Response\GetConversionAmountResponse;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    private $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper)
    {
        $this->soapWrapper = $soapWrapper;
    }

    public function getCurrencyList()
    {
        $this->soapWrapper->add('CurrencyList',function ($service) {
            $service
                ->wsdl('http://webservices.oorsprong.org/websamples.countryinfo/CountryInfoService.wso?WSDL')
                ->trace(true);
        });

        // Without classmap
        $response = $this->soapWrapper->call('CurrencyList.ListOfCurrenciesByName');
        $a = collect($response->ListOfCurrenciesByNameResult)->first();
        $arr = array();
        $i = 0;

        foreach ($a as $currency)
        {
            array_push($arr,array(
                "id" => $i,
                "code" => $currency->sISOCode
            ));
            $i++;
        }
        return $arr;
    }

    public function convertAmount()
    {
        $this->soapWrapper->add('Currency', function ($service) {
            $service
                ->wsdl('http://currencyconverter.kowabunga.net/converter.asmx?WSDL')
                ->trace(true);
        });
        $response = $this->soapWrapper->call('Currency.GetConversionAmount', [[

            'CurrencyFrom'  => 'USD',
            'CurrencyTo'   	=> 'EUR',
            'RateDate'     	=> '2020-01-09',
            'Amount'       	=> '1000',
        ]]);
        dd($response);
    }
}
