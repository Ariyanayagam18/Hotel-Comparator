<?php  
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);

//$locale = "<script>document.write(localStorage.getItem('locale'));</script>";
$url = explode('/', $rootDir);
array_pop($url);
$pathurl = implode('/', $url); 

if(isset($_GET['locale']) && $_GET['locale']=='frFR')
{
  
   require_once "$pathurl/resources/lang/en/fr.php";
  
}
// else if($locale == 'enUS')
// {
//     require_once "$rootDir/Hotelcomparator/resources/lang/en/en.php";
// }
else if(isset($_GET['locale']) && $_GET['locale']=='esES'){

    require_once "$pathurl/resources/lang/en/es.php";
    
}
else
{
   
    require_once "$pathurl/resources/lang/en/en.php";
   
}?>

<div class="home-page" id="homepage">
    <div class="banner-section" id="homepage" >
        <div class="banner-inner">
         <p><?php echo $title; ?></p>
         <mark><?php echo $subtitle ?></mark>
        </div>
    </div>
    <?php 
    //$base_url = 'http://18.135.144.242/Hotelcomparator/public/index.php';
    $base_url = "http://$_SERVER[HTTP_HOST]"; 
    // echo "<pre>";  
    // print_r($_SERVER);
    // echo '<script>let home_true = false </script>';
    // $path = false;
    // if($_SERVER['QUERY_STRING'] == '')
    // {
    //     // echo "home path";
    //     $path = true;
    //     echo '<script>home_true = true </script>';
    // }
    ?>
    <div class="all-section">
        <div class="section-1">        
            <div class="row m-0 justify-content-between">
                <div class="col-xl-5 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label><?php echo $label ?></label>

                    <form method="post" action="{{url('hotelsearch')}}" id="search-holder">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">   

                    <div class="position-relative">

                        <input type="text" placeholder="Enter Destination or Hotel Name"  name="country" class="search-stay search_field" oninput="suggestPlaces(this.value)" id="search_field" autocomplete="off">

                        <img class="clear_input" id="clear_input" style="position:absolute;margin-top: 2%;right: 3%;display:none" src="{{asset('images/clear.svg')}}">

                        <div id="extra_div_name" style="color:red;font-size: 16px;display:none;padding-left: 14px;" >Please enter a destination or hotel</div>
                      
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

                <input type="hidden" placeholder="Enter Destination or Hotel Name" name="regionid" class="region-search-stay region-search_field" id="hidden_search_field" autocomplete="off">    
                
                <input type="hidden" placeholder="Enter Destination or Hotel Name" name="parentregionid" class="region-search-stay region-search_field" id="parentregionid" autocomplete="off">   

                <?php 
                // echo date_default_timezone_get();
                // echo date("d/m/Y");exit;?>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label><?php echo $checkinout ?></label>
                    <input type="text" class="calender-sec" name="datefilter" id="date_picker" value="" readonly/>  
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label>adfadff</label>                   
                    <div class="position-relative">
                        <div class="guestrooms" id="guestrooms">
                            <input class="guest-input" value="1 adult, 1 Room" readonly />                      
                        </div>
                        <div class="members" style="display:none">
                                <div class="list-room">
                                    <div class="list-guest">
                                        <img src="{{asset('images/Maskgroup.svg')}}"> 
                                        <p><?php echo $Adults ?></p>
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
                                        <span><?php echo $Children ?>
                                            <p style="font-size:10px"><?php echo $Below_12_years ?></p>
                                        </span> 
                                    </div>
                                    <div class="handle-counter" id="handleCounter">
                                        <div class="counter-minus btn btn-primary" id="removechilder" onclick="removeFormElements(this)">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </div>
                                        <input type="text" class="Children" value="0" id="childrencount">
                                        <div class="plus btn btn-primary" id="childrenadd">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="module_holder" style="display:none">Age of Children?</div>
                                <div id="container" class="row"></div>
                                <div class="list-room">
                                    <div class="list-guest">
                                        <img src="{{asset('images/roomgroup.svg')}}"> 
                                        <p><?php echo $Rooms; ?> </p>
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
                                        <?php echo $reset ?>
                                   </div>
                                    <div id="guests_ok">
                                        <?php echo $done; ?>
                                   </div>
                                </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label>Ratings</label>
                    <div class="position-relative PopularFilters">
                        <div class="Popular-Filters" id="popular-filter">
                            <input class="pop-input" value="0 Stars" readonly />                      
                        </div>
                        <div class="Pop_Filter" style="display:none">
                            <div class="popular-bor">                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="3 Stars" id="customCheck27">
                                    <label class="custom-control-label" for="customCheck27">
                                        <span class="ml-3 d-flex align-items-center">3 Stars 
                                            <span class="star-multi ml-1 mr-2">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </span>
                                        </span>
                                    </label>
                                </div>                                                                
                            </div> 

                            <div class="popular-bor">                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="4 Stars" id="customCheck28">
                                    <label class="custom-control-label" for="customCheck28">
                                        <span class="ml-3 d-flex align-items-center">4 Stars 
                                            <span class="star-multi ml-1 mr-2">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </span>
                                        </span>
                                    </label>
                                </div>                                                                
                            </div>  

                            <div class="popular-bor">                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="5 Stars" id="customCheck29">
                                    <label class="custom-control-label" for="customCheck29">
                                        <span class="ml-3 d-flex align-items-center">5 Stars 
                                            <span class="star-multi ml-1 mr-2">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </span>
                                        </span>
                                    </label>
                                </div>                                                                
                            </div>  

                            <div class="popular-bor">                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="Free Cancellation" id="customCheck30">
                                    <label class="custom-control-label" for="customCheck30">
                                        <span class="ml-3 d-flex align-items-center">
                                            Free Cancellation                                           
                                        </span>
                                    </label>
                                </div>                                                                
                            </div> 
                        </div>
                    </div>  
                </div> -->
                <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12 form-group text-center text-xl-left Search-Hotels">
                    <label></label>
                    <a class="btn btn-primary" id="search" ><?php echo $Search_Hotels?></a>
                </div>
            </div>                 
        </div>

        <!--  cookie section start -->

        <?php 
        if(isset($hotels_cookies) && count($hotels_cookies) > 0) { ?>

        <?php //echo "<pre>";print_r($hotels_cities_cookies); ?>

        <div class="section-2 sec2a" style="display:block">
            <div class="Plan-Your"><?php echo $Hotels_view ?></div>
                 <div class="row m-0">   

                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Nav pills -->
                    <ul class="nav nav-pills tabs-home" role="tablist">
 
                <li class="nav-item">

                <a class="nav-link active cookie_allcities" data-toggle="pill" href="#allcities" id="cookie_allcities" onclick="">All cities</a>

                </li>
                       <?php 
                       if(isset($hotels_cities_cookies) && count($hotels_cities_cookies) > 0) { 
                        if(count($hotels_cities_cookies) > 8 )
                        {
                            $hotels_cities_cookies =  array_slice($hotels_cities_cookies, 0,8);
                        // echo "count : ".count($hotels_cities_cookies);
                        // echo "<pre>";print_r($hotels_cities_cookies);exit;
                        }
                       foreach($hotels_cities_cookies as $hotels_cities) { ?>
                        @if(!empty($hotels_cities))
                       <li class="nav-item">
                            <a class="nav-link" data-toggle="pill" href="#{{ $hotels_cities }} " onclick="getcitiesCookies('<?php echo $hotels_cities;?>')">{{ $hotels_cities }}</a>
                        </li>
                        @endif
                        <?php }
                        } ?>
                    </ul>

                </div> 
               <input type="hidden" id="search_result" value="1">
                <?php //echo "<pre> allcities : ";print_r($hotels_cookies); ?>

                <div class="col-xl-12 col-lg-12 col-md-12 col-12">

                    <!-- Tab panes -->

                    <div class="tab-content">

                    <img id="loader_cookies" style="display:none;height:200px;margin:auto" src="{{asset('images/building_loader.gif')}}">

                        <div id="allcities" class="tab-pane active">

                            <div class="owl-carousel owl-theme sec2a-carousel" id="cookies_cities">
                            <?php $loop_count=0;?>
                            <?php foreach($hotels_cookies as $allcities) { ?>
                              
                                <div class="item">

                                    <div class="inner-carousel">

                                        <div class="main-img position-relative">
                                            <?php 
                                            // echo "<pre> allcities : ";print_r($allcities);
                                            $img = isset($allcities->heroImage) ? $allcities->heroImage : 'no_img';
                                            // echo "img : ".$img;
                                            // exit;?>
                                            <img src="{{ $img }}" style="height:213px">

                                            <div class="place-star mb-3">   
                                                <div class="star-right">
                                                 <img src="{{asset('images/Star.svg')}}">
                                                </div>
                                                <div class="place-left">{{ $allcities->propertyName }} , {{ $allcities->city }} </div>

                                            </div>

                                        </div>
                                   
                                        <div class="star-per">                                            
                                            <div class="d-flex align-items-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" style="width: 1rem; height: 1rem;"><path d="M13.5 16.963a.806.806 0 01.595-.76 7.5 7.5 0 10-4.19 0 .806.806 0 01.595.76V21a1.5 1.5 0 003 0z"></path></svg>
                                               
                                                <?php 
                                                $location_data = array();
                                                if(isset($allcities->locationAttribute_distanceFromCityCenter)) 
                                                { 
                                                    $location_data = json_decode($allcities->locationAttribute_distanceFromCityCenter);
                                                }
                                                ?>
                                               
                                               <p class="mb-0 ml-2">     
                                                    <span> 
                                                        <?php echo  isset($location_data) && !empty($location_data) ? $location_data->distance  :  '1' ; ?> 
                                                    </span>
                                                    <span> 
                                                        <?php echo  isset($location_data) && !empty($location_data) ? $location_data->unit  :  'km' ; ?>
                                                    </span>
                                                    <span> from city centre</span>
                                                </p>

                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <?php 
                                                //echo "<pre> allcities : ";print_r($allcities);
                                                $rating = isset($allcities->rating) ? $allcities->rating : 'no_rating';
                                                ?>
                                                <span>{{ $rating }}</span>
                                                <div class="d-flex align-items-center">
                                                    <span><img src="https://www.tripadvisor.com/img/cdsi/img2/ratings/traveler/5.0-64600-4.svg"></span>
                                                    <span>
                                                        <span>195</span>
                                                        <span> reviews</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <?php 
                                // if($loop_count < count($hotels_cookies) && $loop_count < 4)
                                //     {
                                //         break;
                                //     }
                                          
                                 } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>

        <!--  cookie section end!!! -->
   


        <div class="section-2">
                    <div class="Plan-Your"><?php echo $Plan_Your ?><span> <?php echo $Next_Staycation ?></span></div>
            <div class="row m-0">   
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Nav pills -->
                    <ul class="nav nav-pills tabs-home" role="tablist" id="staycation_cities">
                    @php
                    $count = 0;
                    //echo "<pre>";print_r($staycation_cities);exit;
                    @endphp
                <?php if(count($staycation_cities) > 0) { ?>     
                @foreach($staycation_cities as $key => $cities)
                     <li class="nav-item " >
                            
                            <a class="nav-link <?php echo $count==0 ? 'active home' : '';?>" value="{{ $cities->province }}"  data-toggle="pill" id="nav-city-<?php echo $count;?>" href="#{{ $cities->province }}" data-neighborhoodId="{{ $cities->locationAttribute_neighborhood_id }}" data-cityId="{{ $cities->locationAttribute_city_id }}" onclick="gethotelsbyRegionId('{{ $cities->locationAttribute_neighborhood_id }}','{{ $cities->locationAttribute_city_id }}')" >  {{ $cities->province }}</a>

                            @php
                            $count++
                            @endphp
                        </li> 
                  @endforeach
                  <?php  } ?>
                    </ul>
                </div> 
                <input type="hidden" name="hotel_default" id="default-hotel" value="<?php echo count($hotels);?>" >
                <input type="hidden" name="img_path" id="img_path" value="">
                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                    <!-- Tab panes -->
                   
                <div class="tab-content">

                    <img id="loader" style="display:none;height:200px;margin:auto" src="{{asset('images/building_loader.gif')}}">

                        <div id="append_hotel" class="tab-pane active">

                          <div class="owl-carousel owl-theme city-1" id="sec2-carousel">
                    
                               <?php if(count($hotels) > 0) { ?>
                              @foreach($hotels as $key=>$value)

                                <div class="item">
                                    <div class="inner-carousel">
                                        <div class="main-img">
                                            <img src="{{$value->heroImage}}" style="height:213px">
                                        </div>
                                        <div class="star-per">
                                            <div class="place-star mb-3">
                                                <div class="place-left">{{$value->propertyName}}</div>
                                                <div class="star-right">
                                                    <img src="{{asset('images/Star.svg')}}">
                                                    <div>{{$value->rating}}</div>
                                                </div>
                                            </div>
                                            <div class="place-per">
                                                <div class="loc-left">
                                                    <img src="{{asset('images/location.svg')}}">
                                                    <div><p class="mb-1">{{$value->city}}</p><p class="m-0">{{$value->country}}</p></div>
                                                </div>
                                                <div class="per-right">
                                                    <div class="currency_symbol"> <span id="currency" class="currency_sym"> $ </span><span class="exchange_price">{{$value->referencePrice_value}}</span></div>
                                                    <p>Per Night</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                <?php } ?>
                                </div>
                                </div>

                          </div>
                    </div>
            </div>
        </div>

        <div class="sec3-inner">
            <div class="section-3">
                <div class="row m-0">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="best-price">
                            <p><?php echo $Get_the_Best_Prices_from_To ?></p>
                            <p><?php echo $Hotel_Provider ?></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="exp-img">
                            <img src="{{asset('images/exp.svg')}}">    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sec4-inner">
            <div class="section-4">
                <div class="row m-0">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="see-inner left-right">
                            <div class="see-img text-center"><img src="{{asset('images/img1.svg')}}"></div>
                            <div><?php echo $See_it_All ?></div>
                            <p><?php echo $See_subtext ?></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="see-inner center">
                            <div class="see-img text-center"><img src="{{asset('images/img2.svg')}}"></div>
                            <div><?php echo $Compare_Right_Here ?></div>
                            <p><?php echo $compare_subtext ?></p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="see-inner left-right">
                            <div class="see-img text-center"><img src="{{asset('images/img3.svg')}}"></div>
                            <div><?php echo $Get_Rxclusive_Rates ?></div>
                            <p><?php echo $get_subtext ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-5">
            <div class="need-inspiration">
                <p><?php echo $Need ?> <span><?php echo $Inspiration ?></span></p>
                <p><?php echo $View ?></p>
            </div>
            <div>
                <div class="owl-carousel owl-theme" id="sec5-carousel">
                    <div class="item">
                        <div class="sec5-inner France-img">
                            <div><?php echo $France ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner America-img">
                            <div><?php echo $Amercia ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner India-img">
                            <div><?php echo $India ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner london-img">
                            <div><?php echo $London ?></div>
                        </div>
                    </div>  
                    <div class="item">
                        <div class="sec5-inner France-img">
                        <div><?php echo $France ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner America-img">
                        <div><?php echo $Amercia ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner India-img">
                        <div><?php echo $India ?></div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner london-img">
                        <div><?php echo $London ?></div>
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</form>
</div>

<!-- mobile search  -->

<input type="hidden" id="resolution_type">
<div id="mobile_searchscreen" class="modal">

        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <input type="text" id="mobile_searchinput" autocomplete="off"  style="border-color: sandybrown;width: 100%;border-radius: 10px;text-align: left;" placeholder="mobile search">
                   <div id="mobile_searchres" class="mobile_searchres"> 
                   <ul id="list_show_mob" class="list_show_mob">
                   </ul>
                   <p id="mob_404"></p>
                </div>
                </div>
            </div>
        </div>
    </div>
<!-- 
    <input type="text" class="mobile_search" placeholder="search" data-bs-toggle="modal" data-bs-target="#mobile_searchscreen" style="border:1px solid red">
 -->

    
<!-- mobile search  -->

<style>

.loader {
  border: 10px solid #f3f3f3; /* Light grey */
  border-top: 10px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 100px;
  height: 100px;
  animation: spin 2s linear infinite;
  margin:auto;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

div.plus img {
    transform: rotate(180deg);
}

.home-page .section-1 .handle-counter div img {
    position: relative;
    top: 7px;
    left: -1px;
}

</style>

<script>

// $(function(){

// alert('ready!!!!');
console.log('ready width : ',mobileSearchScreen(window.innerWidth))

var searchresultstatus = false;

function mobileSearchScreen(width){
if(width > 425)
{
console.log('desktop modal attr removed!!');
// $('#list_show').show();
$('#search_field').removeAttr("data-bs-toggle")
$('#search_field').removeAttr("data-bs-target")
$('#resolution_type').val('desktop')
// $('#mobile_searchscreen').modal('hide');
$('#mobile_searchscreen').hide();
$('.modal-backdrop').hide();
console.log('desktop')
}
else
{
$('.auto_suggest').hide();
$('#search_field').attr("data-bs-toggle","modal")
$('#search_field').attr("data-bs-target","#mobile_searchscreen")
let items = $('#list_show')[0].innerHTML
// console.log('items : ',items);
$('#list_show_mob').append(items);
$('#resolution_type').val('mobile')
// console.log('list : ',$('.auto_suggest'))
console.log('mobile')
}
}

$(window).resize(function(){
     mobileSearchScreen(window.innerWidth)
})

$('#mobile_searchinput').on('input',function(){
    $('#list_show_mob').html('');
    console.log('value : ',$(this).val())
    // $('#search_field').trigger('oninput')
    suggestPlaces($(this).val())
    let items = $('#list_show')[0].innerHTML
    // console.log('items : ',items);
    $('#list_show_mob').append(items);
    $('#list_show').show();

})


document.cookie =  "locale = "+ localStorage.getItem("locale")
console.log('document.cookie : ',document.cookie)



// $('#search_field').click(function(){
//     $('#extra_div_name').hide();
// })
$(document).on('click', 'ul#list_show li', function () {
    searchresultstatus = true;
   
    var regionid = $(this).attr("data-regionid");
    var countryvalue= $(this).attr("value");
    $("#search_result").val(0)
    var parentregionID = $(this).attr("data-parentregionid");  
    $('#hidden_search_field').val(regionid);
    $("#search_field").val(countryvalue); 
    $("#parentregionid").val(parentregionID); 
    // console.log('countryvalue clicked : ',countryvalue)
    $('#clear_input').show();
});

//  click search button 


$('#search').click(function(e){
    
console.log(" res : ",searchresultstatus)
e.preventDefault();
console.log("valid : ",$("#search_result").val())
var name= $('#search_field').val();
console.log('adfdf',name);

// debugger;

if(name == '') {

       $('#myModal2').show();  
    //    location.href = "#";   
        
   }

else
{
if(name !=='' && !searchresultstatus ){


$('#myModal2').show();  
// name_valid = true;
}
else{
location.href =  `/hotelsearch?locale=${localStorage.getItem('locale')}&regionid=${$('#hidden_search_field').val()}&place=${$('#search_field').val()}&parentregionID=${$('#parentregionid').val()}`; 
}

}
  
  
})


// $('#search').click(function(e){

        // if(data.length == 0)
        // {   
        //     $('#list_show').hide();
        //     $('#myModal2').show();
        // }
        // else{
        //     $('#list_show').show();
        //     $('#extra_div_name').hide();
        //     $('#myModal2').hide();
        //     location.href =  `/Hotelcomparator/public/index.php/hotelsearch?locale=${localStorage.getItem('locale')}&regionid=${$('#hidden_search_field').val()}&place=${$('#search_field').val()}&parentregionID=${$('#parentregionid').val()}`; 
        // }

    // });



//  click search button 


var currentRequest = null;    



function suggestPlaces(search_word) {

   // console.log('home_true : ',home_true)
    // if(home_true)
    // {
    // $('#img_path').val('.');
    // }
    // else{
    // $('#img_path').val('..');
    // }
    console.log('search_word : ',search_word)

    if(search_word != '' || search_word.length > 1)
{
    $('#clear_input').show();
currentRequest = jQuery.ajax({
    type:'GET',
    url:"/suggestPlaces",
    data:{
        search_word : search_word,
        locale : localStorage.getItem('locale')
    },
    beforeSend : function()    {           
        if(currentRequest != null) {
            currentRequest.abort();
        }
    },
    success: function(data) {
        console.log('footer');
        if($.isEmptyObject(data.error)){
        
            $('#list_show').html('');
           
        console.log('suggested cities count : ',data.length)
        console.log('suggested data : ',data)
      
        if(data.length == 0){
            $('#search_result').val(0);
            searchresultstatus = false;
        }
        else{
            $("#search_result").val(1)
            searchresultstatus = true;
        }

        let suggest = '';
        // if(home_true)
        // {
            data.map(function(item) {

                var tesVal =  item.Name;
              
                if(item.Name.includes(search_word))
                {
                    var city = tesVal.replace(new RegExp('('+search_word+')','gi'), '<span style="color:#161616">$1</span>');
                }else{
                    var city=item.Name.replace(new RegExp('('+search_word+')','gi'), '<span style="color:#161616">$1</span>');;
                }
                

            suggest += `<li class="suggest_city" value =${item.Name} data-parentregionid=${item.ParentRegionId} data-regionId=${item.RegionID}>
            <div class="align-items-center d-flex"> 
            <div>
            <img src="<?php echo asset('images/${item.Type}.svg');?>" style="width:24px;height:24px;">
            </div>
            <div class="city-place">
            <p class="city">${city}</p>
            <p class="cityplace">${item.ExtendedName}</p>
            </div> 
            </div>
            <div class="city-place"> 
            <p class="cityplace text-nowrap"> (${item.Type})</p>
            </div></li>`

        })
        $('#list_show').append(suggest);
        console.log("res : ",$('#resolution_type').val());
        if($('#resolution_type').val() == 'mobile')
        {
            $('#mob_search_res').html('');
            $('#mob_search_res').append(suggest)
        }
    }
    },
    error:function(e){
        console.log('error !!!',e);
    }

});

}

//     $.ajax({
//   type:'GET',
//   url:"/suggestPlaces",
//   data:{
//     search_word : search_word
// },
//   success:function(data){
//        if($.isEmptyObject(data.error)){
//         $('#list_show').html('');
//         console.log('suggested cities count : ',data.length)
//         let suggest = '';
//             data.map(function(item) {
//             suggest += '<li class="suggest_city" value ='+item.CityName+' data-regionId='+item.RegionID+'><div><img src="{{asset('images/places.svg')}}"></div><div class="city-place"><p class="city">'+item.CityName+'</p><p class="cityplace">'+item.ProvinceName+','+item.CountryName+'</p></div></li>'
//         })
        
//         // $('#list_show').removeClass('loader');
//         $('#list_show').append(suggest);
//        }else{
//            printErrorMsg(data.error);
//        }
//   },
//   beforeSend: function () {
//     if (request !== null) {
//         request.abort();
//     }
//     }
// });
}




$(document).on('click', 'ul#list_show_mob li',function () {
    // alert('mobile clicked !!!');
    // debugger
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



function gethotelsbyRegionId(neighborhood_id,city_id)
{
    // debugger;
    console.log("neighborhood_id : ",neighborhood_id)
    console.log("city_id : ",city_id)

$('#append_hotel').html('');
$('#sec2-carousel').html('');
$('#loader').attr("src","{{asset('images/building_loader.gif')}}")
$('#loader').css('display','block');

localStorage.getItem('locale') == null ||  localStorage.getItem('locale') == undefined ? localStorage.setItem('locale','enUS') : '';

localStorage.getItem('currency') == null ||  localStorage.getItem('currency') == undefined ? localStorage.setItem('currency','USD') : '' ;

localStorage.getItem('symbol') == null ||  localStorage.getItem('symbol') == undefined? localStorage.setItem('symbol','$') : '';
//var locale = (localStorage.getItem('locale') == 'frFR') ? ' FR ' : (localStorage.getItem('locale') == 'esES') ? ' UK ' : 'US';

$.ajax({
  type:'GET',
  url:"<?php echo $base_url;?>/gethotelsbyRegionId",
  data:{
    neighborhood_id : neighborhood_id,
    city_id : city_id,
    locale : localStorage.getItem('locale'),
    currency : localStorage.getItem("currency"),
    symbol : localStorage.getItem('symbol'),
    type : 'getHotels'
},
  success:function(data){

       if($.isEmptyObject(data.error)){
        console.log('searchByRegionId data : ',data)
        let hotels = '';
        data.map(function(item){
            //  console.log('item : ',item)
             hotels += `<div class="item"><div class="inner-carousel"><div class="main-img"><img src='${item.heroImage}' style="height:213px"></div><div class="star-per"><div class="place-star mb-3"><div class="place-left">${item.propertyName}</div><div class="star-right"><img src="{{asset('images/Star.svg')}}"><div>${item.rating}</div></div></div><div class="place-per"><div class="loc-left"><img src="{{asset('images/location.svg')}}"><div><p class="mb-1">${item.city}</p><p class="m-0">${item.country}</p></div></div><div class="per-right"><div class="currency_symbol"> <span class="currency_sym" > ${item.curr_name} </span> <span class="exchange_price">${item.referencePrice_value} ${item.curr_symbol} </span></div><p>Per Night</p></div></div></div></div></div>`
            //  console.log('item.curr_name : ',item.curr_name)
     })
        
        let lll = "<div class='owl-carousel owl-theme city-1' id='sec2-carousel'>"+hotels+"</div>";

        $('#sec2-carousel').remove();

        if(data.length == 0)
        {
            $('#loader').attr("src","{{asset("images/notfound.gif")}}")
            $('#loader').css('display','block')
        }else{
            $('#loader').css('display','none')
            $('#loader').attr("src","{{asset('images/building_loader.gif')}}")
        }
        $('#append_hotel').append(lll)
        // currencySymbol();
        $('#sec2-carousel').owlCarousel({
    margin: 10,
    nav: true,
    navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
    slideBy: 4, 
    dots:false,
    responsive:{
        280:{
            items:1
        },
        500:{
            items:2
        },
        768:{
          items:2
        },
        992:{
          items:3
        },
        1200:{
            items:4
        },
        1900:{
          items:5
        }
    }
})
       }
       else{
           printErrorMsg(data.error);
       }
  }
});

}




// cookies


$('#cookie_allcities').click(function(){
    // alert('all_cities')
    console.log('trigger!!!');
    getcitiesCookies('all_cities')
})

// console.log('cookie cities : ',$('#cookie_allcities').attr('onclick',getcitiesCookies('all_cities')))

function  getcitiesCookies(city_name){
    $('#allcities').html('');
    $('#cookies_cities').html('');
    $('#loader_cookies').attr("src","{{asset('images/building_loader.gif')}}")
    $('#loader_cookies').css('display','block');

    let path = 'M7.925 8.03a1.05 1.05 0 00.793-.591l2.576-5.478a.771.771 0 011.412 0l2.576 5.478a1.048 1.048 0 00.793.59l5.75.87a.835.835 0 01.437 1.407l-4.188 4.274a1.05 1.05 0 00-.287.905l.99 6.05a.795.795 0 01-1.141.869l-5.13-2.83a1.05 1.05 0 00-1.013 0l-5.13 2.83a.795.795 0 01-1.141-.87l.995-6.05a1.05 1.05 0 00-.286-.904l-4.192-4.273A.834.834 0 012.175 8.9z'
    let city={};

    city.city = city_name;

    console.log('all city_name    ====> ',city)

$.ajax({
  type:'GET',
  url:"<?php echo $base_url;?>/getcitiesCookies",
  data:{
    city: city,
},
  success:function(data){
       if($.isEmptyObject(data.error)){
        let rating_count = '';
        let hotels_cookies = [];
        let distance = '';
        let unit = '';

        data.map((item)=>{
         //rating_org = item.rating == null || item.rating == '' ?  : item.rating;
         rating = item.rating ? Math.round(parseFloat(item.rating)) : '';
         let location = item.locationAttribute_distanceFromCityCenter!= null && item.locationAttribute_distanceFromCityCenter!= undefined ? JSON.parse(item.locationAttribute_distanceFromCityCenter) : '' ;
         
         let expedia_rat = item.guestRating_expedia != null && item.guestRating_expedia != undefined ? JSON.parse(item.guestRating_expedia) : '' ;

         let hcom_rat = item.guestRating_hcom != null && item.guestRating_hcom != undefined ? JSON.parse(item.guestRating_hcom) : '' ;
 
         console.log("location : ",location);
             
             if(location)
             {
                 distance = location.distance;
                 unit = location.unit;
             }
             else
             {
                 distance = '1';
                 unit = 'Km';
             }
 
             exp_rating_count = parseFloat(expedia_rat.avgRating)
             exp_reviews_count = parseFloat(expedia_rat.reviewCount)
             hcom_rating_count = parseFloat(hcom_rat.avgRating)
             hcom_reviews_count = parseFloat(hcom_rat.reviewCount)
             
             rating_count = Math.round(exp_rating_count)
             reviews_count = exp_reviews_count
            
 // console.log("location : =======> ",location);
 
         hotels_cookies +=  `<div class="item"><div class="inner-carousel"><div class="main-img position-relative"><a href="<?php echo $base_url;?>/hotelDetails?expediaId=${item.property_ID}&locale=enUS&regionid=${item.region_ID}&price=${item.referencePrice_value}" target="_blank"><img src="${item.heroImage}" style="height:213px"></a><div class="place-star mb-3"> <div class="star-right"><img src="<?php echo asset('images/star_${rating}.png');?>" style="width:auto !important;"></div><div class="place-left"> ${item.propertyName} , ${item.city} </div></div></div><div class="star-per"><div class="d-flex align-items-center mb-2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" style="width: 1rem; height: 1rem;"><path d="M13.5 16.963a.806.806 0 01.595-.76 7.5 7.5 0 10-4.19 0 .806.806 0 01.595.76V21a1.5 1.5 0 003 0z"></path></svg><p class="mb-0 ml-2"><span>${distance} ${unit} </span><span> from city centre</span></p></div><div class="d-flex align-items-center mb-2"><span>${rating_count}</span><div class="d-flex align-items-center"><span style="padding:5px"><img src="<?php echo asset('images/expedia.ico');?>" style="width:20px;height:20px;"></span><span><span></span><span>${reviews_count} reviews</span></span></div></div></div></div></div>`

        })
       

        console.log('data : ',data)

        let lll = "<div class='owl-carousel owl-theme sec2a-carousel' id='cookies_cities'>"+hotels_cookies+"</div>";

        $('#cookies_cities').remove();

        $('#loader_cookies').css('display','none')

$('#allcities').append(lll)
// currencySymbol();
$('#cookies_cities').owlCarousel({
margin: 10,
nav: true,
navText:["<div class='nav-btn prev-slide'></div>","<div class='nav-btn next-slide'></div>"],
slideBy: 4, 
dots:false,
responsive:{
280:{
    items:1
},
500:{
    items:2
},
768:{
  items:2
},
992:{
  items:3
},
1200:{
    items:4
},
1900:{
  items:5
}
}
})


       }
       else{
           printErrorMsg(data.error);
       }
  }

});

}

// cookies

$('.clear_input').click(function(){
  console.log('clear!!!')
  $('#search_field').val('')
  $('#clear_input').hide();
})

</script>



