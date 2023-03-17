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

use Illuminate\Database\QueryException;

use View;

session_start();

class SearchHotelController extends Controller
{
    public function getapi(Request $request)
    {
    
    // dd('test!!!');

    // dd($request->regionid);
    $inputdata = $request->all();

    $locale =  isset($request->locale)? $request->locale : 'enUS';

    $checkIn = date("Y-m-d", strtotime($request->checkIn));  

    $checkOut = date("Y-m-d", strtotime($request->checkOut));  

    $data = $this->searchwithRegionId($locale,$request->regionid,$checkIn,$checkOut);

    // dd($data['overall_result']);
    //dd($data);
//   return $data;
    //dd($inputdata);
    
//     $regionIds = $request->regionid;  
    
//     $parentregionIds = $request-> parentregionID;
    
//     $locale =  isset($request->locale)? $request->locale : 'enUS';
    
    
//     $user_country = 'India';
    
//     //$user_country = $this->userCountry($locale,$user_country);
    
//     $hotels= DB::table('T_summary_data_enUS')
//     ->select('T_summary_data_enUS.propertyId_expedia','T_summary_data_enUS.heroImage','T_summary_data_enUS.propertyName','T_summary_data_enUS.city',
//     'T_summary_data_enUS.country','T_summary_data_enUS.rating','T_summary_data_enUS.referencePrice_value','T_idsRegions_enUS.Name','T_summary_data_enUS.propertyType_name','T_summary_data_enUS.propertyId_hcom')
//     ->join('T_idsRegions_enUS','T_idsRegions_enUS.CityName', '=', 'T_summary_data_enUS.city')
//     ->where('RegionID',$regionIds)
//     ->where('T_summary_data_enUS.referencePrice_value','!=',0)
//     ->limit(5)
//     ->get();
    
//     // dd($hotels);
    


//     // $hotelsdata = DB::select('Select hotelsearchbyregionid_enus(?)',array($request->regionid));



//       // count final

//       $prop = DB::table("T_propertyID_regionID_enUS as propReg")
//       ->select(array('Summ.propertyType_id', DB::raw('COUNT(*) as count')))
//       // ->select('Summ.propertyType_id', DB::raw('count(*) as count'))
//       ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
//       ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
//       ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
//       ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
//       ->where('propReg.region_ID',$regionIds)
//       // ->distinct('Summ.propertyId_expedia')
//       ->distinct('Summ.propertyType_id')
//       ->groupBy('Summ.propertyType_id')
//       // ->pluck('Summ.propertyType_id');
//       // ->toSql();
//       ->get();

//       // dd($prop);

//     // echo "sqwl : ".$prop;die;

    
// $searchResults_count = DB::table("T_propertyID_regionID_enUS as propReg")
// ->select('Loc.propertyType_id')
// ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
// ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
// ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
// ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
// ->where('propReg.region_ID',$regionIds)
// ->distinct('propReg.property_ID')
// //  ->distinct('Loc.propertyType_id')
// ->get()
// ->count();


    
//     $accfilter = $this->accommodationFilter($locale,$regionIds);

//     $starfilter = $this->starratingFilter($locale,$regionIds);

//     $starfilter["unrated"] = $searchResults_count - array_sum(array_values($starfilter));

//     // dd($starfilter);
// // echo "searchResults_count : ".$searchResults_count;


// $hotelsdatanew = DB::select('Select remove_filter_result(?)',array("$regionIds"));



// $result_search = array();

// $overall_res = [];

// foreach($hotelsdatanew as $result=>$property)
// {
//     $cval = stripslashes($property->searchresult);
//     $val =  json_decode(substr($cval,2, -2));
//     // dd($val);
//     $prop_id = (string)$val->property_id;
//     $overall_res[$prop_id] = array();
//     $result_search['property_id'] = $val->property_id;
//     $result_search['property_name'] = $val->property_name;
//     $result_search['propertyType_id'] = $val->propertyType_id;
//     $result_search['address1'] = $val->address1;
//     $result_search['address2'] = $val->address2;
//     $result_search['city'] = $val->city;
//     $result_search['province'] = $val->province;
//     $result_search['country'] = $val->country;
//     $result_search['geolocation'] = $val->geolocation;
//     $result_search['distancecitycenter'] = $val->distancecitycenter;
//     $result_search['exp_rating'] = $val->exp_rating;
//     $result_search['hcom_rating'] = $val->hcom_rating;
//     $result_search['main_image'] = $val->main_image;
//     $result_search['images'] = $val->images;
//     $result_search['rating'] = $val->rating;
//     $result_search['region_ID'] = $val->region_ID;
//     $overall_res[$prop_id] = $result_search;
// }

// // echo "<pre> result_search";print_r($overall_res);

// // echo "overall array keys : ".implode(",",array_values(array_keys($overall_res)));
// $checkIn = date("Y-m-d", strtotime($request->checkIn));  
// $checkOut = date("Y-m-d", strtotime($request->checkOut));  

// $_SESSION["check_in"] = $checkIn;
// $_SESSION["check_out"] = $checkOut;

// // if(count($overall_res) > 0)
// // {
// //   $property_pricedata_API =   $this->cURLforhotelPrice($locale,implode(",",array_values(array_keys($overall_res))));
   
// // //   dd($property_pricedata_API);

// //   foreach (array_merge($property_pricedata_API, $overall_res) as $row) {
// //     $result_data[$row['property_id']] = ($property_pricedata_API[$row['property_id']] ?? []) + $row;
// // }

// // // echo "<pre>";print_r($result_data);exit;
     
// // }
// // else
// // {
// //   $result_data['status_code'] = 404;
// //   $result_data['message'] = 'No results found!!!';
// // }


// // get price range count :



// $searchResults_count = DB::table("T_propertyID_regionID_enUS as propReg")
// ->select('Loc.propertyType_id')
// ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
// ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
// ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
// ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
// ->where('propReg.region_ID',$regionIds)
// ->distinct('propReg.property_ID')
// //  ->distinct('Loc.propertyType_id')
// ->get()
// ->count();



// // dd(implode(",",array_values(array_keys($overall_res))));
// // echo "property_ids : ".implode(",",array_values(array_keys($overall_res)));exit;

// // get price range count :


$accfilter = [];

$starfilter = [];


// dd($data);

return View::make('pages.afterlogin')
    ->with('login',1)
    // ->with('avatar_cond',false)
    // ->with('hotelsdata',$hotelsdata)
    ->with('inputdata',$inputdata)
    ->with('datas',$data['overall_result'])
    ->with('accfilter',$accfilter)
    ->with('starfilter',$starfilter)
    ->with('searchResults_count','')
    ->with('available_count',$data['available_count'])
    ->with('not_available_count',$data['not_available_count']);
    }

public function accommodationFilter($locale,$regionIds)
{
    
    
    $property_type_conv_Ids = PropertyType::all()->where('Property_Type','Conventional Lodging')->pluck('Category_ID')->toArray();
    
    $property_type_vacation_Ids = PropertyType::all()->where('Property_Type','Vacation Rental')->pluck('Category_ID')->toArray();
    
    // $total = count($property_type_conv_Ids) + count($property_type_vacation_Ids)."<br/>";
    
    // $overall_prop_Ids = array_merge($property_type_conv_Ids,$property_type_vacation_Ids);

    // dd($overall_prop_Ids);
    
    $accfilter_count = DB::table("T_propertyID_regionID_enUS as propReg")
                         ->select('Summ.propertyType_name','Summ.propertyType_id')
                         ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
                         ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
                         ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
                         ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
                         ->where('propReg.region_ID',$regionIds) 
                         ->whereIn('Summ.propertyType_id',$property_type_conv_Ids)
                       //->orWhere('Reg.ParentRegionId',$parentregionIds)  
                         ->distinct('Summ.propertyType_id')
                         ->get()
                         ->count();
                         
    $accfilter_new_conv =  DB::table("T_propertyID_regionID_enUS as propReg")
                        ->select('Summ.propertyType_name','Summ.propertyType_id')
                        ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
                        ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
                        ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
                        ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
                        ->where('propReg.region_ID',$regionIds) 
                        ->whereIn('Summ.propertyType_id',$property_type_conv_Ids)
                        //->orWhere('Reg.ParentRegionId',$parentregionIds)  
                        ->distinct('Summ.propertyType_id')
                        ->get()
                        ->toArray();
    
    $accfilter_new_vac =    DB::table("T_propertyID_regionID_enUS as propReg")
      ->select('Summ.propertyType_name','Summ.propertyType_id')
      ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
      ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
      ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
      ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
    ->where('propReg.region_ID',$regionIds) 
    ->whereIn('Summ.propertyType_id',$property_type_vacation_Ids)
    //->orWhere('Reg.ParentRegionId',$parentregionIds)  
    ->distinct('Summ.propertyType_id')
    ->get()
    ->toArray();    


    
    $accfilter = array_merge($accfilter_new_conv,$accfilter_new_vac);

    // echo "<pre>";print_r($accfilter_count);
    // echo "<pre> accfilter_new_conv ";print_r($accfilter_new_conv);
    // echo "<pre> accfilter_new_vac ";print_r($accfilter);exit;
    
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
        $accfilter[$index]->count =  DB::table("T_propertyID_regionID_enUS as propReg")
        ->select('Summ.propertyType_name','Summ.propertyType_id')
        ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
        ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
        ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
        ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
        ->where('propReg.region_ID',$regionIds) 
        ->where("Summ.propertyType_id",$accfilter[$index]->propertyType_id)
        ->count();  
         $index++;  
                   //->orWhere('Reg.ParentRegionId',$parentregionIds)  
    }
    
