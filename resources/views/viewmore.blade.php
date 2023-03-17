<div class="viewmore-page">
    @include('layouts/header')
    <div class="home-page">  
    <?php 
    //$base_url = 'http://18.135.144.242/Hotelcomparator/public/index.php';
    $base_url = "http://$_SERVER[HTTP_HOST]/Hotelcomparator/public/index.php";
      //print_r($actual_link);
    ?>
        <div class="section-holiday">        
            <div class="section-3">  
                <div class="row m-0">            
                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
                        <div>
                            
                            <ul class="home-list">
                                <li><a href="#">Home</li></a>

                                <li><a href="#"><?php echo !empty($hotel_details->propertyType_name) ? $hotel_details->propertyType_name : 'Hotels'; ?> </li></a>

                                <li><a href="#">  <?php echo !empty($hotel_details->province) ? $hotel_details->province : 'province'; ?> </li></a>
                               
                                <li><a href="#">  <?php echo !empty($hotel_details->country) ? $hotel_details->country : 'country'; ?>  </li></a>
                                
                                <li><a href="#"> <?php echo !empty($hotel_details->propertyName) ? $hotel_details->propertyName : 'propertyName'; ?> 
                                </li></a>
                            </ul>
                            <p class="hotel-name"> <?php echo !empty($hotel_details->propertyName) ? $hotel_details->propertyName : 'propertyName'; ?>  </p>
                            <div class="address-sec">
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                    <img src="{{asset('images/location.svg')}}" style="width: 12px;margin-right: 0.5rem;">
                                    <span class="address-way">
                                    <?php echo !empty($hotel_details->address1) ? $hotel_details->address1."," : 'address1,'; ?> 
                                    <?php echo !empty($hotel_details->address2) ? $hotel_details->address2."," : 'address2,'; ?> 
                                    <?php echo !empty($hotel_details->city) ? $hotel_details->city."," : 'city,'; ?> 
                                    <?php echo !empty($hotel_details->postalCode) ? $hotel_details->postalCode."," : 'postalCode,'; ?> 
                                    <?php echo !empty($hotel_details->province) ? $hotel_details->province."," : 'province,'; ?> 
                                    <?php echo !empty($hotel_details->country) ? $hotel_details->country."," : 'country,'; ?> 
                                    </span>
                                </div>                                
                                <div class="mt-3 mt-sm-0"><img src="{{asset('images/share.svg')}}" style="width: 36px;height: 36px;margin-left: 1rem;"></div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
                        <div class="rating-right">
                            <p class="price-value" id="price-value" >$ <?php echo !empty($hotel_details->referencePrice_value) ? $hotel_details->referencePrice_value : '0'; ?>
                            <input type="hidden" id="hotel_price" value="<?php echo $_GET['price'];?>">
                            <input type="hidden" id="propertyId" value="<?php echo $_GET['expediaId'];?>">
                            <div class="rating-star">
                                <div>
                                    Rating  <?php echo !empty($hotel_details->rating) ? $hotel_details->rating : ''; ?>
                                    <span>
                                        <img src="{{asset('images/Star.svg')}}">
                                        <img src="{{asset('images/Star.svg')}}">
                                        <img src="{{asset('images/Star.svg')}}">
                                        <img src="{{asset('images/Star.svg')}}">
                                    </span>
                                </div>
                            </div>
                            <div class="favorite-sec">
                                <div><img src="{{asset('images/heart.svg')}}"></div>
                                <div>Favortie</div>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>  
          <?php 
           //echo "<pre> primary_image ";print_r($primary_image['img_link']);
           ?>
            <?php
            if(isset($images) && !empty($images))
            {
            // foreach ($images as $key=>$img)
            // {
            //     echo "img : ".$img->title."<br/>";
            //     echo "link : ".$img->link."<br/>";
            // }
            // }
            // echo "Images count : ".count($images);
            // $splice_images = array_slice($images,2);
            $images_part1 = array_slice($images,0,4);
            //    echo "<pre> Images : ";print_r($images); 
            $images_part2 = array_slice($images,4);
            // echo "images_part1 count: ".count($images_part1)."<br/>";
            // echo "images_part2  count: ".count($images_part2)."<br/>";
            // echo "<pre> images: ";print_r($images);die; 
            // echo "<pre> images_part2 : ";print_r($images_part2);die; 
            // echo "type : ".gettype($search->guestRating_expedia);
            // echo "<pre> count : ";print_r($search->guestRating_expedia);die;
            
            // echo "<pre> req: ";print_r($review->reviewCount)
            } 
            ?>
            
            <div class="owl-carousel owl-theme" id="view-carousel">

                <div class="item">
                    <div class="view-inner">
                        <div>
                        
                        @if(!empty($primary_image))
                        <img src="<?php echo $primary_image['img_link'];?>" title="<?php echo $primary_image['img_title'];?>" class="single-img">
                       @endif
                        </div>
                    </div>

                </div> 

                <div class="item">
                            
                <div class="view-inner">

                    <div class="row m-0 carousel-view-img">
                        
                        <?php 
                            if(isset($images_part1) && !empty($images_part1))
                            {
                                foreach ($images_part1 as $key=>$img)
                                { ?>

                                <div class="col-xl-6 col-lg-6 col-md-6 col-6 mb-4">
                                    <img src="{{ $img->link }}" title="{{ $img->title }}">
                                </div>

                                <?php 

                                    }  
                                } 
                                ?>

                        </div>
                            </div>
                            </div>
                        

                            <?php 
                            if(isset($images_part2) && !empty($images_part2))
                            {
                            foreach ($images_part2 as $key=>$img)
                            { ?>
                            <div class="item">
                                <div class="view-inner">
                                    <div><img src="{{ $img->link }}" title="{{ $img->title }}" class="single-img"></div>
                                </div>
                            </div> 
                            <?php } 
                            }
                            ?>
            </div>
    


            <div class="section-4">
                <div class="row m-0">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/computer.svg')}}"></div>
                                <div>
                                    <p class="title-list">Description</p>
                                    <div class="descrption-list">
                                    <?php echo (!empty($hotel_description->areaDescription) && isset($hotel_description->areaDescription))  ? $hotel_description->areaDescription : 'Guests are required to show a photo identification and credit card upon check-in. Please note that all Special Requests are subject to availability and additional charges may apply. Fitness centre is closed from Mon 20 Jul 2020 until Sat 25 Jul 2020 Should you choose to pay cash or with a different credit/debit card than was used for booking, the pre-authorisation may remain against your account up to 7-9 days depending on your card issuer.'; ?> 
                                        <br></br>
                                        <?php echo ( !empty($hotel_description->propertyDescription) && isset($hotel_description->propertyDescription)) ? $hotel_description->propertyDescription : 'Pets are not allowed but guide dogs are accepted. Charges may be applicable. On site car parking is limited to 70 spaces. Please arrive early to avoid disappointment as we do not take pre-booking.'; ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/clock.svg')}}"></div>
                                <div>
                                    <p class="title-list">Check in and check out</p>
                                    <div class="d-block d-md-flex">
                                        <div class="mr-5">
                                            <p class="mb-2 descrption-list">Check in from:</p>
                                            <p>14:00</p>
                                        </div>
                                        <div>
                                            <p class="mb-2 descrption-list">Check out before:</p>
                                            <p>12:00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/bluid.svg')}}"></div>
                                <div>
                                    <p class="title-list">Most Popular Facilities</p>
                                    <div class="d-block d-md-flex popular-sec mt-4">
      <?php //echo "<pre>sdafdsafsa";print_r($hotel_amenities);exit;
                                                 if(isset($hotel_amenities) && !empty($hotel_amenities))
                                                 {
                                                    $facilities = json_decode($hotel_amenities->popularAmenities);
                                                    $other_facilities = json_decode($hotel_amenities->propertyAmenities);
                                                 }
                                                   ?>

                                        <ul>

                                        <?php 
                                            if(isset($facilities) && !empty($facilities)) { 
                                            // dd('asdsd');
                                            foreach($facilities as $popularAmenities) { ?>
                                            <li><img src="{{asset('images/popular/popular-img1.svg')}}"><?php echo $popularAmenities;?>
                                           </li> 
                                         <?php   } ?>
                                         </ul>
                                       <?php }  else { 
                                            ?>
                                        <ul>
                                            <li><img src="{{asset('images/popular/popular-img1.svg')}}">Free WIFI</li>
                                            <li><img src="{{asset('images/popular/popular-img2.svg')}}">Conditioned Air</li>
                                            <li><img src="{{asset('images/popular/popular-img3.svg')}}">Restaurant</li>
                                            <li><img src="{{asset('images/popular/popular-img4.svg')}}">Disabled Access</li>
                                        </ul>
                                        <ul>
                                            <li><img src="{{asset('images/popular/popular-img5.svg')}}">Parking</li>
                                            <li><img src="{{asset('images/popular/popular-img6.svg')}}">Pet Friendly</li>
                                            <li><img src="{{asset('images/popular/popular-img7.svg')}}">Gym Centre</li>
                                            <li><img src="{{asset('images/popular/popular-img8.svg')}}">Sap & Wellness Centre</li>
                                        </ul> 
                                        <?php } ?>

                                         

                                    </div>
                                </div>
                            </div>


                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/bell.svg')}}"></div>
                                <div>
                                    <p class="title-list">Others Facilities</p>
                                    <div class="d-block d-md-flex Facilities-sec mt-4">
                                        <?php //echo "<pre>sdafdsafsa";print_r($other_facilities);exit; ?>
                                       <?php if(isset($other_facilities->FAMILY_FRIENDLY)) { ?>
                                        <ul>
                                            <?php foreach($other_facilities->ACCESSIBILITY as $other_facilities) { ?>
                                            <li><img src="{{asset('images/Facilities.svg')}}">{{ $other_facilities }} </li>
                                            <?php }  ?>
                                        </ul>
                                        <?php } else { ?>
                                         <ul>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Meeting Rooms</li>                                           
                                            <li><img src="{{asset('images/Facilities.svg')}}">Lift</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">concierge Service</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Non-smoking floor</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Tor desk</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Game room</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Multilingual staff</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Beverage Vending Machine</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Completely non-smoking property</li>
                                        </ul>
                                        <ul>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Heating</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Car Rental</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Safe deposit box</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Availability of Family Rooms</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Non -Smoking Rooms</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Room Service</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Cash Machine</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Express check-in</li>
                                            <li><img src="{{asset('images/Facilities.svg')}}">Front desk 24 hour</li>
                                        </ul>
                                       <?php } ?>

                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/bluid.svg')}}"></div>
                                <div>
                                    <p class="title-list">Compare Rooms and Prices</p>
                                    <div class="price-compare">We compare 100s of sites to get you the best deal</div>
                                    <div class="d-flex price-compare-img">
                                        <img src="{{asset('images/price/Prices-img1.svg')}}">
                                        <img src="{{asset('images/price/Prices-img2.svg')}}">
                                        <img src="{{asset('images/price/Prices-img3.svg')}}">
                                        <img src="{{asset('images/price/Prices-img4.svg')}}">
                                        <img src="{{asset('images/price/Prices-img5.svg')}}">
                                        <img src="{{asset('images/price/Prices-img6.svg')}}">
                                        <img src="{{asset('images/price/Prices-img7.svg')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="compare-room mb-4">
                                <div class="section-1">        
                                    <div class="row m-0 justify-content-between">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Where do you want to stay</label>
                                            <input type="text" placeholder="Enter Destination or Hotel Name" class="search-stay">
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Check- In & check Out</label>
                                            <input type="text" class="calender-sec">
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 form-group">
                                            <label>Guests and Rooms</label>
                                            <select class="form-control">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                            </select>
                                        </div>                                                                               
                                    </div>     
                                    <div class="Filter-by">
                                        <div>Filter by</div>
                                        <button>Free cancellation</button>
                                        <button>Breakfast Included</button>
                                        <button class="active">Pay on Arrival</button>
                                    </div>    
                                    <div class="links_section">
                                        <div class="row room-selection">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="room-selection-left">
                                                    <p class="stand-double">Double room</p>
                                                    <div><img src="{{asset('images/exp-img.svg')}}"></div> 
                                                    <p class="refundable">Non Refundable - Meals not included</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="d-block d-md-flex justify-content-md-end room-selection-right">
                                                    <div class="text-center text-md-right">
                                                        <p class="lowest-price">Lowest price</p>
                                                        <p class="compare-value">$795</p>
                                                        <p class="day-night">a Night</p>
                                                        <p class="taxes-fee">Taxes and frees not included</p>
                                                    </div>
                                                    <div class="Go-to-Site">
                                                    <button> <a href="" id="expedia_link" target="_blank">Go to Site</a> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row room-selection">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="room-selection-left">
                                                    <p class="stand-double">Standard Room</p>
                                                    <div><img src="{{asset('images/hotels.svg')}}" style="width:79px;height:24px;"></div> 
                                                    <p class="refundable">Non Refundable</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="d-block d-md-flex justify-content-md-end room-selection-right">
                                                    <div class="text-center text-md-right">
                                                        <p class="lowest-price">Lowest price</p>
                                                        <p class="compare-value">$963</p>
                                                        <p class="day-night">a Night</p>
                                                        <p class="taxes-fee">Taxes and frees not included</p>
                                                    </div>
                                                    <div class="Go-to-Site">
                                                    <button> <a href="" id="hcom_link" target="_blank">Go to Site</a> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                </div>                                 
                            </div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/bluid.svg')}}"></div>
                                <div>
                                    <p class="title-list">Other Recommended Hotels</p>                                    
                                </div>                                
                            </div>
                            <div class="recommended-hotels mb-4">
                                <!-- Nav pills -->
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item">
                                    <a class="nav-link similar-section active" data-toggle="pill" href="#Similar" onclick="otherrecommendedHotels('similar')">Similar Hotels Nearby</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link Recommended-section" data-toggle="pill" href="#Recommended" onclick="otherrecommendedHotels('recommended')">Recommended Hotels</a>
                                    </li>
                                    <li class="nav-item">
                                    <a class="nav-link Popular-section" data-toggle="pill" href="#Popular" onclick="otherrecommendedHotels('popular')">Popular hotels</a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->

                                <div class="tab-content">

                                <img id="loader" style="display:none;height:200px;margin:auto" src="{{asset('images/building_loader.gif')}}">

                                    <div id="Similar" class="container tab-pane p-0 active">
                                        <div>
                                            <div class="owl-carousel owl-theme" id="similar_append">
                                            </div>
                                        </div>

                                        </div>
                                   </div>   
                                           <!-- Tab panes end -->                                     
                            </div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img class="title-image" src="{{asset('images/direction.svg')}}"></div>
                                <div>
                                    <p class="title-list">Explore Other Options</p>                                    
                                </div>                                
                            </div>
                            <div class="explore-section">
                                <div class="owl-carousel owl-theme" id="Explore">
                                    <div class="item">
                                        <div class="explore-land">
                                            <img src="{{asset('images/explor-img1.svg')}}">
                                            <div>
                                                <span>Landmark</span>
                                                <p class="place-eye">The London Eye</p>
                                                <p class="place-price">Prices from € 20</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="explore-land">
                                            <img src="{{asset('images/explor-img1.svg')}}">
                                            <div>
                                                <span>Landmark</span>
                                                <p class="place-eye">King's Cross Station</p>
                                                <p class="place-price">Prices from € 20</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="explore-land">
                                            <img src="{{asset('images/explor-img1.svg')}}">
                                            <div>
                                                <span>Entertainment</span>
                                                <p class="place-eye">Battersea Park Child</p>
                                                <p class="place-price">Prices from € 20</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="explore-land">
                                            <img src="{{asset('images/explor-img4.svg')}}">
                                            <div>
                                                <span>Landmark</span>
                                                <p class="place-eye">Spa at The Landmark</p>
                                                <p class="place-price">Prices from € 20</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item"><h4>5</h4></div>
                                    <div class="item"><h4>6</h4></div>
                                    <div class="item"><h4>7</h4></div>
                                    <div class="item"><h4>8</h4></div>
                                    <div class="item"><h4>9</h4></div>
                                    <div class="item"><h4>10</h4></div>
                                    <div class="item"><h4>11</h4></div>
                                    <div class="item"><h4>12</h4></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div>
                            <div class="mb-4">
                                <div id="map"></div>
                                <script
                                  src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}&callback=initMap&v=beta&libraries=marker"
                                  defer
                                ></script>
                            </div>
                            <div class="mb-4">
                                <p class="title-list">Very Good Locations</p>
                                <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                    <img src="{{asset('images/location.svg')}}" style="width: 12px;margin-right: 0.5rem;">
                                   
                                    <span class="address-way">
                                    <?php echo !empty($hotel_details->address1) ? $hotel_details->address1."," : 'address1,'; ?> 
                                    <?php echo !empty($hotel_details->address2) ? $hotel_details->address2."," : 'address2,'; ?> 
                                    <?php echo !empty($hotel_details->city) ? $hotel_details->city."," : 'city,'; ?> 
                                    <?php echo !empty($hotel_details->postalCode) ? $hotel_details->postalCode."," : 'postalCode,'; ?> 
                                    <?php echo !empty($hotel_details->province) ? $hotel_details->province."," : 'province,'; ?> 
                                    <?php echo !empty($hotel_details->country) ? $hotel_details->country."," : 'country,'; ?> 
                                    </span>

                                </div> 
                            </div>

                           

                            <div class="mb-4">
                                <div class="d-block d-md-flex align-items-center">
                                    <p class="title-list m-0">Hotel Rating</p>
                                    <div class="rat-star">
                                        <p class="m-0 mr-2">4.5</p>
                                        <div class="star-rating">
                                            <img src="{{asset('images/Star.svg')}}">
                                            <img src="{{asset('images/Star.svg')}}">
                                            <img src="{{asset('images/Star.svg')}}">
                                            <img src="{{asset('images/Star.svg')}}">
                                            <img src="{{asset('images/Star.svg')}}">
                                        </div>
                                    </div>
                                </div>                      
                                <div class="address-way">
                                    <?//php exit;?>
                                <?php 
                                if(!empty($hotel_reviews->guestRating_expedia))  
                                {   
                                $review = json_decode($hotel_reviews->guestRating_expedia);  
                                $reviewCount = $review->reviewCount;
                                echo $reviewCount;
          
                                }
                                ?>  
                                 reviews</div>   
                                 
                                <div class="mt-4">  
                                    <div class="progress">
                                        <div class="progress-bar blue" style="width:80%"></div>                                    
                                    </div>     
                                    <div class="progress-value">
                                        <div>Cleanliness</div>
                                        <div>4.5</div>
                                    </div> 
                                </div>   
                                <div class="mt-4">  
                                    <div class="progress">
                                        <div class="progress-bar red" style="width:50%"></div>                                    
                                    </div>     
                                    <div class="progress-value">
                                        <div>Location</div>
                                        <div>4.0</div>
                                    </div> 
                                </div> 
                                <div class="mt-4">  
                                    <div class="progress">
                                        <div class="progress-bar green" style="width:80%"></div>                                    
                                    </div>     
                                    <div class="progress-value">
                                        <div>Service</div>
                                        <div>4.0</div>
                                    </div> 
                                </div> 
                                <div class="mt-4">  
                                    <div class="progress">
                                        <div class="progress-bar yellow" style="width:80%"></div>                                    
                                    </div>     
                                    <div class="progress-value">
                                        <div>Rooms</div>
                                        <div>4.0</div>
                                    </div> 
                                </div>                    
                            </div>
                            <div class="mb-4">
                                <div class="trip">
                                    <img src="{{asset('images/trip.svg')}}">
                                    <div> 1256 reviews</div>
                                </div>
                            </div>
                            
                            <?php
                                if(isset($hotel_reviews->guestReviews)) {
                                $reviews = json_decode($hotel_reviews->guestReviews);
                                $review_count = 0;
                                foreach($reviews as $key=>$guest_reviews)
                                {   
                                    // echo "<pre>";var_dump($guest_reviews->reviewerName);die;
                                    // if(isset($guest_reviews->reviewerName))
                                    // {
                                    //     echo "reviewer name : ".$guest_reviews->reviewerName."<br/>";
                                    // }
                                    ?>
                                <div class="d-flex mb-4">                                
                                <div class="mr-4"><img src="{{asset('images/empty-person.svg')}}"></div>
                                <div>
                                    <div class="mb-4">
                                        <p class="m-0"><?php  echo isset($guest_reviews->reviewerName) ? $guest_reviews->reviewerName."<br/>" : 'Anonymous traveller <br/>'; ?></p>
                                        <div class="d-block d-md-flex">
                                            <div>
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </div>
                                            <div class="year-text">
                                            <?php  echo isset($guest_reviews->creationDate) ? $guest_reviews->creationDate."<br/>" : ' creationDate <br/>'; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="hotel-great">Excellent choice when in London</p>
                                        <p class="room-descrption">
                                        <?php  echo isset($guest_reviews->reviewText) ? $guest_reviews->reviewText."<br/>" : ' reviewText <br/>'; ?> <a href="#">Read More</a> 
                                        </p>
                                        <p class="red-like"><img src="{{asset('images/red-heart.svg')}}"><span>Like</span></p>
                                    </div>
                                </div>
                            </div>
                               <?php
                                if($review_count == 4)
                                {
                                    break;
                                }
                               $review_count++;
                                 }
                              }
                            ?>
                     
                           

