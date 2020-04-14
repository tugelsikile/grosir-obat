<?php

namespace App\Medicine;

use Illuminate\Support\Collection;

/**
 * Cart Collection Class.
 */
class PriceLabel
{
    public function list()
    {
        try{
            $client = new \GuzzleHttp\Client();
            $url = env('API_URL_OBAT') . '/api/medicine/price/label/list';
            $response = $client->request('GET',$url);
            $response = json_decode($response->getBody()->getContents());
        }catch (Exception $exception){
            return $exception;
        }
        return (array)$response->params;
    }
}
