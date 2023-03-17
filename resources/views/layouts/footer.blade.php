<?php  
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
$url = explode('/', $rootDir);
array_pop($url);
$pathurl = implode('/', $url); 

if(isset($_GET['locale']) && $_GET['locale']=='frFR')
{
  
   require_once "$pathurl/resources/lang/footer/footfr.php";
  
}
else if(isset($_GET['locale']) && $_GET['locale']=='esES'){

    require_once "$pathurl/resources/lang/footer/footes.php";
    
}
else
{
   
    require_once "$pathurl/resources/lang/footer/footen.php";
   
}?>
<style>
    .someclass {
    color: red;
}
</style>
<div class="footer">
    <div class="footer-section navbar">
        <div class="footer-logo">
            <div class="foot-logo"><img src="{{asset('images/logo.svg')}}"></div>
            <div class="social-img mt-3">
                <img src="{{asset('images/fb.svg')}}">
                <img src="{{asset('images/twitter.svg')}}">
                <img src="{{asset('images/instgram.svg')}}">
                <img src="{{asset('images/linkin.svg')}}">
            </div>
        </div>
        <div class="sites">
            <div>
                <p class="site-explore"><?php echo $International_Sites ?></p>
                <ul>
                    <li><a href="{{ url('') }}" class="sites_link"><img src="{{asset('images/Flags/france.svg')}}"><?php echo $France ?></a></li>
                    <li><a href="{{ url('') }}" class="sites_link"><img src="{{asset('images/Flags/india.svg')}}"><?php echo $India ?></a></li>
                    <li><a href="{{ url('') }}" class="sites_link"><img src="{{asset('images/Flags/usa.svg')}}"><?php echo $USA?></a></li>
                    <li><a href="{{ url('') }}" class="sites_link"><img src="{{asset('images/Flags/EN.svg')}}"><?php echo $London?></a></li>
                </ul>
            </div>
        </div>
        <div class="Explore">
            <div>
                <p class="site-explore"><?php echo $Explore ?></p>
                <ul>
                    <li><?php echo $Sitemap ?></li>
                    <li><?php echo $Cookie_policy ?></li>
                    <li><?php echo $Privacy_policy ?></li>
                    <li><?php echo $Terms_of_service ?></li>
                </ul>
            </div>
        </div>
        <div class="Contact">
            <div class="contact-us">
                <p><?php echo $Contact_Us ?></p>
                <div>
                    <input type="text" placeholder="<?php echo $Name ?>">
                </div>
                <div>
                    <input type="text" placeholder="<?php echo $Email_Id?>"> 
                </div> 
                <div>
                    <button type="button" class="btn btn-primary"><img src="{{asset('images/footer-arrow.svg')}}" class="mr-2"><?php echo $send ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="scanner">
        <p class="m-0">© RoyalPlace Ltd 2002-2023</p>
    </div>
</div>
<!-- Bootstrap script -->
<script src="{{asset('jquery/jquery.validate.js')}}"></script>
<script src="{{asset('popper/popper.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('js/common.js')}}"></script>
<!-- select script -->
<script src="{{asset('select/js/select2.js')}}"></script>
<!-- owl script-->
<script src="{{asset('owl/js/owl.carousel.min.js')}}"></script>
<!-- Pagination script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.js"></script>

<!-- data picker script -->
<script type="text/javascript" src="{{asset('datapicker/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('datapicker/js/daterangepicker.min.js')}}"></script>
<?php 
    $base_url = 'http://18.135.144.242/Hotelcomparator/public/index.php';
    ?>

<div class="modal" id="myModal2">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="hide('popup')" >&times;</button>
        </div>
     <div class="modal-body"><p style="font-size: 18px;font-weight: bold;margin-bottom: 2rem;">An error occurred while trying to perform your search</p>
      <p class="font-weight-bold text-danger">Please choose a valid city,hotel name, or landmark.</p></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" onclick="hide('popup')" data-dismiss="modal" style="width: 100%;background:#005cbf;border: 1px solid #005cbf;font-weight: bold;">Dismiss</button>
        </div>
        
      </div>
    </div>
  </div>

<script>
   const date = new Date();

let day = date.getDate();
let month = date.getMonth() + 1;
let year = date.getFullYear();

// This arrangement can be altered based on how we want the date's format to appear.
let currentDate = `${day}-${month}-${year}`;
let curr_date = `${currentDate} - ${currentDate}`
console.log('currentDate : ',curr_date);
// debugger;
// $('#date_picker')[0].value = curr_date

  
  var currentPageUrl  = location.href 
  console.log("currentPageUrl : ",currentPageUrl);

  $('#id_select2_example').on('change',function(){
   
    console.log('this : ',$(this))
    
    
    location.href = `<?php echo $base_url;?>/language?locale=${$(this).find('.selected').data('locale')}`
    localStorage.setItem("locale",$(this).find('.selected').data('locale'))
    // location.href = `${currentPageUrl}&locale=${$(this).find('.selected').data('locale')}`
  })

  $('#id_select2_examples').on('change',function(){
    console.log('currency select : ',$(this).find('.selected').data('currency'))
    localStorage.setItem("currency",$(this).find('.selected').data('currency'))
    $('a.nav-link.active').hasClass('home') ? getHotels($('a.nav-link.active.home')[0].outerText) : '' ;
    (window.location.pathname == '/hotelDetails') ? currencyConversion(localStorage.getItem('currency'),$('#hotel_price').val()) : '' ;
    
    // location.href = `language?locale=${$(this).find('.selected').data('locale')}`
    
})

$('.locale').each(function(){
  if(localStorage.getItem("locale") == $(this).data('locale'))
  {
      console.log('selected language : ',$(this).data('locale'))
      $(this).attr('selected','true')
  }
//   location.href = `language?locale=${$(this).data('locale')}`
})

$('.currency').each(function(){
  if(localStorage.getItem("currency") == $(this).data('currency'))
  {
    console.log('selected currency : ',$(this).data('currency'))
      $(this).attr('selected','true')
  }
})

var hide = function(id) {
	$('#myModal2').hide();
}

</script>


  