<!--                             
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img src="{{asset('images/empty-person.svg')}}"></div>
                                <div>
                                    <div class="mb-4">
                                        <p class="m-0">Anonymous traveller</p>
                                        <div class="d-block d-md-flex">
                                            <div>
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </div>
                                            <div class="year-text">
                                                2 Oct  2022
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="hotel-great">Excellent choice when in London</p>
                                        <p class="room-descrption">
                                        I have had the most wonderful stay at this IHG hotel, conveniently located just a short walk from the North Acton tube station. <a href="#">Read More</a> 
                                        </p>
                                        <p class="red-like"><img src="{{asset('images/red-heart.svg')}}"><span>Like</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img src="{{asset('images/empty-person.svg')}}"></div>
                                <div>
                                    <div class="mb-4">
                                        <p class="m-0">Anonymous traveller</p>
                                        <div class="d-block d-md-flex">
                                            <div>
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </div>
                                            <div class="year-text">
                                                2 Oct  2022
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="hotel-great">Excellent choice when in London</p>
                                        <p class="room-descrption">
                                        I have had the most wonderful stay at this IHG hotel, conveniently located just a short walk from the North Acton tube station. <a href="#">Read More</a> 
                                        </p>
                                        <p class="red-like"><img src="{{asset('images/red-heart.svg')}}"><span>Like</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img src="{{asset('images/empty-person.svg')}}"></div>
                                <div>
                                    <div class="mb-4">
                                        <p class="m-0">Anonymous traveller</p>
                                        <div class="d-block d-md-flex">
                                            <div>
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </div>
                                            <div class="year-text">
                                                2 Oct  2022
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="hotel-great">Excellent choice when in London</p>
                                        <p class="room-descrption">
                                        I have had the most wonderful stay at this IHG hotel, conveniently located just a short walk from the North Acton tube station. <a href="#">Read More</a> 
                                        </p>
                                        <p class="red-like"><img src="{{asset('images/red-heart.svg')}}"><span>Like</span></p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mb-4">                                
                                <div class="mr-4"><img src="{{asset('images/empty-person.svg')}}"></div>
                                <div>
                                    <div class="mb-4">
                                        <p class="m-0">Anonymous traveller</p>
                                        <div class="d-block d-md-flex">
                                            <div>
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                                <img src="{{asset('images/Star.svg')}}">
                                            </div>
                                            <div class="year-text">
                                                2 Oct  2022
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="hotel-great">Excellent choice when in London</p>
                                        <p class="room-descrption">
                                        I have had the most wonderful stay at this IHG hotel, conveniently located just a short walk from the North Acton tube station. <a href="#">Read More</a> 
                                        </p>
                                        <p class="red-like"><img src="{{asset('images/red-heart.svg')}}"><span>Like</span></p>
                                    </div>
                                </div>
                            </div> -->

                            <div class="Show-more-Results">
                                <button>Show more Results</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>             
        <div class="section-inout">
            <div class="section-1">        
                <div class="row m-0 justify-content-between">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Where do you want to stay</label>
                        <input type="text" placeholder="Enter Destination or Hotel Name" class="search-stay">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Check- In & check Out</label>
                        <input type="text" class="calender-sec">
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Guests and Rooms</label>
                        <select class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                        <label>Popular Filters</label>
                        <select class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </div>
                    <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12 form-group text-center text-xl-left Search-Hotels">
                        <label></label>
                        <button type="button" class="btn btn-primary">Search Hotels</button>
                    </div>
                </div>                 
            </div>            
        </div>
    </div>
    @include('layouts/footer')
