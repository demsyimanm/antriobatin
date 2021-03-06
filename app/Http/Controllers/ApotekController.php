<?php

namespace App\Http\Controllers;
use Auth;
use Request;
use Input;
use Session;
use App\User;
use App\Transaction;
use App\History;

class ApotekController extends Controller
{

private function alertpasien($token,$role,$message){
              $notif = array
            (
                'tag'   => $role,
                'title'     => "NOTIFICATION!!!",
                'body'  => $message,
            );

              $data = array
            (
                'tag'   => $role,
                'title'     => "NOTIFICATION!!!",
                'body'  => $message,
            );


            $json=array(
                'data'  => $data,
                'notification'  => $notif,
                'to'    => $token,
                'priority' => 'high',
                'time_to_live' => 86400,
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: '.strlen(json_encode($json)),
                'Authorization:key=AIzaSyADEYyTtAk7EhvW9ZUVhw2jNj8VXxWdCB0'
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close($ch);
            // echo $output;
    }

    public function home() {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	$transactions = Transaction::where('drugstore_id',Auth::user()->id)->where('status_id','=','1')->orderBy('id','DESC')->get();
            return view('apotek.resep.masuk',compact('transactions'));
        }
        return redirect('/');
    }

    public function homeApi($token) {     
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	$transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','1')->orderBy('id','DESC')->get();
	            $transaction_arr = array();
                foreach ($transactions as $trans) {
                    $temp = array(
                        'id'            => (string)$trans->id,
                        'doctor'        => $trans->dokter->name,
                        'drugstore'     => $trans->apotek->name,
                        'photo'         => $trans->photo,
                        'cost'          => $trans->cost,
                        'message'       => $trans->message,
                        'duration'      => $trans->duration,
                        'status'        => $trans->status->name
                    );
                    array_push($transaction_arr, $temp);
                }
                $res = array(
                        'status'        => 'success',
                        'transactions'  => $transaction_arr
                    );
                return json_encode($res);
	        }
	        $res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);
    	}
	    $res = array(
                'status'        => 'failed',
                'transactions'  => 'null'
            );
        return json_encode($res);
    }

    public function homeApiWebView($token) 
    {     
        if ($user = User::where('remember_token',$token)->first()) 
        {
            if($user->role_id == 4) 
            {
                $transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','1')->orderBy('id','DESC')->get();
                return view('apotek.resep.masukWebView',compact('transactions'));
            }
        }
    }

    public function terima($id) {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	if(Request::isMethod('get'))
        	{
	        	$transaction = Transaction::find($id);
	        	$id = Transaction::where('id',$id)->update(array(
					'status_id'		=> 2
				));
	            return view('apotek.resep.terima',compact('transaction'));
        	}
        	else
        	{
        		$data = Input::all();
        		$id = Transaction::where('id',$id)->update(array(
					'cost' 			=> $data['cost'],
					'duration'		=> $data['duration'],
					'status_id'		=> 3
				));
				return redirect('apotek/resep');
        	}
        }
        return redirect('/');
    }

    public function terimaApiWebview($id,$token) {     
        if ($user = User::where('remember_token',$token)->first()) {
            if($user->role_id == 4) {
                if(Request::isMethod('get'))
                {
                    $transaction = Transaction::find($id);
                    /*$id = Transaction::where('id',$id)->update(array(
                        'status_id'     => 2
                    ));*/
                    return view('apotek.resep.terimaWebView',compact('transaction'));
                }
                else
                {
                    $data = Input::all();
                    $trans = Transaction::where('id',$id)->update(array(
                        'cost'          => $data['cost'],
                        'duration'      => $data['duration'],
                        'status_id'     => 3
                    ));

                        $transaction = Transaction::find($id);
                        $harga = $transaction->cost;
                        $durasi = $transaction->duration;
                        $token_fcm = $transaction->user->token_fcm;

                        $this->alertpasien($token_fcm,"2","Resep diracik , bisa diambil $durasi jam lagi, Harga $harga.");

                    return redirect('webview/apotek/resep/'.$token);
                }
            }
        }
        //return redirect('/');
    }

    public function terimaApi($id,$token) {
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	if(Request::isMethod('get'))
	        	{
		        	$transaction = Transaction::find($id);
		   //      	$update = Transaction::where('id',$id)->update(array(
					// 	'status_id'		=> 2
					// ));
					if ($update) {
			            $res = array(
		                        'status'        => 'success'
		                    );

		                return json_encode($res);
					}
					else
					{
						$res = array(
		                        'status'        => 'failed'
		                    );
		                return json_encode($res);
					}
	        	}
	        	else
	        	{
	        		$data = Input::all();
	        		$update = Transaction::where('id',$id)->update(array(
						'cost' 			=> $data['cost'],
						'duration'		=> $data['duration'],
						'status_id'		=> 3
					));
					if ($update) {
			            $res = array(
		                        'status'        => 'success'
		                    );
                        
		                return json_encode($res);
					}
					else
					{
						$res = array(
		                        'status'        => 'failed'
		                    );
		                return json_encode($res);
					}
	        	}
	        }
	        $res = array(
	                'status'        => 'failed'
	            );
	        return json_encode($res);
    	}     
        $res = array(
                'status'        => 'failed'
            );
        return json_encode($res);
    }

    public function racikApiWebView($token) { 
        if ($user = User::where('remember_token',$token)->first()) {
                if($user->role_id == 4) {
                	$transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','3')->orderBy('updated_at','DESC')->get();
                    return view('apotek.resep.racikWebView',compact('transactions'));
                }
            }    
    }

    public function racikApiWebViewUpdate($id,$token) { 
        if ($user = User::where('remember_token',$token)->first()) {
                if($user->role_id == 4) {
                    $data = Input::all();
                    $trans = Transaction::where('id',$id)->update(array(
                        'cost'          => $data['cost'],
                        'duration'      => $data['duration'],
                    ));
                    $transaction = Transaction::find($id);
                    $harga = $transaction->cost;
                    $durasi = $transaction->duration;
                    $token_fcm = $transaction->user->token_fcm;

                    $this->alertpasien($token_fcm,"2","Harga Berubah. Bisa diambil $durasi jam lagi, Harga $harga.");
                    return redirect('webview/apotek/racik/'.$token);
                }
            }    
    }

    public function racik() {     
        if(Auth::check() && Auth::user()->role_id == 4) {
            $transactions = Transaction::where('drugstore_id',Auth::user()->id)->where('status_id','=','3')->orderBy('updated_at','DESC')->get();
            return view('apotek.resep.racik',compact('transactions'));
        }
    }

    public function racikApi($token) { 
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	$transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','3')->orderBy('updated_at','DESC')->get();
	            $transaction_arr = array();
                foreach ($transactions as $trans) {
                    $temp = array(
                        'id'            => (string)$trans->id,
                        'doctor'        => $trans->dokter->name,
                        'drugstore'     => $trans->apotek->name,
                        'photo'         => $trans->photo,
                        'cost'          => $trans->cost,
                        'message'       => $trans->message,
                        'duration'      => $trans->duration,
                        'status'        => $trans->status->name
                    );
                    array_push($transaction_arr, $temp);
                }
                $res = array(
                        'status'        => 'success',
                        'transactions'  => $transaction_arr
                    );
                return json_encode($res);
	        }
	        $res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);
    	}    
        $res = array(
                'status'        => 'failed',
                'transactions'  => 'null'
            );
        return json_encode($res);
    }


    public function selesai($id) {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	if(Request::isMethod('get'))
        	{
	        	$transaction = Transaction::find($id);
	        	$id = Transaction::where('id',$id)->update(array(
					'status_id'		=> 4
				));
	            return redirect('apotek/racik');
        	}
        }
        return redirect('/');
    }

    public function selesaiApiWebView($id,$token) {     
        if ($user = User::where('remember_token',$token)->first()) {
            if($user->role_id == 4) {
                if(Request::isMethod('get'))
                {
                    $transaction = Transaction::find($id);
                    $trans = Transaction::where('id',$id)->update(array(
                        'status_id'     => 4
                    ));
                        $transaction = Transaction::find($id);
                        $harga = $transaction->cost;
                        $token_fcm = $transaction->user->token_fcm;

                        $this->alertpasien($token_fcm,"2","Resep sudah jadi!! Silahkan ambil sekarang.");

                    return redirect('webview/apotek/racik/'.$token);
                }
            }
        }   
    }


    public function selesaiApi($id,$token) { 
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	if(Request::isMethod('get'))
	        	{
		        	$transaction = Transaction::find($id);
		        	$update = Transaction::where('id',$id)->update(array(
						'status_id'		=> 4
					));
		            if ($update) {
			            $res = array(
		                        'status'        => 'success'
		                    );
		                return json_encode($res);
					}
					else
					{
						$res = array(
		                        'status'        => 'failed'
		                    );
		                return json_encode($res);
					}
	        	}
	        }
	        $res = array(
	                'status'        => 'failed'
	            );
	        return json_encode($res);
    	}    
        $res = array(
                'status'        => 'failed'
            );
        return json_encode($res);
    }


    public function bisaDiambil() {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	$transactions = Transaction::where('drugstore_id',Auth::user()->id)->where('status_id','=','4')->orderBy('updated_at','DESC')->get();
            return view('apotek.resep.selesai',compact('transactions'));
        }
        return redirect('/');
    }

    public function bisaDiambilApiWebView($token) {  
        if ($user = User::where('remember_token',$token)->first())   
        {
            if($user->role_id == 4) {
                $transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','4')->orderBy('updated_at','DESC')->get();
                return view('apotek.resep.selesaiWebView',compact('transactions'));
            }
        }
    }

    public function bisaDiambilApi($token) {     
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	$transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','4')->orderBy('updated_at','DESC')->get();
	            $transaction_arr = array();
                foreach ($transactions as $trans) {
                    $temp = array(
                        'id'            => (string)$trans->id,
                        'doctor'        => $trans->dokter->name,
                        'drugstore'     => $trans->apotek->name,
                        'photo'         => $trans->photo,
                        'cost'          => $trans->cost,
                        'message'       => $trans->message,
                        'duration'      => $trans->duration,
                        'status'        => $trans->status->name
                    );
                    array_push($transaction_arr, $temp);
                }
                $res = array(
                        'status'        => 'success',
                        'transactions'  => $transaction_arr
                    );
                return json_encode($res);
	        }
	        $res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);
    	}
        $res = array(
                'status'        => 'failed',
                'transactions'  => 'null'
            );
        return json_encode($res);
    }

    public function sudahDiambil($id) {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	if(Request::isMethod('get'))
        	{
	        	$transaction = Transaction::find($id);
	        	$id = Transaction::where('id',$id)->update(array(
					'status_id'		=> 5
				));
	            return redirect('apotek/selesai');
        	}
        }
        return redirect('/');
    }

    public function sudahDiambilApiWebView($id,$token) {
        if ($user = User::where('remember_token',$token)->first())
        {
            if($user->role_id == 4) {
                if(Request::isMethod('get'))
                {
                    $transaction = Transaction::find($id);
                    $id = Transaction::where('id',$id)->update(array(
                        'status_id'     => 5
                    ));
                    return redirect('webview/apotek/selesai/'.$token);
                }
            }
        }     
    }

    public function sudahDiambilApi($id,$token) {    
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	if(Request::isMethod('get'))
	        	{
		        	$transaction = Transaction::find($id);
		        	$update = Transaction::where('id',$id)->update(array(
						'status_id'		=> 5
					));
		            if ($update) {
			            $res = array(
		                        'status'        => 'success'
		                    );
		                return json_encode($res);
					}
					else
					{
						$res = array(
		                        'status'        => 'failed'
		                    );
		                return json_encode($res);
					}
	        	}
	        }
	        $res = array(
		            'status'        => 'failed'
		        );
		    return json_encode($res);
    	 } 
        $res = array(
	            'status'        => 'failed'
	        );
	    return json_encode($res);
    }


    public function takenList() {     
        if(Auth::check() && Auth::user()->role_id == 4) {
        	$transactions = Transaction::where('drugstore_id',Auth::user()->id)->where('status_id','=','5')->orderBy('updated_at','DESC')->get();
            return view('apotek.resep.taken',compact('transactions'));
        }
        return redirect('/');
    }

    public function takenListApiWebView($token) {   
        if ($user = User::where('remember_token',$token)->first())
        {   
            if($user->role_id == 4) {
                $transactions = Transaction::where('drugstore_id',$user->id)->where('status_id','=','5')->orderBy('updated_at','DESC')->get();
                return view('apotek.resep.takenWebView',compact('transactions'));
            }
        }
    }

    public function takenListApi($token) {  
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 4) {
	        	$transactions = Transaction::where('drugstore_id',$User->id)->where('status_id','=','5')->orderBy('updated_at','DESC')->get();
	            $transaction_arr = array();
                foreach ($transactions as $trans) {
                    $temp = array(
                        'id'            => (string)$trans->id,
                        'doctor'        => $trans->dokter->name,
                        'drugstore'     => $trans->apotek->name,
                        'photo'         => $trans->photo,
                        'cost'          => $trans->cost,
                        'message'       => $trans->message,
                        'duration'      => $trans->duration,
                        'status'        => $trans->status->name
                    );
                    array_push($transaction_arr, $temp);
                }
                $res = array(
                        'status'        => 'success',
                        'transactions'  => $transaction_arr
                    );
                return json_encode($res);
	        }
	        $res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);

    	}   
        $res = array(
                'status'        => 'failed',
                'transactions'  => 'null'
            );
        return json_encode($res);
    }
}
