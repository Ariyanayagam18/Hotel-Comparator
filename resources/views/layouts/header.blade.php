<?php  
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);

$url = explode('/', $rootDir);
array_pop($url);
$pathurl = implode('/', $url); 
if(isset($_GET['locale']) && $_GET['locale']=='frFR')
{
  
   require_once "$pathurl/resources/lang/header/headfr.php";
  
}
else if(isset($_GET['locale']) && $_GET['locale']=='esES'){

    require_once "$pathurl/resources/lang/header/heades.php";
    
}
else
{
   
    require_once "$pathurl/resources/lang/header/headen.php";
   
}?>

<?php 
  $base_url = "http://$_SERVER[HTTP_HOST]/Hotelcomparator/public/index.php/";
  $path = false;
  ?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hotel Comparator</title>
  <link rel="icon" type="image/svg" href="{{asset('images/logo.svg')}}" >
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
  <!-- Bootstrap -->
  <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">

  <!-- mobile_modal script -->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script class="lazy" data-src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

<!-- mobile_modal script -->

  <!-- style -->
  <link rel="stylesheet" href="{{asset('css/main.css')}}">

  <!-- select -->
  <link rel="stylesheet" href="{{asset('select/css/select2.css')}}"/>

  <!-- datapicker -->
  <link rel="stylesheet" type="text/css" href="{{asset('datapicker/css/daterangepicker.css')}}" />
    
  <!-- owl -->
  <script src="{{asset('jquery/jquery.slim.min.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

  <link rel="stylesheet" href="{{asset('owl/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('owl/css/owl.theme.default.min.css')}}">     
     
</head>
<nav class="header-section navbar navbar-expand-md navbar-light">
  <a class="navbar-brand" href="http://127.0.0.1:8000/">
    <img src="{{asset('images/logo.svg')}}">    
  </a>
  <button class="navbar-toggler" type="button" onclick="openNav()">
     <span class="navbar-toggler-icon"></span>
  </button>
  <div id="mySidenav" class="sidenav">
    <?php $all_data=session()->all(); 
    $token=Auth::id();
  //  dd(Auth::id());
 

    ?>
    <ul class="navbar-nav">
    	<!-- <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
      <li class="localechoose nav-item">
        <select id="id_select2_example">
          <option class="locale" value="USA"  data-locale="enUS" data-img_src="{{asset('images/Flags/usa.svg')}}">USA</option>
          <option class="locale"  value="EN"  data-locale="esES" data-img_src="{{asset('images/Flags/EN.svg')}}">EN</option>
          <option class="locale" value="FR"   data-locale="frFR" data-img_src="{{asset('images/Flags/france.svg')}}">FR</option>
          <option class="locale" value="IND"  data-locale="enUS" data-img_src="{{asset('images/Flags/india.svg')}}">IND</option>
        </select>
      </li>
      <li class="nav-item coins-list">
        <select id="id_select2_examples">
          <option class="currency" data-img_src="{{asset('images/coins/USD.svg')}}" data-currency="USD" >USD</option>
          <option class="currency"  data-img_src="{{asset('images/coins/EUR.svg')}}" data-currency="EUR" >EUR</option>
          <option class="currency" data-img_src="{{asset('images/coins/INR.svg')}}" data-currency="INR" >INR</option>
          <option class="currency" data-img_src="{{asset('images/coins/GBP.svg')}}" data-currency="GBP" >GBP</option>
        </select>
      </li> -->
      <li><a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
      <li class="localechoose nav-item">
        <button id="popupdata" data-toggle='modal' data-target='#myModal'>   
          <div class="header_country">
            <span class="choose_locale" id="country_reg"> </span>
          
            <img  class="flag" src="{{asset('images/us.png')}}" alt="US" title="US">
           
            <span class="choose_currency" id="curr_symbol"> </span>
            <span class="choose_currency" id="currency"> </span>
           
          </div>   

        </button>
        
      </li>
      @if(isset($login) && $login == 1)
      <li class="nav-item login">
        <a class="nav-link" id="loginbutton"><?php echo $Login ?></a>
        <div class="login-link">@include('auth.login')</div>
      </li> 
     @endif
     @if(isset($login) && $login == 2)
     
      <li class="nav-item login-after">
        <div class="dropdown">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            <img src="{{asset('images/profile.svg')}}">   
          </button>
          <div class="dropdown-menu">
            <div class="logout-sec">
              <div class="email-logout">
                <img src="{{asset('images/profile.svg')}}">   
                <p>Scarlet@yopmail.com</p>
              </div>
            </div>
            <div class="logout-sec">
              <div class="log-out">
                <img src="{{asset('images/logout.svg')}}">   
                <a href="{{ route('logout') }}">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </li> 
     
