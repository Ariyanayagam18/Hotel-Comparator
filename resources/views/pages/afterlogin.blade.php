<style>
    .home-page .section-1 .handle-counter div img {
    position: relative;
    top: 7px;
    left: -1px;
    }
    div.plus img {
        transform: rotate(180deg) !important;
    }
    
    .show_nofound {
        display: none;
        text-align: center;
    }
    </style>
    <?php 
    try {
    
    $available_datas = array(); 
    $not_available = array();
    $geolocation = array();
    $static = array();
    
    $base_url = "http://$_SERVER[HTTP_HOST]/Hotelcomparator/public/index.php"; 
    
    $currency_symbol = isset($_SESSION['currency_symbol']) ? $_SESSION['currency_symbol'] : '$' ;
    // dd($currency_symbol);
    $currency = $_SESSION['currency'];
    
    ?>
    
    <div class="afterlogin">
        @include('layouts/header')
        <div class="home-page">
       
            <div class="banner-section">
         
            </div>
            <div class="all-section">
                <div class="section-1">        
                    <div class="row m-0 justify-content-between">
                        <div class="col-xl-5 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                            <label>Where do you want to stay</label>
                            <form method="post" id="search-holder">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">   
                          <input type="hidden" id="search_result" value="1">
                            <div class="position-relative">
                            <input type="text" placeholder="Enter Destination or Hotel Name"  name="country" class="search-stay search_field" oninput="suggestPlaces(this.value)" id="search_field" autocomplete="off" value="<?php echo $inputdata['place'] ?>" >   
                            <input type="hidden" placeholder="Enter Destination or Hotel Name" name="regionid" class="region-search-stay region-search_field" id="hidden_search_field" autocomplete="off" value="<?php echo $inputdata['regionid'] ?>">  
                            <input type="hidden" placeholder="Enter Destination or Hotel Name" name="parentregionid" class="region-search-stay region-search_field" id="parentregionid" autocomplete="off" value="<?php echo $inputdata['parentregionID'] ?>">                    
    
                            @if(isset($regionid))
                           
                            <input type="hidden" value="<?php echo $regionid?>" id="searchid">
                            @endif
                           
                            <div class="auto_suggest">
                           
                            <ul id="list_show">
                                <?php if(count($suggestCities) > 0) { ?>
                                @foreach ($suggestCities as $key=>$suggest_cities)     
                           <?php //echo "<pre>  suggest : ";print_r($suggest_cities);exit;?>
                            <li class="suggest_city" value ="{{ $suggest_cities->Name }}" data-parentregionid={{$suggest_cities->ParentRegionId}}  data-regionId={{ $suggest_cities->RegionID }}>
                                <div class="align-items-center d-flex">
                                    <div><img src="../images/<?php echo $suggest_cities->Type;?>.svg" style="width: 24px;height: 24px;"></div>
                                    <div class="city-place"><p class="city">{{
                                        $suggest_cities->Name }}</p>
                                        <p class="cityplace">{{ $suggest_cities->ExtendedName}}</p>
                                    </div>                                
                               </div>
                               <div class="city-place">
                                    <p class="cityplace text-nowrap"> {{ $suggest_cities->Type}} </p>
                                </div>
    
                            </li>
                                @endforeach
                                <?php } ?>
                                </ul>
    
    
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                            <label>Check- In & check Out</label>
                            <input type="text" class="calender-sec" name="datefilter" id="date_picker" value="06/11/2022 to 13/11/2022" readonly/> 
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Guests and Rooms</label>                   
                        <div class="position-relative">
                            <div class="guestrooms" id="guestrooms">
                                <input class="guest-input" value="1 adult, 1 Room" readonly/>                      
                            </div>
                            <div class="members" style="display:none">
                                    <div class="list-room">
                                        <div class="list-guest">
                                            <img src="{{asset('images/Maskgroup.svg')}}"> 
                                            <p>Adults</p>  
                                        </div>    
                                        <div class="handle-counter" id="handleCounter">
                                            <div class="counter-minus btn btn-primary">
                                                <img src="{{asset('images/white-arrow.svg')}}">   
                                            </div>
                                            <input type="text" class="adults" value="0">
                                            <div class="counter-plus btn btn-primary">
                                                <img src="{{asset('images/white-arrow.svg')}}">   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-room">
                                        <div class="list-guest">
                                            <img src="{{asset('images/childrengroup.svg')}}"> 
                                            <span>Children
                                                <p style="font-size:10px">(Below 12 years)</p>
                                            </span> 
                                        </div>
                                        <div class="handle-counter" id="handleCounter">
                                            <div class="counter-minus btn btn-primary" id="removechilder" onclick="removeFormElements(this)">
                                                   <img src="{{asset('images/white-arrow.svg')}}">
                                            </div>
                                            <input type="text" class="Children" value="0" id="childrencount">
                                            <div class="plus btn btn-primary"  id="childrenadd">
                                                   <img src="{{asset('images/white-arrow.svg')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="module_holder" style="display:none">Age of Children?</div>
                                    <div id="container" class="row"></div>
    
                                    <div class="list-room">
                                        <div class="list-guest">
                                            <img src="{{asset('images/roomgroup.svg')}}"> 
                                            <p>Rooms </p>
                                        </div>
                                        <div class="handle-counter" id="handleCounter">
                                            <div class="counter-minus btn btn-primary">
                                                   <img src="{{asset('images/white-arrow.svg')}}">
                                            </div>
                                            <input type="text" class="Rooms" value="0">
                                            <div class="counter-plus btn btn-primary">
                                                   <img src="{{asset('images/white-arrow.svg')}}">
                                            </div>
                                        </div>
                                    </div>      
                                    <hr>                         
                                    <div class="reset-ok">
                                        <div id="reset">
                                            Reset
                                       </div>
                                        <div id="guests_ok">
                                            Done
                                       </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12 form-group text-center text-xl-left Search-Hotels">
                            <label></label>
                            <a class="btn btn-primary" id="search">Search Hotels</a>
                        </div>
                    </div>                 
                </div>
                <div class="section-2">
                <div class="row m-0">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-12">
                        <div class="filter-outer">
                            <div class="filter-sec">Filters</div>
                            <div class="filter-inner">
    
                    
                                <div class="mb-4">
                                    <p class="filter-title">Availability Status</p>
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div>
                                                    <span class="ml-3" style="color:#5e6165">Available properties</span>
                                                 </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right" id="available_propertycount"> {{ $available_count }}</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div>
                                                   <span class="ml-3" style="color:#5e6165">Not available properties</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right" id="notavailable_propertycount">{{ $not_available_count }}</div>
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
    
                                <div class="mb-4">
                                    <p class="filter-title">View price as</p>
                                    <div class="filter-tabs">
                                        <!-- Nav pills -->
                                        <ul class="nav nav-pills mb-4" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="pill" href="#PerNight">Per Night</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="pill" href="#Totalstay">Total stay</a>
                                            </li>
                                        </ul>
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div id="PerNight" class="container tab-pane p-0 active">
                                                <div id="mappricedata">
                                                    <?php 
                                                        $price_array = array_column($search_result, 'avgprice_exp');
                                                        if(isset($price_array) && count($price_array) > 0 ){
                                                            $checkcount = 0;
                                                            $max_price = max($price_array);
                                                            $rangefo = $max_price/3;
                                                            $price_ranges = array(
                                                                array('min' => 0, 'max' => $rangefo),
                                                                array('min' => $rangefo + 0.01, 'max' => 2 * $rangefo),
                                                                array('min' => 2 * $rangefo + 0.01, 'max' => $max_price)
                                                            );
                                
                                                            foreach ($price_ranges as $range) {
                                                                $prices_in_range = array_filter($price_array, function($price) use ($range) {
                                                                    return $price >= $range['min'] && $price <= $range['max'];
                                                                });
                                                                $count = count($prices_in_range);
                                                                // Calculate the minimum and maximum values for the checkbox input
                                                                $min = $range['min'] == 0 ? 0 : $range['min'];
                                                                $max = $range['max'];
                                                    ?>
                                                    <div class="row mb-3">
                                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input pricescount" id="CustomCheck_<?php echo $checkcount;?>" name ="pricerange"  data-min='<?php echo $min ?>' data-max='<?php echo $max ?>'>
                                                                <label class="custom-control-label" for="CustomCheck_<?php echo $checkcount;?>">
                                                                    <span class="ml-3">
                                                                        <?php if($range['max'] != $max_price){
                                                                            echo "$" . round($min). " - $" . round(($max-0.01));
                                                                        } else {
                                                                            echo "$" . round($min). "+";
                                                                        } ?>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                            <div class="book-right"><?php echo $count ?></div>
                                                        </div>
                                                    </div>
                                                    <?php 
                                                            $checkcount++;
                                                            }
                                                        }
                                                    ?>
                                                </div>
    
                                                <div class="filter-input">
                                                    <div class="row mb-3">
                                                        <div class="col-xl-9 col-lg-9 col-md-9 col-9">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <input type="text" class="form-control" id="minprice" placeholder="$">
                                                                <span class="ml-2 mr-2">-</span>
                                                                <input type="text" class="form-control"  id="maxprice" placeholder="$">
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-3 col-lg-3 col-md-3 col-3">
                                                            <div class="text-right">
                                                                <img src="{{asset('images/filter-search.svg')}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="Totalstay" class="container tab-pane p-0 fade">
                                            <h3>Menu 1</h3>
                                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                
                                <div class="mb-4">
                                    <p class="filter-title">Star_Rating</p>
    
                                    <div id="ratingdata">
    
                                    <?php
                                    $starloopcount = 1;
                                    if(isset($fullrate) && count($fullrate)) 
                                    { 
                                        foreach($fullrate as $item=>$star) {
                                        
                                        // $value_arr = [];
                                        // var_dump($item);
                                        // if(gettype($item) == 'integer')
                                        // {
                                        //     $value_arr[] = $item;
                                        //     $value_arr[] = $item-0.5;
                                        // }
                                    ?>
                                     @if($star >0)
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"  class="custom-control-input getcheck" name="checkdata" id="customCheck_<?php echo $starloopcount;?>" value="{{ $item }}">
                                                    <label class="custom-control-label" for="customCheck_<?php echo $starloopcount;?>" ><span class="ml-3 d-flex align-items-center">@if($item==0)
                                                        {{$item ='unrated'}}
                                                    @else
                                                    {{$item}} 
                                                    @endif<span class="ml-1 mr-2"> @if($item !='unrated')<img src="{{asset('images/Star.svg')}}"></span>Rating</span> @endif </label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">{{ $star }} </div>
                                            </div>
                                        </div>   
                                        @endif
                                        <?php  
                                         $starloopcount++;
                                        }          
                                       
                                    }
                                   
                                    ?>  
    
                                    </div>
    
                                </div>
    
                                <div class="mb-4">
    
                                    <p class="filter-title">Accommodation Type</p>
                                   
                                    <?php if($countarray >0 ){ ?>
    
                                    <div class="acc_type" id="acc_typefilter">
                                    <?php
                                        $loopcount = 1;
                                        $converntional_limit = $accfilter["convenditional_hotelcount"];
                                        $datacount = count($countarray);
                                        // $showMore = ($datacount > $converntional_limit) ? true : false;
                                        $i = 0;
                                        
                                        foreach($countarray as $key => $item) {
                                        ?>
                                        <div class="row mb-3 accfilter_row" id="accfilter_<?php echo $loopcount;?>" data-property_typeId="<?php echo $propertyid[$i];?>">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input acccount" id="custom_<?php echo $loopcount;?>" name="accfilter" data-property_typeId="<?php echo $propertyid[$i];?>">
                                                <label class="custom-control-label accfiltervalue"  for="custom_<?php echo $loopcount;?>"><span class="ml-3"><?php echo $key ?></span></label>
                                            </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="wait_filter loader_filter" style="display:none"></div>
                                            <div class="book-right property_count"><?php echo $item ?></div>
                                            </div>
                                        </div>
                                        <?php
                                        $loopcount++;
                                        $i++;
                                        }
                                        $static []=$propertyid;
                                        
                                        ?>
                                    </div>
                                    <?php } ?>
                           
                                    <div class="SeeMore" id="acctype_seemore">See More</div>
                                </div>
                                <div class="mb-4">
                                    <p class="filter-title">Cancellation policy</p>
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck21">
                                                    <label class="custom-control-label" for="customCheck21"><span class="ml-3">Free Cancellation</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1259</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck22">
                                                    <label class="custom-control-label" for="customCheck22"><span class="ml-3">Non refundable</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1322</div>
                                            </div>
                                        </div>                                           
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="filter-title">Meal plan</p>
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck23">
                                                    <label class="custom-control-label" for="customCheck23"><span class="ml-3">Breakfast included</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1274</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck24">
                                                    <label class="custom-control-label" for="customCheck24"><span class="ml-3">Meals not included</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1194</div>
                                            </div>
                                        </div>                                           
                                    </div>
                                    <div class="SeeMore">More Details</div>
                                </div>
                                <div class="mb-4">
                                    <p class="filter-title">Guest rating</p>
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck25">
                                                    <label class="custom-control-label" for="customCheck25"><span class="ml-3">With honours</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1274</div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck26">
                                                    <label class="custom-control-label" for="customCheck26"><span class="ml-3">Excellent</span></label>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                <div class="book-right">1194</div>
                                            </div>
                                        </div>                                           
                                    </div>
                                    <div class="SeeMore">More Details</div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                        <div>
                            <div class="hotel-found"> <div id="countname" class="mr-1">{{ count($search_result) }}</div> hotels found in &nbsp<span id="result_city">{{ $_GET['place'] }}</span> </div>
                            <div class="row select-sort">
                                <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                    <div>
                                        <span class="select-multi">
                                            <div class="cross-red"><img src="{{asset('images/red-cross.svg')}}"></div>
                                            <select class="form-control">
                                                <option>$0 - $1,150</option>
                                                <option>$1 - $1,150</option>
                                                <option>$2 - $1,150</option>
                                                <option>$3 - $1,150</option>
                                            </select>
                                        </span>
                                        <span class="select-multi">
                                            <div class="cross-red"><img src="{{asset('images/red-cross.svg')}}"></div>
                                            <select class="form-control">
                                                <option>$0 - $0,150</option>
                                                <option>$1 - $1,150</option>
                                                <option>$2 - $2,150</option>
                                                <option>$3 - $3,150</option>
                                            </select>                        
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                    <div class="align-items-center d-flex">
                                        <div class="sort-by">Sort by</div>
                                        <div class="sort-select">
                                            <select class="form-control" id="sort_byfilter">
                                                <option>All</option>
                                                <option value="lowest">Lowest</option>
                                                <option value="highest">Highest</option>
                                                <option value="moststars">More stars</option>      
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="list-wrapper">
                                <img src="" id="loader" style="display:none">
                                <div id="search_resultajax">
                                    
                                    <?php
                                    if (isset($search_result["status_code"]) == 404) {?>
                                        <p style="text-align:center;font-weight:bold;">No data found</p>
                    
                                    <?php }
        
                                    else { 
                                        
                                //  hide available working fine
                                $not_available = array_slice($search_result,count($search_result) - $not_available_count);
    
                                $not_available = array_slice($search_result,count($search_result) - $not_available_count);
    
                                $available_datas = array_slice($search_result,0,$available_count);
    
                                // dd($not_available);
    
                                // array_splice($search_result,-($not_available_count));
        
                                //  hide not available
                                $count_overall = 0;
                                $api_name = '';
                                $api_city = '';
                                $api_country = '';
                                $api_url = '';
    
                                // dd($search_result);
                                foreach($search_result as $res_data=>$data) {

                                if( isset($data['exp_status']) || isset($data['hcom_status'])){
                                if($data['hcom_status'] ||  $data['exp_status'])
                                {
                                $rating =  (float)isset($data["rating"]) ? $data["rating"] : 0 ;
    
                                $property_details = array();
    
                                $property_details['avgprice_exp'] = isset($data["avgprice_exp"]) ? $data["avgprice_exp"] : 0 ;
    
                                $property_details['avgprice_hcom'] = isset($data["avgprice_hcom"]) ? $data["avgprice_hcom"] : 0 ;
    
                                $property_details['rating'] = ceil($rating);
    
                                $property_details['property_id'] = isset($data['property_id']) ? $data['property_id'] : '';
                                
                                $property_details['regionid'] = isset($_GET['regionid']) ? $_GET['regionid'] : '' ;
    
                                $property_details['property_name'] = ( isset($data["property_name"]) && !empty($data["property_name"]) ) ? $data["property_name"] : ( (isset($data['api_name']) && !empty($data['api_name'])) ? $data['api_name'] : $data['api_hcomname'] ) ;
                                
                                $property_details['main_image'] = ( isset($data["main_image"]) && !empty($data["main_image"]) ) ? $data["main_image"] : ( (isset($data['api_image_url']) && !empty($data['api_image_url'])) ? $data['api_image_url'] : $data['api_hcom_imageurl'] );
                                
                                $property_details['latitude'] = isset($data['latitude']) ? $data['latitude'] : (isset($data['api_latitude']) ? $data['api_latitude'] : $data['api_hcomlatitude'] ) ;
    
                                $property_details['longitude'] = isset($data['longitude']) ? $data['longitude'] :(isset($data['api_longitude']) ?  $data['api_longitude'] : $data['api_hcomlongitude'] );
    
                                $api_name = $property_details['property_name'] ;
    
                                $api_url =   $property_details['main_image'];
    
                                $geolocation[] = $property_details;
    
                                }
                                }
                                    $not_db_data = false;
    
                                    $api_city = isset($data['api_city']) ? $data['api_city'] : ( (isset($data['api_hcomcity']) && !empty($data['api_hcomcity'])) ? $data['api_hcomcity'] : '' ) ;
    
                                    $api_country = isset($data['api_country']) ? $data['api_country'] : ( (isset($data['api_hcomcountry']) && !empty($data['api_hcomcountry'])) ? $data['api_hcomcountry'] : '' ) ;
    
                                    $api_expedia_link = isset($data['api_expedia_link']) ? $data['api_expedia_link'] : 'hcom_testing';
    
                                    $avg_hcomprice = '';
                                    $avg_expediaprice = '';
                                    $preview_images = [];
    
                                    if(isset($data['images'])) {
                                    $images  =  json_decode($data['images'],true);
                                    if(isset($images["ROOMS"]))
                                    {
                                        $preview_images = array_slice($images["ROOMS"],0,5,true);
                                    }
                                    }
    
                                ?>
                                
                                <?php if($count_overall < $available_count) { ?>
        
                                <div class="row m-0  hotel-list list-item available" id="{{ $data['property_id'] }}" data-index="{{ $count_overall }}">
        
                                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0">
                                            <div class="position-relative">
                                                 
                                <?php 
    
                                $img_link = isset($data["main_image"]) ? $data["main_image"] : '';
                                if(empty($img_link))
                                {
                                    $file_dir = '';
                                    $file_ext = '';
                                    $file_name = '';
                                    $file = pathinfo($api_url);
                                    
                                    if(isset($file["dirname"]) && isset($file["extension"]) && isset($file["filename"]))
                                    {
                                        $file_dir = $file["dirname"];
                                        $file_ext =  $file["extension"];
                                        $file_name = $file["filename"];
                                    }
                                    $change_imgtype = 'y';
                                    $file_name = trim($file_name);
                                    $remove_last = substr($file_name, 0, -1);
                                    $alter_image_type = $remove_last.''.$change_imgtype;   
                                    $img_link = $file_dir.'/'.$alter_image_type.".".$file_ext;
                                }
    
                                ?>
                                         <div class="hotel-img"><img src="<?php echo strlen($img_link) > 3 ? $img_link : "empty";?>" class="w-100 hotel_img">
                            
                                        </div>
                                        
                                        <div class="small-image" style="display:none"> 
                                            <?php
                                                $count = 0;
                                                    foreach($preview_images as $img=>$link) { 
                                                    ?>
                                            <?php if($count < 5) { ?>
                                                <?php if($count != 0 ){ ?>
                                                    <div class="small-image-first"><img src="{{ $link["link"] }}" class="small-image-preview"></div>
                                                <?php } else { ?>
                                                <div class="small-image-first"><img src="{{ $img_link }}" class="small-image-preview"></div>
                                                <?php }?>
                                            <?php 
                                            }
                                                $count++;
                                        } ?>
                                        </div>
                                    </div>                                    
                                    </div>
        
                                        <div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0">
                                            <div class="row m-0 pt-3">
                                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400">
                                                   
                                                    <div class="hotel-leftside">
        
                                                        <?php if( isset($data["property_name"]) && isset($data["province"]) && isset($data["country"]) && isset($data["city"])){ ?>
                                                        <p class="hotel-title" title="{{ $data["property_name"] }}"> {{ $data["property_name"] }}</p>
                                                        <div class="hotel-loc">
                                                            <img src="{{asset('images/location.svg')}}">
                                                            <div><p class="m-0"> {{ $data["city"] }},{{ $data["province"] }},{{ $data["country"] }} </p></div>
                                                        </div>
                                                        <?php } else {
                                                            $not_db_data = true;
                                                            ?>
                                                            <p class="hotel-title" title="{{ $api_name }}"> {{ $api_name }}</p>
                                                            <div class="hotel-loc">
                                                                <img src="{{asset('images/location.svg')}}">
                                                                <div><p class="m-0"> {{ $api_city }},{{ $api_country }} </p></div>
                                                            </div>
                                                            <?php 
                                                        }?>
        
                                                        <div class="breakfast">

                                                            <?php if($data['breakfast_status_exp']) { ?>

                                                            <img src="{{asset('images/break.svg')}}">
                                                            <div><p class="m-0">Breakfast Included</p></div>

                                                            <?php } else { ?>
                                                                <img>
                                                                <div><p class="m-0"></p></div>

                                                            <?php } ?>

                                                        </div>
                                                        <div class="Night-price">
                                                <?php
                                                // dd($data);
                                                    if(isset($data["exp_status"]))
                                                    {
                                                    if($data["exp_status"] == 1)
                                                    { 
                                                        echo "<span class='total_tax_price'> $currency_symbol ".$data["totalprice_exp"]." </span> total
                        includes taxes & fees";
                                                    }
                                                    else
                                                    {
                                                        echo "<span class='total_tax_price'> No availability on these dates please choose other dates!! </span>";
                                                    }
                                                    }
                                                    else
                                                    {
    
                                                        if(isset($data["hcom_status"])){
                                                        if($data["hcom_status"] == 1)
                                                    { 
                                                        echo "<span class='total_tax_price'>$currency_symbol ".$data["totalprice_hcom"]." </span> total
                        includes taxes & fees";
                                                    }
                                                    else
                                                    {
                                                        echo "<span class='total_tax_price'> No availability on these dates please choose other dates!! </span>";
                                                    }
                                                    }
                                                    }
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                                                    <div class="bor-bottom">
                                                        
                                                        <?php 
                                                        if(isset($data["rating"])) {
                                                        $rating =  (float)$data["rating"];
                                                        $rating_round = ceil($rating);
                                                        }
                                                        else {
                                                            $rating_round = 0;
                                                        }
                                                       ?>
                                                        <div>
                                                            <?php if($rating_round != 0 ) { ?>
                                                            <img src="<?php echo asset("images/star_$rating_round.png");?>">
                                                            <?php } else {?>
                                                            <span>No star</span>
                                                            <?php } ?>
                                                        </div>
        
                                                        <div class="Rating">Rating </div>
                                                    </div>
        
                                                    <?php 
                                                    $exp_valid = false;
                                                    if(isset($data["exp_status"]))
                                                    { ?>
    
                                                    <div class="bor-bottom">
                                                    
                                                        <div class="Agoda">
    
                                                            <a href="#" target="_blank">Expedia</a>
    
                                                        </div>
        
                                                        <?php 
                                                        if($data["exp_status"] == 1) { 
                                                            $exp_valid = true;
                                                            $avg_expediaprice = $data["avgprice_exp"];
                                                            ?>
                                                        <div class="num-price" id="avg_expprice" > 
                                                          {{ $currency_symbol }} {{ round($avg_expediaprice) }}
                                                        </div>
                                                        <?php } else { 
                    
                                                            ?>
                                                            {{ "No availability on these dates" }}
                                                        <?php
                                                        } ?>
        
                                                    </div>
                                                      <?php }?>
        
                                                    <div class="bor-bottom">
        
                                                        <div class="Agoda">
                                                            <a href="#" target="_blank"> Hotels.com </a>
        
                                                        </div>
                                                        
                                                        <?php
                                                         $hcom_valid = false;
                                                         if(isset($data["hcom_status"]))
                                                        { 
                                                        if($data["hcom_status"] == 1) { 
                                                            $hcom_valid = true;
                                                            $avg_hcomprice = $data["avgprice_hcom"];
                                                            ?>
                                                        <div class="num-price" id="avg_hcomprice" > 
                                                            {{ $currency_symbol }} {{ round($avg_hcomprice) }}
                                                        </div>
                                                        
                                                        <?php } else { 
                        
                                                            ?>
                                                            {{ "No availability on these dates" }}
                                                        <?php
                                                        }
                                                    }?>
                                                    </div>
                                                    
                                                </div>
                                            </div>
        
                                            <?php 
                                            // $final_price = '';
                                            // if($avg_hcomprice != '' || $avg_expediaprice != '')
                                            // {
                                            //     $final_price = $avg_expediaprice > $avg_hcomprice ? $avg_expediaprice :     $avg_hcomprice;
                                            // }
                                            // else 
                                            // {
                                            //     $final_price = 0;
                                            // }
                                            $best_expedia = false;
                                            $best_hcom    = false;
                                            if($exp_valid && $hcom_valid)
                                            {
                                              $final_price = $avg_expediaprice > $avg_hcomprice ? $avg_expediaprice : $avg_hcomprice;
                                              $best_expedia = true;
                                            }
                                            else if($exp_valid && !$hcom_valid )
                                            {
                                                // echo "only expedia!!!";
                                                $final_price = $avg_expediaprice;
                                                $best_expedia = true;
                                            }
                                            else
                                            {
                                                $final_price = $avg_hcomprice; 
                                                $best_hcom = true;
                                                // echo "only hcom!!!";
                                            }
                                            ?>
        
                                            <?php if($final_price != 0) { ?>
        
                                            <div class="row m-0 pb-3">
        
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400">
                                                    <div class="exp-price">                                              
                                                        <div><img src="<?php
                                                        if($best_expedia)
                                                        {
                                                           echo asset('images/exp-img.svg');
                                                        }
                                                        else
                                                        {
                                                            echo asset('images/hotels logo.svg');
    
                                                        }?>"
                                                        ></div>   
                                                        <div class="value-price">
                                                            {{ $currency_symbol }} {{ round($final_price) }}
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400">
                                                    <div class="exp-view"> 
                                                        <?php if($not_db_data)   
                                                        {?>                                          
                                                        <a href="{{ $api_expedia_link }}" target="_blank">View More</a>
                                                        <?php } else { ?>
                                                        <a href="<?php echo $base_url;?>/hotelDetails?expediaId={{ $data["property_id"] }}&price={{ $final_price }}&locale=enUS&regionid={{ $_GET["regionid"] }}" target="_blank">View More</a>
                                                        <?php }?>
                                                     </div>
                                                    
                                                </div>
        
                                            </div>
        
                                            <?php } ?>
        
                                        </div>
        
                                    </div>
        
                                <?php  } else {  ?>
                                    <div class="row m-0  hotel-list list-item not_available" id="{{ $data['property_id'] }}">
        
                                        <div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0">
                                            <div class="position-relative">
                                              
                                                <?php 
    
                                                $img_link = isset($data["main_image"]) ? $data["main_image"] : '';
    
                                                if(empty($img_link))
                                                {
                                                    $file_dir = '';
                                                    $file_ext = '';
                                                    $file = pathinfo($api_url);
                                                    $file_name = $file["filename"];
                                                    if(isset($file["dirname"]) && isset($file["extension"]))
                                                    {
                                                        $file_dir = $file["dirname"];
                                                        $file_ext =  $file["extension"];
                                                    }
                                                    $change_imgtype = 'y';
                                                    $file_name = trim($file_name);
                                                    $remove_last = substr($file_name, 0, -1);
                                                    $alter_image_type = $remove_last.''.$change_imgtype;   
                                                    $img_link = $file_dir.'/'.$alter_image_type.".".$file_ext;
                                                }
                                                ?>
                                                <div class="hotel-img"><img src="<?php echo strlen($img_link) > 3 ? $img_link : "empty";?>" class="w-100 hotel_img">
                                    
                                                </div>
                                                
                                                <div class="small-image" style="display:none"> 
                                                    <?php
                                                        $count = 0;
                                                         foreach($preview_images as $img=>$link) { 
                                                            ?>
                                                    <?php if($count < 4) { ?>
                                                    <div class="small-image-first"><img src="{{ $link["link"] }}" class="small-image-preview"></div>
                                                     
                                                    <?php 
                                                    }
                                                     $count++;
                                                } ?>
                                                </div>
                                            </div>                                    
                                         </div>
        
                                        <div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0">
                                            <div class="row m-0 pt-3">
                                                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400">
                                                    <div class="hotel-leftside">
        
                                                        <?php if( isset($data["property_name"]) && isset($data["province"]) && isset($data["country"]) && isset($data["city"])){ ?>
                                                        <p class="hotel-title" titel="{{ $data["property_name"] }}"> {{ $data["property_name"] }}</p>
                                                        <div class="hotel-loc">
                                                            <img src="{{asset('images/location.svg')}}">
                                                            <div><p class="m-0"> {{ $data["city"] }} , {{ $data["province"] }} , {{ $data["country"] }} </p></div>
                                                        </div>
                                                        <?php } else {
                                                            ?>
                                                        <p class="hotel-title"> record not avilable in database </p>
                                                            <?php 
                                                        }?>
                                                        <div class="breakfast">
                                                            <?php if($data['breakfast_status_exp']) { ?>

                                                                <img src="{{asset('images/break.svg')}}">
                                                                <div><p class="m-0">Breakfast Included</p></div>
    
                                                                <?php } else { ?>
                                                                    <img>
                                                                    <div><p class="m-0"></p></div>
    
                                                                <?php } ?>
                                                        </div>
                                                        <div class="Night-price">
                                                        <?php
                                                        
                                                            if(isset($data["exp_status"]))
                                                            {
                                                                echo "exp statuas : ".$data["exp_status"]."<br/>";
                                                            if($data["exp_status"] == 1)
                                                            { 
                                                               echo "$ ".$data["totalprice_exp"]." total
    includes taxes & fees";
                                                            }
                                                        }
                                                        else
                                                            {
                                                                 
                                                                echo "<span class='total_tax_price'> No availability on these dates please choose other dates!! </span>";
                                                            }
                                                            
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                                                    <div class="bor-bottom">
                                                        
                                                        <?php 
                                                        if(isset($data["rating"])) {
                                                        $rating =  (float)$data["rating"];
                                                        $rating_round = ceil($rating);
                                                        }
                                                        else {
                                                            $rating_round = 0;
                                                        }
                                                       ?>
                                                        <div>
                                                            <?php if($rating_round != 0 ) { ?>
                                                                <img src="<?php echo asset("images/star_$rating_round.png");?>">
                                                                <?php } else {?>
                                                                <span>No star</span>
                                                                <?php } ?>
                                                        </div>
        
                                                        <div class="Rating">Rating </div>
                                                    </div>
        
                                                    <div class="bor-bottom">
                                                    
                                                        <div class="Agoda">
                                                            <a href="#" target="_blank">Expedia</a>
                                                        </div>
    
                                                        <div class="num-price" id="avg_expprice" > 
    
                                                        <?php if(isset($data["exp_status"]))
                                                        { 
                                                        if($data["exp_status"] == 1) { 
                                                            $avg_expediaprice = $data["avgprice_exp"];
                                                            ?>
                                                        
                                                            {{ $currency_symbol }} {{ $avg_expediaprice }}
                                                        
                                                        <?php } 
                                                    }
                                                    else { 
                                                        ?>
                                                        {{ "Not available" }}
                                                    <?php
                                                    }  ?>
                                                      </div>
                                                    </div>
        
                                                    <div class="bor-bottom">
        
                                                        <div class="Agoda">
                                                            <a href="#" target="_blank"> Hotels.com </a>
        
                                                        </div>
    
                                                        <div class="num-price" id="avg_hcomprice" > 
                                                        <?php if(isset($data["hcom_status"]))
                                                        { 
                                                        if($data["hcom_status"] == 1) { 
                                                            $avg_hcomprice = $data["avgprice_hcom"];
                                                            ?>
                                                        
                                                            {{ $currency_symbol }} {{ $avg_hcomprice }}
                                                        
                                                        <?php 
                                                    } } else { 
                                                        ?>
                                                        {{ "Not available" }}
                                                    <?php
                                                    }?>
                                                    </div>
                                                    </div>
        
                                                </div>
                                            </div>
        
                                            <?php 
                                            $final_price = '';
                                            if($avg_hcomprice != '' && $avg_expediaprice != '')
                                            {
                                                $final_price = $avg_expediaprice > $avg_hcomprice ? $avg_expediaprice : $avg_hcomprice;
                                            }
                                            else 
                                            {
                                                $final_price = 0;
                                            }
                                            ?>
        
                                            <?php if($final_price != 0) { ?>
        
                                            <div class="row m-0 pb-3">
        
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400">
                                                    <div class="exp-price">                                              
                                                        <div><img src="{{asset('images/exp-img.svg')}}"></div>   
                                                        <div class="value-price">
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400">
                                                    <div class="exp-view">                                              
                                                        <a href="<?php echo $base_url;?>/hotelDetails?expediaId={{ $data["property_id"] }}&price={{ $final_price }}&locale=enUS&regionid={{ $_GET["regionid"] }}" target="_blank">View More</a>
                                                     </div>
                                                    
                                                </div>
        
                                            </div>
        
                                            <?php } ?>
        
                                        </div>
        
                                    </div>
        
                                 <?php } 
        
                                $count_overall++;
                                // echo "count inc : ".$count_overall;
                                 }
                            }
                            ?> 
    
                            </div>
        
                            {{-- no data found --}}
    
                            <div class="face show_nofound">
                                <div class="band">
                                    <div class="red"></div>
                                    <div class="white"></div>
                                    <div class="blue"></div>
                                </div>
                                <div class="eyes"></div>
                                <div class="dimples"></div>
                                <div class="mouth"></div>
                            </div>
                            <h2 class="show_nofound">No available hotels found</h2>
    
                            {{-- no data found --}}
    
                            </div>
                            <div id="pagination-container">
                            </div> 
                            </div>
                    </div>
                    <div class="col-xl-4 col-lg-3 col-md-12 col-12">
                        <div id="map"></div>
                        <script
                        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap&v=beta&libraries=marker"
                        defer
                      ></script>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="db_regionId" value="<?php echo isset($_GET['regionid']) ? $_GET['regionid'] : 0 ;?>">
        <input type="hidden" id="not_available_latlong" data-lat="" data-long="">
    </form>
        
        @include('layouts/footer') 
    </div>
    
    <?php } catch(Exception $e)
    {
        // echo "error line : ".$e->getLine().'<br/>';
        // echo "error : ".$e->getMessage();
        // dd('Exception Catched!!!');
    }?>
    
    <style>
        .loader_filter {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        animation: spin 2s linear infinite;
        margin-top: 5%;
        margin-left: 40%;
        }
        
    #map {
      height: 100%;
      position: sticky !important;
      top: 1.375rem;
      display: flex;
      flex: 1 1;
      height: calc(100vh - 1.375rem);
    }
    .total_tax_price{
        font-size: 18px;
        font-family: 'Inter';
        color: currentColor;
        font-weight: 600;
    }
    .gm-style-iw.gm-style-iw-c {
        padding: 0px;
        width: 250px;
        max-width: 220px !important;
    }
    .gm-style-iw-d {
        overflow: hidden !important;
    }
    button.gm-ui-hover-effect {
        display: none !important;
    }
    .gm-style-iw.gm-style-iw-c {
        box-shadow: none;
        background: transparent;
    }
    .map-inner {
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 7px 1px rgb(0 0 0 / 30%);
        background: #fff;
        position: relative;
        z-index: 2;
    }
    .Night-price.text-right {
        font-size: 14px;
    }
    .map-main-img{
        width: 100%;
        height: 130px;
        object-fit: cover;
        position: relative;
        top: 6px;
        z-index: 1;
        border-radius: 8px 8px 0px 0px;
    }
    #searchBox
    {
        top: 1% !important;
        left: 232px;
        background: white;
        padding: 8px;
        font-size: 18px;
    }
    .selected_map{
       border : 2px solid green;
    }
    
    .price-tag {
      background-color: #4285F4;
      color: #FFFFFF;
      font-size: 14px;
      padding: 0.125rem 0.5rem;
      position: relative;
      justify-content: center;
      align-items: center;
      border: 3px solid #0062e3;
      border-radius: 0.375rem;
      cursor: pointer;
    }
    
    .price-tag::after {
      content: "";
      position: absolute;
      left: 50%;
      top: 100%;
      transform: translate(-50%, 0);
      width: 0;
      height: 0;
      border-left: 8px solid transparent;
      border-right: 8px solid transparent;
      border-top: 8px solid #4285F4;
    }
    
    [class$=api-load-alpha-banner] {
      display: none;
    }
    
    .selected_map{
       border : 2px solid green;
    }
    
    .highlight_click{
        z-index: 5 !important;
        padding: 0.25rem 0.5rem !important;
        border-color: #0062e3 !important;
        background-color: #fff !important;
        color: #0062e3 !important;
        font-size: 1rem !important;
        position : revert !important;
    }
    
    .gm-style-iw-tc
    {
      display: none !important;
    }
    
    </style>
    
    <script>
    
    $(function()
    {
    
    $('#popupdata').css('cursor','not-allowed')
    
    $('#popupdata').removeAttr('data-target')
    
    smallImagesHover();
    
    hoverOnPropertiesList();
    
    imgLoadError();
    
    function imgLoadError()
    {
    
    $('.hotel_img').on('error',function () {
    console.log(`failed to load the main image ${this.src}`);
    this.src = "https://images.trvl-media.com/hotels/1000000/30000/20500/20427/383efd1a_z.jpg";
    });
    
    }
    
    let locations = {{ Js::from($geolocation) }};
    
    let client_map_id = {{ Js::from(env('GOOGLE_MAP_ID')) }}
    
    let currency_symbol = {{ Js::from($currency_symbol) }}
        
    console.log("currency_symbol : ",currency_symbol)
    //var searchresultstatus = false;
    
    let  jqueryarray = []
    
    let originalArray=[]
    
    let filter_sortBy = [];
    
    console.log("overall pin locations : ",locations)
    
    let drag_event = false; 
    
    let pin_items = [];
    
    let data_location = [];
    
    let split_array = [];
    
    let split_array_drag = [];
    
    let hovered_indexarr = []
    
    filter_sortBy = {{ Js::from($search_result) }}
    
    var map = '';
    
    
    $(".listget").click(function ()
    {       
    var a = $(this).attr("data-regionid");
    $('#hidden_search_field').val(a);
    
    var b = $(this).attr("value");
    console.log('value',b);
    
    $("#search_field").val(b);//here the clicked value is showing in the div name user
    console.log(a);//here the clicked value is showing in the console
    });
    
    $('.coins-list').click(function(){
      console.log("Choosen currency : ",$('#id_select2_examples').val())
      if($('#select2-id_select2_examples-container').attr('title') != 'USD')
      {
        console.log("Choosen currency2222222222222222 : ",$('#id_select2_examples').val())
          localStorage.setItem("currency1111111111",$('#select2-id_select2_examples-container').attr('title'))
          GetSearch($('a.nav-link.active')[0].outerText);
          
      }
      else
      {
         localStorage.setItem("currency",$('#select2-id_select2_examples-container').attr('title'))
      }
    
    })
    
    $('#search').click(function(e){    
        e.preventDefault();   
        var name= $('#search_field').val();  
        if(name == '') {   
               $('#myModal2').show();             
           }
       else
        {
        if(name !=='' ){ 
        var checkin=$('#date_picker').val().replace(/ /g,'');
        var arr = checkin.split('-');
        var date1 = arr[0];
        var checkIn=date1.replace(/\//g,'-')
        var date2 =arr[1];
        var checkOut=date2.replace(/\//g,'-')
       
    
            location.href =  `/Hotelcomparator/public/index.php/hotelsearch?locale=${$('#active_locale').val()}&regionid=${$('#hidden_search_field').val()}&place=${$('#search_field').val()}&parentregionID=${$('#parentregionid').val()}&checkIn=${checkIn}&checkOut=${checkOut}&Noofdates=${$('#no_of_days').val()}`; 
        
            
        }
        else{
           $('#myModal2').hide();  
        }
        
        }
               
    })
    
    $(document).on('click', 'ul#list_show li', function () {
        var regionid = $(this).attr("data-regionid");
        var countryvalue= $(this).attr("value");
        var parentregionID = $(this).attr("data-parentregionid");
        console.log('data-parentid',parentregionID);
    
        console.log('after',countryvalue);
        $('#hidden_search_field').val(regionid);
        $("#search_field").val(countryvalue);    // here the clicked value is showing in the div name user
        $("#parentregionid").val(parentregionID); 
        console.log('rrrrrrrrfterrrr',regionid);               // here the clicked value is showing in the console
    });
    
    function smallImagesHover()
    {
        $('.small-image-preview').on('mouseenter',function(){
        $(this).parent().parent().parent().find('img.w-100.hotel_img').attr('src',$(this).attr('src'))
    });
    
    $('.hotel-list').mouseenter(function(){
        $(this).find('.small-image').css('display','flex')
    })
    
    $('.hotel-list').on('mouseleave',function(){
        $(this).find('.small-image').css('display','none')
    })
    }
    
    
    $(document).mouseup(function (e) {
                if ($(e.target).closest(".members").length == 0) {
                    $(".members").hide();
                    $('#guests_ok').trigger("click");
                }
                if ($(e.target).closest(".login-section").length
                            === 0) {
                    $(".login-section").hide();
                }
            });
    
       let detect_click = 0;
     
    $(document).on('click', 'ul#list_show_mob li',function () {
     var regionid = $(this).attr("data-regionid");
     var countryvalue= $(this).attr("value");
     var parentregionID = $(this).attr("data-parentregionid");  
     $('#hidden_search_field').val(regionid);
     $("#search_field").val(countryvalue); 
     $("#parentregionid").val(parentregionID); 
     // console.log('countryvalue clicked : ',countryvalue)
     $('#mobile_searchinput').val(countryvalue)
    // $('#search_field').val($(this).find('.city').text())
     // $('#mobile_searchscreen').modal('hide');
     $('#mobile_searchscreen').hide();
    $('.modal-backdrop').hide();
    });
    
    // pagination scritp start 
    
    var items = $(".list-wrapper .list-item");
    
        var numItems = '<?php echo count($search_result);?>'
        var perPage = 20;
        
        items.slice(perPage).hide();
    
        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "Pre",
            nextText: "Next",
            onPageClick: function (pageNumber) {
                imgLoadError()
                console.log('clicked page number : ',pageNumber);
                console.log("pagination 3 ")
                let offset = (pageNumber-1)*20
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
                window.scrollTo(0, 0);
            }
        });
    
    // pagination scritp end 
    
    //Filter start
    var availability =[];
    var arr = [];
    //  get Hotels Ajax
    $(document).on('change click', '.acccount', function() {
      availability = [];
      $('input.acccount:checked').each(function() {
        var acctypedata = $(this).data("property_typeid").toString();
        availability.push(acctypedata);
    
      });
      
      if ($(this).is(':checked') || availability.length == 0) {
        var staticarray = ["5","4","3","2","1","0"];
        acctypefilter(availability, arr.length !== 0 ? arr : staticarray);
      } else {
        acctypefilter(availability, arr);
      }
    });
    
    $(document).on('change click', '.getcheck', function() {
      arr = [];         
      $.each($("input[name='checkdata']:checked"), function() {
        arr.push($(this).val());
      });
      if (availability.length !== 0) {
        acctypefilter(availability, arr);
      } else {
        var availabilityarray = <?php echo json_encode($static); ?>;
        var finaldataava = availabilityarray.toString();
        acctypefilter(finaldataava, arr);
      }
    });
    
    $(".text-right").click(function(){  
    
    // Assuming the user inputs the range as min and max values
    var minValue = Number($("#minprice").val());
    var maxValue = Number($("#maxprice").val());
    
    
    acctypefilter(availability,arr,minValue,maxValue);
    
    });
    
    $(document).on('change click', '.pricescount', function() {
    // $(".pricescount").click(function(){  
    
    let minValue = Number($(this).data('min'));
    let maxValue = Number($(this).data('max'));
    
    
    if ($("input[name='pricerange']:checked").length !== 0) {
        acctypefilter(availability,arr,minValue,maxValue);
    
    
    }
    else{
    
    acctypefilter(availability, arr);
    }
    
    });
    
    
    // acctype  
    
    function checkListFilterappenditems(data)
    {
    
        filter_sortBy = []
    
        filter_sortBy = data
    
        console.log("latest sortby applied : ",filter_sortBy)
    
        //console.log('aaaaa666666666',data);
        $('#search_resultajax').html('')
       
        if(data.length > 0 ){
        let hotels_data_filter = Object.values(data);
        let result_filter = '';
        let avg_Expprice = ''
        let avg_Hcomprice = ''
        let final_price = '';
        let total_price = '';
        var hide_section = [];
        var show_taxtext = false;
        hotels_data_filter.map(function(item,index){
    
    
            let star_imghtml = '';
    
            let images_hover = '';
    
            let smallmain_image = item.main_image;
    
            if(item.images && item.images != undefined)
            {
                let imgappend_start = `<div class="small-image" style="display: none;">`
    
                let imgappend_end = `</div>`
    
                let decoded_images = JSON.parse(item.images)
    
                let img_list = ''
    
                if(decoded_images.ROOMS && decoded_images.ROOMS != undefined)
                {
                    let sliced_arr = decoded_images.ROOMS.length > 4 ? decoded_images.ROOMS.slice(0,5) : decoded_images.ROOMS;
    
                    // console.log("decoded sliced_arr images ======> ",sliced_arr)
    
                    sliced_arr.map(function(item,index){
    
                        index == 0 ? img_list += `<div class="small-image-first">
                        <img src=${smallmain_image} class="small-image-preview">
                        </div>`  : img_list += `<div class="small-image-first">
                        <img src=${item.link} class="small-image-preview">
                        </div>`
                        
                    })    
    
                    images_hover = `${imgappend_start}${img_list}${imgappend_end}`
                }
                else
                {
                    console.log("ROOMS key is undefined!!!")
                }
                
            }
    
            if((item.exp_status == undefined || item.hcom_status == undefined))
            {
                if(item.exp_status == undefined && item.hcom_status == undefined)
                {
                    avg_Expprice = 'Not available'
                    avg_Hcomprice = 'Not available'
                    total_price = 'No availability on these dates please choose other dates'                                                
                    final_price =  0
                    hide_section.push(index);
                    show_taxtext = false
                }
                else if(item.exp_status != undefined && item.hcom_status == undefined)
                {
    
                    avg_Hcomprice = 'Not available'
                    console.log("expedia only available!!!")
                    final_price =  Math.round(parseFloat(item.avgprice_exp))
                    total_price = parseFloat(item.totalprice_exp)
                }
                else
                {
                    avg_Expprice = 'Not available'
                    console.log("hcom only available!!!")
                    final_price = Math.round(parseFloat(item.avgprice_hcom))
                    total_price = parseFloat(item.totalprice_hcom)
                }
            }
            else
            {
                avg_Expprice = item.avgprice_exp
                avg_Hcomprice = item.avgprice_hcom
                //avg_currency = item.avgprice_exp.Currency
                final_price =  Math.round(parseFloat(avg_Expprice))  > Math.round(parseFloat(avg_Hcomprice)) ? Math.round(parseFloat(avg_Expprice)) : Math.round(parseFloat(avg_Hcomprice))
                total_price = parseFloat(item.totalprice_exp)
                show_taxtext = true
            }
    
            if (typeof item.property_name === 'undefined' || typeof item.country === 'undefined' || typeof item.city === 'undefined' || typeof item.main_image === 'undefined' ) {
                    appiname = item.api_name;
                    apicity = item.api_city;
                    apicount =item.api_country;
                    // console.log("item.api_image_url : ",item.api_image_url)
                    mainimage = item.api_image_url !== undefined ?  item.api_image_url.replace('_t','_y') : item.main_image
                
                } else {
                
                    appiname = item.property_name;
                    apicity = item.city;
                    apicount =item.country;
                    mainimage=item.main_image
            
                }
    
                var rating = item.rating; 
                
                var ratingRound = Math.ceil(rating);
    
                // console.log('ratingRound  : ',ratingRound)
    
                var starImageUrl = "/Hotelcomparator/public/images/star_" + ratingRound + ".png";
    
                star_imghtml = ratingRound != 0 ? `<img src="${starImageUrl}">` : 'No star'
                // total_price =  
    
                // console.log("final average price  : ",final_price)
    
                // ${ currentProperty.regionid == undefined ? $('#db_regionId').val() : currentProperty.regionid }
    
            result_filter += `<div class="row m-0  hotel-list list-item ${ index == 0 ? 'selected_map' : '' }" data-index="${index}" id="${item.property_id}"><div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0">
                <div class="position-relative">
                    <div class="hotel-img">
                    <img src="${mainimage}" class="w-100 hotel_img">
                    </div>
                    ${ (images_hover && images_hover != '') ? images_hover : '' }
                    </div>
                    </div>
                    <div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0"><div class="row m-0 pt-3"><div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400"><div class="hotel-leftside"><p class="hotel-title" title="${appiname}"> ${appiname}</p>
                    <div class="hotel-loc"><img src="{{asset('images/location.svg')}}"><div><p class="m-0"> ${apicity},${item.province},${apicount} </p></div></div><div class="breakfast"><img src="{{asset('images/break.svg')}}">
                    <div><p class="m-0">Breakfast Included</p></div></div><div class="Night-price"> 
                        <span class="total_tax_price"> ${ typeof(total_price) == 'number' ? `${currency_symbol} ${total_price}` : total_price } </span> 
                        ${ show_taxtext ? `total includes taxes & fees` : '' }</div>
                    </div></div><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                    <div class="bor-bottom"><div>
                        ${star_imghtml}
                        </div><div class="Rating"> Rating</div>
                    </div><div class="bor-bottom"><div class="Agoda"><a href="#" target="_blank">Expedia</a></div><div class="num-price" id="avg_expprice" >${ final_price != 0 ? `${currency_symbol} ${final_price}` : 'Not available' } </div>
                    </div><div class="bor-bottom"><div class="Agoda">
                    <a href="#" target="_blank"> Hotels.com </a>
                    </div><div class="num-price" id="avg_hcomprice">${ final_price != 0 ? `${currency_symbol} ${final_price}` : 'Not available' } </div></div></div></div><div class="row m-0 pb-3 price_hide" id="hide_${index}" style="display:none"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400"><div class="exp-price"><div><img src="{{asset('images/exp-img.svg')}}"></div><div class="value-price"> ${currency_symbol} ${Math.round(final_price)} </div></div> </div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400"><div class="exp-view"><a href="<?php echo $base_url;?>/hotelDetails?expediaId=${item.property_id}&price=${final_price}&locale=${$('#active_locale').val()}&regionid=${$('#db_regionId').val()}" target="_blank">View More</a></div></div></div></div></div>`
        })
    
        hoverOnPropertiesList();
       
        $('#search_resultajax').append(result_filter);
    
        imgLoadError()
    
        $('.price_hide').each(function(index){
                if(!(hide_section.includes(index))){
                    $(`#hide_${index}`).show();
                }
            })
          
    // pagination scritp start 
    
        var items = $(".list-wrapper .list-item");
        var numItems = Object.values(data).length;
        var perPage = 20;
        items.slice(perPage).hide();
    
        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "Pre",
            nextText: "Next",
            onPageClick: function (pageNumber) {
                imgLoadError()
                console.log("pagination after checklist filter")
    
                $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
                $('.yNHHyP-marker-view').first().addClass('zindex-prop')
    
                console.log('clicked page number : ',pageNumber);
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
                window.scrollTo(0, 0);
                let pagination_index = pageNumber-1
                if(pageNumber <= split_array.length)
                {
                console.log('current passed array ready result : ',split_array[pagination_index])
                pinLocationsinMap(split_array[pagination_index])
                hoverOnPropertiesList()
                }
                else
                {
                    pinLocationsinMap([])
                }
            }
        });
    
        $('#countname').html('');
        $('#countname').append(Object.values(data).length);
    
        $('#pagination-container').show();
        $('.show_nofound').hide();
    
       }
        else{
            $('#pagination-container').hide();
            $('.show_nofound').show();
        }
    
        smallImagesHover();
    
        hoverOnPropertiesList()
    
        
    }
    
    originalArray = <?php echo json_encode($search_result); ?>;
    
    jqueryarray = originalArray;
    
    
    console.log("jqueryarray intial : ",jqueryarray)
    
    function acctypefilter(region_ID_filter,starating,minValue,maxValue)
    {
    
    jqueryarray = originalArray;
    
    console.log('wholearray',jqueryarray);
    
    var filterValue = region_ID_filter;
    
    console.log('ttttttttttt',filterValue)
    
    if(filterValue.length > 0){
        
        jqueryarray =  jqueryarray.filter(item => 
    
    filterValue.includes(item.propertyType_id)
    );
    }  
    else {
        jqueryarray = originalArray;
      }
    
    console.log('jqueryarray ==> filterValue',jqueryarray)
    
    console.log("starating : ",arr)
    
    if (arr.length > 0) {
      
      jqueryarray = jqueryarray.filter(item => {
        if (item.rating === arr[0]) {
          
          return true;
        } else {
          
          return arr.includes(item.rating);
        }
      });
      
      
      jqueryarray.sort((a, b) => b.rating - a.rating);
      
      
    }
    
    
    if (minValue >= 0 && maxValue > 0) {
      jqueryarray = jqueryarray.filter(item => ( (item.avgprice_exp >= minValue   &&  item.avgprice_exp <= maxValue ) && (item.avgprice_hcom >= minValue  &&  item.avgprice_hcom <= maxValue )));
      jqueryarray.sort((a, b) => a.avgprice_exp - b.avgprice_exp);
      console.log(jqueryarray);
    }
    
    console.log('jqueryarray ==> arr',jqueryarray)
    
    
    var filter_pinlocations = [];
    
    jqueryarray.filter(function(filteritem,index) {
        if((filteritem.exp_status || filteritem.hcom_status) && (filteritem.exp_status != undefined || filteritem.hcom_status != undefined))
        {
            locations.filter(function(pinitem,index) {
                if(filteritem.property_id == pinitem.property_id){
                    // console.log("pinitem : ",pinitem)
                    filter_pinlocations.push(pinitem)
                }
            })
        }
    })
    
    console.log("filtered_pinlocations",filter_pinlocations)
    
    let split_onfilter = splitLocationsPin(filter_pinlocations)
    
    split_array = []
    
    split_array = split_onfilter
    
    console.log("filter on locations : ",split_onfilter)
    
    if(split_onfilter.length > 0 )
    {
        pinLocationsinMap(split_array[0])
    }
    else
    {
        pinLocationsinMap([])
    }
    
    // locationSearchItems(jqueryarray)    
    
    checkListFilterappenditems(jqueryarray);
    
    // /
    }
    
    
    //Filter End
    
    
    // get hotels availability status and price at initial page load
    
    // map location pin at initial load and drag
    
    // pagination scritp start 
    
        var items = $(".list-wrapper .list-item");
    
        var numItems = '<?php echo count($search_result);?>'
    
        var perPage = 20;
        
        items.slice(perPage).hide();
    
        $('#pagination-container').pagination({
            items: numItems,
            itemsOnPage: perPage,
            prevText: "Pre",
            nextText: "Next",
            onPageClick: function (pageNumber) {
                imgLoadError()
                console.log("splitted arr : ",split_array)
                hovered_indexarr = []
                console.log('clicked page number : ',pageNumber);
                console.log('pagination at initial load')
    
                $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
                
                setTimeout(() => {
                    $('.yNHHyP-marker-view').first().addClass('zindex-prop')
                }, 2000);
    
                var showFrom = perPage * (pageNumber - 1);
                var showTo = showFrom + perPage;
                items.hide().slice(showFrom, showTo).show();
                let pagination_index = pageNumber-1
                if(pageNumber <= split_array.length)
                {
                console.log('current passed array ready result : ',split_array[pagination_index])
                pinLocationsinMap(split_array[pagination_index])
                hoverOnPropertiesList()
                }
                else
                {
                    pinLocationsinMap([])
                }
                window.scrollTo(0, 0);
    
            }
        });
    
    // pagination script end 
    
    
    function createCenterControl(map) {
      const controlButton = document.createElement("button");
    
      // Set CSS for the control.
      controlButton.style.backgroundColor = "#fff";
      controlButton.style.border = "2px solid #fff";
      controlButton.style.borderRadius = "20px";
      controlButton.style.boxShadow = "0 2px 6px rgba(0,0,0,.3)";
      controlButton.style.color = "rgb(25,25,25)";
      controlButton.style.cursor = "pointer";
      controlButton.style.fontFamily = "Roboto,Arial,sans-serif";
      controlButton.style.fontSize = "16px";
      controlButton.style.lineHeight = "38px";
      controlButton.style.margin = "8px 0 22px";
      controlButton.style.padding = "0 5px";
      controlButton.style.textAlign = "center";
      controlButton.textContent = "Search this area";
      controlButton.title = "Click to search";
      controlButton.type = "button";
      controlButton.id = "search_map"
      // Setup the click event listeners: simply set the map to Chicago.
      controlButton.addEventListener("click", () => {
        console.log('center latitude : ',map.getCenter().lat()); 
        console.log('center longtitude : ',map.getCenter().lng());
        mapsAPIaction(map.getCenter().lat(),map.getCenter().lng());
      });
      return controlButton;
    }
    
    function initMap() {
    
        if(locations.length <= 20)
        {
            pinLocationsinMap(locations)
            split_array.push(locations)
            // console.log("initail set array : ",split_array)
        }
        else
        {
            split_array =  splitLocationsPin(locations)
            pinLocationsinMap(split_array[0])
            console.log('first 20 items : ',split_array[0])
    
        }
    
    }
    
    
    // search as you move the Map this area 
    
    
    window.initMap = initMap;
    
    // split the pinlocations array by 20 on each pagination with this function
    
    function splitLocationsPin(all_items)
    {
    
      console.log("all_items.length : ",all_items.length)  
    
      let total_pages = all_items.length/20;
      
      total_pages = !Number.isInteger(total_pages) ? parseInt(total_pages+1) : total_pages ;
    
      console.log("total_pages for locations pin : ",total_pages)  
    
      let paginate_pinarr = [];
    
      let range = 20;
    
      let inital_range = 0;
    
      for(let spilt_items=0;spilt_items < total_pages; spilt_items++)
      {
        paginate_pinarr[spilt_items] = all_items.slice(inital_range,range)
        inital_range += 20
        range += 20
      }
    //   console.log("paginate_pinarr : ",paginate_pinarr)
    return paginate_pinarr;
    
    }
    
    // split the pinlocations array by 20 on each pagination with this function
    
    function mapsAPIaction(lat,long)
    {
    
    jqueryarray =[];
    
    $.ajax({
    type:'GET',
    url:"<?php echo $base_url;?>/mapsAPIaction",
    data:{ 
        latitude : lat,
        longitude : long
    },
    success:function(data){
    
        pin_items = [];
    
        hovered_indexarr = [];
    
        var  list_items = [];
    
        var db_regionId = 0;
    
        if($.isEmptyObject(data.error)){
    
            console.log('data success : ',data)
    
            console.log('data object : ',data.list_items)
    
            console.log('data object : ',data.location_pin)
    
            if(data.location_pin.length > 0){
    
            locations = [];
    
            locations = data.location_pin
    
            // rearrange the pinlocations array according to the database list items order 
    
            var rearrange_pinitems = [];
     
            var list_itemsIds = Object.keys(data.list_items) 
    
            // console.log("database list ids : ",list_itemsIds)
    
            list_itemsIds.filter(function(db_propertyid,index){
                data.location_pin.filter(function(api_pinitem,index){
                    db_propertyid == api_pinitem.property_id ? rearrange_pinitems.push(api_pinitem) : ''
                })
            })
    
            // console.log("rearrange_pinitems : ",rearrange_pinitems)
    
            // rearrange the pinlocations array according to the database list items order 
    
            $('#db_regionId').val(data.region_Id)
            
            // $('#search_resultajax').html('')
             
            data_location = rearrange_pinitems
    
            map = new google.maps.Map(document.getElementById('map'), {});
            
    
            if(data_location.length <= 20)
            {
                    pinLocationsinMap(data_location) 
            }
            else
            {
                drag_event = true;
                split_array_drag =  splitLocationsPin(data_location) 
                console.log("split_array_drag overall : ======> ",split_array_drag)
                pinLocationsinMap(split_array_drag[0])
            }
    
    
        console.log('data_location count : ',data_location.length)
    
        console.log('data_location drag on map : ',data_location)
       
        list_items = Object.values(data.list_items);
    
        console.log("list_items : ",list_items);
    
        let valid_items = list_items.filter((item) => Object.keys(item).length == 13)
    
        console.log("valid_items in database : ",list_items);
    
        console.log("initial sortby : ",filter_sortBy)
        
        // update the recent search items to the filter
    
        filter_sortBy = []
    
        filter_sortBy = list_items
    
        console.log("latest sortby : ",filter_sortBy)
    
         // update the recent search items to the filter
    
        locationSearchItems(list_items)
    
        mapfilterproperty(list_items)
    
        hoverOnPropertiesList()
    
        }
        else
        {
            alert('no hotels found in the Radius!!!')
        }
       }
        else{
            printErrorMsg(data.error);
        }
    }
    });
    
    
    }
    
    // function to pin the markers in the map section start
    
    
    function pinLocationsinMap(locations)
    {
    
    console.log('pin locations : ',locations)
    
    if(locations.length > 0 )
    {
    
    var custom_pricetags = []
    
    var centerMap = { lat: parseFloat(locations[0].latitude), lng: parseFloat(locations[0].longitude) };
    
    $('#not_available_latlong').attr('data-lat',centerMap.lat)
    
    $('#not_available_latlong').attr('data-long',centerMap.lng)
    
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: centerMap,
      mapId: client_map_id
    });
    
    
    locations.map(function(item,index){
    
        custom_pricetags[index] = document.createElement("div");
    
        custom_pricetags[index].className = "price-tag";
    
        custom_pricetags[index].id = item.property_id;
    
        custom_pricetags[index].textContent = `${currency_symbol} ${ Math.round(item.avgprice_exp) != 0 ? Math.round(item.avgprice_exp) : Math.round(item.avgprice_hcom) }`;
    
        var markerView = new google.maps.marker.AdvancedMarkerView({
        map,
        position: new google.maps.LatLng(item.latitude,item.longitude),
        content: custom_pricetags[index]
        });
    
        const infowindow = new google.maps.InfoWindow();
    
        const element  = markerView.element
    
        if(index == 0 )
        {
            $(element).find('.price-tag').addClass('highlight_click')
            // console.log("add class : ",$('.highlight_click').parent().parent().addClass('zindex-prop'))    
              // to show the price
            console.log("first item id : ",item.property_id)
            $('#search_resultajax').find(`#${item.property_id}`).addClass('selected_map')
        }
    
    
          element.addEventListener("pointerenter", () => {
            $('.gm-style-iw-tc').css('display','none')
            highlight(markerView, item );
          })
        
            element.addEventListener("pointerleave", () => {
    
                console.log("current element id :",$(element).find('.price-tag')[0].id)
    
                hoverOnMapPropertyCard($(element).find('.price-tag')[0].id);
    
                $(`.card_${$(element).find('.price-tag')[0].id}`).fadeOut()
    
                $('.gm-style-iw-tc').css('display','none')
                
            });
    
            markerView.addListener("click", (event) => {
    
            $('#map').find('.highlight_click').removeClass('highlight_click')
    
            $('#search_resultajax').find('.selected_map').removeClass('selected_map')
    
            $(element).find('.price-tag').addClass('highlight_click')
    
            $('.highlight_click').parent().parent().addClass('zindex-prop')
    
            $(`#${item.property_id}`).addClass('selected_map')
    
            console.log("items : ",$(`#${item.property_id}`))
    
            window,scrollTo(0,$(`#${item.property_id}`)[0].offsetTop)
    
            }); 
    
    })
        
    }
    else
    {
    
    console.log('not available lat and logitude from 1st one ',$('#not_available_latlong'))
    
    var not_available_center = { 
        lat: parseFloat($('#not_available_latlong')[0].dataset.lat), 
        lng: parseFloat($('#not_available_latlong')[0].dataset.long) };
    
    console.log("not_available_center : ",not_available_center)
    // var centerMap = $('#not_available_latlong')[0].dataset;
    
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 12,
      center: not_available_center,
      mapId: client_map_id
    });
    
    }
    
    const centerControlDiv = document.createElement("div");
    // Create the control.
    const centerControl = createCenterControl(map);
    
    // Append the control to the DIV.
    centerControlDiv.appendChild(centerControl);
    
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);
    
    // hoverAfter();
    console.log('current map position last : ',map.getBounds())
    
    setTimeout(() => {
        $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
        $('.yNHHyP-marker-view').first().addClass('zindex-prop')
    }, 1500);
    
    }
    
    
    // function to pin the markers in the map section end
    
    const infowindow = new google.maps.InfoWindow();
    
    // function to open the popup in map section while hovering the price value start
    
    function highlight(markerView,currentProperty) {
        
        console.log('hover price currentProperty : ',currentProperty)
        let popuprating_html = `<img src="<?php echo asset('images/star_${parseInt(currentProperty.rating)}.png');?>" style="width:50px">`
    
        infowindow.setContent(`<div class="map-location card_${currentProperty.property_id}" data-cardid=${currentProperty.property_id}>
            <a target="_blank" href="<?php echo $base_url;?>/hotelDetails?expediaId=${currentProperty.property_id}&price=${Math.round(currentProperty.price)}&locale=${$('#active_locale').val()}&regionid=${ currentProperty.regionid == undefined ? $('#db_regionId').val() : currentProperty.regionid }" ><img src="${ currentProperty.img_url != null ? currentProperty.img_url.replace('_t','_s') : currentProperty.main_image.replace('_t','_s') }" class="map-main-img"></a>
            <div class="map-inner">
                <p class="hotel-title mb-3" title="${currentProperty.property_name}">${currentProperty.property_name}</p>     
                <div class="mb-3">
                    ${ parseInt(currentProperty.rating) == 0 || isNaN(currentProperty.rating) ? '<span style="font-weight: 600;font-size: 15px;">No star</span>' : popuprating_html} 
                </div> 
                <div class="Night-price text-right">
                    <span class="total_tax_price">${currency_symbol} ${ Math.round(currentProperty.avgprice_exp) != 0 ? Math.round(currentProperty.avgprice_exp) : Math.round(currentProperty.avgprice_hcom) }</span> 
                    a night                                                   
                </div>
            </div>
            </div>`);
    
        infowindow.open(map, markerView);
    
    }
    
    // function to open the popup in map section while hovering the price value end 
     
    
    
    function hoverOnMapPropertyCard(elementId)
    {
        $(`.card_${elementId}`).hover(
            // mouse on property
            function () {
                $(`.card_${elementId}`).fadeIn(50)
                $('.gm-style-iw-tc').css('display','none')
            },
            function () {
                $(`.card_${elementId}`).fadeOut()
                $('.gm-style-iw-tc').css('display','none')
                // $('.gm-style-iw-tc').hide()
            },
        )
        
    }
    
    // Append the location searchthis area items in the property lists start
    
    function locationSearchItems(list_items)
    {
        jqueryarray =  list_items;
    
        originalArray = list_items;
        
        if(list_items.length > 0)
        {
        console.log("list_items  =====> ",list_items);
        
        // console.log('current location city : ',list_items[0].city)
    
        let items_map = '';
    
        list_items.map(function(item,index){
    
            let images_hover = '';
    
            let smallmain_image = item.main_image;
    
            if(item.images && item.images != undefined)
            {
                let imgappend_start = `<div class="small-image" style="display: none;">`
    
                let imgappend_end = `</div>`
    
                let decoded_images = JSON.parse(item.images)
    
                let img_list = ''
    
                if(decoded_images.ROOMS && decoded_images.ROOMS != undefined)
                {
                    let sliced_arr = decoded_images.ROOMS.length > 4 ? decoded_images.ROOMS.slice(0,5) : decoded_images.ROOMS;
    
                    // console.log("decoded sliced_arr images ======> ",sliced_arr)
    
                    sliced_arr.map(function(item,index){
    
                        index == 0 ? img_list += `<div class="small-image-first">
                        <img src=${smallmain_image} class="small-image-preview">
                        </div>`  : img_list += `<div class="small-image-first">
                        <img src=${item.link} class="small-image-preview">
                        </div>`
                        
                    })    
    
                    images_hover = `${imgappend_start}${img_list}${imgappend_end}`
                }
                else
                {
                    console.log("ROOMS key is undefined!!!")
                }
                
            }
            // console.log("item.totalprice_exp : ",item.totalprice_exp)
    
            const rating_img = `<img src="<?php echo asset('images/star_${Math.round(item.rating)}.png');?>">`
    
            const nostar = `<span class="no_star">No star</span>`
    
                items_map += `<div class="row m-0  hotel-list list-item ${ index == 0 ? 'selected_map' : '' }" data-index="${index}" id="${item.property_id}" ><div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0">
                    <div class="position-relative">
                        <div class="hotel-img"><img src="${ item.main_image != undefined ?  item.main_image  : ( item.api_image_url == undefined ? item.api_hcom_imageurl.replace('_t','_y') : item.api_image_url.replace('_t','_y') ) }" class="w-100 hotel_img">
                        </div>
                        ${ (images_hover && images_hover != '') ? images_hover : '' }
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0"><div class="row m-0 pt-3"><div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400"><div class="hotel-leftside"><p class="hotel-title" title="${ item.property_name == undefined ? item.api_name : item.property_name }"> ${ item.property_name == undefined ? item.api_name : item.property_name }</p>
                    <div class="hotel-loc"><img src="{{asset('images/location.svg')}}"><div><p class="m-0"> ${ item.address1 == undefined ? item.api_address : item.address1 },${item.city == undefined ? item.api_city : item.city },${ item.country == undefined ? item.api_country : item.country } </p></div></div><div class="breakfast"><img src="{{asset('images/break.svg')}}">
                    <div><p class="m-0">Breakfast Included</p></div></div><div class="Night-price"> 
                        <span class="total_tax_price">${currency_symbol} ${item.totalprice_exp}</span> 
                        total includes taxes & fees
                     </div>
                    </div></div><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                    <div class="bor-bottom"><div>
                        ${(item.rating != null && item.rating != 0) ? rating_img : nostar}
                    </div><div class="Rating"> Rating</div>
                    </div><div class="bor-bottom"><div class="Agoda"><a href="#" target="_blank">Expedia</a></div><div class="num-price" id="avg_expprice" >${currency_symbol} ${Math.round(item.avgprice_exp)}</div>
                    </div><div class="bor-bottom"><div class="Agoda">
                    <a href="#" target="_blank"> Hotels.com </a>
                    </div><div class="num-price" id="avg_hcomprice_${index}">  ${Math.round(item.avgprice_hcom)} </div></div></div></div><div class="row m-0 pb-3 price_hide"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400"><div class="exp-price"><div><img src="{{asset('images/exp-img.svg')}}"></div><div class="value-price">${currency_symbol} ${Math.round(item.avgprice_exp)} </div></div> </div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400"><div class="exp-view"> <a href="<?php echo $base_url;?>/hotelDetails?expediaId=${item.property_id}&price=${item.avgprice_exp}&locale=${$('#active_locale').val()}&regionid=${$('#db_regionId').val()}" target="_blank"> View More </a> </div></div></div></div></div>`
     
        })
    
        $('#search_resultajax').html('');
    
        $('#search_resultajax').append(items_map);
    
        imgLoadError()
    
    // pagination scritp start 
    
    
    var items = $(".list-wrapper .list-item");
    
    console.log("items length : ",items.length)
    
    var numItems = items.length
    
    var perPage = 20;
    
    items.slice(perPage).hide();
    
    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "Pre",
        nextText: "Next",
        onPageClick: function (pageNumber) {
            imgLoadError()
            console.log('paginataion after mapdrag')
            $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
            $('.yNHHyP-marker-view').first().addClass('zindex-prop')
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
            pinLocationsinMap(split_array_drag[pageNumber-1])
            hoverOnPropertiesList()
            window.scrollTo(0, 0);
        }
    });
    
    $("#result_city").text(list_items[0].city)
    
    $('#available_propertycount').text(list_items.length)
    
    $('#notavailable_propertycount').text(0)
    
    $('#search_field').val(list_items[0].city)
    
    setTimeout(() => {
        $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
        $('.yNHHyP-marker-view').first().addClass('zindex-prop')
    }, 1500);
    
    }
    else
    {
        alert('No Hotels found in the radius!!')
    }
    
    
    
    $('#countname').text(items.length)
    
    hoverOnPropertiesList()
    
    }
    
    
    //mapappendfilter
    
    function mapfilterproperty(list_items){
    
    // Generate property count and filter HTML
    let propertyCount = {};
    let acctype = '';
    let checkid =1;
    $.each(list_items, function(index, item) {
      let propertyType = item.propertyType_name + '-' + item.propertyType_id;
      if(propertyType in propertyCount) {
        propertyCount[propertyType]++;
      } else {
        propertyCount[propertyType] = 1;
      }
    });
    
    // To access the propertyType_id and propertyType_name separately, you can split the propertyType string:
    for (let propertyType in propertyCount) {
      let [propertyTypeName, propertyTypeId] = propertyType.split('-');
      console.log(`Property type name: ${propertyTypeName}, Property type ID: ${propertyTypeId}, Count: ${propertyCount[propertyType]}`);
    }
    
    
    $.each(propertyCount, function(propertyType, count) {
      let [propertyTypeName, propertyTypeId] = propertyType.split('-');
      acctype += `<div class="row mb-3 accfilter_row" id="mapaccfilters_${checkid}" data-property_typeId="${propertyTypeId}">
                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input acccount" id="mapcustoms_${checkid}" name="accfilter" data-property_typeId="${propertyTypeId}">
                        <label class="custom-control-label accfiltervalue" for="mapcustoms_${checkid}"><span class="ml-3">${propertyTypeName}</span></label>
                      </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                      <div class="wait_filter loader_filter" style="display:none"></div>
                      <div class="book-right property_count">${count}</div>
                    </div>
          
                  </div>`;
                  checkid++;
                  
    });
    
    $('#acc_typefilter').html(acctype);
    
    //map star rating 
    let ratingpropertyCount = {};
    let ratecheckid =1;
    $.each(list_items, function(index, item) {
      let rating = Math.round(item.rating); // round item.rating to the nearest integer
      if (isNaN(rating)) {
        return;
      }
      if (rating in ratingpropertyCount) {
        ratingpropertyCount[rating]++;
      } else {
        ratingpropertyCount[rating] = 1;
      }
    });
    
    let ratingdiv = '';
    for (let rating = 5; rating >= 0; rating--) {
      let count = ratingpropertyCount[rating];
      if (count === undefined) {
        continue;
      }
    
      var ratings = 'unrated'; // replace with your rating variable
    
    if (ratings !== 'unrated') {
      const ratingDiv = document.getElementById('ratingDiv');
      ratingDiv.style.display = 'block';
    }
    
      ratingdiv += `<div class="mb-4">
        
          <div class="row mb-3">
            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input getcheck" name="checkdata" id="mapcustomCheck_${ratecheckid}" value="${rating}">
                <label class="custom-control-label" for="mapcustomCheck_${ratecheckid}">
                  <span class="ml-3 d-flex align-items-center"><span class="ml-3 d-flex align-items-center">${(rating == 0 ) ? 'unrated' : rating}<span class="ml-1 mr-2">
                  <div id="ratingDiv">
      <span class="ml-1 mr-2"><img src="{{asset('images/one_1.png')}}">Rating</span>
    </div>
                </label>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
              <div class="book-right">${count}</div>
            </div>
            </div>  
    </div>`
    
      ratecheckid++;
    
    }
    
    $('#ratingdata').html(ratingdiv);
    
    //map price range
    // get the maximum price from the list_items array
    let maxPrice = Math.max(...list_items.map(item => item.avgprice_exp));
    
    // divide max price by 3 to get the size of each range
    let rangeSize = maxPrice / 3;
    
    // create an array of price ranges
    let priceRanges = [];
    for (let i = 0; i < 2; i++) {
      let min = i * rangeSize;
      let max = (i + 1) * rangeSize;
      priceRanges.push({ min: min, max: max });
    }
    priceRanges.push({ min: priceRanges[1].max, max: maxPrice });
    
    // count the number of items that fall into each price range
    let pricepropertyCount = {};
    list_items.forEach(item => {
      let price = item.avgprice_exp;
      for (let i = 0; i < priceRanges.length; i++) {
        if (price >= priceRanges[i].min && price <= priceRanges[i].max) {
          if (pricepropertyCount[i] === undefined) {
            pricepropertyCount[i] = 1;
          } else {
            pricepropertyCount[i]++;
          }
          break;
        }
      }
    });
    
    // create HTML markup for displaying the price ranges and counts
    let pricedata = '';
    for (let i = 0; i < priceRanges.length; i++) {
      let range = priceRanges[i];
      let count = pricepropertyCount[i] || 0;
      let min = Math.round(range.min === 0 ? 0 : range.min);
      
    
      let max = Math.round(range.max);
      pricedata += `
        <div class="row mb-3">
          <div class="col-xl-8 col-lg-8 col-md-8 col-12">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input pricescount" id="CustomCheck_${i}" data-min="${min}" data-max="${max}">
              <label class="custom-control-label" for="CustomCheck_${i}">
                <span class="ml-3">${range.max !== maxPrice ? `$${min} - $${Math.round(max - 0.01)}` : `$${min}+`}</span>
              </label>
            </div>
          </div>
         
    
          <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="book-right">${count}</div>
          </div>
        </div>
      `;
    };
    
     
    $('#mappricedata').html(pricedata);
    
    }
    
    //endmapappendfilter
    
    // Append the location searchthis area items in the property lists end
    
    
    // filter functoin for sort by section start
    
    function filterBasedOptions(filter_type)
    {
        
    for(let i=0;i< filter_sortBy.length;i++)
    {
        for(let j=0;j <= i ;j ++)
        {
            if( ( parseFloat(filter_sortBy[i].avgprice_exp) < parseFloat(filter_sortBy[j].avgprice_exp) || parseFloat(filter_sortBy[i].avgprice_hcom) < parseFloat(filter_sortBy[j].avgprice_hcom) ) && filter_type == "lowest")
            {
                let temp = filter_sortBy[i]
                filter_sortBy[i] = filter_sortBy[j]
                filter_sortBy[j] = temp
            }
            else if( ( parseFloat(filter_sortBy[i].avgprice_exp) > parseFloat(filter_sortBy[j].avgprice_exp) || parseFloat(filter_sortBy[i].avgprice_hcom) > parseFloat(filter_sortBy[j].avgprice_hcom) ) && filter_type == "highest" )
            {
                let temp = filter_sortBy[i]
                filter_sortBy[i] = filter_sortBy[j]
                filter_sortBy[j] = temp
            }
            else
            {
                if((filter_sortBy[i].rating > filter_sortBy[j].rating && filter_type == "moststars" ))
                {
                let temp = filter_sortBy[i]
                filter_sortBy[i] = filter_sortBy[j]
                filter_sortBy[j] = temp
                }
            }
        }
    
    }
    hoverOnPropertiesList();
    
    return filter_sortBy
    
    }
    
    // filter functiOn for sort by section end
    
    
    $('#sort_byfilter').on('change',function(){
        let filtertype  = this.value
        console.log("current filter  : ",filtertype)
        console.log("filtered result in func call : ",filterBasedOptions(filtertype))
        let filterred_result = filterBasedOptions(filtertype)
        locationSearchItems(filterred_result)
        hoverOnPropertiesList()
        smallImagesHover()   
    })
    
    
    
    //see more
      
      var showCount = 4; 
      var totalCount = $('.accfilter_row').length; 
      
      // Show/hide rows based on the showCount
      $('.accfilter_row').slice(0, showCount).show();
      $('.accfilter_row').slice(showCount).hide();
      
      // If all rows are already visible, hide the "See More" button
      if (showCount >= totalCount) {
        $('.SeeMore').hide();
      }
      
      // Show/hide additional rows when the "See More" button is clicked
      $('.SeeMore').on('click', function() {
        $('.accfilter_row').slice(showCount).toggle();
        $(this).text(function(i, text) {
          return $('#acctype_seemore').text() === "See More" ? "See Less" : "See More"; // Change button text
        });
        $('html, body').animate({
          scrollTop: $('.accfilter_row').offset().top
        }, 500); // Scroll to the top of the table after toggling the additional rows
      });
      
    //see end
    
    
    function hoverOnPropertiesList(){
    
        // smallImgLoadError();
    
        smallImagesHover();
    
    $('#search_resultajax .list-item').hover(
    
        // mouse in
        function () {
    
        // $(this).find('.small-image').css('display','flex')
        
        if(!$(this).hasClass('not_available')){
        // console.log("pin items [] ===> ",pin_items)
    
          if(!hovered_indexarr.includes($(this).attr('id')))
          {      
            hovered_indexarr.push($(this).attr('id'));
          }
          if(hovered_indexarr.length > 1)
          {
            $('.yNHHyP-marker-view').each(function(){
                $(this).removeClass('zindex-prop')
                // console.log('current : ',$(this).removeClass('zindex-prop'))
            })
    
            $('.gm-style-iw-d').hide();
    
            $('.gm-style-iw-tc').hide();
    
            $('#map').find('.highlight_click').removeClass('highlight_click')
    
            $('#search_resultajax').find('.selected_map').removeClass('selected_map')
    
            // console.log("hovered_indexarr before remove : ",hovered_indexarr)
    
            hovered_indexarr.shift()
    
            // console.log("hovered_indexarr after remove : ",hovered_indexarr)
    
            $('#map').find(`#${hovered_indexarr}`).addClass('highlight_click')      
    
            // $('.highlight_click').parent().parent().removeClass('zindex-prop')
            $('.highlight_click').parent().parent().addClass('zindex-prop')
    
                    // $('.yNHHyP-marker-view').each(function(){
            //     console.log("current element : ",$(this).removeClass('zindex-prop'))
            // })
          }
    
        }
        else{
            console.log("hover on not available properties !!!")
        }
    
        }
        ,
        // mouse out
        function () {
          // if(!$(this).hasClass('not_available')){
        //   pin_items[$(this).attr('data-index')].setIcon(normalIcon());
        //   $(this).find('.small-image').css('display','none')
          // }
        }
    
      );
    
    }
    
    setTimeout(() => {
        $('.yNHHyP-marker-view').first().removeClass('zindex-prop')
        $('.yNHHyP-marker-view').first().addClass('zindex-prop')
    }, 1500);
    
    })  
    // staycation_img
    
    
    function smallImgLoadError()
    {
        console.log('hello!!!')
        $('.small-image-preview').on('error',function () {
        console.log(`failed to load the small image ${this.src}`);
        this.src = "https://images.trvl-media.com/hotels/1000000/30000/20500/20427/383efd1a_z.jpg";
    });
    
    }
    
    
    
    
    </script>
    
    