    // dd($accfilter);

        return $accfilter;
}
    
public function starratingFilter($locale,$regionIds)
{
    $rating_for_region = DB::table("T_propertyID_regionID_enUS as propReg")
    ->select('Summ.propertyType_name','Summ.propertyType_id','Summ.rating')
    ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
    ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
    ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
    ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
    ->whereNotNull('Summ.rating')
    ->where('propReg.region_ID',$regionIds) 
    ->distinct('Summ.rating')
    ->orderBy('Summ.rating','desc')
    ->pluck('Summ.rating')
    ->toArray();

    
    // dd($rating_for_region);

    $starrating_count = DB::table("T_propertyID_regionID_enUS as propReg")
    ->select(SummaryUS::raw('count(*) as rating_count'))
    ->join("T_summary_data_$locale as Summ",'Summ.propertyId_expedia','=','propReg.property_ID')
    ->join("T_property_location_$locale as Loc",'Loc.propertyId_expedia','=','propReg.property_ID')
    ->join("T_guestRatings_reviews_$locale as Reviews",'Reviews.propertyId_expedia','=','propReg.property_ID')
    ->join("T_property_images_$locale as Img",'Img.propertyId_expedia','=','propReg.property_ID')
    ->where('propReg.region_ID',$regionIds) 
    ->whereIn('Summ.rating',$rating_for_region)
    ->distinct('Summ.rating')
    ->groupBy('Summ.rating')
    ->orderBy('Summ.rating','desc')
    ->get()
    ->toArray();

    // dd($starrating_count);
    
    $res =  $this->grouparray_by_keyname($starrating_count,'1');

    $rating_map_count = [];

    for($index=0;$index < count($rating_for_region);$index++)
    {
    $org_float =  (float)$rating_for_region[$index];
    $rating_map_count[$index][ceil($org_float)] = $res["rating_count"][$index];
    }
    return $this->grouparray_by_keyname($rating_map_count,'2');

}