</div>
<style>
    a#expedia_link,a#hcom_link
    {
        color : #fff !important;
    }
    .blur
    {
        filter: blur(3px);
    }
</style>

<script>

currencyConversion(localStorage.getItem('currency'),'<?php echo $_GET['price']?>')


// var symbol =  (currency_sym == 'EUR') ? ' € ' : (currency_sym == 'INR') ? ' ₹ ' : (currency_sym == 'GBP') ? '£' : (currency_sym == 'USD')  ? ' $ ' : '';

function currencyConversion(curr,price)
{
//    console.log('local storage : ',curr);
   
//    console.log('curr symbol ',symbol)
    $.ajax({
    type:'GET',
    url:"/getExchangedCurrency",
    data:{
        currency : curr,
        price : price
    },
    success:function(data){
        if($.isEmptyObject(data.error)){
            $('#price-value').text(`${localStorage.getItem('symbol')} ${data}`)
            console.log(`converted price : ${localStorage.getItem('symbol')} ${data}`)
            // console.log('price val : ', );
        }else{
            printErrorMsg(data.error);
        }
    }
    });

}

// setTimeout(() => {
    partnerLink()
    otherrecommendedHotels('similar')
// },4000);


function partnerLink()
{
    $('.links_section').addClass('blur')

   var locale = (localStorage.getItem('locale') == 'frFR') ? ' FR ' : (localStorage.getItem('locale') == 'esES') ? ' UK ' : 'US';
   
   $.ajax({
    type:'GET',
    url:"/partnerLink",
    data:{
        locale : locale,
        propertyId : <?php echo $_GET["expediaId"]?>,
        type: "partnerlink"
    },
    success:function(data){
        if($.isEmptyObject(data.error))
        {   
            $('#expedia_link').attr('href',data[0])
            $('#hcom_link').attr('href',data[1])
            console.log('expedia_link url : ',data[0]);
            console.log('hcom link url : ',data[1]);
            $('.links_section').removeClass('blur')
        }
        else{
            printErrorMsg(data.error);
        }
    }
    });

}

