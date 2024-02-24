<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ShippingController extends Controller
{
    public function getCountries()
{
    $client = new Client();
    $response = $client->get('https://restcountries.com/v3.1/all');
    $countriesData = json_decode($response->getBody(), true);

    $countries = [];
    foreach ($countriesData as $countryData) {
        $country = [
            'name' => $countryData['name']['common'],
            'flag' => $countryData['flags']['png'] ?? null, // Assuming PNG flag is used
            'code' => $countryData['cca2']
        ];
        $countries[] = $country;
    }

    return response()->json($countries);
}


    public function getCities(Request $request)
    {
        $countryCode = $request->input('country_code');
        $client = new Client();
        $response = $client->get("http://api.geonames.org/searchJSON?country=$countryCode&maxRows=10&username=demo");
        $cities = json_decode($response->getBody(), true);
        return response()->json($cities);
    }

    public function getZipCodes(Request $request)
    {
        $city = $request->input('city');
        // You may need to adjust this part based on the API you're using for zip codes
        $zipCodes = []; // Fetch zip codes based on the selected city
        return response()->json($zipCodes);
    }
}
