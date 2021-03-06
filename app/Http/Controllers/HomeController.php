<?php
namespace App\Http\Controllers;
use Auth;
use Request;
use Input;
use Session;
use App\User;
use DNS2D;
use App\Role;
use App\Status;
class HomeController extends Controller
{
    protected $data = array();
    
    public function index() {     
        $this->data['username'] = "";
        $this->data['password'] = "";
        if(Auth::check()) {
            $this->data['username'] = Auth::user()->username;
            $this->data['password'] = Auth::user()->password;
        }
        return view('user.home',$this->data);
    }

    public function login() {
        /*Role::create(array(
            'id'    => 1,
            'name'  => 'Admin'
        ));

        Role::create(array(
            'id'    => 2,
            'name'  => 'Pasien'
        ));

        Role::create(array(
            'id'    => 3,
            'name'  => 'Dokter'
        ));

        Role::create(array(
            'id'    => 4,
            'name'  => 'Apotek'
        ));

        Role::create(array(
            'id'    => 5,
            'name'  => 'Dinas Kesehatan'
        ));

         Status::create(array(
            'id'    => 1,
            'name'  => 'Dikirim ke Apotek'
        ));

        Status::create(array(
            'id'    => 2,
            'name'  => 'Diterima Apotek'
        ));

        Status::create(array(
            'id'    => 3,
            'name'  => 'Sedang dalam proses peracikan obat'
        ));

        Status::create(array(
            'id'    => 4,
            'name'  => 'Obat sudah bisa diambil'
        ));

        Status::create(array(
            'id'    => 5,
            'name'  => 'Obat telah diambil'
        ));

         User::insertGetId(array(
            'name'      => 'Admin', 
            'username'  => 'admin@gmail.com', 
            'password'  => bcrypt('admin'), 
            'telp'      => '085607227007', 
            'nip'       => '5113100081',
            'barcode'   => '',
            'address'   => 'Teknik Informatika ITS',
            'role_id'   => 1
        ));

        User::insertGetId(array(
            'name'      => 'Pasien', 
            'username'  => 'pasien@gmail.com', 
            'password'  => bcrypt('pasien'), 
            'telp'      => '085607227007', 
            'nip'       => '5113100046',
            'barcode'   => '',
            'address'   => 'Keputih',
            'role_id'   => 2
        ));

        User::insertGetId(array(
            'name'      => 'Dokter', 
            'username'  => 'dokter@gmail.com', 
            'password'  => bcrypt('dokter'), 
            'telp'      => '085607227007', 
            'nip'       => '5113100015',
            'barcode'   => '',
            'address'   => 'Wisma Permai Gg 3 no 3',
            'role_id'   => 3
        ));

        User::insertGetId(array(
            'name'      => 'Apotek', 
            'username'  => 'apotek@gmail.com', 
            'password'  => bcrypt('apotek'), 
            'telp'      => '085607227007', 
            'nip'       => '5113100300',
            'barcode'   => '',
            'address'   => 'Apotek Keputih Sukolilo',
            'role_id'   => 4
        ));

        User::insertGetId(array(
            'name'      => 'Dinas Kesehatan', 
            'username'  => 'dinas@gmail.com', 
            'password'  => bcrypt('dinas'), 
            'telp'      => '085607227007', 
            'nip'       => '5113100081',
            'barcode'   => '',
            'address'   => 'Dinas Kesehatan Surabaya',
            'role_id'   => 5
        ));*/

        if (Request::isMethod('post')) {
            $credentials = Input::only('username','password');
            $this->data['username'] = Input::get('username');
            $cek = User::where('username',$this->data['username'] )->count();
            if ($cek > 0)
            {
                if (Auth::attempt($credentials,true)){
                    if(Auth::user()->role_id == 1) {
    					return redirect('admin'); 
    				} 
                    else if (Auth::user()->role_id == 2) {
    					return redirect('pasien'); 
    				} 
                    else if (Auth::user()->role_id == 3) {
    					return redirect('dokter'); 
    				}
    				else if (Auth::user()->role_id == 4) {
    					return redirect('apotek'); 
    				}

                }
                Session::flash('status','failed-login');
                return redirect('/');
            }
            else
            {
                Session::flash('status','not-exist');
                return redirect('/');
            }
        }
        else if (Request::isMethod('get')) {
            if (Auth::check()) {
            	if(Auth::user()->role_id == 1){
                	return redirect('admin');
                }
                else if (Auth::user()->role_id == 2){
                	return redirect('pasien');
                }
                else if (Auth::user()->role_id == 3){
                	return redirect('dokter');
                }
                else if (Auth::user()->role_id == 4){
                	return redirect('apotek');
                }
            }
            
            return view('login');
        }
    }