var locale = localStorage.getItem('locale') == undefined ? localStorage.setItem('locale','enUS') : '';

function otherrecommendedHotels(type)
{
    
    $('#loader').attr("src","{{asset('images/building_loader.gif')}}");
    console.log('type : ',type);
    $('#Similar').html('');
    $('#loader').show();
    $('#Similar').addClass('blur');

   $.ajax({
    type:'GET',
    url:"/otherrecommendedHotels",
    data:{
        locale : localStorage.getItem("locale"),
        regionId : '<?php echo $_GET['regionid'];?>',
        type : type
    },
    success:function(data){
        if($.isEmptyObject(data.error))
        {   
        if(data.length > 0){  
         let reviewCount_obj = '';
         let similar_hotels = '';
        if(type != 'popular'){
            data.map(function(item){
                reviewCount_obj = JSON.parse(item.guestRating_expedia);

                similar_hotels += '<div class="item"><div class="inner-carousel"> <div class="main-img"> <a href="/hotelDetails?expediaId='+item.propertyId_expedia+'&locale='+localStorage.getItem('locale')+'" target="_blank"> <img src="'+item.heroImage+'" alt="hotel_image" style="height:140px;width:210px;"> </a><img class="star-white" src="{{asset('images/star-white.svg')}}"></div><div class="star-per"><div class="mb-1"><p class="address-text">'+item.propertyName+'</p><div class="loc-left d-block"><div class="d-flex m-0"><img src="{{asset('images/location.svg')}}"><p class="ml-2 mb-0">'+item.ExtendedName+'</p></div></div></div><div class="row"><div class="col-xl-6 col-lg-6 col-md-6 col-6"><div class="rating-review"><button>'+item.rating+'</button><div class="reviews-hotal"><img src="{{asset('images/eye-green.svg')}}"><p>'+reviewCount_obj.reviewCount+' reviews</p></div></div></div><div class="col-xl-6 col-lg-6 col-md-6 col-6"><p class="recommended-hotels-price">$'+item.referencePrice_value+'</p><p class="recommended-hotels-night">a Night</p></div></div></div></div></div>' 
                // console.log('rating count before parse : ',item.guestRating_expedia)  
                // console.log('type : ',typeof(item.guestRating_expedia))
                
                // console.log('rating count after parse : ',par.reviewCount)
                // console.log('type : ',typeof(par))       
     })
     }
     else
     {
        data.map(function(item){

        reviewCount_obj = JSON.parse(item.guestRating_expedia);

     similar_hotels += '<div class="item"><div class="inner-carousel"> <div class="main-img"> <a href="/hotelDetails?expediaId='+item.propertyId_expedia+'&locale='+localStorage.getItem('locale')+'" target="_blank"> <img src="'+item.heroImage+'" alt="hotel_image" style="width:210px;height:140px;"> </a><img class="star-white" src="{{asset('images/star-white.svg')}}"></div><div class="star-per"><div class="mb-1"><p class="address-text">'+item.propertyName+'</p><div class="loc-left d-block"><div class="d-flex m-0"><img src="{{asset('images/location.svg')}}"><p class="ml-2 mb-0">'+item.address1+","+item.city+'</p></div></div></div><div class="row"><div class="col-xl-6 col-lg-6 col-md-6 col-6"><div class="rating-review"><button>'+item.rating+'</button><div class="reviews-hotal"><img src="{{asset('images/eye-green.svg')}}"><p>'+parseInt(reviewCount_obj.avgRating)+' reviews</p></div></div></div><div class="col-xl-6 col-lg-6 col-md-6 col-6"><p class="recommended-hotels-price">$'+item.referencePrice_value+'</p><p class="recommended-hotels-night">a Night</p></div></div></div></div></div>' 

        });

     }


     let lll = "<div class='owl-carousel owl-theme' id='similar_hotels'>"+similar_hotels+"</div>";

     $('#similar_append').html('');
     // console.log('hotels : ',lll)
     $('#Similar').removeClass('blur');
    //  $('#loader').hide();
     $('#loader').hide();
     $('#Similar').append(lll);

     $('#similar_hotels').owlCarousel({
    loop:false,
    margin:10,
    nav:false,
    dots:true,
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
            items:3
        },
        1900:{
          items:5
        }
    }
})
            console.log('data : ',data)
}
else
{
//    alert('empty!!!');
   $('#loader').attr("src","{{asset("images/notfound.gif")}}")
   $('#loader').show();
}
}
        else{
            printErrorMsg(data.error);
        }
    }


    });

}

