<?php

namespace App\Medicine;

use http\Env\Request;
use Illuminate\Support\Collection;

/**
 * Cart Collection Class.
 */
class Medicine
{
    public function find($request)
    {
        try{
            $client = new \GuzzleHttp\Client();
            $url = env('API_URL_OBAT'). '/api/medicine/find?name='.$request;
            $response = $client->request('POST', $url);
            $response = json_decode($response->getBody()->getContents());
        }catch (Exception $exception){
            return $exception;
        }
        return (array)$response->params;
    }
    public function list()
    {
        try{
            $client = new \GuzzleHttp\Client();
            $url = env('API_URL_OBAT'). '/api/medicine/list';
            $response = $client->request('GET', $url);
            $response = json_decode($response->getBody()->getContents());
        }catch (Exception $exception){
            return $exception;
        }
        return (array)$response->params;
    }
    public function data($request){
        try{
            $client = new \GuzzleHttp\Client();
            $url = env('API_URL_OBAT'). '/api/medicine/detail?id='.$request;
            $response = $client->request('POST', $url);
            $response = json_decode($response->getBody()->getContents());
        }catch (Exception $exception){
            return $exception;
        }
        return (array)$response->params;
    }
}
