<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use View;
use Illuminate\Support\Facades\DB;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle(Request $request)
    {
      
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        
        try {
           
            $result = app('App\Http\Controllers\AjaxController')->defaultDatas();
 
        
            $staycation_cities= $result['staycation_cities'];
            $suggestCities =  $result['suggestCities'];
            $hotels =  $result['hotels'];
                  

  
           

           

            $user = Socialite::driver('google')->stateless()->user();
            
         
            $finduser = User::where('google_id', $user->id)->first();

          
            //dd($finduser);

           
        //    dd($finduser);
            if($finduser){
       
                Auth::login($finduser);
      
                //return redirect('/hotels')->with('suggestCities','suggestCities');

                return View::make('welcome')
                ->with('login',2)
                ->with('staycation_cities',$staycation_cities)
                ->with('suggestCities',$suggestCities)
                ->with('hotels',$hotels)
               
                ->with('user',$user);
               
                
       
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'password' => encrypt('123456dummy')
                ]);
      
                Auth::login($newUser);
      
                //return redirect()->intended('/');

                 return View::make('welcome')
                ->with('login',2)
                ->with('suggestCities',$suggestCities)
                ->with('staycation_cities',$staycation_cities)
                ->with('hotels',$hotels)
                ->with('user',$user);
            }
      
        } catch (Exception $e) {
            //dd($e->getMessage());
            throw $e;
        }
    }
}

?>

