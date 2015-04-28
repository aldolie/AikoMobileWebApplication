<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller {

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
		$this->api='http://localhost/aiko/services/';
		$this->help='http://localhost/store/help/';
		//$this->middleware('auth');
	}

	public function buy(Request $request){

		$user=null;
		//$url=$request->path();
		$url=$request->headers->get('referer');
		if(Session::has('user')){
			$user=Session::get('user');
			$quantity=$request->input('quantity');
			$userid=$user->userid;
			$productid=$request->input('id');
			$client = new Client();
			$response = $client->post($this->api.'transaction_undef_buy/'.$request->route('id') ,['future' => true,'body'=>['userid'=>$userid,'productid'=>$productid,'quantity'=>$quantity],'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
			$data=json_decode($response->getBody());
			if($data->status=='failed')
			{
				return Redirect::to($url)->withErrors(['0'=>$data->error]);
			}
			else if($data->status=='success'){
				return Redirect::to($url)->with('message', 'Pembelian Berhasil');
			}
		}
	}

	public function pready(){
		$user=null;
		if(Session::has('user'))
			$user=Session::get('user');
		return view('content/pr',['user'=>$user]);
	}

	public function pdetail(Request $request){

		$client = new Client();
		$response = $client->get($this->api.'product_id/'.$request->route('id') ,['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
		$data=json_decode($response->getBody());
		$user=null;
		if(Session::has('user'))
			$user=Session::get('user');
		return view('content/detail',['status'=>$data->status,'product'=>$data->result,'user'=>$user]);
		
	}

	public function ppo(){

		$user=null;
		if(Session::has('user'))
			$user=Session::get('user');
		return view('content/pp',['user'=>$user]);
	}

	public function oready(){
		if(Session::has('user')){
			$user=Session::get('user');
			$client = new Client();
			$response = $client->get($this->api.'order_user/id/'.$user->userid,['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
			$data=json_decode($response->getBody());
			return view('content/or',['orders'=>$data->result,'user'=>$user]);
		}
		else{
			return '404';
		}
	}

	public function opo(){
		if(Session::has('user')){
			$user=Session::get('user');
			$client = new Client();
			$response = $client->get($this->api.'po_user/id/'.$user->userid,['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
			$data=json_decode($response->getBody());
			return view('content/op',['orders'=>$data->result,'user'=>$user]);
		}
		else{
			return '404';
		}
	}


	public function transaction(){
		if(Session::has('user')){
			$user=Session::get('user');
			$client = new Client();
			$response = $client->get($this->api.'transaction_user_sync/id/'.$user->userid.'/created_at/0000-00-0000:00:00',['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
			$data=json_decode($response->getBody());
			return view('content/tr',['transactions'=>$data->result,'user'=>$user]);
			}
		else{
			return '404';
		}
	}

	public function help(){
		
		$client = new Client();
		$response = $client->get($this->help,['future' => true]);
		$view=$response->getBody();
		$user=null;
		if(Session::has('user'))
			$user=Session::get('user');
		
		return view('content/help',['view'=>$view,'user'=>$user]);
	}


	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

}