@endif
    </ul>
     
  </div>  
</nav>
<div class="container">
  <!-- Button to Open the Modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Open modal
  </button> -->

  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      

      <!-- Modal Header -->
      <div class="modal-header">
          <h4 class="modal-title"><?php echo $Regional_settings ?></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
          <div>
            <label><img src="{{asset('images/svgexport-35.svg')}}"><?php echo $Language ?></label>
            <br>
            <select class="locale-select currency-select" id="locale_select">
             <option  data-country='English (US)' value='enUS'>English (US)</option>
              <option data-country='Français (FR)' value='frFR'>Français (FR)</option>
              <option data-country='English (UK)' value='enUS'>English (UK)</option>
              <option data-country='English (IN)' value='enUS'>English (IN)</option>
              <option data-country='English (CAN)' value='enUS'>English (CAN)</option>
              <option data-country='Español (ES)' value='esES'>Español (ES)</option>
            </select>
          </div>
        </div>


        <!-- Modal Header -->
      
        <!-- Modal body -->
        <div class="modal-body">
          <div>
            <label><img src="{{asset('images/money.svg')}}"> <?php echo $Currency ?></label>
            <br>
            <select class="curr-select currency-select" id="currencies">
            </select>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
        <a><button type="button" class="btn btn-primary" id="apply" data-dismiss="modal"><?php echo $Apply ?></button></a>
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo $Close ?></button>
        </div>
        
      </div>
      <input type="hidden" id="sel_locale" value=''>
      <input type="hidden" id="sel_country" value=''>
      <input type="hidden" id="sel_country_id" value=''>
      <input type="hidden" id="sel_currency" value=''>
      <input type="hidden" id="sel_currency_symbol" value='' >
      <input type="hidden" id="active_locale" value='<?php echo isset($_GET['locale']) ? $_GET['locale'] : '' ;?>' >
    </div>
  </div>
  
</div>

<script>

// $('#date_picker').value = 'bdfsbasdfkdbfkdsa'
$('.calender-sec').trigger('click')

console.log('active currency : ',localStorage.getItem('currency'))
console.log('active locale : ',localStorage.getItem('locale'))
console.log('active_country_id : ',localStorage.getItem('country_id'))
console.log('active_country : ',localStorage.getItem('country'))
console.log('active_currency symbol : ',localStorage.getItem('symbol'))

var active_currency = localStorage.getItem('currency');
var active_locale  = localStorage.getItem('locale')
var active_country_id = localStorage.getItem('country_id')
var active_country = localStorage.getItem('country')
var currency_symbol = localStorage.getItem('symbol')
var currchange_detect = false
var language_change = 0;

if(active_country == undefined && active_country_id == undefined )
{
console.log('initial : ');
$('#curr_symbol').text('$')
$('#currency').text('USD')
$('#country_reg').text('English (US)')
}
else{
$('#curr_symbol').text(currency_symbol)
$('#currency').text(active_currency)
$('#country_reg').text(active_country)
}

// console.log("get locale :",localStorage.getItem("locale")) == undefined ? localStorage.setItem("locale","enUS") : '';
// console.log("get locale :",localStorage.getItem("currency")) == undefined  ? localStorage.setItem("currency","USD") : '';

  var currentPageUrl  = location.href 
//   // console.log("currentPageUrl : ",currentPageUrl);
  
//   $('#id_select2_examples').on('change',function(){
//     // console.log('currency select : ',$(this).find('.selected').data('currency'))
//     localStorage.setItem("currency",$(this).find('.selected').data('currency'))
//     $('a.nav-link.active').hasClass('home') ? getHotels($('a.nav-link.active.home')[0].outerText) : '' ;
//     window.location.pathname == '/hotelDetails' ? currencyConversion(localStorage.getItem('currency'),$('#hotel_price').val()) : '' ;
//     // location.href = `language?locale=${$(this).find('.selected').data('locale')}`
// })