// cookies section 

let allHotel_ids = [];
let curr_hotel_id = '<?php echo $_GET['expediaId'];?>'
allHotel_ids.push(curr_hotel_id)
localStorage.getItem('hotel_ids') == null ?  localStorage.setItem('hotel_ids',JSON.stringify(allHotel_ids)) : '';
console.log('cache hotels : ',JSON.parse(localStorage.getItem('hotel_ids')))

localAdd();
setCookie(JSON.parse(localStorage.getItem('hotel_ids')), 30)

function localAdd()
{
    let allHotel_ids = JSON.parse(localStorage.getItem('hotel_ids'));
    // console.log('getObj before : ',localStorage.getObj('hotel_ids'))
    if(allHotel_ids.includes(curr_hotel_id))
    {
        console.log("hotel exists already!!!")
    }
    else
    {
    allHotel_ids.push(curr_hotel_id)
    localStorage.setItem('hotel_ids', JSON.stringify(allHotel_ids));
    console.log('get Ids  : ',JSON.parse(localStorage.getItem('hotel_ids')))
    setCookie(JSON.parse(localStorage.getItem('hotel_ids')),30)
    }  

}

//   let curr_hotel_id = ''

console.log("curr_hotel_id : ",curr_hotel_id);

function setCookie(arr, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    let cvalue = '';
    arr.forEach(ele=>{
        // console.log('element : ',ele)
        cvalue += `${ele},`
    })
    // console.log('cvalue : ',cvalue)
    document.cookie = "hotel_ids" + "=" + cvalue + ";" + expires + ";path=/";
    }

// cookies section 

</script>

