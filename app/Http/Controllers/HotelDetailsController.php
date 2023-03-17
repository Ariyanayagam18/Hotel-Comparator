<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;

use View;

use App\Http\Controllers\AjaxController;



class HotelDetailsController extends Controller
{

    
    
public function otherrecommendedHotels(Request $request)
{

if($request->type == 'similar')
{
    $similar_hotels  = DB::table("T_summary_data_$request->locale as Summ")
    ->select('Summ.heroImage','Regions.ExtendedName','Regions.RegionID','Summ.rating','Summ.propertyName','Summ.propertyId_expedia','Summ.propertyId_hcom','Summ.referencePrice_value','Reviews.guestRating_expedia','Reviews.guestRating_hcom')
    ->join("T_idsRegions_$request->locale as Regions",'Regions.CityName', '=', 'Summ.city')
    ->join("T_guestRatings_reviews_$request->locale as Reviews",'Reviews.propertyId_expedia', '=', 'Summ.propertyId_expedia')
    ->whereNotNull('Summ.referencePrice_value')
    ->whereNotNull('Summ.rating')
    ->whereNotNull('Regions.ExtendedName')
    ->where('Regions.RegionID',$request->regionId)
    ->distinct('Summ.propertyName')
    ->get();

    return $similar_hotels;
}
else if($request->type == 'recommended')
{
    $recommended_hotels  = DB::table("T_summary_data_$request->locale as Summ")
    ->select('Summ.heroImage','Regions.ExtendedName','Regions.RegionID','Summ.rating','Summ.propertyName','Summ.propertyId_expedia','Summ.propertyId_hcom','Summ.referencePrice_value','Summ.guestRating_expedia')
    ->join("T_idsRegions_$request->locale as Regions",'Regions.CityName', '=', 'Summ.city')
    // ->join("T_guestRatings_reviews_$request->locale as Reviews",'Reviews.propertyId_expedia', '=', 'Summ.propertyId_expedia')
    ->whereNotNull('Summ.referencePrice_value')
    ->whereNotNull('Summ.rating')
    ->whereNotNull('Regions.ExtendedName')
    // ->whereIn('Summ.rating',["3","3.5","4","5"])
    ->where('Summ.propertyType_id',1)
    ->where('Regions.RegionID',$request->regionId)
    ->distinct('Summ.propertyId_expedia','Summ.rating')
    ->orderBy('Summ.rating','desc')
    ->get();
   
    // dd($recommended_hotels);

    return $recommended_hotels;
}
else
{
    $hotels_cities_cookies = array();
    $hotels_cookies = array();

    if(isset($_COOKIE['hotel_ids']))
    {
        $cookies_hotels = explode(',',$_COOKIE['hotel_ids']);

        $cookies_hotels = array_reverse($cookies_hotels);

        $cookie_hotels_loc = DB::table("T_property_location_$request->locale as Location")
        ->select('Location.city','Location.propertyName','Location.address1','Location.propertyId_expedia','Location.locationAttribute_city_id','Location.locationAttribute_neighborhood_id')
        ->whereIn('propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();

        $cookie_hotels_review = DB::table("T_summary_data_$request->locale as Summ")
        ->select('Summ.heroImage','Summ.rating','Summ.propertyId_expedia','Summ.propertyName','Summ.city','Summ.guestRating_expedia','Summ.referencePrice_value')
        ->whereIn('propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();


        foreach (array_merge($cookie_hotels_loc, $cookie_hotels_review) as $entry) {
            if (!isset($cookie_hotels_review[$entry->propertyId_expedia])) {
                $cookie_hotels_review[$entry->propertyId_expedia] = $entry;
                
            } else {
                foreach ($entry as $key => $value) {
                    $cookie_hotels_review[$entry->propertyId_expedia]->$key = $value;
                }
            }
        }

    
        // echo "<pre> cookie_hotels_review ";print_r($cookie_hotels_review);

        for($hotel_id=1; $hotel_id < count($cookies_hotels) ;$hotel_id++)
        { 
            $property_id = $cookies_hotels[$hotel_id];
            if(isset($cookie_hotels_review[$property_id]))
            {
            if(!in_array($cookie_hotels_review[$property_id]->city, $hotels_cities_cookies))
            {
                array_push($hotels_cities_cookies,$cookie_hotels_review[$property_id]->city);
            }
            array_push($hotels_cookies,$cookie_hotels_review[$property_id]);
            }
        }

        session_start();

        $_SESSION["hotels_cookies"] = $hotels_cookies;

        return $hotels_cookies;

        // dd($hotels_cookies);
    }

}

}

public function getExchangedCurrency(Request $request)
{
    $main_controller = new AjaxController;

    return round($request->price /$main_controller->currencyConversion($request->currency),2);
}


public function apiAccess(Request $request)
{
    // dd($request);
    if($request->type == 'partnerlink')
    {
        $API_details = DB::table("T_ApiAccess as API")
        ->where('Local',$request->locale)
        ->whereIn('agency',["expedia","Hcom"])
        ->get();
    }
    else{
        $API_details = DB::table("T_ApiAccess as API")
        ->where('Local',$request->locale)
        ->where('agency',"expedia")
        ->get();
    }

    $locale = '';

   $main_controller = new AjaxController;

    if(!empty($API_details) && isset($API_details))
    {
        if($request->type == 'partnerlink')
        {
            return $main_controller->cURL($API_details,$request->propertyId,$request->type,$locale);
        }
        else{
            return $main_controller->cURL($API_details[0],$request->regionId,$request->type,$locale);
        }
    }
    else{
        dd("no details found!!!");
    }
}



public function hotelDetails(Request $request)
{

    // dd('sadfsfsfdsa');


// original query hide jan 11 10.30

// $search = DB::table("T_summary_data_$request->locale as Summ")
// ->select('Summ.city','Summ.province','Summ.country','Summ.address1','Summ.address2','Summ.postalCode','Summ.propertyName','Summ.propertyType_name','Summ.referencePrice_value','Desc.areaDescription','Desc.propertyDescription','Ams.popularAmenities','Ams.propertyAmenities','Img.hero_link','Img.images','Img.hero_title','Reviews.guestReviews','Reviews.guestRating_expedia','Reviews.guestRating_hcom')
// ->join("T_property_description_$request->locale as Desc",'Desc.propertyId_expedia', '=', 'Summ.propertyId_expedia')
// ->join("T_property_amenities_$request->locale as Ams",'Ams.propertyId_expedia','=','Desc.propertyId_expedia')
// ->join("T_property_images_enUS as Img",'Img.propertyId_expedia','=','Desc.propertyId_expedia')
// ->join("T_guestRatings_reviews_enUS as Reviews","Reviews.propertyId_expedia",'=','Desc.propertyId_expedia')
// // ->join("T_property_description_$request->locale as Desc",'Desc.propertyId_expedia', '=', 'Summ.propertyId_expedia')
// ->where('Summ.propertyId_expedia',$request->expediaId)
// ->limit(5)
// ->get();

//dd($search)

// original query hide jan 11 10.30

// get images start

$hotel_images = array();
$primary_image = array();
$images = array();
$hotel_details = array();
$hotel_description = array();
$hotel_amenities = array();
$hotel_reviews = array();

$hotel_images = DB::table("T_property_images_$request->locale as Img")
->select('Img.hero_link','Img.images','Img.hero_title')
->where('Img.propertyId_expedia',$request->expediaId)
->get()
->toArray();

$hotel_images = !empty($hotel_images) && isset($hotel_images) ? $hotel_images[0] : [] ;

if(isset($hotel_images) && !empty($hotel_images))
 {
    $primary_image = array( "img_link"=> $hotel_images->hero_link,"img_title"=>$hotel_images->hero_title);

    if(isset($hotel_images->images))
    {
        $res = json_decode($hotel_images->images);
        $images = $res->ROOMS;
    }
}

// get images  end 

// get names and details  start

$hotel_details = DB::table("T_summary_data_$request->locale as Summ")
->select('Summ.city','Summ.province','Summ.country','Summ.address1','Summ.address2','Summ.postalCode','Summ.propertyName','Summ.propertyType_name','Summ.referencePrice_value')
->where('Summ.propertyId_expedia',$request->expediaId)
->get()
->toArray();



$hotel_details = (isset($hotel_details) && !empty($hotel_details)) ? $hotel_details[0] : [];


// get names and details  end 


//  get Description  start

$hotel_description = DB::table("T_property_description_$request->locale as Desc")
->select('Desc.areaDescription','Desc.propertyDescription')
->where('Desc.propertyId_expedia',$request->expediaId)
->get()
->toArray();

$hotel_description = !empty($hotel_description) && isset($hotel_description) ? $hotel_description[0] : [] ;

//  get Description end 


//  get Amenities  start

$hotel_amenities = DB::table("T_property_amenities_$request->locale as Ams")
->select('Ams.popularAmenities','Ams.propertyAmenities')
->where('Ams.propertyId_expedia',$request->expediaId)
->get()
->toArray();

$hotel_amenities = !empty($hotel_amenities) && isset($hotel_amenities) ? $hotel_amenities[0] : [] ;

// dd($hotel_amenities);

//  get Amenities end 

//  get hotel reviews  start

$hotel_reviews = DB::table("T_guestRatings_reviews_$request->locale as Reviews")
->select('Reviews.guestReviews','Reviews.guestRating_expedia','Reviews.guestRating_hcom')
->where('Reviews.propertyId_expedia',$request->expediaId)
->get()
->toArray();

$hotel_reviews = !empty($hotel_reviews) && isset($hotel_reviews) ? $hotel_reviews[0] : [] ;

// dd($hotel_reviews);


//  get hotel reviews end 


$login = 1;

// $search = (isset($search[0]) && !empty($search[0])) ? $search[0] : [];

// empty($search) ? dd("This hotel details doesn't available in all the required tables!!") : ''

// dd($search);

// return view('viewmoreold');



return view('viewmore',compact('login','images','primary_image','hotel_details','hotel_description','hotel_amenities','hotel_reviews'));

}

}

?>