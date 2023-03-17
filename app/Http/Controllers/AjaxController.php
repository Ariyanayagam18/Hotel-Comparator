<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Session;

use GuzzleHttp\Client;

use App\Models\Regions\RegionUS;

use App\Models\Summary\SummaryUS;

use App\Models\Ref\PropertyType;

use View;

class AjaxController extends Controller
{

protected  $cookies_arr;

private $test;


public function defaultDatas()
{
    

    // $location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));

    // $user_country = $location['geoplugin_countryName'];

    // $user_timezone = $location['geoplugin_timezone'];

    // date_default_timezone_set($user_timezone);
    $date = date('d/m/Y', time());
    // echo "tz : ".$user_timezone."<br/>";
    // echo "date :".$date;exit;


    // $location = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));

    // $user_country = $location['geoplugin_countryName'];

        $user_country ='India';
        //      echo '<script>
        //      function setCookie(name,value,days) {
        //        var expires = "";
        //        if (days) {
        //            var date = new Date();
        //            date.setTime(date.getTime() + (days*24*60*60*1000));
        //            expires = "; expires=" + date.toUTCString();
        //        }
        //        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        //     }
        //     //get your item from the localStorage
        //     setCookie("locale", localStorage.getItem("locale"), 2);
        //     </script>';
        //     // $variableName = session('arya');cookies_hotels
 
    
        // echo "<pre>";print_r($cookies_hotels);exit;

        echo '<script>
        localStorage.setItem("locale","enUS")</script>';
        // if(isset($_COOKIE['locale'])) {
        //     $locale = $_COOKIE['locale'];
        // }

        $locale = isset($_COOKIE['locale']) ? $_COOKIE['locale'] : 'enUS';
    
        $staycation_cities = DB::table("T_property_location_enUS as Location")
        ->select('Location.province','Location.locationAttribute_city_id','Location.locationAttribute_neighborhood_id')
        // ->join("T_idsRegions_$locale as Reg",'Reg.RegionID','=','Location.locationAttribute_region_id')
        ->whereNotNull('locationAttribute_neighborhood_id')
        ->whereNotNull('locationAttribute_city_id')
        ->where('country',"$user_country")
        ->inRandomOrder()
        ->limit(5)
        ->get()
        ->unique('province')
        ->toArray();

        // dd($staycation_cities);
        
// SELECT distinct T_idsRegions_enUS"
// where "CountryName"='India' and "ParentRegionType"='province_state'

    $suggestCities = DB::table("T_idsRegions_enUS")
    ->select('RegionID','ExtendedName','Type','ParentRegionId','Name','ProvinceName','CountryName')
    ->where('ProvinceName','!=','')
    ->where('CityName','!=','')
    ->where('ExtendedName','!=','')
    ->where('ParentRegionType','province_state')
    ->where('CountryName','=',"$user_country")
    ->orWhere('CountryName','ilike',"$user_country")
    ->where('Type','city')
    ->where('CityName','!=','')
    ->where('ExtendedName','!=','')
    ->inRandomOrder()
    ->get()
    ->unique('ProvinceName')
    // ->toSql();
    ->toArray();
    
    // echo "count : ".count($suggestCities);

    if(count($suggestCities) > 10)
    {
        $suggestCities = array_slice($suggestCities, 0, 10);
    }

    // dd($suggestCities);

    $hotels =  array();

    if(!empty($staycation_cities)){
    $hotels = DB::table("T_summary_data_enUS")
    ->select('heroImage','propertyName','city','country','rating','referencePrice_value')
    ->where('province',$staycation_cities["0"]->province)
    ->where('rating','!=','')
    ->limit(12)
    ->orderBy('rating','desc')
    ->get()
    ->toArray();
    }

    $login = 1; 

    $hotels_cookies =  array();
    $hotels_cities_cookies = array();
    $hotelscities_overall = array();

    if(isset($_COOKIE['hotel_ids']))
    {
        $cookies_hotels = explode(',',$_COOKIE['hotel_ids']);

        $cookies_hotels = array_reverse($cookies_hotels);

        $cookie_hotels_loc = DB::table("T_property_location_$locale as Location")
        ->select('Location.locationAttribute_distanceFromCityCenter','Location.city','Location.propertyName','Location.propertyId_expedia as property_ID','Location.locationAttribute_city_id','Location.locationAttribute_neighborhood_id','Location.geoLocation')
        ->whereIn('Location.propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();

        // dd($cookie_hotels_loc);

        $cookie_hotels_region = DB::table("T_propertyID_regionID_$locale as PropReg")
            ->select('Summ.city','PropReg.property_ID','PropReg.region_ID','Summ.heroImage','Summ.propertyName','Reviews.guestRating_expedia','Reviews.guestRating_hcom','Summ.referencePrice_value')
            ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','PropReg.property_ID')
            ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','Summ.propertyId_expedia')
            ->whereIn('property_ID',$cookies_hotels)
            ->distinct('property_ID')
            ->get()
            ->toArray();

        // dd($cookie_hotels_review1);

        $cookie_hotels_review = DB::table("T_summary_data_$locale as Summ")
        ->select('Summ.heroImage','Summ.propertyId_expedia as property_ID','Summ.city','Summ.propertyName','Summ.referencePrice_value')
        ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','Summ.propertyId_expedia')
        ->whereIn('Summ.propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();

        $cookie_hotels_loc = array_merge($cookie_hotels_loc,$cookie_hotels_region);

        // dd($cookie_hotels_review);

        // echo "<pre> cookie_hotels_loc ";print_r($cookie_hotels_loc);

        // echo "<pre> cookie_hotels_review ";print_r($cookie_hotels_review);

        // exit;


        foreach (array_merge($cookie_hotels_loc, $cookie_hotels_review) as $entry) {
            // dd($entry);
            // echo "<pre> entry ";print_r($entry);
            if (!isset($cookie_hotels_review[$entry->property_ID])) {
                $cookie_hotels_review[$entry->property_ID] = $entry;
                
            } else {
                foreach ($entry as $key => $value) {
                    $cookie_hotels_review[$entry->property_ID]->$key = $value;
                }
            }
        }

        // echo "<pre> cookie_hotels_review ";print_r($cookie_hotels_review);

        // echo "<pre> cookie_hotels_review final ";print_r($cookie_hotels_review);exit;

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

        // dd($hotels_cookies);

        // $js_format = $hotels_cookies;

        // Session::put('hotels_cookies', $hotels_cookies);

        session_start();

        // foreach($hotels_cookies as $hotel=>$values)
        // {
        //     $res = [];
        //     $regionId = DB::table("T_propertyID_regionID_$locale as PropReg")
        //     ->select('region_ID')
        //     ->where('property_ID',$values->propertyId_expedia)
        //     ->get();
        //     echo "regionId : ".$regionId;
        // }

        // dd($hotels_cookies);

        $_SESSION["hotels_cookies"] = $hotels_cookies;

        // $this->cookies_arr = $hotels_cookies;
        // $this->test = 'sadfdsafassad';

        // dd($this);
        // dd(session()->all());
        // echo "sess";
        // dd(Session::get('hotels_cookies'));

        // echo "<pre> cookies_arr ";print_r($this->cookies_arr);exit;
        // echo "<pre>";print_r($hotels_cities_cookies);exit;

    }
    
    return view('welcome',compact('staycation_cities','hotels','login','suggestCities','date','hotels_cookies','hotels_cities_cookies'));
}

public function getHotels(Request $request)
{
  

    $locale =  isset($request->locale)? $request->locale : 'enUS';
    $request->currency = isset($request->currency)? $request->currency : 'EUR';

    $hotels= DB::table("T_summary_data_$locale")
    ->select('heroImage','propertyName','city','country','rating','referencePrice_value')
    ->whereNotNull('rating')
    ->where('referencePrice_value','!=','0')
    ->where('province',$request->city)
    ->limit(12)
    ->orderBy('rating','desc')
    ->get()
    ->toArray();

    if($request->currency == 'USD')
    {
    return $hotels;
    }
    else
    {
        $exchange_rate = $this->currencyConversion($request->currency);
        foreach($hotels as $hotel)
        {
            $hotel->referencePrice_value = round(($hotel->referencePrice_value/$exchange_rate),2);
        }
        return $hotels;
    } 
}

public function suggestPlaces(Request $request)
{

    // old query 02 feb 

    // $suggestion = DB::table("T_idsRegions_$request->locale")
    // ->select('RegionID','ExtendedName','Type','ParentRegionId','Name')
    // ->whereNotNull('Name')
    // ->where('Name', 'ilike', "$request->search_word%")
    // ->orWhere('CountryName', 'ilike', "$request->search_word%")
    // // ->orWhere('CityName','ilike',"%$request->search_word%")
    // // ->whereIn('Type',['city', "airport","point_of_interest","country"])
    // ->whereIn('Type',['city', "airport","point_of_interest","country"])
    // ->whereNotNull('Name')
    // ->distinct('CountryName')
    // ->limit('200')
    // // ->groupBy('Type')
    // ->get()
    // ->toArray();

//   $res =   RegionUS::where('RegionID', 6047456)->get()->toArray();

//   dd($res);
    
    $suggestion = DB::table("T_idsRegions_$request->locale")
    ->select('RegionID','ExtendedName','Type','ParentRegionId','Name')
    ->whereNotNull('Name')
    ->where('Name', 'ilike', "$request->search_word%")
    ->orWhere('CountryName', 'ilike', "%$request->search_word%")
    // ->where('Name', 'ilike', "$request->search_word%")
    // ->orWhere('CountryName', 'ilike', "$request->search_word%")
    // ->orWhere('CityName','ilike',"%$request->search_word%")
    ->whereIn('Type',['city', "airport","point_of_interest","country"])
    // ->whereIn('Type',['city', "airport","point_of_interest","country"])
    ->whereNotNull('Name')
    ->distinct('Type')
    // ->groupBy('Type')
    ->limit('10')
    ->get()
    ->toArray();
       
    // dd($suggestion);

    return $suggestion;

}

public function locale(Request $request)
{
        // dd($request->locale);
        // dd('sadfdsfs');
        // dd($request);
        $locale_fetchdata = false;

        $user_country = 'India';

        $locale =  isset($request->locale)? $request->locale : 'enUS';
        
        $user_country_tr = $this->userCountry($locale,$user_country); 

        // $staycation_cities = DB::table("T_idsRegions_$locale")
        // ->select('ProvinceName','ParentRegionId','RegionID')
        // // ->distinct('ProvinceName') 
        // ->where('ProvinceName','!=','')
        // ->where('CountryName',"$user_country")
        // ->limit(5)
        // ->inRandomOrder()
        // ->get();

        // dd($user_country);

        $staycation_cities = DB::table("T_property_location_$locale")
        ->select('province','locationAttribute_city_id','locationAttribute_neighborhood_id')
        ->whereNotNull('locationAttribute_neighborhood_id')
        ->whereNotNull('locationAttribute_city_id')
        ->where('country',"$user_country_tr")
        ->inRandomOrder()
        ->limit(5)
        ->get()
        ->unique('province')
        ->toArray();
        
        // dd($staycation_cities);
    
        // $user_country 
        if(empty($staycation_cities) && count($staycation_cities) == 0)
        {
        $staycation_cities = DB::table("T_property_location_$locale")
        ->select('province','locationAttribute_city_id','locationAttribute_neighborhood_id')
        ->whereNotNull('locationAttribute_neighborhood_id')
        ->whereNotNull('locationAttribute_city_id')
        ->where('country',"$user_country")
        ->inRandomOrder()
        ->limit(5)
        ->get()
        ->unique('province')
        ->toArray();
         $locale_fetchdata = true;

        // dd($staycation_cities);
        }

    
        // $suggestCities = DB::table("T_idsRegions_$locale")
        // ->select('RegionID','Name','ExtendedName','Type','ParentRegionId')
        // ->where('CityName','!=','')
        // ->whereOr('CountryName','=',"$user_country_tr")
        // ->where('CountryName','like',"$user_country_tr")
        // ->distinct('CityName')
        // ->get();


        $suggestCities = DB::table("T_idsRegions_$request->locale")
        ->select('RegionID','ExtendedName','Type','ParentRegionId','Name')
        ->whereNotNull('Name')
        ->where('Name', 'ilike', "$request->search_word%")
        ->orWhere('CountryName', 'ilike', "$request->search_word%")
        // ->orWhere('CityName','ilike',"%$request->search_word%")
        // ->whereIn('Type',['city', "airport","point_of_interest","country"])
        ->whereIn('Type',['city', "airport","point_of_interest","country"])
        ->whereNotNull('Name')
        ->distinct('CountryName')
        ->limit('30')
        // ->groupBy('Type')
        ->get()
        ->toArray();

        // dd($staycation_cities);
    
        $hotels = DB::table("T_summary_data_$locale")
        ->select('heroImage','propertyName','city','country','rating','referencePrice_value')
        ->where('province',$staycation_cities["0"]->province)
        ->where('rating','!=','')
        ->limit(12)
        ->orderBy('rating','desc')
        ->get();

        //   dd('before!!!');

        $hotels_cookies =  array();
        $hotels_cities_cookies = array();
        
        
        if(isset($_COOKIE['hotel_ids']))
    {
        $cookies_hotels = explode(',',$_COOKIE['hotel_ids']);

        $cookies_hotels = array_reverse($cookies_hotels);

        $cookie_hotels_loc = DB::table("T_property_location_$locale as Location")
        ->select('Location.locationAttribute_distanceFromCityCenter','Location.city','Location.propertyName','Location.propertyId_expedia as property_ID','Location.locationAttribute_city_id','Location.locationAttribute_neighborhood_id','Location.geoLocation')
        ->whereIn('Location.propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();

        // dd($cookie_hotels_loc);

        $cookie_hotels_region = DB::table("T_propertyID_regionID_$locale as PropReg")
            ->select('Summ.city','PropReg.property_ID','PropReg.region_ID','Summ.heroImage','Summ.propertyName','Reviews.guestRating_expedia','Reviews.guestRating_hcom','Summ.referencePrice_value')
            ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','PropReg.property_ID')
            ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','Summ.propertyId_expedia')
            ->whereIn('property_ID',$cookies_hotels)
            ->distinct('property_ID')
            ->get()
            ->toArray();

        // dd($cookie_hotels_review1);

        $cookie_hotels_review = DB::table("T_summary_data_$locale as Summ")
        ->select('Summ.heroImage','Summ.propertyId_expedia as property_ID','Summ.city','Summ.propertyName','Summ.referencePrice_value')
        ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','Summ.propertyId_expedia')
        ->whereIn('Summ.propertyId_expedia',$cookies_hotels)
        ->get()
        ->toArray();

        $cookie_hotels_loc = array_merge($cookie_hotels_loc,$cookie_hotels_region);

        // dd($cookie_hotels_review);

        // echo "<pre> cookie_hotels_loc ";print_r($cookie_hotels_loc);

        // echo "<pre> cookie_hotels_review ";print_r($cookie_hotels_review);


        foreach (array_merge($cookie_hotels_loc, $cookie_hotels_review) as $entry) {
            // dd($entry);
            // echo "<pre> entry ";print_r($entry);
            if (!isset($cookie_hotels_review[$entry->property_ID])) {
                $cookie_hotels_review[$entry->property_ID] = $entry;
                
            } else {
                foreach ($entry as $key => $value) {
                    $cookie_hotels_review[$entry->property_ID]->$key = $value;
                }
            }
        }

        // echo "<pre> cookie_hotels_review ";print_r($cookie_hotels_review);
        // echo "<pre> cookie_hotels_review final ";print_r($cookie_hotels_review);exit;

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
    
            // dd($hotels_cookies);
  
            $_SESSION["hotels_cookies"] = $hotels_cookies;
        }
        
         
        $login = 1; 

        return view('welcome',compact('staycation_cities','hotels','login','suggestCities','hotels_cookies','hotels_cities_cookies'));
}

public function translate($sourceText,$sourceLang,$targetLang)
{
    $res = json_decode(file_get_contents('https://translate.googleapis.com/translate_a/single?client=gtx&sl='.$sourceLang.'&tl='.$targetLang.'&dt=t&q='.urlencode($sourceText)));
    return $res[0][0][0];
}

public function userCountry($locale,$user_country)
{

    if($locale == 'frFR')
    {
        return  $this->translate($user_country,'en','fr');
    }
    else if($locale == 'esES')
    {
        return $this->translate($user_country,'en','es');
    }
    else
    {
        return $user_country;
    }

}

public function currencyConversion($curr)
{
    $currency_rate = json_decode(file_get_contents("https://api.coinbase.com/v2/exchange-rates?currency=$curr"));
    $conv =  $currency_rate->data->rates->USD;
    return round($conv,5);
}


public function getapi(Request $request)
{

//    dd('dsafdsafsafsafsafsadfsafdsa');
$start = microtime(true);

$inputdata = $request->all();
//dd($inputdata);

$regionIds = $request->regionid;  

$parentregionIds = $request-> parentregionID;

$locale =  isset($request->locale)? $request->locale : 'enUS';


$user_country = 'India';

$user_country = $this->userCountry($locale,$user_country);

$hotels= DB::table('T_summary_data_enUS')
->select('T_summary_data_enUS.propertyId_expedia','T_summary_data_enUS.heroImage','T_summary_data_enUS.propertyName','T_summary_data_enUS.city',
'T_summary_data_enUS.country','T_summary_data_enUS.rating','T_summary_data_enUS.referencePrice_value','T_idsRegions_enUS.Name','T_summary_data_enUS.propertyType_name','T_summary_data_enUS.propertyId_hcom')
->join('T_idsRegions_enUS','T_idsRegions_enUS.CityName', '=', 'T_summary_data_enUS.city')
->where('RegionID',$regionIds)
->where('T_summary_data_enUS.referencePrice_value','!=',0)
->limit(5)
->get();

// dd($hotels);

$suggestCities = DB::table("T_idsRegions_$locale")
->select('RegionID','CityName','ProvinceName','CountryName','ParentRegionId','Name','Type','ExtendedName')
->where('CityName','!=','')
->whereOr('CountryName','=',"$user_country")
->where('CountryName','like',"$user_country")
->distinct('CityName')
->get()
->toArray();

// old query hide 06 feb 

// $hotelsdata = DB::table("T_summary_data_$locale as Summ")->select('Summ.rating','Summ.propertyName')
//        ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
//        ->join("T_property_images_enUS as Img",'Img.propertyId_expedia','Summ.propertyId_expedia')
//     // ->join("T_summary_data_$locale","T_summary_data_$locale.")
//        ->where('Reg.RegionID',$regionIds)
//        ->orderBy('Summ.rating','desc')
//     //    ->whereNull('Summ.rating')
//     //    ->groupBy('Summ.rating')
//     //    ->orWhere('Reg.ParentRegionId',$parentregionIds)     
//     //    ->where('referencePrice_value','!=','0')    
//     //    ->limit(5)
//         ->get();

// old query hide 06 feb 



// echo "<pre> hotelsdata ";print_r($hotelsdata);

//SELECT summarydata."propertyId_expedia",summarydata."heroImage",summarydata."propertyName",summarydata."country",summarydata."rating",summarydata."referencePrice_value",idregions."Name",idregions."CountryName",Img."images"
// FROM   "T_summary_data_enUS" summarydata
// JOIN   "T_idsRegions_enUS" idregions ON idregions."CityName" = summarydata."city"
// join  "T_property_images_enUS" Img ON Img."propertyId_expedia" = summarydata."propertyId_expedia"
// WHERE  idregions."RegionID" = RegionID;

    //    echo "<pre>sadfasfdsasa";print_r($hotelsdata);

    //    foreach($hotelsdata as $key =>$data){

    //         $images = array();
    // $regionIds
    //         if(isset($data->images))
    //         {

    //             $res = json_decode($data->images);
    //             $preview_images = array();
    //             $images = $res->ROOMS;
    //             $count = 0;
    //             foreach($images as $key=>$img_links)
    //             {
    //                 array_push($preview_images,$img_links->link);
    //                 $count++;
    //                 if($count == 3)
    //                 {
    //                     break;
    //                 }
    //             //    echo "<pre>";print_r($img_links->link)
    //             }
    //             // echo "<pre>";print_r($preview_images);
    //         }
    //     }
            // dd($images);
//         dd($hotelsdata);

// $hotelsdata = DB::select('Select getsearchhotel(?)',array($request->regionid));.



// original query in live price get


// $query = DB::table("T_summary_data_$locale as Summ")->select('Summ.rating','Summ.propertyName','Summ.propertyId_expedia')
// ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
// ->join("T_property_images_enUS as Img",'Img.propertyId_expedia','Summ.propertyId_expedia')
// // ->join("T_summary_data_$locale","T_summary_data_$locale.")
// ->where('Reg.RegionID',$regionIds)
// ->orderBy('Summ.rating','desc');


// $pageNumber = 1;

// $searchResults_count = DB::table("T_propertyID_regionID_enUS as propReg")
//                      ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
//                      ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
//                      ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
//                      ->where('propReg.region_ID',1029)
//                      ->distinct('propReg.property_ID')
//                      //->toSql();
//                      ->get()
//                      ->count();

                    //  echo "query : ".$searchResults_count;
                    //  ->toArray();
                    //  ->toSql();
                     
// echo "query : ";var_dump($searchResults_count);die;

// $res = $searchResults->paginate(20, ['*'], 'page', $pageNumber);
                     
// dd($searchResults);

// $hotelsdata = $query->get();

    //    ->whereNull('Summ.rating')
    //    ->groupBy('Summ.rating')
    //    ->orWhere('Reg.ParentRegionId',$parentregionIds)     
    //    ->where('referencePrice_value','!=','0')  

    // dd($hotelsdata);

    // select hotelsearchresultnew1('1029','0')

// $count_of_hotels = DB::select('Select getpropertyIdsandCount9(?,?)',array('1029','0'))

$searchResults_count = DB::table("T_propertyID_regionID_enUS as propReg")
                     ->select('Loc.propertyType_id')
                     ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
                     ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
                     ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
                     ->where('propReg.region_ID',$regionIds)
                     ->distinct('propReg.property_ID')
                    //  ->distinct('Loc.propertyType_id')
                     ->get()
                     ->count();

// echo "searchResults_count : ".$searchResults_count;dd('sadfdsafdsa');



                    //  ->get();


// $hotelsdatanew1 = DB::select('Select searchresultnewcountrate(?,?)',array('1029','0'));

// echo "all properties array : ".$searchResultsprice_count1;exit;

$hotelsdatanew = DB::select('Select searchresult(?,?)',array($regionIds,'0'));
    
// $searchResult = array_column($hotelsdatanew , 'hotelsearchresultnew1');
// echo "<pre> searchResult";print_r($hotelsdatanew);exit;

// array[to_json(jsonb_build_object('property_id', loc."propertyId_expedia"::text, 'property_name',loc."propertyName"::text,'propertyType_id',loc."propertyType_id"::text,'address1',loc."address1"::text,'address2',loc."address2"::text,'city',loc."city"::text,'province',loc."province"::text,'country',loc."country"::text,'geolocation',loc."geoLocation"::text,'distancecitycenter',loc."locationAttribute_distanceFromCityCenter"::text,'exp_rating',Reviews."guestRating_expedia"::text,'hcom_rating',Reviews."guestRating_hcom"::text,'main_image',Img."hero_link"::text,'images',Img."images"::text ))]

$result_search = array();
$overall_res = [];
foreach($hotelsdatanew as $result=>$property)
{
    $cval = stripslashes($property->searchresult);
    $val =  json_decode(substr($cval,2, -2));
    // dd($val);
    $prop_id = (string)$val->property_id;
    $overall_res[$prop_id] = array();
    $result_search['property_id'] = $val->property_id;
    $result_search['property_name'] = $val->property_name;
    $result_search['propertyType_id'] = $val->propertyType_id;
    $result_search['address1'] = $val->address1;
    $result_search['address2'] = $val->address2;
    $result_search['city'] = $val->city;
    $result_search['province'] = $val->province;
    $result_search['country'] = $val->country;
    $result_search['geolocation'] = $val->geolocation;
    $result_search['distancecitycenter'] = $val->distancecitycenter;
    $result_search['exp_rating'] = $val->exp_rating;
    $result_search['hcom_rating'] = $val->hcom_rating;
    $result_search['main_image'] = $val->main_image;
    $result_search['images'] = $val->images;
    $result_search['region_ID'] = $val->region_ID;
    $overall_res[$prop_id] = $result_search;
}

// echo "<pre> result_search";print_r($overall_res);

// echo "overall array keys : ".implode(",",array_values(array_keys($overall_res)));

$property_pricedata_API =   $this->cURLforhotelPrice($locale,implode(",",array_values(array_keys($overall_res))));

// dd($property_pricedata_API);



foreach (array_merge($property_pricedata_API, $overall_res) as $row) {
    $result_data[$row['property_id']] = ($property_pricedata_API[$row['property_id']] ?? []) + $row;
}

// dd($result_data);


// $result_data = array_map(function($property_pricedata_API,$overall_res){  
//     return array_merge(isset($property_pricedata_API) ? $property_pricedata_API : array(), isset($overall_res) ? $overall_res : array());
//      },$property_pricedata_API,$overall_res);  

// echo "<pre> result_data ";print_r($result_data);

// $time_elapsed_secs = microtime(true) - $start;

// dd($time_elapsed_secs);




// $hotelsdata = DB::select('Select hotelsearchresult(?,?)',array('1029','0'));

$property_ids = [];


// $searchResult = array_column($hotelsdata , 'hotelsearchresult');

// $property_ids = arrray_column($property_ids,'getpropertyIdsandCount');

// echo "<pre> searchResult ";print_r($searchResult);

// foreach($searchResult as $result=>$property)
// {
//     $data= explode(',',$property);
//     // echo "<pre> property";print_r($data);
//     array_push($property_ids,str_replace("{",'', $data[0]));

// }

// exit;
// echo "count : ".$count;

// echo "<pre> ";print_r($property_ids);

// $hotelsdata = DB::select('Select hotelsearchbyregionid_enus(?)',array($request->regionid));

// $property_pricedata  = array();

// if(isset($property_ids) && count($property_ids) > 0)
// {
//     if(count($property_ids) < 19)
//     {
//         echo "less than 20 hotels ";
//         // dd($hotelsdata);
//     }
//     else
//     {
//         // $property_ids = implode(",",array_values($hotelsdata->pluck('propertyId_expedia')->toArray()));
//         // echo "<pre>";print_r(implode(",",array_values($hotelsdata->pluck('propertyId_expedia')->toArray())));
//        $property_ids = implode(",",array_values($property_ids));
//     //    dd($property_ids);
//        $property_pricedata =   $this->cURLforhotelPrice($locale,$property_ids);
       
//        echo "<pre> property_pricedata ";print_r($property_pricedata);exit;
//     }  
// }


// original query in live price get



// $hotelsdata


// original query in hotelsearchbyregionid_enus function hide 09 feb


// $hotelsdata = DB::table("T_summary_data_$locale as Summ")->select('propReg.*')
//        ->join("T_propertyID_regionID_enUS as propReg",'propReg.property_ID', '=','Summ.propertyId_expedia')
//        ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','Summ.propertyId_expedia')
//        ->join("T_property_location_$locale as Location",'Location.propertyId_expedia','=','Summ.propertyId_expedia')
//     // ->join("T_summary_data_$locale","T_summary_data_$locale.")
//        ->where('propReg.region_ID','553248635976469332')
//        ->orderBy('Summ.rating','desc')
//     //    ->whereNull('Summ.rating')
//     //    ->groupBy('Summ.rating')
//     //    ->orWhere('Reg.ParentRegionId',$parentregionIds)     
//     //    ->where('referencePrice_value','!=','0')  
//        ->offset(20)  
//        ->limit(5)   
//        ->get();

// $pageNumber = 1;

// $searchResults = DB::table("T_propertyID_regionID_enUS as propReg")
//                      ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
//                      ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
//                      ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
//                      ->where('region_ID',$regionIds)
//                      ->orderBy('Loc.propertyType_id','asc')
//                      ->toSql();
                    //  
                    //  echo "query : ".$searchResults;die;

                    //  $res = $searchResults->paginate(20, ['*'], 'page', $pageNumber);
                     

// echo "<pre> searchResults ";print_r($res);exit;


// echo "<pre>";print_r($res);
// dd($searchResults);



// original query in hotelsearchbyregionid_enus function hide 09 feb


$hotelsdata = [];

$accfilter = $this->accommodationFilter($locale,$regionIds);

$starfilter = $this->starratingFilter($locale,$regionIds,count($hotelsdata));

$starfilter["unrated"] = count($hotelsdata) - array_sum(array_values($starfilter));

// echo "null rating count : ".$null_rating_count;exit;

// dd(count(array_sum($starfilter)));

// $unrated_hotel_count =  count(array_sum($starfilter));

//$accfilter = $this->accommodationFilter($locale,$regionIds);
// echo "<pre>";print_r($hotelsdata[0]->hotelsearchbyregionid_enus); echo "<br/>";
// $getdata = explode(',',$hotelsdata[0]->hotelsearchbyregionid_enus);
// var_dump($getdata);

// foreach($getdata as $key=>$images)
// {
    // var_dump($images);
    // echo json_decode($images);
//     if(strlen($images) > 100)
//     {
//         echo "images : ".$images."</br>";
//         $ser =  explode(' "" ',$images);
//         $val = json_decode($ser[0]);
//         echo "value : ".$val;
//         $lin = explode(':',$val);
//         var_dump($lin);exit;
//         echo "link : ".$lin[1];
//     }
// //     var_dump($images);
//    $ser =  explode(' "" ',$images);
//    print_r($ser);
    // if (in_array("images", $images))
    // {
    //     echo sprintf("'kitchen' is in '%s'", implode(', ', $arr));
    // }
// }
// exit;
// echo "<pre>";print_r($preview_images)

// dd('sadsasasa');

// 


//   $accfilter_req = DB::table("T_summary_data_$locale as Summ")
//             ->select('Summ.propertyType_name','Summ.propertyType_id')
//             ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
//             ->where('Reg.RegionID',$regionIds) 
//             ->whereIn('Summ.propertyType_id',$property_type_conv) 
//         //->orWhere('Reg.ParentRegionId',$parentregionIds)  
//             ->distinct('Summ.propertyType_id')
//             ->orderBy('Summ.propertyType_id','asc')
//             ->get()
//             ->toArray();




// dd($accfilter);
                     

                    //  DB::table("T_summary_data_enUS as Summ")
                    //  ->select('Summ.propertyType_name','Summ.propertyType_id')
                    //  ->join("T_idsRegions_enUS as Reg",'Reg.CityName', '=', 'Summ.city')
                    //  ->where('Reg.RegionID',$request->regionId) 
                    // //  ->where("Summ.propertyType_id",$id)
                    //  ->count();

// dd($accfilter);

// $accfilter1 = DB::table("T_summary_data_$locale as Summ")
// ->select('Summ.propertyType_name','Summ.propertyType_id')
// ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
// ->where('Reg.RegionID',$regionIds) 
// //->orWhere('Reg.ParentRegionId',$parentregionIds)  
// ->distinct('Summ.propertyType_id')
// ->get()
// ->toArray();                   
                     
                     
// echo "<pre> accfilter_propids : ";print_r($accfilter);exit;

                    


// try {
//     // Validate the value...
// dd('sdafssda');
// dd(SummaryUS::all()->pluck('propertyType_id')->limit(5));

    // $accfilter_propids =   SummaryUS::all();
// } catch (Throwable $e) {
//     report($e);
//     echo "error : ".$e;die;
// }

// $accfilter_propids =   DB::table("T_summary_data_$locale as Summ")->pluck('propertyType_id');
// ->select('propertyType_id')
// ->distinct('propertyType_id')
// ->limit(6)
// ->get()
// ->toArray();   


// echo "<pre> accfilter_propids : ";print_r($accfilter);exit;

// dd($accfilter_propids);




// $acc_type_filter_1 = DB::table("T_summary_data_enUS as Summ")
// ->select('propertyType_name')
// ->whereIn('propertyType_id',14)
// ->count();

// $acc_type_filter_2 = DB::table("T_summary_data_enUS as Summ")
// ->select('propertyType_name')
// ->where('propertyType_id',42)
// ->count();

// echo "acc_type_filter_1 ".$acc_type_filter_1."<br/>";
// echo "acc_type_filter_2 ".$acc_type_filter_2."<br/>";
// dd($acc_type_filter);


    // dd('dsafdsfsa');
return View::make('pages.afterlogin')
    ->with('login',1)
    // ->with('avatar_cond',false)
    // ->with('hotelsdata',$hotelsdata)
    ->with('propertyid',$regionIds)
    //->with('data',$data)
    ->with('suggestCities',$suggestCities)
    ->with('inputdata',$inputdata)
    ->with('accfilter',$accfilter)
    ->with('starfilter',$starfilter)
    ->with('search_result',$result_data)
    ->with('searchResults_count',$searchResults_count);

}


public function cURLforhotelPrice($locale,$property_Ids)
{
    // dd($locale);
    $locale = 'enUS';

    if($locale == 'enUS')
    {
        $Local = 'US';
    }
    else if($locale == 'frFR')
    {
        $Local = 'FR';
    }
    else if($locale == 'esES')
    {
        $Local = 'ES';
    }
    else{
        $Local = 'US';
    }

    $Request_data = DB::table("T_ApiAccess as API")
    ->where('Local',$Local)
    ->whereIn('agency',['expedia','Hcom'])
    ->get()
    ->toArray();

    $client = new Client();

    $check_in  = "2023-02-20";

    $check_out = "2023-02-25";

    $expedia_hotels_price = array();
    $hcom_hotels_price = array();

    // dd($property_Ids);
    // echo "<pre>";print_r($property_Ids);

    $uri_expedia = $Request_data[0]->EndPoint."?&ecomHotelIds=$property_Ids&checkIn=$check_in&checkOut=$check_out";

    $params_expedia['headers'] = [
        'Authorization' => "Basic ".$Request_data[0]->auth_token,
        'Accept' => $Request_data[0]->accept,
        'Partner-Transaction-Id'=> $Request_data[0]->partner_id,
        'Key' =>$Request_data[0]->f_key
    ];

    // echo "uri_expedia : ".$uri_expedia;

    // echo "<pre> params_expedia ";print_r($params_expedia);

    $response_expedia = $client->request('get', $uri_expedia, $params_expedia);

    $data_expedia = json_decode($response_expedia->getBody(), true);

    // echo "exxpedia";dd($data_expedia);
   
    if(isset($data_expedia['Hotels']))
    {
        $expedia_hotels_price = $data_expedia['Hotels']; 
    }
    else
    {
        $expedia_hotels_price['status'] = 404;
        $expedia_hotels_price['message'] = 'No hotels found in Expedia!!!';
    }

    // required array expedia

    $uri_hcom = $Request_data[1]->EndPoint."?&ecomHotelIds=$property_Ids&checkIn=$check_in&checkOut=$check_out";

    $params_hcom['headers'] = [
        'Authorization' => "Basic ".$Request_data[1]->auth_token,
        'Accept' => $Request_data[1]->accept,
        'Partner-Transaction-Id'=> $Request_data[1]->partner_id,
        'Key' =>$Request_data[1]->f_key
    ];

    $response_hcom = $client->request('get', $uri_hcom, $params_hcom);

    $data_hcom = json_decode($response_hcom->getBody(), true);

    if(isset($data_hcom['Hotels']))
    {
        $hcom_hotels_price = $data_hcom['Hotels'];
    }
    else
    {
        $hcom_hotels_price['status'] = 404;
        $hcom_hotels_price['message'] = 'No hotels found in Hcom!!!';
    }
   
    if( isset($expedia_hotels_price["status"]) && isset($hcom_hotels_price["status"]) )
    {
        // echo "<pre> expedia ";print_r($expedia_hotels_price);
        // echo "<pre> hcom ";print_r($hcom_hotels_price);
        // exit;
        $status = false;
        return $this->priceresultExpediaandHcom($expedia_hotels_price,$hcom_hotels_price,$status,$property_Ids);
    }
    else
    {
        $status = true;
        return $this->priceresultExpediaandHcom($expedia_hotels_price,$hcom_hotels_price,$status,$property_Ids);
    }
   // required array expedia
}

public function priceresultExpediaandHcom($expedia,$hcom,$status,$property_Ids)
{  
    if($status)
    {
        $expedia_arr = array();
        $hcom_arr = array(); 
    
        foreach($expedia as $expedia_hotel=>$expedia_hoteldata)
        {
            $property_id = (string) $expedia_hoteldata['Id'];
            // dd($property_id);
            $expedia_arr[$property_id] = array();

            $response_exp = array();

            if(($expedia_hoteldata['Status'] == 'AVAILABLE'))
            {
            $response_exp["exp_status"] = 1;
            $response_exp["property_id"] = $property_id;
            $response_exp["totalprice_expedia"] = $expedia_hoteldata["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"];
            $response_exp["tax_amount"] = $expedia_hoteldata["RoomTypes"][0]["Price"]["TaxesAndFees"];
            $response_exp["avgprice_expedia"] =  $expedia_hoteldata["RoomTypes"][0]["Price"]["AvgNightlyRate"];
            // $response_exp["expedia_link"] = $expedia_hoteldata['RoomTypes'][0]["Links"]["WebDetails"]["Href"];
            $expedia_arr[$property_id] = $response_exp;
            }
            else
            {
            $response_exp["exp_status"] = 0;
            $response_exp["property_id"] = $property_id;
            $expedia_arr[$property_id] = $response_exp;
            }

       }

       foreach($hcom as $hcom_hotel=>$hcom_hoteldata)
       {

           $property_id = (string) $hcom_hoteldata['Id'];

           $hcom_arr[$property_id] = array();

           $response_hcom = array();

           if(($hcom_hoteldata['Status'] == 'AVAILABLE'))
           {
           $response_hcom["hcom_status"] = 1;
           $response_hcom["property_id"] = $property_id;
           //dd($response_exp["property_id"]);
           $response_hcom["totalprice_hcom"] = $hcom_hoteldata["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"];
           $response_hcom["tax_amount"] = $hcom_hoteldata["RoomTypes"][0]["Price"]["TaxesAndFees"];
           $response_hcom["avgprice_hcom"] =  $hcom_hoteldata["RoomTypes"][0]["Price"]["AvgNightlyRate"];
           //$response_hcom["hcom_link"] = $hcom_hoteldata['RoomTypes'][0]["Links"]["WebDetails"]["Href"];
           $hcom_arr[$property_id] = $response_hcom;
           }
           else
           {
           $response_hcom["hcom_status"] = 0;
           $response_hcom["property_id"] = $property_id;
           $hcom_arr[$property_id] = $response_hcom;
           }

        }

    //   echo "<pre> expedia ";print_r($expedia_arr);
    //   echo "<pre> hcom ";print_r($hcom_arr);
  
    //   $price_response = array_merge($expedia_arr,$hcom_arr);
    // if()/
    // dd($price_response);

    foreach (array_merge($expedia_arr, $hcom_arr) as $row) {
        $price_response[$row['property_id']] = ($price_response[$row['property_id']] ?? []) + $row;
    }
   
    // dd($price_response);
    }
    else
    {
        $price_response['status_code'] = 404;
        $price_response['message'] = 'No results found!!!';
        $price_response['property_Ids'] = $property_Ids;
    }   

    return $price_response;
    // dd($price_response);
}



public function accommodationFilter($locale,$regionIds)
{


$property_type_conv_Ids = PropertyType::where('Property_Type','Conventional Lodging')->pluck('Category_ID')->toArray();

$property_type_vacation_Ids = PropertyType::where('Property_Type','Vacation Rental')->pluck('Category_ID')->toArray();


// echo "property_type_conv_Ids count : ".count($property_type_conv_Ids)."<br/>";

// echo "property_type_vacation_Ids count : ".count($property_type_vacation_Ids)."<br/>";

// echo "<pre> property_type_conv_Ids ";print_r($property_type_conv_Ids)."<br/>";

// echo "<pre> property_type_vacation_Ids ";print_r($property_type_vacation_Ids)."<br/>";


$total = count($property_type_conv_Ids) + count($property_type_vacation_Ids)."<br/>";

// echo "total count : ".$total."<br/>";

$overall_prop_Ids = array_merge($property_type_conv_Ids,$property_type_vacation_Ids);

// echo "<pre> overall_prop_Ids ";print_r($overall_prop_Ids)."<br/>";

// echo "accfilter_count  overall region : ".count($accfilter)."<br/>";

// echo "property_type_conv_Ids count : ".count($property_type_conv_Ids);exit;

$accfilter_count = DB::table("T_summary_data_$locale as Summ")
                     ->select('Summ.propertyType_name','Summ.propertyType_id')
                     ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
                     ->where('Reg.RegionID',$regionIds) 
                     ->whereIn('Summ.propertyType_id',$property_type_conv_Ids)
                   //->orWhere('Reg.ParentRegionId',$parentregionIds)  
                     ->distinct('Summ.propertyType_id')
                     ->get()
                     ->count();
                     
$accfilter_new_conv =  DB::table("T_summary_data_$locale as Summ")
                    ->select('Summ.propertyType_name','Summ.propertyType_id')
                    ->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
                    ->where('Reg.RegionID',$regionIds) 
                    ->whereIn('Summ.propertyType_id',$property_type_conv_Ids)
                    //->orWhere('Reg.ParentRegionId',$parentregionIds)  
                    ->distinct('Summ.propertyType_id')
                    ->get()
                    ->toArray();


$accfilter_new_vac =    DB::table("T_summary_data_$locale as Summ")
->select('Summ.propertyType_name','Summ.propertyType_id')
->join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'Summ.city')
->where('Reg.RegionID',$regionIds) 
->whereIn('Summ.propertyType_id',$property_type_vacation_Ids)
//->orWhere('Reg.ParentRegionId',$parentregionIds)  
->distinct('Summ.propertyType_id')
->get()
->toArray();     




$accfilter = array_merge($accfilter_new_conv,$accfilter_new_vac);

$accfilter["convenditional_hotelcount"] = $accfilter_count;

$prop_ids = array();

for($i=0; $i< count($accfilter)-1; $i++)
{
$cell=$accfilter[$i];
$prop_ids[] = $accfilter[$i]->propertyType_id;
}

$index = 0;

foreach($prop_ids as $id)
{       
    $accfilter[$index]->count = DB::table("T_summary_data_$locale as Summ")
    ->select('Summ.propertyType_name','Summ.propertyType_id')
    ->join("T_idsRegions_enUS as Reg",'Reg.CityName', '=', 'Summ.city')
    ->where('Reg.RegionID',$regionIds) 
    ->where("Summ.propertyType_id",$accfilter[$index]->propertyType_id)
    ->count();  
     $index++;  
               //->orWhere('Reg.ParentRegionId',$parentregionIds)  
}

// echo "asdfdsss";
// dd($accfilter);

    return $accfilter;
}


public function starratingFilter($locale,$regionIds,$total_hotelcount)
{

    // echo "total_hotelcount : ".$total_hotelcount;

    $rating_for_region = SummaryUS::join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'city')->whereNotNull('rating')->where('Reg.RegionID',$regionIds)->distinct('rating')->orderBy('rating','desc')->pluck('rating')->toArray();

    // echo "<pre> starrating : ";print_r($rating_for_region);
    
    $starrating_count = SummaryUS::join("T_idsRegions_$locale as Reg",'Reg.CityName', '=', 'city')
    ->select(SummaryUS::raw('count(*) as rating_count'))
    ->where('Reg.RegionID',$regionIds)
    ->whereIn('rating',$rating_for_region)
    ->distinct('rating')
    ->groupBy('rating')
    ->orderBy('rating','desc')
    ->get()
    ->toArray();
    

    $res =  $this->grouparray_by_keyname($starrating_count,'1');

    // dd($res);

    $rating_map_count = [];

    for($index=0;$index < count($rating_for_region);$index++)
    {
    $org_float =  (float)$rating_for_region[$index];
    $rating_map_count[$index][ceil($org_float)] = $res["rating_count"][$index];
    }
    
    
    // echo "<pre> rating_map_arrcount ";print_r($rating_map_count);
    // echo "<pre> starrating_count ";print_r($starrating_count);exit;

    return $this->grouparray_by_keyname($rating_map_count,'2');

}


public function grouparray_by_keyname($arr,$type)
{ 
    $result = array();
    if($type == 2)
    {
        // echo "<pre>";print_r($arr);
        $res_filter = array();
        foreach ($arr as $sub) {
          foreach ($sub as $k => $v) {
            $result[$k][] = $v;
          }
          foreach($result as $item=>$value)
          {
              $res_filter[$item] = array_sum($value);
              // echo "<pre> value";print_r($value);exit;
          }
        }
        // dd($res);
        return $res_filter;
    }
    else{
        $result = array();
        foreach ($arr as $sub) {
          foreach ($sub as $k => $v) {
            $result[$k][] = $v;
          }
        }
    }
        return $result;
}


public function cURL($Request_data,$propertyId,$type,$locale)
{

$links = array();
$client = new Client();
if($type == "partnerlink")
{
    foreach ($Request_data as $API_Request_data => $header_value) {
        $uri = $header_value->EndPoint."?&ecomHotelIds=$propertyId";
        $params['headers'] = [
            'Authorization' => "Basic ".$header_value->auth_token,
            'Accept' => $header_value->accept,
            'Partner-Transaction-Id'=> $header_value->partner_id,
            'Key' =>$header_value->f_key
        ];
        $response = $client->request('get', $uri, $params);
        $data = json_decode($response->getBody(), true);
        // dd($data);
        $link = isset($data['Hotels'][0]['RoomTypes']) ? $data['Hotels'][0]['RoomTypes'][0]["Links"]["WebDetails"]["Href"]  : $data['Hotels'][0]['Links']['WebSearchResult']['Href'];
        array_push($links,$link);
}

return $links;

}
else
{
    $uri = $Request_data->EndPoint."?&regionIds=$propertyId";
    $params['headers'] = [
        'Authorization' => "Basic ".$Request_data->auth_token,
        'Accept' => $Request_data->accept,
        'Partner-Transaction-Id'=> $Request_data->partner_id,
        'Key' =>$Request_data->f_key
    ];

    // echo "<pre>uri";print_r($uri);
    $response = $client->request('get', $uri, $params);
   
    $data = json_decode($response->getBody(), true);
    // dd($data);
    // dd($data);
    
    $result = array_splice($data['Hotels'],0,12);

    // echo "<pre>";print_r($result);exit;
    $property_IDs = array();
    foreach($result as $result_filter){
        array_push($property_IDs,$result_filter["Id"]);
    }
    //   echo "<pre>";print_r($property_IDs);

$result_filter = DB::table("T_summary_data_enUS as Summ")
->whereIn('Summ.propertyId_expedia',$property_IDs)
->get();

// return $

// dd($search);exit;

    return $result_filter;
}

}
// public function similarHotelsnearBy()
// {
//     $similar_hotels  = DB::table("T_summary_data_$request->locale as Summ")
// ->join("T_property_description_$request->locale as Desc",'T_idsRegions_enUS.RegionID', '=', 'Summ.RegionID')
// ->where('Summ.city','Libreville')
// ->limit(5)
// ->get();
// }


public function gethotelsbyRegionId(Request $request)
{
    //    return $this->apiAccess($request);    
    
    $staycation_hotels_joinsum  = DB::table("T_property_location_$request->locale as Location")
                        ->select('Summ.propertyType_name',
                        'Summ.propertyType_id','Summ.rating','Location.propertyId_expedia','Location.propertyId_hcom','Summ.propertyName','Summ.heroImage','Summ.referencePrice_value','Summ.city','Summ.country')
                        ->join("T_summary_data_$request->locale as Summ",'Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
                        // ->join('T_idsRegions_enUS as Region','Region.RegionID', '=', 'Location.locationAttribute_neighborhood_id')
                        // ->whereNotNull('Summ.rating')
                        ->where('Summ.propertyType_id','=',1)
                        ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
                        ->orWhere('Location.locationAttribute_city_id', $request->city_id)
                        // ->whereNotNull('Summ.rating')
                        ->where('Summ.propertyType_id','=',1)
                        ->orderBy('Summ.rating','desc')
                        // ->unique('Summ.city')
                        // ->toSql();
                        ->limit(15)
                        ->get()
                        // ->unique('Summ.city')
                        ->toArray();
    //    dd($staycation_hotels_joinsum);/

      

    
        // $staycation_alone = DB::table("T_property_location_$request->locale as Location")
        // // ->select('Location.city','Location.country','Location.propertyName','Img.hero_link','Img.hero_title','Location.propertyId_expedia','Location.propertyType_id','Location.propertyType_name')
        // //->join("T_property_images_enUS as Img",'Img.propertyId_expedia', '=', 'Location.propertyId_expedia')
        // ->join("T_summary_data_$request->locale as Summ",'Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
        // ->where('Location.propertyType_id',1)
        // ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
        // ->orWhere('locationAttribute_city_id', $request->city_id)
        // ->where('Location.propertyType_id',1)
        // ->limit(15)
        // ->get()
        // ->toArray();

        // dd($staycation_alone);

        if(count($staycation_hotels_joinsum) < 4)
        {

            $staycation_hotels_joinregion = DB::table("T_property_location_$request->locale as Location")
            // ->select('Location.propertyId_expedia','Location.propertyId_hcom','Location.propertyName','Summ.heroImage','Summ.rating','Summ.referencePrice_value','Summ.city','Summ.country','Summ.propertyType_name')
            //->join('T_summary_data_enUS as Summ','Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
            // ->join("T_idsRegions_$request->locale as Region",'Region.ParentRegionId', '=', 'Location.locationAttribute_region_id')
            ->where('Location.propertyType_id',1)
            ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
            ->orWhere('Location.locationAttribute_city_id', $request->city_id)
            ->limit(100)
            // ->toSql()
            ->get()
            ->toArray();
            
    
            $staycation_hotels_joinsum  = DB::table("T_property_location_enUS as Location")
            ->select('Summ.propertyType_name',
            'Summ.propertyType_id','Summ.rating','Location.propertyId_expedia','Location.propertyId_hcom','Summ.propertyName','Summ.heroImage','Summ.referencePrice_value','Summ.city','Summ.country')
            ->join("T_summary_data_enUS as Summ",'Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
            ->join('T_idsRegions_enUS as Region','Region.RegionID', '=', 'Location.locationAttribute_neighborhood_id')
            //->join('T_idsRegions_enUS as Region','Region.ParentRegionId', '=', 'Location.locationAttribute_neighborhood_id')
            // ->whereNotNull('Summ.rating')
            ->where('Summ.propertyType_id','=',1)
            ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
            ->orWhere('Location.locationAttribute_city_id', $request->city_id)
            // ->whereNotNull('Summ.rating')
            ->where('Summ.propertyType_id','=',1)
            ->orderBy('Summ.rating','desc')
            ->limit(15)
            // ->toSql();
            ->get()
            ->toArray();


            $staycation_hotels_joinregion = DB::table("T_property_location_$request->locale as Location")
            // ->select('Location.propertyId_expedia','Location.propertyId_hcom','Location.propertyName','Summ.heroImage','Summ.rating','Summ.referencePrice_value','Summ.city','Summ.country','Summ.propertyType_name')
            //->join('T_summary_data_enUS as Summ','Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
            ->join("T_idsRegions_$request->locale as Region",'Region.RegionID', '=', 'Location.locationAttribute_region_id')
            ->where('Location.propertyType_id',1)
            ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
            ->limit(100)
            // ->toSql()
            ->get()
            ->toArray();


            // dd('asdfdsa');
            // $staycation_hotels_joinsum  = DB::table("T_property_location_$request->locale as Location")
            // ->select('Location.propertyId_expedia','Location.propertyId_hcom','Summ.propertyName','Summ.propertyType_id','Summ.heroImage','Summ.rating','Summ.referencePrice_value','Summ.city','Summ.country','Summ.propertyType_name')
            // ->join("T_summary_data_$request->locale as Summ",'Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
            // // ->join('T_idsRegions_enUS as Region','Region.RegionID', '=', 'Location.locationAttribute_neighborhood_id')
            // ->whereNotNull('Summ.rating')
            // ->where('Summ.propertyType_id','1')
            // ->where('Summ.referencePrice_value','!=','0')
            // ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
            // ->orWhere('Location.locationAttribute_city_id', $request->city_id)
            // ->get()
            // ->toArray();



    $staycation_alone = DB::table("T_property_location_$request->locale as Location")
    // ->select('Location.city','Location.country','Location.propertyName','Img.hero_link','Img.hero_title','Location.propertyId_expedia','Location.propertyType_id','Location.propertyType_name')
    //->join("T_property_images_enUS as Img",'Img.propertyId_expedia', '=', 'Location.propertyId_expedia')
    ->join("T_summary_data_$request->locale as Summ",'Summ.propertyId_expedia', '=', 'Location.propertyId_expedia')
    // ->whereNotNull('Location.propertyType_id')
    // ->where('Location.propertyType_id',1)
    ->where('Location.locationAttribute_neighborhood_id',$request->neighborhood_id)
    ->orWhere('locationAttribute_city_id', $request->city_id)
    ->limit(15)
    ->get()
    ->toArray();
    
    //  $hotel_ids = array();

    //  foreach($staycation_alone as $staycation)
    //  {
    //     array_push($hotel_ids,$staycation->propertyId_expedia);
        
    //  }
     
    //  echo "<pre> hotel_ids ";print_r($hotel_ids);
    //  echo "<pre> staycation_hotels_joinsum ";print_r($staycation_hotels_joinsum);
    //  echo "<pre> staycation_hotels_joinregion ";print_r($staycation_hotels_joinregion);
    //  echo "<pre> staycation_alone ";print_r($staycation_alone);exit;
    


        }
            // $where = $staycation_hotels_joinsum->where('locationAttribute_city_id', $request->city_id);
            // dd($where);
            // dd($staycation_hotels_joinsum);

           if($request->locale)
           {
            $exchange_rate = $this->currencyConversion($request->currency);
            foreach( $staycation_hotels_joinsum as $hotel)
            {
                $hotel->referencePrice_value = round(($hotel->referencePrice_value/$exchange_rate),2);
                $hotel->curr_symbol = $request->symbol;
                $hotel->curr_name = $request->currency;
            }
            // dd($staycation_hotels_joinsum);
            return $staycation_hotels_joinsum;
           }

    return $staycation_hotels_joinsum;
    
}

public function getcitiesCookies(Request $request)
{
    session_start();
      
    // dd($_SESSION);

    $cookies_hotels = $_SESSION['hotels_cookies'];


    $click_city = $request->city;

    if($click_city["city"] != 'all_cities')
    {
        $result = [];
        for ($i=0; $i < count($cookies_hotels); $i++) { 
            if($cookies_hotels[$i]->city == $click_city["city"])
            {
                // echo "<pre> ";print_r($cookies_hotels[$i]);
                $result[] = $cookies_hotels[$i];
            }
        }
        return $result;
    }
    else
    {
        return $cookies_hotels;
    }
    // echo "<pre> session : ";print_r($_SESSION['hotels_cookies']);echo '<br/>';

}


public function getPropertiesSearch(Request $request)
{
    // dd($request);
    session_start();
    $region_ID = $request->region_ID;
    $offset = $request->offset;

$hotelsdatanew = DB::select('Select searchresult(?,?)',array('1029',"$offset"));
    
$result_search = array();

$overall_res = [];

foreach($hotelsdatanew as $result=>$property)
{
    $cval = stripslashes($property->searchresult);
    $val =  json_decode(substr($cval,2, -2));
    // dd($val);
    $prop_id = (string)$val->property_id;
    $overall_res[$prop_id] = array();
    $result_search['property_id'] = $val->property_id;
    $result_search['property_name'] = $val->property_name;
    $result_search['propertyType_id'] = $val->propertyType_id;
    $result_search['address1'] = $val->address1;
    $result_search['address2'] = $val->address2;
    $result_search['city'] = $val->city;
    $result_search['province'] = $val->province;
    $result_search['country'] = $val->country;
    $result_search['geolocation'] = $val->geolocation;
    $result_search['distancecitycenter'] = $val->distancecitycenter;
    $result_search['exp_rating'] = $val->exp_rating;
    $result_search['hcom_rating'] = $val->hcom_rating;
    $result_search['main_image'] = $val->main_image;
    $result_search['images'] = $val->images;
    $result_search['region_ID'] = $val->region_ID;
    $overall_res[$prop_id] = $result_search;
}

// echo "<pre> result_search";print_r($overall_res);

// echo "overall array keys : ".implode(",",array_values(array_keys($overall_res)));

$property_pricedata_API =   $this->cURLforhotelPrice('enUS',implode(",",array_values(array_keys($overall_res))));

// dd($property_pricedata_API);

// echo "<pre> property_pricedata_API ";print_r($property_pricedata_API);

// echo "<pre> property_pricedata_API ";print_r($property_pricedata_API);

// echo "<pre> overall_res ";print_r($overall_res);exit;

if(isset($property_pricedata_API["status_code"]) != 404)
{
    $res = array_merge($property_pricedata_API, $overall_res);
    // echo "<pre>";print_r($res);
    foreach (array_merge($property_pricedata_API, $overall_res) as $row) {
        $result_data[$row['property_id']] = ($property_pricedata_API[$row['property_id']] ?? []) + $row;
    }
    
    // echo "<pre>";print_r($result_data);
}
else
{
    $result_data['status'] = $property_pricedata_API["status_code"];
    $result_data['message'] = $property_pricedata_API["message"];
    $result_data['property_Ids'] = $property_pricedata_API["property_Ids"];
}

// dd($result_data);
return $result_data;

}


public function pcURL($locale,$property_Ids)
{


$links = array();

$client = new Client();


 $checkIn = '2023-05-25';

 $checkOut = '2023-05-28';

if($locale == 'enUS')
{
    $Local = 'US';
}
else if($locale == 'frFR')
{
    $Local = 'FR';
}
else if($locale == 'esES')
{
    $Local = 'ES';
}
else{
    $Local = 'US';
}

$Request_data = DB::table("T_ApiAccess as API")
->where('Local',$Local)
->whereIn('agency',['expedia','Hcom'])
->get()
->toArray();

$uri_expedia = $Request_data[0]->EndPoint."?&ecomHotelIds=$property_Ids&checkIn=$checkIn&checkOut=$checkOut";

$params_expedia['headers'] = [
    'Authorization' => "Basic ".$Request_data[0]->auth_token,
    'Accept' => $Request_data[0]->accept,
    'Partner-Transaction-Id'=> $Request_data[0]->partner_id,
    'Key' =>$Request_data[0]->f_key
];

// echo "<pre> params_expedia ";print_r($params_expedia);

$response_expedia = $client->request('get', $uri_expedia, $params_expedia);

$data_expedia = json_decode($response_expedia->getBody(), true);

$collection_exp  = $data_expedia["Hotels"];

// for particular hotels price 

// $res_exp = array_filter($collection_exp, fn($v) => $v["Id"] == '77952549');

// for available hotels price expedia org

$res_exp = array_filter($collection_exp, fn($v) =>  $v["Status"] != 'NOT_AVAILABLE' ?  $v["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"] : ''

);

// for not available hotels price 

// $res_exp = array_filter($collection_exp, fn($v) => $v["Status"] == 'NOT_AVAILABLE' ? $v : '');

echo "<pre>";print_r($res_exp);

$uri_hcom = $Request_data[1]->EndPoint."?&ecomHotelIds=$property_Ids&checkIn=$checkIn&checkOut=$checkOut";

$params_hcom['headers'] = [
    'Authorization' => "Basic ".$Request_data[1]->auth_token,
    'Accept' => $Request_data[1]->accept,
    'Partner-Transaction-Id'=> $Request_data[1]->partner_id,
    'Key' =>$Request_data[1]->f_key
];

$response_hcom = $client->request('get', $uri_hcom, $params_hcom);

$data_hcom = json_decode($response_hcom->getBody(), true);

$collection_hcom  = $data_hcom["Hotels"];

// for particular hotels hcom price 

// $res_hcom = array_filter($collection_hcom, fn($v) => $v["Id"] == '77952549');

// for available hotels price hcom org

$res_price_exp = array();

$res_hcom = array_filter($collection_hcom, fn($v) => $v["Status"] != 'NOT_AVAILABLE' ? $v : '');

// for not available hotels hcom price 

// $res_hcom = array_filter($collection_hcom, fn($v) => $v["Status"] == 'NOT_AVAILABLE' ? $v : '');

// echo "<pre> res_hcom ";print_r($res_price_exp);exit;

// $filtered = $collection->where('Id','77952549');
// dd($res);

}


public function filterprice($property)
{
//     array_push($res_price_exp,$property["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]);
// return $res_price_exp;
    return $property["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"];
}



}

?>





