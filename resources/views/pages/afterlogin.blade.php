<style>
    .home-page .section-1 .handle-counter div img {
    position: relative;
    top: 7px;
    left: -1px;
}
.price_hide
{
    display: none !important;
}

</style>

<?php 
try {
$base_url = "http://$_SERVER[HTTP_HOST]/Hotelcomparator/public/index.php"; ?>
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
                        <input type="hidden" placeholder="Enter Destination or Hotel Name" name="regionid" class="region-search-stay region-search_field" id="hidden_search_field" autocomplete="off">  
                        <input type="hidden" placeholder="Enter Destination or Hotel Name" name="parentregionid" class="region-search-stay region-search_field" id="parentregionid" autocomplete="off">                   

                        @if(isset($regionid))
                       
                        <input type="hidden" value="<?php echo $regionid?>" id="searchid">
                        @endif
                       
                        <div class="auto_suggest">
                     

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
                            <input class="guest-input" value="1 adult, 1 Room" />                      
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
                                        <div class="counter-minus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </div>
                                        <input type="text" class="Children" value="0">
                                        <div class="counter-plus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </div>
                                    </div>
                                </div>
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
                    <!-- <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Popular Filters</label>
                        <div class="position-relative PopularFilters">
                        <div class="Popular-Filters" id="popular-filter">
                            <input class="pop-input" value="0 star"  />                      
                        </div>
                        <div class="Pop_Filter" style="display:none">
                            <div class="popular-bor">                                
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input popular" id="customCheck27">
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
                                    <input type="checkbox" class="custom-control-input popular" id="customCheck28">
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
                                    <input type="checkbox" class="custom-control-input popular" id="customCheck29">
                                    <label class="custom-control-label" for="customCheck28">
                                        <span class="ml-3 d-flex align-items-center">5 Stars 
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
                                    <input type="checkbox" class="custom-control-input popular" id="customCheck30">
                                    <label class="custom-control-label" for="customCheck29">
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
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input property_status" id="available_check" data-id="1" checked>
                                                <label class="custom-control-label property_status" for="available_check"><span class="ml-3">Available properties</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="book-right"> {{ $available_count }}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input property_status" name='property_status' id="not_available_check" data-id="0">
                                                <label class="custom-control-label property_status" for="not_available_check"><span class="ml-3">Not available properties</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="book-right">{{ $not_available_count }}</div>
                                        </div>
                                    </div>                                           
                                </div>
                            </div>
                            

                            <div class="mb-4">
                                <p class="filter-title">Book with peace of mind</p>
                                <div>
                                    <div class="row mb-3">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                                <label class="custom-control-label" for="customCheck1"><span class="ml-3">Free Cancellation</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="book-right">1433</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="customCheck2">
                                                <label class="custom-control-label" for="customCheck2"><span class="ml-3">Pay on Arrival</span></label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="book-right">490</div>
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
                                            
                                           <div>

                                                <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck3" checked>
                                                            <label class="custom-control-label" for="customCheck3"><span class="ml-3">$0 - $400</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">1396</div>
                                                    </div>

                                                </div>

                                                <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck4" checked>
                                                            <label class="custom-control-label" for="customCheck4"><span class="ml-3">$400 - $800</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">430</div>
                                                    </div>

                                                </div> 

                                                <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck5">
                                                            <label class="custom-control-label" for="customCheck5"><span class="ml-3">$800+</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">93</div>
                                                    </div>

                                                </div>  
<!-- 
                                                <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck6">
                                                            <label class="custom-control-label" for="customCheck6"><span class="ml-3">$3,450 - $4,600</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">44</div>
                                                    </div>

                                                </div>   -->
<!-- 
                                                <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck7">
                                                            <label class="custom-control-label" for="customCheck7"><span class="ml-3">$4,600 - $5,750</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">93</div>
                                                    </div>

                                                </div>   -->

                                                <!-- <div class="row mb-3">

                                                    <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="customCheck8">
                                                            <label class="custom-control-label" for="customCheck8"><span class="ml-3">$5,750 +</span></label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                                        <div class="book-right">31</div>
                                                    </div>

                                                </div>     -->

                                            </div>

                                            <div class="filter-input">
                                                <div class="row mb-3">
                                                    <div class="col-xl-9 col-lg-9 col-md-9 col-9">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <input type="text" class="form-control" placeholder="$">
                                                            <span class="ml-2 mr-2">-</span>
                                                            <input type="text" class="form-control" placeholder="$">
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

                                <div>

                                <?php
                                $starloopcount = 1;
                                if(isset($starfilter) && count($starfilter)) 
                                { 
                                    foreach($starfilter as $item=>$star) {

                                        // dd($star);
                                ?>
                                    <div class="row mb-3">
                                        <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input getcheck" name="checkdata" id="customCheck_<?php echo $starloopcount;?>" value="5">
                                                <label class="custom-control-label" for="customCheck_<?php echo $starloopcount;?>" ><span class="ml-3 d-flex align-items-center">{{ $item }}<span class="ml-1 mr-2"> @if($item !='unrated')<img src="{{asset('images/Star.svg')}}"></span>Rating</span> @endif </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
                                            <div class="book-right">{{ $star }} </div>
                                        </div>
                                    </div>   
                                  
                                    <?php  
                                     $starloopcount++;
                                    }          
                                   
                                }
                               
                                ?>  

                                </div>

                            </div>

                            <div class="mb-4">

                                <p class="filter-title">Accommodation Type</p>
                               
                                

                                <div class="acc_type" id="acc_typefilter">
                            

                                    <?php
                                    $loopcount = 1;
                                    $converntional_limit = 0;
                                    //echo  "converntional_limit : ".$converntional_limit;
                                    // dd($accfilter_names);   
                                   // echo ""var_dump($accfilter_names);exit;
                                     foreach($accfilter as $property) { ?> 
    
                                        <?php if(isset($property->propertyType_name) && isset($property->count)) { ?>
                                          
                                            <?php  if($loopcount <= $converntional_limit ) { ?>
    
                                        <div class="row mb-3" id="accfilter_<?php echo $loopcount;?>" data-property_typeId="{{ $property->propertyType_id }}">
    
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
    
                                                    <input type="checkbox" class="custom-control-input" id="custom_<?php echo $loopcount;?>" name="accfilter" data-property_typeId="{{ $property->propertyType_id }}">
                                                  
                                                    <label class="custom-control-label accfiltervalue"  for="custom_<?php echo $loopcount;?>"><span class="ml-3"> {{ $property->propertyType_name }}</span></label>
                                                
                                                </div>
                                            </div>
    
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
    
                                               <div class="wait_filter loader_filter" style="display:none"></div>
                                                <div class="book-right property_count"> {{ $property->count }} </div>
    
                                            </div>
    
                                        </div>
    
                                        <?php } 
                                        else
                                         {
                                        ?>
    
                                        <div class="row mb-3 acc_filter_more" style="display:none" id="accfilter_<?php echo $loopcount;?>" data-property_typeId="{{ $property->propertyType_id }}">
    
                                            <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                                                <div class="custom-control custom-checkbox">
    
                                                    <input type="checkbox" class="custom-control-input" id="custom_<?php echo $loopcount;?>" name="accfilter" data-property_typeId="{{ $property->propertyType_id }}" onclick="accomdationtype()">
                                                
                                                    <label class="custom-control-label accfiltervalue" for="custom_<?php echo $loopcount;?>"><span class="ml-3"> {{ $property->propertyType_name }}</span></label>
                                                
                                                </div>
                                            </div>
    
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-12">
    
                                            <div class="wait_filter loader_filter" style="display:none"></div>
                                                <div class="book-right property_count"> {{ $property->count }} </div>
    
                                            </div>
    
                                            </div>
    
                                            <?php } ?>
    
                                        <?php }?>
    
                                    <?php
                                    $loopcount++;
                                        } ?>

                                </div>

                                
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
                        <div class="hotel-found"> {{ count($datas) }} hotels found in  {{ $_GET['place'] }}</div>
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
                                        <select class="form-control">
                                            <option>Best</option>
                                            <option>Best</option>
                                            <option>Best</option>
                                            <option>Best</option>
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

                        echo "total datas : ".count($datas)."<br/>";

                        echo "not_available_count : ".$not_available_count."<br/>";

                        $not_available = array_slice($datas,count($datas) - $not_available_count);

                        $available_datas = array_slice($datas,0,$available_count);

                        // echo "<pre> available";print_r($datas);
                        // dd($not_available);
                        // dd($not_available);
                        // array_splice($datas,-($not_available_count));
                        //  hide not available

                        $count_overall = 0;
                        $geolocation = [];

                        // dd($datas);

                        foreach($datas as $res_data=>$data) { 

                            // echo "<pre> data ";print_r($data["latitude"]);

                            $property_loc['avgprice_exp'] = isset($data["avgprice_exp"]) ? $data["avgprice_exp"] : 0 ;
                            $property_loc['avgprice_hcom'] = isset($data["avgprice_hcom"]) ? $data["avgprice_hcom"] : 0 ;
                            if($property_loc['avgprice_exp'] != 0 && $property_loc['avgprice_hcom'] != 0){
                            $property_loc['latitude'] = isset($data["latitude"]) ? $data["latitude"] : 0 ;
                            $property_loc['longitude'] = isset($data["longitude"]) ? $data["longitude"] : 0 ;
                            $property_loc['property_name'] = isset($data["property_name"]) ? $data["property_name"] : '' ;
                            $property_loc['img_url'] = isset($data["main_image"]) ? $data["main_image"] : '' ;
                            $property_loc['regionid'] = isset($_GET['regionid']) ? $_GET['regionid'] : '';
                            $rating =  (float)isset($data["rating"]) ? $data["rating"] : 0 ;
                            $property_loc['rating'] = ceil($rating);
                            $property_loc['property_id'] = isset($data['property_id']) ? $data['property_id'] : '';
                            $property_loc['latitude'] = isset($data['latitude']) ? $data['latitude'] : $data['api_latitude'] ;
                            $property_loc['longitude'] = isset($data['longitude']) ? $data['longitude'] : $data['api_longitude'];
                            $geolocation[] = $property_loc;
                            }

                            $not_db_data = false;
                            $api_name = isset($data['api_name']) ? $data['api_name'] : '';
                            $api_city = isset($data['api_city']) ? $data['api_city'] : '';
                            $api_country = isset($data['api_country']) ? $data['api_country'] : '';
                            $api_url =   isset($data['api_image_url']) ? $data['api_image_url'] : '';

                            $api_expedia_link = isset($data['api_expedia_link']) ? $data['api_expedia_link'] : '';
                            // dd($geolocation);
                            // exit;
                        $avg_hcomprice = '';
                        $avg_expediaprice = '';
                        $preview_images = [];
                        if(isset($data['images'])) {
                        $images  =  json_decode($data['images'],true);
                        if(isset($images["ROOMS"]))
                        {
                            $preview_images = array_slice($images["ROOMS"],0,4,true);
                        }
                        }
                        ?>
                        
                        <?php 
                        if($count_overall < $available_count)
                        {
                        ?>
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
                                        <div class="hotel-img"><img src="<?php echo $img_link ?>" class="w-100 hotel_img">
                            
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
                                                <p class="hotel-title"> {{ $data["property_name"] }}</p>
                                                <div class="hotel-loc">
                                                    <img src="{{asset('images/location.svg')}}">
                                                    <div><p class="m-0"> {{ $data["city"] }} , {{ $data["province"] }} , {{ $data["country"] }} </p></div>
                                                </div>
                                                <?php } else {
                                                    $not_db_data = true;
                                                    ?>
                                                    <p class="hotel-title"> {{ $api_name }}</p>
                                                    <div class="hotel-loc">
                                                        <img src="{{asset('images/location.svg')}}">
                                                        <div><p class="m-0"> {{ $api_city }} , {{ $api_country }} </p></div>
                                                    </div>
                                                    <?php 
                                                }?>

                                                <div class="breakfast">
                                                    <img src="{{asset('images/break.svg')}}">
                                                    <div><p class="m-0">Breakfast Included</p></div>
                                                </div>
                                                <div class="Night-price">
                                                <?php
                                                // dd($data);
                                                    if(isset($data["exp_status"]))
                                                    {
                                                    if($data["exp_status"] == 1)
                                                    { 
                                                       echo "$ ".$data["totalprice_exp"];
                                                    }
                                                    else
                                                    {
                                                        echo "No availability on these dates please choose other dates!!";
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
                                                    <img src="<?php echo asset("images/star_$rating_round.png");?>">
                                                </div>

                                                <div class="Rating">Rating </div>
                                            </div>

                                            <div class="bor-bottom">
                                            
                                                <div class="Agoda">
                                                    <a href="#" target="_blank">Expedia</a>
                                                </div>

                                                <?php if(isset($data["exp_status"]))
                                                { 
                                                if($data["exp_status"] == 1) { 
                                                    $avg_expediaprice = isset($data["avgprice_exp"])? $data["avgprice_exp"] : 0 ;
                                                    ?>
                                                <div class="num-price" id="avg_expprice" > 
                                                   {{ $avg_expediaprice }}
                                                </div>
                                                <?php } else { 
            
                                                    ?>
                                                    {{ "No availability on these dates" }}
                                                <?php
                                                }
                                            }?>

                                            </div>

                                            <div class="bor-bottom">

                                                <div class="Agoda">
                                                    <a href="#" target="_blank"> Booking.com </a>

                                                </div>

                                                <?php if(isset($data["hcom_status"]))
                                                { 
                                                if($data["hcom_status"] == 1) { 
                                                    $avg_hcomprice = $data["avgprice_hcom"];
                                                    ?>
                                                <div class="num-price" id="avg_hcomprice" > 
                                                   {{ $avg_hcomprice }}
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
                                                    $ {{ round($final_price) }}
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400">
                                            <div class="exp-view"> 
                                                <?php if($not_db_data)   
                                                {?>                                          
                                                <a href="{{ $api_expedia_link }}" target="_blank">View More</a>
                                                <?php } else { ?>
                                                <a href="/hotelDetails?expediaId={{ $data["property_id"] }}&price={{ $final_price }}&locale=enUS&regionid={{ $_GET["regionid"] }}" target="_blank">View More</a>
                                                <?php }?>
                                             </div>
                                            
                                        </div>

                                    </div>

                                    <?php } ?>

                                </div>

                            </div>

                            <?php } else { ?>

                                <div class="row m-0  hotel-list list-item not_available" data-property_ids="{{ $data['property_id'] }}">

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
                                            <div class="hotel-img"><img src="<?php echo $img_link ?>" class="w-100 hotel_img">
                                
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
                                                    <p class="hotel-title"> {{ $data["property_name"] }}</p>
                                                    <div class="hotel-loc">
                                                        <img src="{{asset('images/location.svg')}}">
                                                        <div><p class="m-0"> {{ $data["city"] }} , {{ $data["province"] }} , {{ $data["country"] }} </p></div>
                                                    </div>
                                                    <?php } else {
                                                        $not_db_data = true;
                                                        ?>
                                                        <p class="hotel-title"> {{ $api_name }}</p>
                                                        <div class="hotel-loc">
                                                            <img src="{{asset('images/location.svg')}}">
                                                            <div><p class="m-0"> {{ $api_city }} , {{ $api_country }} </p></div>
                                                        </div>
                                                        <?php 
                                                    }?>
    
                                                    <div class="breakfast">
                                                        <img src="{{asset('images/break.svg')}}">
                                                        <div><p class="m-0">Breakfast Included</p></div>
                                                    </div>
                                                    <div class="Night-price">
                                                    <?php
                                                    // dd($data);
                                                        if(isset($data["exp_status"]))
                                                        {
                                                        if($data["exp_status"] == 1)
                                                        { 
                                                           echo "$ ".$data["totalprice_exp"];
                                                        }
                                                        else
                                                        {
                                                            echo "No availability on these dates please choose other dates!!";
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
                                                        <img src="<?php echo asset("images/star_$rating_round.png");?>">
                                                    </div>
    
                                                    <div class="Rating">Rating </div>
                                                </div>
    
                                                <div class="bor-bottom">
                                                
                                                    <div class="Agoda">
                                                        <a href="#" target="_blank">Expedia</a>
                                                    </div>
    
                                                    <?php if(isset($data["exp_status"]))
                                                    { 
                                                    if($data["exp_status"] == 1) { 
                                                        $avg_expediaprice = isset($data["avgprice_exp"])? $data["avgprice_exp"] : 0 ;
                                                        ?>
                                                    <div class="num-price" id="avg_expprice" > 
                                                       {{ $avg_expediaprice }}
                                                    </div>
                                                    <?php } else { 
                
                                                        ?>
                                                        {{ "No availability on these dates" }}
                                                    <?php
                                                    }
                                                }?>
    
                                                </div>
    
                                                <div class="bor-bottom">
    
                                                    <div class="Agoda">
                                                        <a href="#" target="_blank"> Booking.com </a>
    
                                                    </div>
    
                                                    <?php if(isset($data["hcom_status"]))
                                                    { 
                                                    if($data["hcom_status"] == 1) { 
                                                        $avg_hcomprice = $data["avgprice_hcom"];
                                                        ?>
                                                    <div class="num-price" id="avg_hcomprice" > 
                                                       {{ $avg_hcomprice }}
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
                                                        $ {{ round($final_price) }}
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400">
                                                <div class="exp-view"> 
                                                    <?php if($not_db_data)   
                                                    {?>                                          
                                                    <a href="{{ $api_expedia_link }}" target="_blank">View More</a>
                                                    <?php } else { ?>
                                                    <a href="/hotelDetails?expediaId={{ $data["property_id"] }}&price={{ $final_price }}&locale=enUS&regionid={{ $_GET["regionid"] }}" target="_blank">View More</a>
                                                    <?php }?>
                                                 </div>
                                                
                                            </div>
    
                                        </div>
    
                                        <?php } ?>
    
                                    </div>
    
                                </div>

                         <?php 
                            }
                        $count_overall++;
                        // echo "count inc : ".$count_overall;
                         }
                    }
                    ?> 

                    </div>

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
</form>
    
    @include('layouts/footer') 
</div>

<?php } catch(Exception $e)
{
    print_r($e);
    echo "error : ".$e->getMessage();
    dd('Frontend Exception Catched!!!');
}
?>
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

html,
body {
  height: 100%;
  margin: 0;
  padding: 0;
}

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

/* custom style start*/

:root {
  --building-color: #FF9800;
  --house-color: #0288D1;
  --shop-color: #7B1FA2;
  --warehouse-color: #558B2F;
}
/*
 * Property styles in unhighlighted state.
 */
 .property {
  align-items: center;
  background-color: #FFFFFF;
  border-radius: 50%;
  color: #263238;
  display: flex;
  font-size: 14px;
  gap: 15px;
  height: 30px;
  justify-content: center;
  padding: 4px;
  position: relative;
  position: relative;
  transition: all 0.3s ease-out;
  width: 30px;
}

.property::after {
  border-left: 9px solid transparent;
  border-right: 9px solid transparent;
  border-top: 9px solid #FFFFFF;
  content: "";
  height: 0;
  left: 50%;
  position: absolute;
  top: 95%;
  transform: translate(-50%, 0);
  transition: all 0.3s ease-out;
  width: 0;
  z-index: 1;
}

.property .icon {
  align-items: center;
  display: flex;
  justify-content: center;
  color: #FFFFFF;
  
}

.property .icon svg {
  height: 20px;
  width: auto;
}

.property .details {
  display: none;
  flex-direction: column;
  flex: 1;
}

.property .address {
  color: #9E9E9E;
  font-size: 10px;
  margin-bottom: 10px;
  margin-top: 5px;
}

.property .features {
  align-items: flex-end;
  display: flex;
  flex-direction: row;
  gap: 10px;
}

.property .features > div {
  align-items: center;
  background: #F5F5F5;
  border-radius: 5px;
  border: 1px solid #ccc;
  display: flex;
  font-size: 10px;
  gap: 5px;
  padding: 5px;
}

/*
 * Property styles in highlighted state.
 */
.property.highlight {
  background-color: #FFFFFF;
  border-radius: 8px;
  box-shadow: 10px 10px 5px rgba(0, 0, 0, 0.2);
  height: 80px;
  padding: 8px 15px;
  width: auto;
}

.property.highlight::after {
  border-top: 9px solid #FFFFFF;
}

.property.highlight .details {
  display: flex;
}

.property.highlight .icon svg {
  width: 50px;
  height: 50px;
  margin-top: 100px;
}

.property.highlight .icon{
  width: 50px;
  height: 50px;
  margin-top: 100px;
}

.property .bed {
  color: #FFA000;
}

.property .bath {
  color: #03A9F4;
}

.property .size {
  color: #388E3C;
}

/*
 * House icon colors.
 */
.property.highlight:has(.fa-house) .icon {
  color: var(--house-color);
}

.property:not(.highlight):has(.fa-house) {
  background-color: var(--house-color);
}

.property:not(.highlight):has(.fa-house)::after {
  border-top: 9px solid var(--house-color);
}

/*
 * Building icon colors.
 */
.property.highlight:has(.fa-building) .icon {
  color: var(--building-color);
}

.property:not(.highlight):has(.fa-building) {
  background-color: var(--building-color);
}

.property:not(.highlight):has(.fa-building)::after {
  border-top: 9px solid var(--building-color);
}

/*
 * Warehouse icon colors.
 */
.property.highlight:has(.fa-warehouse) .icon {
  color: var(--warehouse-color);
}

.property:not(.highlight):has(.fa-warehouse) {
  background-color: var(--warehouse-color);
}

.property:not(.highlight):has(.fa-warehouse)::after {
  border-top: 9px solid var(--warehouse-color);
}

/*
 * Shop icon colors.
 */
.property.highlight:has(.fa-shop) .icon {
  color: var(--shop-color);
}

.property:not(.highlight):has(.fa-shop) {
  background-color: var(--shop-color);
}

.property:not(.highlight):has(.fa-shop)::after {
  border-top: 9px solid var(--shop-color);
}


/* custom style end */


.highlight_click{
    z-index: 5 !important;
    padding: 0.25rem 0.5rem !important;
    border-color: #0062e3 !important;
    background-color: #fff !important;
    color: #0062e3 !important;
    font-size: 1rem !important;
    position : revert !important;
}

</style>

<script>

var searchresultstatus = false;
   
// hoverProperties();

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


function GetSearch()
{

$.ajax({
  type:'GET',
  url:"/hotelsearch",
  
  data:{
    propertyid: $('#searchid').val(),
    locale : localStorage.getItem("locale"),
    currency : localStorage.getItem("currency"),
    ajax : true,
   
},
  success:function(getdata){
    
    console.log('fetchedeeee43434',getdata)
//     if($.isEmptyObject(data.error)){
//         console.log('fetchedeeee',data)
//         let hotels = '';
        
//         data.map(function(item){
//              console.log('itemeeeeeeeeeeeeeeeeeee : ',item)
//              //hotels += `<div class="item"><div class="inner-carousel"><div class="main-img"><img src='${item.heroImage}' style="height:213px"></div><div class="star-per"><div class="place-star mb-3"><div class="place-left">${item.propertyName}</div><div class="star-right"><img src="{{asset('images/Star.svg')}}"><div>${item.rating}</div></div></div><div class="place-per"><div class="loc-left"><img src="{{asset('images/location.svg')}}"><div><p class="mb-1">${item.city}</p><p class="m-0">${item.country}</p></div></div><div class="per-right"><div class="currency_symbol"> <span class="currency_sym" > $ </span> <span class="exchange_price">${item.referencePrice_value}</span></div><p>Per Night</p></div></div></div></div></div>`
//      })
        
//   }
}
});

}
// $('.coins-list').click(function(){
// getHotels($('a.nav-link.active')[0].outerText);
// });

// $('#search').click(function(){
//     location.href =  `/hotelsearch?locale=${localStorage.getItem('locale')}&regionid=${$('#hidden_search_field').val()}&place=${$('#search_field').val()}&parentregionID=${$('#parentregionid').val()}`; 
// })

$('#search').click(function(e){    
    e.preventDefault();   
    var name= $('#search_field').val();  
    if(name == '') {   
           $('#myModal2').show();             
       }
   else
    {
    if(name !=='' && !searchresultstatus ){   
    $('#myModal2').show();  
    }
    else{
    location.href =  `/hotelsearch?locale=${localStorage.getItem('locale')}&regionid=${$('#hidden_search_field').val()}&place=${$('#search_field').val()}&parentregionID=${$('#parentregionid').val()}`; 
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
          
            // console.log("property_ids : ",property_ids);
            // getpropertiesCount(property_ids)

        $('#acctype_seemore').click(function(){
            console.log('toggle text : ',$('#acctype_seemore'))
            $('.acc_filter_more').toggle();
            $('#acctype_seemore').text() == 'See More' ? $('#acctype_seemore').text('See Less') : $('#acctype_seemore').text() == 'See Less' ? $('#acctype_seemore').text('See More') : $('#acctype_seemore').text('See Less');

            // if($('#acctype_seemore').text() == 'See Less' && detect_click < 1)
            // {
            //     detect_click++;
            //     // getpropertiesCount(property_ids);
            // }

        })


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
url:"/gethotelsbyRegionId",
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


$('.accfiltervalue').on('click', function() {

    var array = [];
    $("input:checkbox[name=accfilter]:checked").each(function() {
               console.log('rrrrr',$(this).data('property_typeid'));         
            });
            
});

function accomdationtype()
{
 

$.ajax({
type:'GET',
url:"/hotelsearch",
data:{
 
 locale : localStorage.getItem('locale'),
 currency : localStorage.getItem("currency"),
 symbol : localStorage.getItem('symbol'),
 type : 'getHotels'
},
success:function(data){

    
}
});

}







// get Hotels Ajax 

function getPropertiesSearch(region_ID,offset)
{
console.log("region_ID : ",region_ID)
console.log("offset : ",offset)
    $.ajax({
type:'GET',
url:"/getPropertiesSearch",
data:{
 region_ID : region_ID,
 offset : offset,
 checkIn : '<?php echo $_GET["checkIn"];?>',
 checkOut : '<?php echo $_GET["checkOut"];?>'
},
success:function(data){

    if($.isEmptyObject(data.error)){
    console.log('data result  : ',data);
    // console.log('values : ',)
    let hotels_data = Object.values(data);
    if(Object.values(data).length > 3){
    //  let response = JSON.parse(data)
    let result = '';
    let avg_Expprice = ''
    let avg_Hcomprice = ''
    let final_price = '';
    let total_price = '';
    hotels_data.map(function(item,index){
        // console.log("item : ",item)
        if((item.exp_status == undefined || item.hcom_status == undefined) || (item.exp_status == 0 || item.hcom_status == 0))
        {
            avg_Expprice = 'Not available'
            avg_Hcomprice = 'Not available'
            total_price = 'No availability on these dates please choose other dates!!'                                                
            final_price =  0;
        }
        else
        {
            avg_Expprice = item.avgprice_expedia.Value;
            avg_Hcomprice = item.avgprice_hcom.Value;
            final_price =  Math.round(parseFloat(avg_Expprice))  > Math.round(parseFloat(avg_Hcomprice)) ? Math.round(parseFloat(avg_Expprice)) : Math.round(parseFloat(avg_Hcomprice));
            total_price = item.totalprice_expedia.Value;
        }

    result += `<div class="row m-0  hotel-list list-item"><div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0"><div class="position-relative"><div class="hotel-img"><img src="${item.main_image}" class="w-100 hotel_img"></div>
                <div class="small-image" style="display:none"><div class="small-image-first"><img src="{{asset('images/hotel/hotel-sign-stars-3d.webp')}}" class="small-image-preview"></div><div><img src="{{asset('images/hotel/hotel-bed-room-21064950.jpg')}}" class="small-image-preview" ></div><div><img src="{{asset('images/hotel/home-processing-software-image-04-300x268.jpg')}}" class="small-image-preview" ></div><div class="small-image-last"><div class="imge-vlaue">16+</div></div></div></div></div>
                <div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0"><div class="row m-0 pt-3"><div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400"><div class="hotel-leftside"><p class="hotel-title"> ${item.property_name}</p>
                <div class="hotel-loc"><img src="{{asset('images/location.svg')}}"><div><p class="m-0"> ${item.city},${item.province},${item.country} </p></div></div><div class="breakfast"><img src="{{asset('images/break.svg')}}">
                <div><p class="m-0">Breakfast Included</p></div></div><div class="Night-price"> ${total_price} </div>
                </div></div><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                <div class="bor-bottom"><div><img src="{{asset('images/Star.svg')}}"><img src="{{asset('images/Star.svg')}}"><img src="{{asset('images/Star.svg')}}"><img src="{{asset('images/Star.svg')}}"></div><div class="Rating">Rating </div>
                </div><div class="bor-bottom"><div class="Agoda"><a href="#" target="_blank">Expedia</a></div><div class="num-price" id="avg_expprice" >${avg_Expprice}</div>
                </div><div class="bor-bottom"><div class="Agoda">
                <a href="#" target="_blank"> Booking.com </a>
                </div><div class="num-price" id="avg_hcomprice"> ${avg_Hcomprice} </div></div></div></div><div class="row m-0 pb-3 show_price"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400"><div class="exp-price"><div><img src="{{asset('images/exp-img.svg')}}"></div><div class="value-price"> ${final_price} </div></div> </div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400"><div class="exp-view"><a href="/hotelDetails?expediaId=" target="_blank">View More</a></div></div></div></div></div>`
    })
    $('#search_resultajax').html('');
    $('#search_resultajax').append(result);
    // console.log('result  : ',result)
    }
    else{
        console.log('hotels_data : ',hotels_data)
    }
   }
    else{
        printErrorMsg(data.error);
    }
}
});

}

// map location pin at initial load and drag

let locations = {{ Js::from($geolocation) }};

let client_map_id = {{ Js::from(env('GOOGLE_MAP_ID')) }}

let drag_event = false; 

let pin_items = [];

let data_location = [];

let split_array = [];

let split_array_drag = [];

let hovered_indexarr = []

// pagination scritp start 

    var items = $(".list-wrapper .list-item");

    var numItems = '<?php echo count($datas);?>'

    var perPage = 20;
    
    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "Pre",
        nextText: "Next",
        onPageClick: function (pageNumber) {
            hovered_indexarr = [];
            console.log('clicked page number : ',pageNumber);
            console.log('paginataion 1 ')
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
            if(pageNumber <= split_array.length)
            {
            console.log('current passed array ready result : ',split_array[pageNumber-1])
            pinLocationsinMap(split_array[pageNumber-1])
            hoverProperties()
            }
            window.scrollTo(0, 0);
        }
    });

// pagination scritp end 


console.log('locations : ',locations)

// locations = locations.filter((item,index)function(){

// })


function createCenterControl(map) {

  const controlButton = document.createElement("button");

  // Set CSS for the control.
  controlButton.style.backgroundColor = "#fff";
  controlButton.style.border = "2px solid #fff";
  controlButton.style.borderRadius = "3px";
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

function splitLocationsPin(all_items)
{
  console.log("all_items.length : ",all_items.length)  

  let total_pages = all_items.length/20;
  
  total_pages = !Number.isInteger(total_pages) ? parseInt(total_pages+1) : total_pages ;

  console.log("total_pages : ",total_pages)  

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

function mapsAPIaction(lat,long)
{

$.ajax({
type:'GET',
url:"/mapsAPIaction",
data:{ 
    latitude : lat,
    longitude : long,
    locale : 'enUS',
    checkIn : "<?php echo $_GET['checkIn'];?>",
    checkOut : "<?php echo $_GET['checkOut'];?>"
},
success:function(data){

    pin_items = [];

    hovered_indexarr = [];

    if($.isEmptyObject(data.error)){

        // debugger;

        console.log('data success : ',data)

        if(data.location_pin.length > 0){

        $('#search_resultajax').html('')
         
        data_location = data.location_pin

        
         
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

        console.log('data_location drag location : ',data_location)

    let  list_items = Object.values(data.list_items);
    
    console.log("list_items : ",list_items);

    // filter for only valid items 
    
    let valid_items = list_items.filter((item) => Object.keys(item).length == 13)

    console.log("valid_items in database : ",list_items);

    locationSearchItems(list_items)

    // hoverProperties()

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


// function initMap() {

//   const center = {
//     lat: 11.970913,
//     lng: 79.806696,
//   };

//   const map = new google.maps.Map(document.getElementById("map"), {
//     zoom: 11,
//     center,
//     mapId: "4504f8b37365c3d0",
//   });

//  const custom_pricetags = [];

// //   for (const property of properties) {

//     locations1.map(function(item,index){

//     custom_pricetags[index] = document.createElement("div");

//     custom_pricetags[index].className = "price-tag";

//     custom_pricetags[index].id = item.property_id;

//     custom_pricetags[index].textContent = `$${Math.round(item.avgprice_exp)}`;

//     const advancedMarkerView = new google.maps.marker.AdvancedMarkerView({
//       map,
//       position: new google.maps.LatLng(item.latitude,item.longitude),
//       content: custom_pricetags[index]
//     });
    
//     const element = advancedMarkerView.element;

//     ["focus", "pointerenter"].forEach((event) => {
//       element.addEventListener(event, () => {
//         highlight(advancedMarkerView, item );
//       })
//       });    
      
//     ["blur", "pointerleave"].forEach((event) => {

//       element.addEventListener(event, () => {
//         hoverOnMapPropertyCard();
//         // alert("mouse leaved from pin!!!")
//       });

//     });

//     advancedMarkerView.addListener("click", (event) => {

//         alert("you have clicked the price marker!!!")

//     }); 
  
  
// })

// }

// }



function pinLocationsinMap(locations)
{

console.log('pin locations length : ',locations)

var custom_pricetags = []

var centerMap = { lat: parseFloat(locations[0].latitude), lng: parseFloat(locations[0].longitude) };

var map = new google.maps.Map(document.getElementById("map"), {
  zoom: 12,
  center: centerMap,
  mapId: client_map_id
});

locations.map(function(item,index){

    custom_pricetags[index] = document.createElement("div");

    custom_pricetags[index].className = "price-tag";

    custom_pricetags[index].id = item.property_id;

    custom_pricetags[index].textContent = `$${Math.round(item.avgprice_exp)}`;

    var markerView = new google.maps.marker.AdvancedMarkerView({
    map,
    position: new google.maps.LatLng(item.latitude,item.longitude),
    content: custom_pricetags[index]
    });

    const infowindow = new google.maps.InfoWindow();

    const element  = markerView.element

    //   ["focus", "pointerenter"].forEach((event) => {
      element.addEventListener("pointerenter", () => {
        $('.gm-style-iw-tc').css('display','none')
        //   $('.gm-style-iw-tc').hide()
        highlight(markerView, item );
      })
    //   });    
    

        // ["blur", "pointerleave"].forEach((event) => {

        element.addEventListener("pointerleave", () => {

            console.log("current element id :",$(element).find('.price-tag')[0].id)

            // $('.gm-style-iw-tc').hide();

            hoverOnMapPropertyCard($(element).find('.price-tag')[0].id);

            $(`.card_${$(element).find('.price-tag')[0].id}`).fadeOut()

            // $('.gm-style-iw-tc').css('display','none !important')
            $('.gm-style-iw-tc').css('display','none')
            
            // $('.gm-style-iw-tc').fadeOut(100);
        });

        // });

        markerView.addListener("click", (event) => {

        alert("you have clicked the price marker!!!")

        }); 

    // });
//   }


    // ["focus", "pointerenter"].forEach((event) => {
    

    //   element.addEventListener("pointerenter", () => {

    //     console.log("hover element  : ",$(element))

    //     console.log("hover element position in Top : ",$(element)[0].style.transform)

    //     // highlight(markerView, property);
    //             infowindow.setContent(`<div class="map-location">
    //     <a target="_blank" href="/hotelDetails?expediaId=${item.property_id}&price=${Math.round(item.price)}&locale=${$('#active_locale').val()}&regionid=${item.regionid}" ><img src="${item.img_url}" class="map-main-img"></a>
    //     <div class="map-inner">
    //         <p class="hotel-title mb-3">${item.property_name}</p>     
    //         <div class="mb-3">
    //             <img src="<?php echo asset('images/star_${parseInt(item.rating)}.png');?>" style="width:50px">
    //         </div> 
    //         <div class="Night-price text-right">
    //             <span class="total_tax_price">$${ (item.avgprice_exp && item.avgprice_exp != undefined) ? Math.round(item.avgprice_exp) : Math.round(item.price) }</span> 
    //             a night                                                   
    //         </div>
    //     </div>
    //     </div>`);

    //     infowindow.open(map, markerView);
        
    //         // })(markerView, item));

    //   });

    // });

    // markerView.addListener("click", (event) => {

    // $('#map').find('.highlight_click').removeClass('highlight_click')

    // $('#search_resultajax').find('.selected_map').removeClass('selected_map')

    // $(element).find('.price-tag').addClass('highlight_click')

    // $(`#${item.property_id}`).addClass('selected_map')
  
    //  console.log("items : ",$(`#${item.property_id}`))

    //  window,scrollTo(0,$(`#${item.property_id}`)[0].offsetTop)


    // });

    // hide end 

    // pin_items.push(markerView)


    
    // google.maps.event.addListener(markerView, 'click', (function(markerView, item) {

    // return function() {
    //     infowindow.setContent(`<div class="map-location">
    //     <a target="_blank" href="/hotelDetails?expediaId=${item.property_id}&price=${Math.round(item.price)}&locale=${$('#active_locale').val()}&regionid=${item.regionid}" ><img src="${item.img_url}" class="map-main-img"></a>
    //     <div class="map-inner">
    //         <p class="hotel-title mb-3">${item.property_name}</p>     
    //         <div class="mb-3">
    //             <img src="<?php echo asset('images/star_${parseInt(item.rating)}.png');?>" style="width:50px">
    //         </div> 
    //         <div class="Night-price text-right">
    //             <span class="total_tax_price">$${Math.round(item.avgprice_exp)}</span> 
    //             a night                                                   
    //         </div>
    //     </div>
    //     </div>`);
    //     infowindow.open(map, markerView);

    //     const element = markerView.element;

    // $('#map').find('.highlight_click').removeClass('highlight_click')

    // $('#search_resultajax').find('.selected_map').removeClass('selected_map')

    // $(element).find('.price-tag').addClass('highlight_click')

    // $(`#${item.property_id}`).addClass('selected_map')

    // console.log("items : ",$(`#${item.property_id}`))

    // window,scrollTo(0,$(`#${item.property_id}`)[0].offsetTop)

    // }
    

    // })(markerView, item));

    // google.maps.event.addListener(markerView, 'mouseout', (function(markerView, item) {
    //     const element = markerView.element;
    //     console.log('mouseout event!!!')
    //         return function() {
    //             // setTimeout(() => {
    //                 element.hide();
    //                 // $('.gm-style-iw-tc').hide();
    //             // }, 2000);
    //         }
    //     })(markerView, item));

    // infowindow.open(map, markerView);

// }

})

const centerControlDiv = document.createElement("div");
// Create the control.
const centerControl = createCenterControl(map);

// Append the control to the DIV.
centerControlDiv.appendChild(centerControl);

map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

// hoverAfter();

}

function highlight(markerView,currentProperty) {

const infowindow = new google.maps.InfoWindow();

infowindow.setContent(`<div class="map-location card_${currentProperty.property_id}" data-cardid=${currentProperty.property_id}>
    <a target="_blank" href="/hotelDetails?expediaId=${currentProperty.property_id}&price=${Math.round(currentProperty.price)}&locale=${$('#active_locale').val()}&regionid=${currentProperty.regionid}" ><img src="${currentProperty.img_url}" class="map-main-img"></a>
    <div class="map-inner">
        <p class="hotel-title mb-3">${currentProperty.property_name}</p>     
        <div class="mb-3">
            <img src="<?php echo asset('images/star_${parseInt(currentProperty.rating)}.png');?>" style="width:50px">
        </div> 
        <div class="Night-price text-right">
            <span class="total_tax_price">$${Math.round(currentProperty.avgprice_exp)}</span> 
            a night                                                   
        </div>
    </div>
    </div>`);

        infowindow.open(map, markerView);
}

// function hoverAfter()
// {
   
// }

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

// bind location drag items 

function locationSearchItems(list_items)
{
    
    var map_resultitems =  list_items;
    
    if(list_items.length > 0)
    {
    console.log("list_items  =====> ",list_items);
    
    console.log('current location city : ',list_items[0].city)

    let items_map = '';

    let images_hover = '';

    list_items.map(function(item,index){

        if(item.images && item.images != undefined)
        {
            let imgappend_start = `<div class="small-image" style="display: none;">`

            let imgappend_end = `</div>`

            let decoded_images = JSON.parse(item.images)

            let img_list = ''

            if(decoded_images.ROOMS && decoded_images.ROOMS != undefined)
            {
                // debugger

                let sliced_arr = decoded_images.ROOMS.length > 4 ? decoded_images.ROOMS.slice(0,4) : decoded_images.ROOMS;

                console.log("decoded sliced_arr images ======> ",sliced_arr)

                sliced_arr.map(function(item,index){
                    
                    img_list += `<div class="small-image-first">
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
        


        items_map += `<div class="row m-0  hotel-list list-item" data-index="${index}"><div class="col-xl-5 col-lg-4 col-md-4 col-sm-4 col-12 p-0"><div class="position-relative"><div class="hotel-img"><img src="${item.main_image}" class="w-100 hotel_img"></div>
        ${ (images_hover && images_hover != '') ? images_hover : '' }
        </div></div><div class="col-xl-7 col-lg-8 col-md-8 col-sm-8 col-12 p-0"><div class="row m-0 pt-3"><div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7 w-sm-400"><div class="hotel-leftside"><p class="hotel-title"> ${item.property_name}</p>
                <div class="hotel-loc"><img src="{{asset('images/location.svg')}}"><div><p class="m-0"> ${item.address1},${item.city},${item.country} </p></div></div><div class="breakfast"><img src="{{asset('images/break.svg')}}">
                <div><p class="m-0">Breakfast Included</p></div></div><div class="Night-price"> <span class="total_tax_price">$ ${item.totalprice_exp} </span> total includes taxes & fees  </div>
                </div></div><div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5 w-sm-400">
                <div class="bor-bottom"><div><img src="<?php echo asset('images/star_${Math.round(item.rating)}.png');?>"></div><div class="Rating"> Rating</div>
                </div><div class="bor-bottom"><div class="Agoda"><a href="#" target="_blank">Expedia</a></div><div class="num-price" id="avg_expprice" >${item.avgprice_exp}</div>
                </div><div class="bor-bottom"><div class="Agoda">
                <a href="#" target="_blank"> Booking.com </a>
                </div><div class="num-price" id="avg_hcomprice_${index}"> ${ (item.avgprice_exp && item.avgprice_exp != undefined) ? Math.round(item.avgprice_exp) : Math.round(item.price) } </div></div></div></div><div class="row m-0 pb-3 price_hide"><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pr-0 w-sm-400"><div class="exp-price"><div><img src="{{asset('images/exp-img.svg')}}"></div><div class="value-price"> ${item.avgprice_exp} </div></div> </div><div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 pl-0 w-sm-400"><div class="exp-view"><a href="/hotelDetails?expediaId=" target="_blank">View More</a></div></div></div></div></div>`
    })
   
    $('#search_resultajax').append(items_map);



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
        console.log('paginataion 2 ')
        var showFrom = perPage * (pageNumber - 1);
        var showTo = showFrom + perPage;
        items.hide().slice(showFrom, showTo).show();
        pinLocationsinMap(split_array_drag[pageNumber-1])
        hoverProperties()
    }
});
    }
    else
    {
        alert('No Hotels found in the radius!!')
    }

$('#countname').text(items.length)

}

// bind location drag items 

//  map location pin at initial load and drag

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
  

// hover after drag event in map 

function hoverProperties(){

$('#search_resultajax .list-item').hover(
    
    // mouse in
    function () {

      if(!hovered_indexarr.includes($(this).data('index')))
      {      
        hovered_indexarr.push($(this).data('index'));
      }
      
      if(hovered_indexarr.length > 1)
      {
        console.log("hovered_indexarr before remove : ",hovered_indexarr)
        pin_items[hovered_indexarr[0]].setIcon(normalIcon());
        hovered_indexarr.shift()

      }

      pin_items[$(this).attr('data-index')].setIcon(highlightedIcon());

      console.log("hovered_indexarr array ===> ",hovered_indexarr)

      console.log("current hover index  ===> ",$(this).data('index'))

    }


  );
  
  function normalIcon() {
    return {
      url   : "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
    };
  }
  function highlightedIcon() {
    return {
      url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'
    };
  }

}

// hover after drag event in map 


let overall_data = {{ Js::from($datas) }};

let available_data =  {{ Js::from($available_datas) }};

let not_availabledata = {{ Js::from($not_available) }};

console.log("overall_data : ",overall_data)

console.log("available_data : ",available_data)

console.log("not_availabledata : ",not_availabledata)

$('.property_status').on('click', function() {

            if($(this)[0].id == 'not_available_check' && $(this)[0].checked)
            {
                console.log('not available checked!!!')
                $('.not_available').show();
                $('.available').hide();
                //appendItems(not_availabledata)
            }
          else if($(this)[0].id == 'available_check' && $(this)[0].checked)
            {
            console.log('available checked!!!')
            //appendItems(available_data)
            }
           else
           {
            console.log('both checked/unchecked!!',overall_data)
            //appendItems(overall_data)
           }
        
        
});



function paginationSection(total_items)
{

items.slice(perPage).hide();

$('#pagination-container').pagination({
    items: total_items,
    itemsOnPage: 20,
    prevText: "Pre",
    nextText: "Next",
    onPageClick: function (pageNumber) {
        var showFrom = perPage * (pageNumber - 1);
        var showTo = showFrom + perPage;
        items.hide().slice(showFrom, showTo).show();
    }
});

}

let obj = [
    {
    "avgprice_exp": "115.00",
    "avgprice_hcom": "115.00",
    "latitude": "46.809856",
    "longitude": "-92.164855",
    "property_name": "La Quinta Inn & Suites by Wyndham Duluth",
    "img_url": "https://images.trvl-media.com/hotels/12000000/11290000/11288300/11288233/90310129_z.jpg",
    "regionid": "1029",
    "rating": 3,
    "property_id": "11288233"
}
]
function customEvents(){

$('.price-tag').mouseenter(function (){ 
            console.log("this : ",$(this))
       const infowindow = new google.maps.InfoWindow();
        infowindow.setContent(`<div class="map-location">
    <a target="_blank" href="/hotelDetails?expediaId=${obj[0].property_id}&price=${Math.round(obj[0].price)}&locale=${$('#active_locale').val()}&regionid=${obj[0].regionid}" ><img src="${obj[0].img_url}" class="map-main-img"></a>
    <div class="map-inner">
        <p class="hotel-title mb-3">${obj[0].property_name}</p>     
        <div class="mb-3">
            <img src="<?php echo asset('images/star_${parseInt(obj[0].rating)}.png');?>" style="width:50px">
        </div> 
        <div class="Night-price text-right">
            <span class="total_tax_price">$${Math.round(obj[0].avgprice_exp)}</span> 
            a night                                                   
        </div>
    </div>
    </div>`);

    infowindow.open(map, markerView);
})
}




</script>