    public function loginApi() {
        if (Request::isMethod('post')) {
            $credentials = Input::only('username','password');
            $this->data['username'] = Input::get('username');
            $cek = User::where('username',$this->data['username'] )->count();
            if ($cek > 0)
            {
                if (Auth::attempt($credentials,true)){
                    if(Auth::user()->role_id == 1) {
                        $res = array(
                                'user_id'   => (string)Auth::user()->id,
                                'status'    => 'success',
                                'token'     => Auth::user()->remember_token,
                                'role'      => '1',
                                'barcode'   => Auth::user()->barcode
                                );
                        return json_encode($res); 
                    } 
                    else if (Auth::user()->role_id == 2) {
                        $res = array(
                                'user_id'   => (string)Auth::user()->id,
                                'status'    => 'success',
                                'token'     => Auth::user()->remember_token,
                                'role'      => '2',
                                'barcode'   => Auth::user()->barcode
                                );
                        return json_encode($res); 
                    } 
                    else if (Auth::user()->role_id == 3) {
                        $res = array(
                                'user_id'   => (string)Auth::user()->id,
                                'status'    => 'success',
                                'token'     => Auth::user()->remember_token,
                                'role'      => '3',
                                'barcode'   => Auth::user()->barcode
                                );
                        return json_encode($res); 
                    }
                    else if (Auth::user()->role_id == 4) {
                        $res = array(
                                'user_id'   => (string)Auth::user()->id,
                                'status'    => 'success',
                                'token'     => Auth::user()->remember_token,
                                'role'      => '4',
                                'barcode'   => Auth::user()->barcode
                                );
                        return json_encode($res); 
                    }

                }
                $res = array(
                        'user_id'   => 'null',
                        'status'    => 'failed',
                        'token'     => 'null',
                        'role'      => 'null',
                        'barcode'   => 'null'
                        );
                return json_encode($res); 
            }
            else
            {
                $res = array(
                        'user_id'   => 'null',
                        'status'    => 'not-exist',
                        'token'     => 'null',
                        'role'      => 'null',
                        'barcode'   => 'null'
                        );
                return json_encode($res); 
            }
        }
        /*else if (Request::isMethod('get')) {
            if (Auth::check()) {
                if(Auth::user()->role_id == 1){
                    return redirect('admin');
                }
                else if (Auth::user()->role_id == 2){
                    return redirect('pasien');
                }
                else if (Auth::user()->role_id == 3){
                    return redirect('dokter');
                }
                else if (Auth::user()->role_id == 4){
                    return redirect('apotek');
                }
            }
            return view('login');
        }*/
    }

    public function admin() {     
        if(Auth::check()) {
            return view('admin.homeAdmin');
        }
        return redirect('/');
    }

    public function pasien() {     
        if(Auth::check()) {
            return view('pasien.homePasien');
        }
        return redirect('/');
    }

    public function dokter() {     
        if(Auth::check()) {
            return view('dokter.homeDokter');
        }
        return redirect('/');
    }

    public function apotek() {     
        if(Auth::check()) {
            return view('apotek.homeApotek');
        }
        return redirect('/');
    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function logoutApi($token) {
        if($user_id = User::where('remember_token',$token)->first())
        {
            User::where('username', $user_id->username)->update(array(
                'remember_token'    => NULL
            ));
            $res = array(
                    'status'    => 'logout-success',
                    );
            return json_encode($res);
            
        }
        else
        {
            $res = array(
                    'status'    => 'logout-failed',
                    );
            return json_encode($res);
        }
    }

    public function register(){
        if (Request::isMethod('post')) {
            $data = Input::all();
            $cek = User::where('username',$data['username'])->count();
            if($cek == 0)
            {
                User::insertGetId(array(
                    'name'      => $data['name'], 
                    'username'  => $data['username'], 
                    'password'  => bcrypt($data['password']), 
                    'telp'      => $data['telp'], 
                    'nip'       => $data['nip'],
                    'address'   => $data['address'],
                    'role_id'   => $data['role']
                ));
                Session::flash('status','register-success');
                $user = User::where('username',$data['username'])->first();
                $img = DNS2D::getBarcodePNG( $data['username'].$data['nip']."_=".$user->id,"QRCODE");
                $data = 'data:image/png;base64,'.$img;
                $update = User::where('id',$user->id)->update(array(
                    'barcode'   => $data
                ));

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('qrcodeUser/'.$user->id.'.png', $data);
            }
            else
            {
                Session::flash('status','register-failed');
            }
            return redirect('/');
        }
    }

    public function registerApi(){
        if (Request::isMethod('post')) {
            $data = Input::all();
            $cek = User::where('username',$data['username'])->count();
            if($cek == 0)
            {
                $create = User::create(array(
                    'name'      => $data['name'], 
                    'username'  => $data['username'], 
                    'password'  => bcrypt($data['password']), 
                    'telp'      => $data['telp'], 
                    'nip'       => $data['nip'],
                    'address'   => $data['address'],
                    'role_id'   => $data['role']
                ));

                $user = User::where('username',$data['username'])->first();
                $img = DNS2D::getBarcodePNG( $data['username'].$data['nip']."_=".$user->id,"QRCODE");
                $data = 'data:image/png;base64,'.$img;
                $update = User::where('id',$user->id)->update(array(
                    'barcode'   => $data
                ));

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                file_put_contents('qrcodeUser/'.$user->id.'.png', $data);
                if($create && $update)
                {
                    $res = array(
                            'status'    => 'register-success',
                            );
                    return json_encode($res);
                }
                else
                {
                    $res = array(
                            'status'    => 'register-failed',
                            );
                    return json_encode($res);   
                }
            }
            else
            {
                $res = array(
                        'status'    => 'account-exist',
                        );
                return json_encode($res);
            }
            return redirect('/');
        }
    }

    public function sendToken($token){
        if (Request::isMethod('post')) {
            $data = Input::all();
            $user = User::where('remember_token',$token)->first();
            $update = User::where('id',$user->id)->update(array(
                'token_fcm'      => $data['token_fcm'], 
            ));
            if($update)
            {
                $res = array(
                        'status'    => 'send-success',
                        );
                return json_encode($res);
            }
            else
            {
                $res = array(
                        'status'    => 'register-failed',
                        );
                return json_encode($res);   
            }

            return redirect('/');
        }
    }
}
