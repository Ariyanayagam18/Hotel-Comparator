<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Exceptions\AuthenticationException;
use GuzzleHttp\Client;

class PostController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     * 
     */
    
    public function getapi(Request $request)
    {

    //$response = Http::get('https://apim.expedia.com/hotels/listings?checkIn=2022-12-2&checkOut=2022-12-05&ecomHotelIds=523223,9231567');
    
    
$uri = "https://apim.expedia.com/hotels/listings?checkIn=2022-12-2&checkOut=2022-12-05&regionIds=8816";
$params['headers'] = [
    'Authorization' => 'Basic MWY4ZDllYjItZWEzNi00YWY3LWE4YmItZGI1NWRiODZiMWY5Okg2ZUtKdFJKNTdGT2NNWXc=',
     'Accept' => 'application/vnd.exp-hotel.v3+json',
     'Partner-Transaction-Id'=> 'RPDC92200',
      'Key' =>'1f8d9eb2-ea36-4af7-a8bb-db55db86b1f9'

];

$client = new Client();
$response = $client->request('get', $uri, $params);
$data = json_decode($response->getBody(), true);
dd($data);
        
    }
}