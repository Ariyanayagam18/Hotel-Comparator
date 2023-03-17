<?php  
$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);

//$locale = "<script>document.write(localStorage.getItem('locale'));</script>";

$url = explode('/', $rootDir);
array_pop($url);
$pathurl = implode('/', $url); 
if(isset($_GET['locale']) && $_GET['locale']=='frFR')
{
  
   require_once "$pathurl/resources/lang/logintranlate/loginfr.php";
  
}
// else if($locale == 'enUS')
// {
//     require_once "$rootDir/Hotelcomparator/resources/lang/en/en.php";
// }
else if(isset($_GET['locale']) && $_GET['locale']=='esES'){

    require_once "$pathurl/resources/lang/logintranlate/logines.php";
    
}
else
{
   
    require_once "$pathurl/resources/lang/logintranlate/loginen.php";
   
}?>
<div class="login-section" style="display:none" id="loginform" >
    <div class="mb-4" name="logo">
        <img src="{{asset('images/login-under.svg')}}">    
    </div>
    <div class="login-text"><?php echo $Login ?></div>
   
    <form method="post" name="loginform" id="loginformid" action="{{route('userlogin')}}" >
    <input type="hidden" name="_token" value="{{ csrf_token() }}">   
        <div  class="login-inner">                   
            <input id="email" type="email" name="email" :value="old('email')" autofocus placeholder="<?php echo $Username_field ?>" />            
        </div>
        <div class="login-inner">                    
            <input id="password" type="password" name="password"  autocomplete="current-password"  placeholder="<?php echo $Password ?>"/>
        </div>
        <div>
            @if (Route::has('password.request'))
                <a class="forgot-pass" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <div class="log-in">
            <button><?php echo $Login ?></button>
        </div>            
        <hr class="hr-text" data-content="<?php echo $signup ?>">
        <div class="google-fb">
            <a class="" href="{{ url('auth/google') }}"  id="btn-fblogin" >
                <img src="{{asset('images/login-google.svg')}}">    
            </a>                
            <a class="" href="{{ url('auth/facebook') }}" id="btn-fblogin">
                <img src="{{asset('images/login-fb.svg')}}">    
            </a>                
        </div>
    </form>
</div>
  
    
