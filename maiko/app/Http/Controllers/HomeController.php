<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

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
			if($userid==null||$userid=='0'||$userid==''){
				return Redirect::to($url)->withErrors(['0'=>'Harus Login terlebih dahulu']);

			}
			else if($quantity==null||$quantity=='0'||$quantity==''){
				return Redirect::to($url)->withErrors(['0'=>'Jumlah beli harus diisi']);

			}
			else if($productid==null||$productid=='0'||$productid==''){
				return Redirect::to($url)->withErrors(['0'=>'Product harus di isi']);

			}
			else{
				$response = $client->post($this->api.'transaction_undef_buy/'.$request->route('id') ,['future' => true,'body'=>['userid'=>$userid,'productid'=>$productid,'quantity'=>$quantity],'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
				$data=json_decode($response->getBody());
				if($data->status=='failed')
				{
					return Redirect::to($url)->withErrors(['0'=>$data->error]);
				}
				else if($data->status=='success'){
					return Redirect::to($url)->withErrors(['0'=>'Pembelian Berhasil']);
				}
			}
		}
	}

	public function download(Request $request){
		if($request->input('href')!=null){
			$href=$request->input('href');
			$ext=explode('.', $href);
			$ext=$ext[count($ext)-1];
			$client = new Client();
			$u=date("U");
			$file="image_".$u.'.'.$ext;
			file_put_contents($file, fopen($href, 'r'));
			$headers = array('Content-Type: image/'.$ext);
			return Response::download($file,'image.'.$ext,$headers);
			
		}
	}

	public function profile(){
		$user=null;
		if(Session::has('user')){
			$user=Session::get('user');
			$client = new Client();
			$response = $client->get($this->api.'user/id/'.$user->userid,['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
			$data=json_decode($response->getBody());
			$dataUser=$data->result;
			if($dataUser){
				Session::set('user',$dataUser);
				$user=Session::get('user');
			}
			return view('content/profile',['user'=>$user]);
		}
	}

	public function profile_do(Request $request){
		$user=null;
		if(Session::has('user')){
			$validator = Validator::make($request->all(),
		    [
		     'nama'=>'required',
		     'alamat'=>'required',
		     'email'=>'required|email',
		     'telepon'=>'required'],
		    [
		    'nama.required'=>'Nama tidak boleh kosong',
		    'alamat.required'=>'Alamat tidak boleh kosong',
		    'email.required'=>'Email tidak boleh kosong',
		    'telepon.required'=>'Telepon tidak boleh kosong',
		    'email.email'=>'Email tidak sesuai format email']
		);
			if($validator->fails()){
				 return Redirect::to('Profile')->withErrors($validator->messages());
			}
			else{
				$nama=$request->input('nama');
				$alamat=$request->input('alamat');
				$email=$request->input('email');
				$telepon=$request->input('telepon');
				$user=Session::get('user');
				$client = new Client();
				$response = $client->post($this->api.'user_update/',['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$'],
					'body'=>['userid'=>$user->userid,'nama'=>$nama,'alamat'=>$alamat,'telepon'=>$telepon,'email'=>$email,'note'=>$user->note,'bb'=>$user->bb]]);
				$data=json_decode($response->getBody());
				if($data->status=='success'){
					$response = $client->get($this->api.'user/id/'.$user->userid,['future' => true,'auth' =>  ['administrator', 'KJHASDF89.ajHFAHF$']]);
					$data=json_decode($response->getBody());
					$dataUser=$data->result;
					if($dataUser){
						Session::set('user',$dataUser);
						$user=Session::get('user');
					}
					return view('content/profile',['user'=>$user]);
				}
				else{
					return Redirect::to('Profile')->withErrors(['0'=>'Simpan data gagal']);
				}
			}
		}
	}

	//user_update_post

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
