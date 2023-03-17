<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Session;
use App\Models\User;
use View;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function  index(){
        // dd('hii');
        return view('auth.login');
    }
    
    public function select(Request $request)
    {
        
        $result = app('App\Http\Controllers\AjaxController')->defaultDatas();
 
        
        $staycation_cities= $result['staycation_cities'];
        $suggestCities =  $result['suggestCities'];
        $hotels =  $result['hotels'];
              
        $id = $request->all();   
        
        //$user= Auth::user();
        $host = DB::table('users')->select('email','google_id')->where('email', $id['email'])->get();
        //dd($host->google_id);
        if(count($host)>0){
           $google = $host[0]->google_id;
        // dd($google );
           $user=$host[0]->email;
       
        if($google !== null && !empty($google)){
          // $session_var=Session::put('user',$host);                    
            //return redirect('/')->with('errorMessageDuration', 'Error!');
        //     return view('welcome', [
        //         'errorMessageDuration' => 'Users Email exists Already',
        //         'route' => 'createPr',
        //         'type' => 'new',
                
        //    ])->with('login',1);

           return view('welcome', [
            'errorMessageDuration' => 'Users Email exists Already',
            'route' => 'createPr',
            'type' => 'new',
            
       ])
           ->with('login',1)
           ->with('suggestCities',$suggestCities)
           ->with('staycation_cities',$staycation_cities)
           ->with('hotels',$hotels)
           ->with('users',$id);
            // return redirect('/');
            // return Views::make('welcome')
            // ->with('login',$session_var);
        } 
        else if($user !==null && !empty($user)){
           
            //return redirect('/hotels');

            return View::make('welcome')
            ->with('login',2)
            ->with('suggestCities',$suggestCities)
            ->with('staycation_cities',$staycation_cities)
            ->with('hotels',$hotels)
            ->with('users',$id);
          
            //dd($newUser);
           
        }
    } 
    else{
        
            $newusers = DB::table('users')->select('email')->where('email', $id['email'])->get();
            $newUser = User::create([
                'name' => 'new users',
                'email' =>  $id['email'],
                'password' => $id['password']
            ]);
            //return redirect('/hotels');
            return View::make('welcome')
            ->with('login',2)
            ->with('suggestCities',$suggestCities)
            ->with('staycation_cities',$staycation_cities)
            ->with('hotels',$hotels)
            ->with('user',$newusers);
        }
   
    //  dd($host);
       
        
    }
    // public function hotels(Request $request) {
    //    dd(Auth::id())
    //   }

    public function logout(Request $request) {
        // Session::flush();
        // Session::destroy();
        Auth::logout();
        return redirect('/');
      }
   
    
    

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
