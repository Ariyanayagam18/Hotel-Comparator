@include('layouts.header')
<div class="home-page" id="homepage">
    <div class="banner-section" id="homepage" >
        <div class="banner-inner">
            <p>Book with Us and</p> 
            <mark>Enjoy your Journey</mark>
        </div>
    </div>
 
    <div class="all-section">
        <div class="section-1">        
            <div class="row m-0 justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label>Where do you want to stay </label>
                     
                    <div class="position-relative">
                        <input type="text" placeholder="Enter Destination or Hotel Name" class="search-stay search_field" onkeyup="filter()" autocomplete="off" id="search_field">      

                        <?php 
                        $svg_image = 'M19 6h-4a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v15a1 1 0 0 0 2 0V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2 2.15 2.15 0 0 0-2 2v13a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V8a2.15 2.15 0 0 0-2-2zm-5 11a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm4 6a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zM9 7a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 3a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 6a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0-3a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 6a1 1 0 1 1-1-1 1 1 0 0 1 1 1z';
                        ?>      

                        <div class="auto_suggest">

                            <ul id="list_show">
                            <?php if(count($suggestCities) > 0) { ?>
                            @foreach ($suggestCities as $key=>$suggest_cities)       
                            <li class="suggest_city" data-regionId={{ $suggest_cities->RegionID }}><div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="PopularDestination_PopularDestination__icon__Y2IyM BpkIcon_bpk-icon--rtl-support__NjAzZ" style="width: 1.5rem; height: 1.5rem;"><path d="<?php echo $svg_image;?>"></path></svg></div><div class="city-place"><p class="city">{{
                                $suggest_cities->CityName }}</p><p class="cityplace">{{ $suggest_cities->ProvinceName  }} , {{ $suggest_cities->CountryName }}</p></div></li>
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
                            <input class="guest-input" value="1 adult, 1 Room" readonly />                      
                        </div>
                        <div class="members" style="display:none">
                                <div class="list-room">
                                    <div class="list-guest">
                                        <img src="{{asset('images/Maskgroup.svg')}}"> 
                                        <p>Adults</p>
                                    </div>
                                    <div class="handle-counter" id="handleCounter">
                                        <button class="counter-minus btn btn-primary">
                                            <img src="{{asset('images/white-arrow.svg')}}">   
                                        </button>
                                        <input type="text" class="adults" value="0">
                                        <button class="counter-plus btn btn-primary">
                                            <img src="{{asset('images/white-arrow.svg')}}">   
                                        </button>
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
                                        <button class="counter-minus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </button>
                                        <input type="text" class="adults" value="0">
                                        <button class="counter-plus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </button>
                                    </div>
                                </div>
                                <div class="list-room">
                                    <div class="list-guest">
                                        <img src="{{asset('images/roomgroup.svg')}}"> 
                                        <p>Rooms </p>
                                    </div>
                                    <div class="handle-counter" id="handleCounter">
                                        <button class="counter-minus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </button>
                                        <input type="text" class="adults" value="0">
                                        <button class="counter-plus btn btn-primary">
                                               <img src="{{asset('images/white-arrow.svg')}}">
                                        </button>
                                    </div>
                                </div>      
                                <hr>                         
                                <div class="reset-ok">
                                    <button id="reset">
                                        Reset
                                    </button>
                                    <button id="guests_ok">
                                        Done
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-12 form-group">
                    <label>Ratings</label>
                    <div class="position-relative PopularFilters">
                        <div class="Popular-Filters" id="popular-filter">
                            <input class="pop-input" value="4 Stars" readonly />                      
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
                </div>
                <div class="col-xl-2 col-lg-12 col-md-12 col-sm-12 col-12 form-group text-center text-xl-left Search-Hotels">
                    <label></label>
                    <button type="button" class="btn btn-primary" >Search Hotels</button>
                </div>
            </div>                 
        </div>
        <div class="section-2">
                    <div class="Plan-Your">Plan Your <span>Next Staycation</span></div>
            <div class="row m-0">   
                <div class="col-xl-2 col-lg-4 col-md-4 col-12">
                    <!-- Nav pills -->
                    
                    <ul class="nav nav-pills tabs-home" role="tablist" id="staycation_cities">
                    @php
                    $count = 0;
                    @endphp
                <?php if(count($staycation_cities) > 0) { ?>     
                @foreach($staycation_cities as $key => $value)
                     <li class="nav-item " >
                            <a class="nav-link <?php echo $count==0 ? 'active' : '';?>" data-toggle="pill" href="#{{$value->ProvinceName}}" onclick="getHotels('{{$value->ProvinceName}}')">  {{ $value->ProvinceName }}</a>
                            @php
                            $count++
                            @endphp
                        </li> 
                  @endforeach
                  <?php  } ?>
                    </ul>
                </div> 
                

                <div class="col-xl-10 col-lg-8 col-md-8 col-12">
                    <!-- Tab panes -->

                <div class="tab-content">

                    <div id="loader" class="">

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
                                                    <div>${{$value->referencePrice_value}}</div>
                                                    <p>Per Night</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                                <?php } 
                                 else
                                 {
                                        echo "No Hotels Found!!!";
                                 }
                                ?>
                                </div>
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
                            <p>Get the Best Prices from To</p>
                            <p>Hotel Provider</p>
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
                            <div>See it All</div>
                            <p>From local hotels to global brands, discover millions of rooms all around the world.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="see-inner center">
                            <div class="see-img text-center"><img src="{{asset('images/img2.svg')}}"></div>
                            <div>Compare Right Here</div>
                            <p>No need to search anywhere else. The biggest names in travel are right here.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <div class="see-inner left-right">
                            <div class="see-img text-center"><img src="{{asset('images/img3.svg')}}"></div>
                            <div>Get Rxclusive Rates</div>
                            <p>We’ve special deals with the world's leading hotels – and we share these savings with you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-5">
            <div class="need-inspiration">
                <p>Need <span>Inspiration</span></p>
                <p>View our hand-picked hotel destinations</p>
            </div>
            <div>
                <div class="owl-carousel owl-theme" id="sec5-carousel">
                    <div class="item">
                        <div class="sec5-inner France-img">
                            <div>France</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner America-img">
                            <div>America</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner India-img">
                            <div>India</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner london-img">
                            <div>London</div>
                        </div>
                    </div>  
                    <div class="item">
                        <div class="sec5-inner France-img">
                            <div>France</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner America-img">
                            <div>America</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner India-img">
                            <div>India</div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="sec5-inner london-img">
                            <div>London</div>
                        </div>
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</div>