public function grouparray_by_keyname($arr,$type)
{ 
    $result = array();
    if($type == 2)
    {
        $res_filter = array();
        foreach ($arr as $sub) {
          foreach ($sub as $k => $v) {
            $result[$k][] = $v;
          }
          foreach($result as $item=>$value)
          {
              $res_filter[$item] = array_sum($value);
          }
        }
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


public function cURLforhotelPrice($locale,$property_Ids)
{
    // dd($locale);

    $checkIn  = isset($_SESSION["check_in"]) ? $_SESSION["check_in"] : '' ;
    $checkOut = isset($_SESSION["check_out"]) ? $_SESSION["check_out"] : '' ;

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

    $expedia_hotels_price = array();

    $hcom_hotels_price = array();

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

    $uri_hcom = $Request_data[1]->EndPoint."?&ecomHotelIds=$property_Ids&checkIn=$checkIn&checkOut=$checkOut";

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
            $expedia_arr[$property_id] = array();
            $response_exp = array();
            if(($expedia_hoteldata['Status'] == 'AVAILABLE'))
            {
            $response_exp["exp_status"] = 1;
            $response_exp["property_id"] = $property_id;
            $response_exp["totalprice_expedia"] = $expedia_hoteldata["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]["Value"];
            $response_exp["tax_amount"] = $expedia_hoteldata["RoomTypes"][0]["Price"]["TaxesAndFees"];
            $response_exp["avgprice_exp"] =  $expedia_hoteldata["RoomTypes"][0]["Price"]["AvgNightlyRate"]["Value"];
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
           $response_hcom["totalprice_hcom"] = $hcom_hoteldata["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]["Value"];
           $response_hcom["tax_amount"] = $hcom_hoteldata["RoomTypes"][0]["Price"]["TaxesAndFees"];
           $response_hcom["avgprice_hcom"] =  $hcom_hoteldata["RoomTypes"][0]["Price"]["AvgNightlyRate"];
           $hcom_arr[$property_id] = $response_hcom;
           }
           else
           {
           $response_hcom["hcom_status"] = 0;
           $response_hcom["property_id"] = $property_id;
           $hcom_arr[$property_id] = $response_hcom;
           }

        }
        
    foreach (array_merge($expedia_arr, $hcom_arr) as $row) {
        $price_response[$row['property_id']] = ($price_response[$row['property_id']] ?? []) + $row;
    }
    }
    else
    {
        $price_response['status_code'] = 404;
        $price_response['message'] = 'No results found Expedia APIs!!!';
        $price_response['property_Ids'] = $property_Ids;
    }   

    return $price_response;


}

public function getPropertiesSearch(Request $request)
{
    // dd($request);

    $region_ID = $request->region_ID;
    $offset = $request->offset;
    $_SESSION["check_in"] = date("Y-m-d", strtotime($request->checkIn));
    $_SESSION["check_out"] = date("Y-m-d", strtotime($request->checkOut));

$hotelsdatanew = DB::select('Select searchresult(?,?)',array("$region_ID","$offset"));
    
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

$property_pricedata_API =   $this->cURLforhotelPrice('enUS',implode(",",array_values(array_keys($overall_res))));

// echo "<pre> property_pricedata_API ";print_r($property_pricedata_API);

if(isset($property_pricedata_API["status_code"]) != 404)
{
    $res = array_merge($property_pricedata_API, $overall_res);
    foreach (array_merge($property_pricedata_API, $overall_res) as $row) {
        $result_data[$row['property_id']] = ($property_pricedata_API[$row['property_id']] ?? []) + $row;
    }

    // dd($result_data);
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
public function filteracctype(Request $request)
{

    // dd('fsddsadasadsads');
    
    $start = microtime(true);

    $accfilterarray = $request->region_ID_filter;

    
    $regionIds = $request->regionid;  
    
    $parentregionIds = $request-> parentregionID;
    
    $locale =  isset($request->locale)? $request->locale : 'enUS';
       
    $user_country = 'India';

    // if($request->has('region_ID_filter')){
     $values  = implode(",",$accfilterarray);

    $hotelsdatanew =  DB::select('Select example_array_input(?,?,?)',array('1029','0','{'.$values.'}'));

    $result_search = array();

    $overall_res = [];

    foreach($hotelsdatanew as $result=>$property)
    {
        $cval = stripslashes($property->example_array_input);
        $val =  json_decode(substr($cval,2, -2));
        $prop_id = (string)$val->property_id;
        $overall_res[$prop_id] = array();
        $result_search['rating'] = $val->rating;
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
    
    $ids = array_values(array_keys($overall_res));

    // echo "<pre> getAPI ";dd($this->getapi($request));

    $property_pricedata_API =   $this->cURLforhotelPrice($locale,implode(",",$ids));

    echo "<pre> property_pricedata_API ";print_r($property_pricedata_API);

    $error_live = isset($property_pricedata_API['status_code']) ? $property_pricedata_API['status_code'] : false;
    if(count($ids) > 0 && $error_live != 404){
        
        echo "<pre> property_pricedata_API ";print_r($property_pricedata_API);

        echo "<pre> overall_res ";print_r($overall_res);



        foreach (array_merge($property_pricedata_API, $overall_res) as $row) {
            $result_data[$row['property_id']] = ($property_pricedata_API[$row['property_id']] ?? []) + $row;
        }
        return $result_data;
    }
    else{
        $result_data["status"]= 404;
        $result_data["message"]= 'No data found ajax';
        return $result_data;
    } 
    
}


public function searchwithRegionId($locale,$region_ID,$checkIn,$checkOut)
{
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

    // dd($Local);

    $Request_data = DB::table("T_ApiAccess as API")
    ->where('Local',$Local)
    ->whereIn('agency',['expedia','Hcom'])
    ->get()
    ->toArray();

    $client = new Client();

    $uri_expedia = $Request_data[0]->EndPoint."?checkIn=$checkIn&checkOut=$checkOut&regionIds=$region_ID";

    $params_expedia['headers'] = [
        'Authorization' => "Basic ".$Request_data[0]->auth_token,
        'Accept' => $Request_data[0]->accept,
        'Partner-Transaction-Id'=> $Request_data[0]->partner_id,
        'Key' =>$Request_data[0]->f_key
    ];

    // echo "<pre> params_expedia ";print_r($params_expedia);

    // required array expedia

    $uri_hcom = $Request_data[1]->EndPoint."?checkIn=$checkIn&checkOut=$checkOut&regionIds=$region_ID";

    $params_hcom['headers'] = [
        'Authorization' => "Basic ".$Request_data[1]->auth_token,
        'Accept' => $Request_data[1]->accept,
        'Partner-Transaction-Id'=> $Request_data[1]->partner_id,
        'Key' =>$Request_data[1]->f_key
    ];

    try
    {
        $response_expedia = $client->request('get', $uri_expedia, $params_expedia);

        $response_hcom = $client->request('get', $uri_hcom, $params_hcom);

        $data_expedia = json_decode($response_expedia->getBody(), true);

        $data_hcom = json_decode($response_hcom->getBody(), true);
        
       if( (isset($data_expedia["Warnings"]) && isset($data_hcom["Warnings"])) || ( isset($data_expedia["Errors"]) && isset($data_hcom["Errors"]) ) )
       {
        dd('response error!!!');
       }
       else
       {

        // echo "<pre> data_expedia : ";print_r($data_expedia);

        // echo "<pre> data_hcom : ";print_r($data_hcom);

        $res_count_expedia = isset($data_expedia["Count"]) ? $data_expedia["Count"] : 0;

        $res_count_hcom = isset($data_hcom["Count"]) ? $data_hcom["Count"] : 0;

        $expedia_hotels = isset($data_expedia["Hotels"]) ? $data_expedia["Hotels"] : 0;

        $hcom_hotels = isset($data_hcom["Hotels"]) ? $data_hcom["Hotels"] : 0;


        if( ($res_count_expedia > 0 && $res_count_hcom > 0) && ( $expedia_hotels != 0 && $hcom_hotels != 0) )
        {
            // echo "<pre> expedia_hotels : ";print_r($expedia_hotels);

            // echo "<pre> hcom_hotels : ";print_r($hcom_hotels);

            $expedia_data_available = array();
         
            $expedia_data_notavailable = array();

            $hcom_data_available = array();
         
            $hcom_data_notavailable = array();

            foreach($expedia_hotels as $key=>$prop)
            {
                if($prop["Status"] == "AVAILABLE")
                {
                    $prop_id = $prop["Id"];
                    $res_exp["property_id"] = $prop["Id"];
                    $res_exp['exp_status'] = 1;
                    $res_exp["totalprice_exp"] = $prop["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]["Value"];
                    $res_exp["tax_amount_exp"] = isset($prop["RoomTypes"][0]["Price"]["TaxesAndFees"]) ? $prop["RoomTypes"][0]["Price"]["TaxesAndFees"] : 0 ;
                    $res_exp["avgprice_exp"] =  $prop["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value'];
                    $res_exp['api_name'] =  $prop['Name'];
                    $res_exp['api_city'] =  isset($prop['Location']['Address']['City']) ? $prop['Location']['Address']['City'] : '';
                    $res_exp['api_country'] = isset($prop['Location']['Address']['Country']) ? $prop['Location']['Address']['Country'] : '';
                    $res_exp['api_image_url'] = isset($prop['ThumbnailUrl']) ? $prop['ThumbnailUrl'] : '';
                    $res_exp['api_expedia_link'] = isset($prop['RoomTypes'][0]["Links"]["WebDetails"]["Href"])? $prop['RoomTypes'][0]["Links"]["WebDetails"]["Href"] : '';
                    $expedia_data_available[$prop_id] = $res_exp;
                }
                else
                {
                    $expedia_data_notavailable[] = $prop["Id"];
                }
            }

            foreach($hcom_hotels as $key=>$prop)
            {
                if($prop["Status"] == "AVAILABLE")
                {
                    $prop_id = $prop["Id"];
                    $res_hcom["property_id"] = $prop["Id"];
                    $res_hcom['hcom_status'] = 1;
                    $res_hcom["totalprice_hcom"] = $prop["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]["Value"];
                    $res_hcom["tax_amount_hcom"] = isset($prop["RoomTypes"][0]["Price"]["TaxesAndFees"]) ? $prop["RoomTypes"][0]["Price"]["TaxesAndFees"] : 0 ;
                    $res_hcom["avgprice_hcom"] =  $prop["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value'];
                    $hcom_data_available[$prop_id] = $res_hcom;
                }
                else
                {
                    $hcom_data_notavailable[] = $prop["Id"];
                }
            }

            $not_available_property_Ids = array_unique(array_merge($expedia_data_notavailable,$hcom_data_notavailable));

            $API_data = array();

            $Db_data_available = array();

            foreach (array_merge($expedia_data_available, $hcom_data_available) as $row) {
                $API_data[$row['property_id']] = ($API_data[$row['property_id']] ?? []) + $row;

            }

            $available_property_Ids = implode(',',array_keys($API_data));

            $not_available_property_Ids = implode(',',array_values($not_available_property_Ids));

            // echo "property ids : ",$available_property_Ids;exit;
            
            $Db_data =  $this->storedProcedureCall(DB::select('Select search_datas(?)',array('{'.$available_property_Ids.'}')),true);
            
            // echo "<pre> DB Datas";print_r($Db_data);exit;

            foreach (array_merge($API_data, $Db_data ) as $row) {
                    $Db_data_available[$row['property_id']] = ($Db_data_available[$row['property_id']] ?? []) + $row;
            }

            $Db_datanot_available = $this->storedProcedureCall(DB::select('Select search_datas(?)',array('{'.$not_available_property_Ids.'}')),true);

            $result = [];

            $overall_result = array_merge($Db_data_available,$Db_datanot_available);

            $result['available_count'] = count($Db_data_available);
            $result['not_available_count'] = count($Db_datanot_available);
            $result['overall_result'] = $overall_result;
            // dd($result['overall_result']);
            return $result;
        }

       }

    }
    catch(\Exception $e)
    {
        echo "error : ".$e;
        // echo "<pre> error : ";print_r($e);
        dd('Exception Catched !!!');
    }


}

public function mapsAPIaction(Request $request)
{
    // dd($request);
    $locale = $request->locale;

    $checkIn = date("Y-m-d", strtotime($request->checkIn));  

    $checkOut = date("Y-m-d", strtotime($request->checkOut));  

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

    // dd($Local);

    $Request_data = DB::table("T_ApiAccess as API")
    ->where('Local',$Local)
    ->whereIn('agency',['expedia','Hcom'])
    ->get()
    ->toArray();

    
    // expedia Response for geolocation

    $Expedia_req = $Request_data[0];

    $client = new Client();

    $uri_expedia = $Expedia_req->EndPoint."?checkIn=$checkIn&checkOut=$checkOut&geoLocation=$request->latitude,$request->longitude&radius=20&unit=km&availOnly=true";

    $params_expedia['headers'] = [
        'Authorization' => "Basic ".$Expedia_req->auth_token,
        'Accept' => $Expedia_req->accept,
        'Partner-Transaction-Id'=> $Expedia_req->partner_id,
        'Key' =>$Expedia_req->f_key
    ];

       $response_expedia = $client->request('get', $uri_expedia, $params_expedia);

       $data_expedia = json_decode($response_expedia->getBody(), true);

       // expedia Response for geolocation


       // Hcom Response for geolocation

       $Hcom_req = $Request_data[1];
   
       $uri_hcom = $Hcom_req->EndPoint."?checkIn=$checkIn&checkOut=$checkOut&geoLocation=$request->latitude,$request->longitude&radius=40&unit=km&availOnly=true";
   
       $params_Hcom['headers'] = [
           'Authorization' => "Basic ".$Hcom_req->auth_token,
           'Accept' => $Hcom_req->accept,
           'Partner-Transaction-Id'=> $Hcom_req->partner_id,
           'Key' =>$Hcom_req->f_key
       ];
   
          $response_hcom = $client->request('get', $uri_hcom, $params_Hcom);
   
          $data_hcom = json_decode($response_hcom->getBody(), true);

        //   echo "<pre> data_expedia";print_r($data_expedia);
        //   dd($data_hcom);



       // Hcom Response for geolocation


       $hotelsdata_expedia = isset($data_expedia["Hotels"]) ? $data_expedia["Hotels"] : [];

       $hotelsdata_hcom = isset($data_hcom["Hotels"]) ? $data_hcom["Hotels"] : [];

       

       $location_pin = array();

       $index = 0;

       $available_prop_ids = array();

       $expedia_liveprice = array();

       $hcom_liveprice  = array();

       foreach($hotelsdata_expedia as $location=>$GL)
       {

        $location_pin[$index]['latitude'] = $GL['Location']['GeoLocation']['Latitude'];
        $location_pin[$index]['longitude'] = $GL['Location']['GeoLocation']['Longitude'];
        $location_pin[$index]['property_id'] = $GL['Id'];
        $location_pin[$index]['property_name'] = $GL['Name'];
        $location_pin[$index]['img_url'] = isset($GL['ThumbnailUrl']) ? $GL['ThumbnailUrl'] : '';
        $location_pin[$index]['price'] = isset($GL["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value']) ? $GL["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value'] : '0';

        $available_prop_ids[] = $location_pin[$index]['property_id'];

        $available_exp['property_id'] = $GL['Id'];

        $available_exp['property_name'] = $GL['Name'];

        $available_exp['propertyType_name'] =  $GL['PropertyType']["Name"]; 
              
        $available_exp['rating']          = isset($GL['StarRating']) ? (float)$GL['StarRating'] : '';

        $available_exp['propertyType_id'] = $GL['PropertyType']["Id"];

        $available_exp['main_image'] = isset($GL['ThumbnailUrl']) ? $GL['ThumbnailUrl'] : '';

        $available_exp['avgprice_exp'] = $location_pin[$index]['price'];

        $available_exp["totalprice_exp"] = $GL["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]['Value'];

        $available_exp['expedia_link'] = isset($GL['RoomTypes'][0]["Links"]["WebDetails"]["Href"])? $GL['RoomTypes'][0]["Links"]["WebDetails"]["Href"] : '';

        $expedia_liveprice[$GL['Id']] = $available_exp;

        $index++;

       }


       foreach($hotelsdata_hcom  as $location=>$GL)
       {
        $available_hcom['property_id'] = $GL['Id'];
        
        $available_hcom['Hcom_id'] = $GL['HcomId'];

        $available_hcom['avgprice_hcom'] = isset($GL["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value']) ? $GL["RoomTypes"][0]["Price"]["AvgNightlyRate"]['Value'] : '0';

        $available_hcom['hcom_link'] = isset($GL['RoomTypes'][0]["Links"]["WebDetails"]["Href"])? $GL['RoomTypes'][0]["Links"]["WebDetails"]["Href"] : '';

        $available_hcom["totalprice_hcom"] = $GL["RoomTypes"][0]["Price"]["TotalPriceWithHotelFees"]['Value'];

        $hcom_liveprice[$GL['Id']] = $available_hcom;

       }

       $live_apiprice = array();

       foreach (array_merge($expedia_liveprice, $hcom_liveprice) as $row) {
        $live_apiprice[$row['property_id']] = ($live_apiprice[$row['property_id']] ?? []) + $row;
    }

       $available_property_Ids = implode(',',array_values($available_prop_ids));

       $getavailable_pin_properties =  $this->storedProcedureCall(DB::select('Select search_datas(?)',array('{'.$available_property_Ids.'}')),false);
      
       $getavailable_props = [];

       foreach (array_merge($live_apiprice, $getavailable_pin_properties) as $entry) {
 
        if (!isset($getavailable_pin_properties[$entry["property_id"]])) {
            foreach ($entry as $key => $value) {
                    $getavailable_props[$entry["property_id"]][$key] = $value;
            }
    }
    }

       $geolocation_result = [];

       $geolocation_result['location_pin'] = $location_pin;

       $geolocation_result['list_items'] = $getavailable_props;

       return $geolocation_result;

} 
public function storedProcedureCall($spfunction_response,$status)
{
            $result_search = array();
            $overall_res = [];

            if($status)
            {
                foreach($spfunction_response as $result=>$property)
                {
                    $cval = stripslashes($property->search_datas);
                    $val =  json_decode(substr($cval,2, -2));
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
                    $result_search['latitude'] = $val->geoLocationlatitude;
                    $result_search['longitude'] = $val->geoLocationlongitude;
                    $result_search['main_image'] = $val->main_image;
                    $result_search['images'] = $val->images;
                    $result_search['rating'] = $val->rating;
                    $overall_res[$prop_id] = $result_search;
                }
                return $overall_res;
            }
            else
            {
                foreach($spfunction_response as $result=>$property)
                {
                    $cval = stripslashes($property->search_datas);
                    $val =  json_decode(substr($cval,2, -2));
      
                    $result_search['property_id'] = $val->property_id;
                    $result_search['property_name'] = $val->property_name;
                    $result_search['propertyType_id'] = $val->propertyType_id;
                    $result_search['address1'] = $val->address1;
                    $result_search['address2'] = $val->address2;
                    $result_search['city'] = $val->city;
                    $result_search['province'] = $val->province;
                    $result_search['country'] = $val->country;
                    $result_search['latitude'] = $val->geoLocationlatitude;
                    $result_search['longitude'] = $val->geoLocationlongitude;
                    $result_search['main_image'] = $val->main_image;
                    $result_search['images'] = $val->images;
                    $result_search['rating'] = $val->rating;
                    $overall_res[] = $result_search;
                    // dd($overall_res);
                }
               
                return $overall_res;
            }
            
}

}







