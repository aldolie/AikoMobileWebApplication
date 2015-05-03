<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/
	private $api;
	private $help;
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->api='http://supolshop.com/aiko/services/';
		//$this->middleware('auth');
	}


	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('login');
	}

	public function signout()
	{
		Session::remove('user');
		return Redirect::to('Signin');
	}

	public function register(){
		return view('content/register');
	}

	public function register_do(Request $request){
		$validator = Validator::make($request->all(),
		    ['username' => 'required',
		     'password'=>'required',
		     'cpassword'=>'required',
		     'nama'=>'required',
		     'alamat'=>'required',
		     'email'=>'required|email',
		     'telepon'=>'required'],
		    ['username.required' => 'Username tidak boleh kosong',
		    'password.required'=>'Password tidak boleh kosong',
		    'cpassword.required'=>'Confirmation Password tidak boleh kosong',
		    'nama.required'=>'Nama tidak boleh kosong',
		    'alamat.required'=>'Alamat tidak boleh kosong',
		    'email.required'=>'Email tidak boleh kosong',
		    'telepon.required'=>'Telepon tidak boleh kosong',
		    'email.email'=>'Email tidak sesuai format email']
		);

		if($validator->fails()){
			 return Redirect::to('Register')->withErrors($validator->messages());
		}
		else{
			$username=$request->input('username');
			$password=$request->input('password');
			$cpassword=$request->input('cpassword');
			$nama=$request->input('nama');
			$alamat=$request->input('alamat');
			$email=$request->input('email');
			$telepon=$request->input('telepon');
			if($password!=$cpassword){
				return Redirect::to('Register')->withErrors(['0'=>'Password dan Konfirmasi Password tidak cocok']);
			}
			else{
				$client = new Client();
				try{
					$response =$client->post($this->api.'users_register', ['future'=>true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$'],
						'body'=>['username'=>$username,'password'=>$password,'nama'=>$nama
						,'alamat'=>$alamat,'telepon'=>$telepon,'email'=>$email]]);
					$code=json_decode($response->getBody());
					if($code->status=='success'){
				    	$responseLogin =$client->post($this->api.'users_signin', ['future'=>true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$'],'body'=>['username'=>$username,'password'=>$password]]);
						$codeLogin=json_decode($responseLogin->getBody());
						if($codeLogin->status=='success'){
						 	Session::set('user',$codeLogin->result);
					    	return Redirect::to('/');
					    }
					    
				    }
				    else{
				    	return Redirect::to('Register')->withErrors(['0'=>$code->reason]);
			    	}
				}
				catch(RequestException $e){
					echo $e->getRequest() . "\n";
				    if ($e->hasResponse()) {
				        echo $e->getResponse() . "\n";
				    }
				   
				}
			}
			
		}
	}

	public function signin(Request $request){
		$validator = Validator::make($request->all(),
		    ['username' => 'required',
		     'password'=>'required'],
		    ['username.required' => 'Username tidak boleh kosong',
		    'password.required'=>'Password tidak boleh kosong']
		);

		if($validator->fails()){
			 return Redirect::to('Signin')->withErrors($validator->messages());
		}
		else{
			$username=$request->input('username');
			$password=$request->input('password');

			$client = new Client();
			try{
				$response =$client->post($this->api.'users_signin', ['future'=>true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$'],'body'=>['username'=>$username,'password'=>$password]]);
				$code=json_decode($response->getBody());
				if($code->status=='success'){
				 	Session::set('user',$code->result);
			    	return Redirect::to('/');
			    }
			    else{
			    	return Redirect::to('Signin')->withErrors(['0'=>'Username dan Password tidak sesuai']);
		    	}
			}
			catch(RequestException $e){
				echo $e->getRequest() . "\n";
			    if ($e->hasResponse()) {
			        echo $e->getResponse() . "\n";
			    }
			   
			}
			
		}
	}

}