<style>

.loader {
  border: 10px solid #f3f3f3; /* Light grey */
  border-top: 10px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 100px;
  height: 100px;
  animation: spin 2s linear infinite;
  margin-top: 5%;
  margin-left: 40%;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.append_hotel
{
    margin-top : 100px;
    text-align : center;
}


</style>

<script>
    
function getHotels(city)
{
$('#append_hotel').html('');
$('#append_hotel').removeClass('append_hotel');
$('#sec2-carousel').html('');
$('#loader').addClass('loader')
$.ajax({
  type:'GET',
  url:"/getHotels",
  data:{city:city},
  success:function(data){
       if($.isEmptyObject(data.error)){
        console.log('hotels fetched!!!',data)
        let hotels = '';
        if(data.length == 0)
        {
            $('#append_hotel').append('No Hotels Found!!')
            $('#append_hotel').addClass('append_hotel');
        }
        data.map(function(item){
            //  console.log('item : ',item)
             hotels += `<div class="item"><div class="inner-carousel"><div class="main-img"><img src='${item.heroImage}' style="height:213px"></div><div class="star-per"><div class="place-star mb-3"><div class="place-left">${item.propertyName}</div><div class="star-right"><img src="{{asset('images/Star.svg')}}"><div>${item.rating}</div></div></div><div class="place-per"><div class="loc-left"><img src="{{asset('images/location.svg')}}"><div><p class="mb-1">${item.city}</p><p class="m-0">${item.country}</p></div></div><div class="per-right"><div>$${item.referencePrice_value}</div><p>Per Night</p></div></div></div></div></div>`
     })
        let lll = "<div class='owl-carousel owl-theme city-1' id='sec2-carousel'>"+hotels+"</div>";
        $('#sec2-carousel').remove();
        $('#loader').removeClass('loader')
        
        $('#append_hotel').append(lll)
        $('#sec2-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
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


       }else{
           printErrorMsg(data.error);
       }
  }
});

}



// $('#search_field').on('keyup',function()
// {
//     // console.log("input value : ",$(this).val())
//     suggestPlaces($(this).val());
// })


// function suggestPlaces(search_word) {

//     console.log('search_word : ',search_word)

//     // var search_word = document.getElementById("search_field").value;
//     $.ajax({
//   type:'GET',
//   url:"/suggestPlaces",
//   data:{
//     country : 'United States',
//     search_word : search_word
// },
//   success:function(data){
//        if($.isEmptyObject(data.error)){
//         console.log('suggested cities : ',data)
//         let suggest = '';
//             data.map(function(item) {
//             suggest += '<li class="d-flex align-items-center" data-regionId='+item.RegionID+'><div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="PopularDestination_PopularDestination__icon__Y2IyM BpkIcon_bpk-icon--rtl-support__NjAzZ" style="width: 1.5rem; height: 1.5rem;"><path d="M19 6h-4a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v15a1 1 0 0 0 2 0V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2 2.15 2.15 0 0 0-2 2v13a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V21a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V8a2.15 2.15 0 0 0-2-2zm-5 11a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm4 6a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zm0-3a1 1 0 1 1 1-1 1 1 0 0 1-1 1zM9 7a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 3a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 6a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0-3a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm0 6a1 1 0 1 1-1-1 1 1 0 0 1 1 1z"></path></svg></div><div class="city-place"><p class="city">'+item.CityName+'</p><p class="cityplace">'+item.ProvinceName+','+item.CountryName+'</p></div></li>'
//         })
//         $('#list_show').html('');
//         $('#list_show').append(suggest);
//        }else{
//            printErrorMsg(data.error);
//        }
//   }
// });

// }

function filter() {

    var input, filter, ul, li, a, i, txtValue;

    input = document.getElementById("search_field");

   if(input.value != '')
   {

    filter = input.value.toUpperCase();

    ul = document.getElementById("list_show");

    li = ul.getElementsByTagName("li");

    for (i = 0; i < li.length; i++) {

        a = li[i].getElementsByTagName("p")[0];
        // console.log("a : ",a);

        txtValue = a.textContent || a.innerText;

        // txtValue = a.startsWith(`${txtValue}`)

        if ((txtValue.toUpperCase().indexOf(filter) > -1)) {
           
            // console.log('filter come!!!')

            li[i].style.display = "";

        } 
        else 
        {
            li[i].style.display = "none";
        }
    }
}

}




</script>

@include('layouts.footer')