function currenciesList()
{
  let response = fetch('https://www.skyscanner.co.in/g/oc-registry/culture-selector/1.3.12/?market=IN&locale=en-GB&currency=EUR')
  .then((response) => response.json())
  .then((data) => {
    console.log('data : ',data)
  // console.log('html : ',data.html)
  let split_te = data.html.split('props')
  // console.log('split : ',split_te[1])
  var req_res = split_te[1].split(';')
  let req = req_res[0]
  // console.log('req : ',req)
  let remove_first = req.slice(1);
  // console.log('remove_first : ',remove_first)
  // 81297
  // console.log('remove_first before : ',remove_first)
  let remove_last = remove_first.slice(0, -1)
    // console.log('remove_first after : ',remove_last)
    // console.log('remove_first : ',remove_first)
  // console.log('str : ',remove_first.charAt((81297)-1))
  // let remove_last = remove_first.slice((remove_first.length)-1)
  // console.log('dafsa',remove_first.charAt((remove_first.length)-1))
  // console.log('remove_last : ',remove_last)
  let pas = JSON.parse(remove_last)
  console.log('pas : ',pas)
  // alert('data fetched')
  let curr =   pas.currencies
  $('#currencies').html('')
  let curr_list = '';
  curr.map(function(item){
      // console.log(`${item.Code} - ${item.Symbol}`)
      // if(item.Code == 'USD')
      // {
      //   curr_list += `<option value="${item.Code}" selected data-symbol="${item.Symbol}">${item.Code} - ${item.Symbol}</option>`
      // }
      // else{    debugger;
    //$("#currencies").val(active_currency);
    if(active_currency == item.Code)
    {
      curr_list += `<option value="${item.Code}" selected data-symbol="${item.Symbol}">${item.Code} - ${item.Symbol}</option>`
    }
    else{
      curr_list += `<option value="${item.Code}" data-symbol="${item.Symbol}">${item.Code} - ${item.Symbol}</option>`
    }
        
      // }
      
  })
  // console.log('curr_list : ',curr_list)
  $('#currencies').append(curr_list)
  // return pas;
//   let req = split_te[1]
//   var scriptRegex = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi;
// var html2 = req.replace(scriptRegex, "");
// console.log('html : ',html2)
// console.log('res : ',req)
//   let rem = data.html.replace( /(<([^>]+)>)/ig, '');
//   let pas = JSON.parse(rem)
//   console.log('pas : ',pas)
//   console.log('type : ',typeof(data.html))
  })
}

var initial = 0;


$('#myModal').on('show.bs.modal', function (e) {
    $('#select2-id_select2_examples-results').hide();
    // console.log('modal opened');
    (initial == 0 )?  currenciesList() : '';
    initial++;
    // Your code goes here


});
$('#myModal').on('hide.bs.modal', function (e) {
    // console.log('modal closed!!!');
    $('.nav-link.active').trigger('click')
    
    // Your code goes here
});



$('#currencies').on('change',function(){
    console.log('currenct selected : ',$('#currencies').val())
    // console.log('currenct selected : ',$('#currencies'))
    localStorage.setItem('currency',$('#currencies').val())
    localStorage.setItem('symbol',$('#currencies').find(":selected").attr('data-symbol'))
    console.log('currency changed  : ',localStorage.getItem('currency'));
    $('#sel_currency').val(localStorage.getItem('currency'))
    $('#sel_currency_symbol').val(localStorage.getItem('symbol'))
    console.log('get symbol : ',localStorage.getItem('symbol'))
    currchange_detect = true;
    // localStorage.setItem('symbol',$('#currencies').data('symbol'))
})

let selected_country  = $('#locale_select').find(':selected').attr('data-country');


$('#locale_select').on('change',function(){
     
      console.log('this : ',this)
      var sel = $('#locale_select').val()
      // let selected_country  = $(this).find(':selected').attr('data-country');
      var selected_country_id  = $(this)[0].selectedIndex; 
      localStorage.setItem('country_id',(selected_country_id+1))
      console.log('selectedIndex : ',$(this)[0].selectedIndex)
      console.log('country_choose : ',$(this).find(':selected').attr('data-country'))
      localStorage.setItem('country',$(this).find(':selected').attr('data-country'))
      localStorage.setItem('locale',sel)
      $('#sel_locale').val(sel)
      $('#sel_country_id').val(selected_country_id)
      $('#sel_country').val($(this).find(':selected').attr('data-country'))
      console.log('sleect hidden : ',$('#sel_locale').val());
      language_change++
      // change_detect = true;
      
})

$('#apply').click(function(){
  let select_index =  $('#sel_country_id').val()
  console.log('select_index : ',select_index);
  if(currchange_detect) 
      {
        // console.log('curr symbol : ',$('#curr_symbol'))
        $('#curr_symbol').text($('#sel_currency_symbol').val())
        $('#currency').text($('#sel_currency').val())
        // currencyConversion(localStorage.getItem('currency'),'<?//php echo $_GET['price']?>')
      }
   if(language_change >=1 )
    { 
        // debugger;
        $('#locale_select option:nth-child('+(select_index+1)+')').prop('selected',true)
        location.href = `/language?locale=${$('#sel_locale').val()}`
    }

})


$('#popupdata').click(function(){
  
  active_currency == null ? $('#currencies').val('USD') : '';
  $('#locale_select option:nth-child('+(active_country_id)+')').prop('selected',true)
})

</script>
