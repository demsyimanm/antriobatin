<?php

namespace App\Http\Controllers;
use Auth;
use Request;
use Input;
use Session;
use App\User;
use App\Transaction;
use App\History;

class DokterController extends Controller
{
	public function cek()
	{
		$message = "opo iku";
		$data = array
        (
            'status' 	=> $message,
            'title' 	=> "ALERT!!!",
            'body' 		=> 'Check & Reply',
        );
        $json=array(
            'data' 	=> $data,
            'to' 	=> "diU9qjMvV3U:APA91bGspbWWgmMesqGcwkiRsvTDVwnP-a6pX2Gou0zx4G1ZmKHUP7QB2xaLgmx8iSvJtH7MZEN2M9sYriMjxPSAFiEfyCcVg8awME-7117BaElprneix86_x7xU2b1iYWrgd8tc9_1r",
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
        echo $output;
	}
    public function home() {     
        if(Auth::check() && Auth::user()->role_id == 3) {
        	$transactions = Transaction::where('doctor_id',Auth::user()->id)->orderBy('id','DESC')->get();
            return view('dokter.resep.manage',compact('transactions'));
        }
        return redirect('/');
    }

    public function homeApi($token) {     
    	if ($user = User::where('remember_token',$token)->first()) {
	        if($user->role_id == 3) {
	        	$transactions = Transaction::where('doctor_id',Auth::user()->id)->orderBy('id','DESC')->get();
	            $transaction_arr = array();
                foreach ($transactions as $trans) {
                    $temp = array(
                        'id'            => $trans->id,
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

    public function homeRiwayat() {     
        if(Auth::check() && Auth::user()->role_id == 3) {
        	$histories = History::where('doctor_id',Auth::user()->id)->orderBy('id','DESC')->orderBy('user_id','DESC')->get();
            return view('dokter.riwayat.manage',compact('histories'));
        }
        return redirect('/');
    }

    public function homeRiwayatApi($token) {    
    	if(Request::isMethod('get'))
    	{
	        /*if(Auth::check() && Auth::user()->role_id == 3) {
	        	$drugstores = User::where('role_id',4)->get();
	            return view('dokter.resep.create',compact('drugstores'));
	        }*/
    	}
    	else
    	{
	    	if ($user = User::where('remember_token',$token)->first())
	    	{
		        if($user->role_id == 3) {
		        	$data = Input::all();
		        	$histories = History::where('user_id',$data['user_id'])->orderBy('id','DESC')->get();
		        	$history_arr = array();
	                foreach ($histories as $history) {
	                    $temp = array(
	                        'id'            	=> $history->id,
	                        'illness'        	=> $history->illness,
	                        'year'    			=> $history->year,
	                        'doctor_id'         => $history->doctor->nama,
	                        'description'       => $history->description
	                    );
	                    array_push($history_arr, $temp);
	                }
	                $res = array(
	                        'status'        => 'success',
	                        'histories'  	=> $history_arr
	                    );
	                return json_encode($res);
		        }
		        $res = array(
	                    'status'        => 'failed',
	                    'histories'  	=> 'null'
	                );
	            return json_encode($res);
	    	}
	    	$res = array(
                    'status'        => 'failed',
                    'histories'  	=> 'null'
                );
            return json_encode($res); 
    	}
    }

    public function create() {     
    	if(Request::isMethod('get'))
    	{
	        if(Auth::check() && Auth::user()->role_id == 3) {
	        	$drugstores = User::where('role_id',4)->get();
	            return view('dokter.resep.create',compact('drugstores'));
	        }
    	}
        else
        {
        	if(Auth::check() && Auth::user()->role_id == 3)
        	{
        		$data = Input::all();
        		$uploadOk = 1;
                $target_dir = "resep/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			    $check = getimagesize($_FILES["photo"]["tmp_name"]);
			    if($check !== false) 
			    {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } 
			    else 
			    {
			    	$uploadOk = 0;
			        Session::flash('status','not-image');
                	return redirect('dokter/resep');
			    }
			    if ($_FILES["photo"]["size"] > 1000000) {
				    $uploadOk = 0;
				    Session::flash('status','too-large');
                	return redirect('dokter/resep');
				}
			    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) 
			    {
			    	$uploadOk = 0;
				    Session::flash('status','wrong-format');
                	return redirect('dokter/resep');
				}
			    $id = Transaction::insertGetId(array(
					'user_id' 		=> $data['user'], 
					'doctor_id'		=> Auth::user()->id, 
					'drugstore_id' 	=> $data['drugstore'],
					'message'		=>$data['message'],
					'status_id'		=> 1
				));
				$target_dir = "resep/";
				$temp = explode(".", $_FILES["photo"]["name"]);
				$_FILES["photo"]["name"] =  $temp[0].'_'.$id.'.' . end($temp);
				$target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			    $check = getimagesize($_FILES["photo"]["tmp_name"]);
			    if($check !== false) 
			    {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } 
			    else 
			    {
			    	$uploadOk = 0;
			        Session::flash('status','not-image');
                	return redirect('dokter/resep');
			    }
			    if ($_FILES["photo"]["size"] > 1000000) {
				    echo "Sorry, your file is too large.";
				    $uploadOk = 0;
				    Session::flash('status','too-large');
                	return redirect('dokter/resep');
				}
			    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) 
			    {
			    	$uploadOk = 0;
				    Session::flash('status','wrong-format');
                	return redirect('dokter/resep');
				}
				if ($uploadOk == 0) 
				{
				   	Session::flash('status','failed-upload');
                	return redirect('dokter/resep');
				} 
				else 
				{
				    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) 
				    {
				        echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
				    } 
				    else 
				    {
				        Session::flash('status','failed-upload');
                		return redirect('dokter/resep');
				    }
				}

				$update = Transaction::where('id',$id)->update(array(
					'photo' 		=> 'resep/'. $_FILES["photo"]["name"],

				));
				if($id > 0 and $update != 0 && $uploadOk != 0)
				{
					Session::flash('status','success');
	                return redirect('dokter/resep');
				}
				else
				{
					Session::flash('status','failed');
	                return redirect('dokter/resep');
				}
        	}
        }
        return redirect('/');
    }

    public function createApi($token) {     
    	if(Request::isMethod('get'))
    	{
    		if ($user = User::where('remember_token',$token)->first()) {
		        if($user->role_id == 3) {
		        	$drugstores = User::where('role_id',4)->get();
		            $drugstores_arr = array();
	                foreach ($drugstores as $drug) {
	                    $temp = array(
	                        'id'            => $drug->id,
	                        'username'      => $drug->username,
	                        'name'     		=> $drug->name,
	                        'telp'         	=> $drug->telp,
	                        'nip'          	=> $drug->nip,
	                        'address'       => $drug->address,
	                    );
	                    array_push($drugstores_arr, $temp);
	                }
	                $res = array(
	                	'status'		=> 'success',
                        'drugstores'  	=> $drugstores_arr
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
        else
        {
        	if ($user = User::where('remember_token',$token)->first()) {
	        	if($user->role_id == 3)
	        	{
	        		$data = Input::all();
	        		$uploadOk = 1;
				    $id = Transaction::insertGetId(array(
						'user_id' 		=> $data['user'], 
						'doctor_id'		=> $user->id, 
						'drugstore_id' 	=> $data['drugstore'],
						'message'		=> $data['message'],
						'status_id'		=> 1,
						'photo' 		=> $data['photo']

					));
					if($id > 0)
					{
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
	        	$res = array(
	                'status'        => 'failed',
	            );
	        	return json_encode($res);
        	}
        	$res = array(
	                'status'        => 'failed',
	            );
	        return json_encode($res);
        }
        $res = array(
                'status'        => 'failed'
            );
        return json_encode($res);
    }

    public function createRiwayat() {     
    	if(Request::isMethod('get'))
    	{
	        if(Auth::check() && Auth::user()->role_id == 3) {
	            return view('dokter.riwayat.create');
	        }
    	}
        else
        {
        	if(Auth::check() && Auth::user()->role_id == 3)
        	{
        		$data = Input::all();
			    $id = History::insertGetId(array(
					'user_id' 		=> $data['user'], 
					'doctor_id'		=> Auth::user()->id, 
					'illness'	 	=> $data['illness'],
					'year'			=> $data['year'],
					'description'	=> $data['description']
				));
				if($id > 0)
				{
					Session::flash('status','success');
	                return redirect('dokter/riwayat');
				}
				else
				{
					Session::flash('status','failed');
	                return redirect('dokter/riwayat');
				}
        	}
        }
        return redirect('/');
    }

    public function createRiwayatApi($token) {     
    	if(Request::isMethod('get'))
    	{
	        /*if(Auth::check() && Auth::user()->role_id == 3) {
	            return view('dokter.riwayat.create');
	        }*/
    	}
        else
        {
        	if ($user = User::where('remember_token',$token)->first()) 
        	{
	        	if($user->role_id == 3)
	        	{
	        		$data = Input::all();
				    $id = History::insertGetId(array(
						'user_id' 		=> $data['user'], 
						'doctor_id'		=> $user->id, 
						'illness'	 	=> $data['illness'],
						'year'			=> $data['year'],
						'description'	=> $data['description']
					));
					if($id > 0)
					{
						$res = array(
				                'status'        => 'success'
				            );
				        return json_encode($res);
					}
					else
					{
						$res = array(
				                'status'        => 'create-failed'
				            );
				        return json_encode($res);
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
    }

    public function update($id)
    {
    	if (Request::isMethod('post')) {
            if (Auth::check()) {
                $data = Input::all();
                $date = date("Y-m-d H:i:s");
                if(!isset($data['photo']))
                {
                	$id = Transaction::where('id',$id)->update(array(
						'drugstore_id' 	=> $data['drugstore'],
						'message'		=>$data['message'],
						'status_id'		=> 1
					));
                	Session::flash('status','update-success');
	                return redirect('dokter/resep');

                }
                $transaction = Transaction::find($id);
				$filename = $transaction->photo;
				if (file_exists($filename)) {
				  unlink($filename);
				  echo 'File '.$filename.' has been deleted';
				} 
				else 
				{
				  echo 'Could not delete '.$filename.', file does not exist';
				}
				$target_dir = "resep/";
				$temp = explode(".", $_FILES["photo"]["name"]);
				$_FILES["photo"]["name"] =  $temp[0].'_'.$id.'.' . end($temp);
				$target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$uploadOk = 1;
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			    $check = getimagesize($_FILES["photo"]["tmp_name"]);
			    if($check !== false) 
			    {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } 
			    else 
			    {
			    	$uploadOk = 0;
			        Session::flash('status','not-image');
                	return redirect('dokter/resep');
			    }
			    if ($_FILES["photo"]["size"] > 1000000) {
				    echo "Sorry, your file is too large.";
				    $uploadOk = 0;
				    Session::flash('status','too-large');
                	return redirect('dokter/resep');
				}
			    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) 
			    {
			    	$uploadOk = 0;
				    Session::flash('status','wrong-format');
                	return redirect('dokter/resep');
				}
				if ($uploadOk == 0) 
				{
				   	Session::flash('status','failed-upload');
                	return redirect('dokter/resep');
				} 
				else 
				{
				    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) 
				    {
				        echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
				    } 
				    else 
				    {
				        Session::flash('status','failed-upload');
                		return redirect('dokter/resep');
				    }
				}

				$update = Transaction::where('id',$id)->update(array(
					'drugstore_id' 	=> $data['drugstore'],
					'message'		=>$data['message'],
					'status_id'		=> 1,
					'photo' 		=> 'resep/'. $_FILES["photo"]["name"],

				));
				if($update != 0 && $uploadOk != 0)
				{
					Session::flash('status','update-success');
	                return redirect('dokter/resep');
				}
				else
				{
					Session::flash('status','update-failed');
	                return redirect('dokter/resep');
				}
            }
        }
        else if (Request::isMethod('get')) {
            if (Auth::check()) {
            	$drugstores = User::where('role_id',4)->get();
            	$transaction = Transaction::find($id);
                return view('dokter.resep.update', compact('transaction','drugstores'));
            }
            return redirect('/');
        }
    }

    public function updateApi($id,$token)
    {
    	if (Request::isMethod('post')) {
    		if ($user = User::where('remember_token',$token)->first()) 
    		{
	            if ($user->role_id == 3) {
	                $data = Input::all();
	                $date = date("Y-m-d H:i:s");
	                $trans = Transaction::find($id);
		            if($trans->status_id == 1 or $trans->status_id == 2)
		            {
		                if(!isset($data['photo']))
		                {
		                	$id = Transaction::where('id',$id)->update(array(
								'drugstore_id' 	=> $data['drugstore'],
								'message'		=> $data['message'],
								'status_id'		=> 1
							));
		                	$res = array(
					                'status'        => 'update-success'
					            );
					        return json_encode($res);

		                }
		                $transaction = Transaction::find($id);
						$filename = $transaction->photo;
						if (file_exists($filename)) {
						  unlink($filename);
						  echo 'File '.$filename.' has been deleted';
						} 
						else 
						{
						  echo 'Could not delete '.$filename.', file does not exist';
						}
						$target_dir = "resep/";
						$temp = explode(".", $_FILES["photo"]["name"]);
						$_FILES["photo"]["name"] =  $temp[0].'_'.$id.'.' . end($temp);
						$target_file = $target_dir . basename($_FILES["photo"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
					    $check = getimagesize($_FILES["photo"]["tmp_name"]);
					    if($check !== false) 
					    {
					        echo "File is an image - " . $check["mime"] . ".";
					        $uploadOk = 1;
					    } 
					   else 
					    {
					    	$uploadOk = 0;
		                	$res = array(
					                'status'        => 'not-image'
					            );
					        return json_encode($res);
					    }
					    if ($_FILES["photo"]["size"] > 1000000) {
						    echo "Sorry, your file is too large.";
						    $uploadOk = 0;
		                	$res = array(
					                'status'        => 'too-large'
					            );
					        return json_encode($res);
						}
					    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) 
					    {
					    	$uploadOk = 0;
		                	$res = array(
					                'status'        => 'wrong-format'
					            );
					        return json_encode($res);
						}
						if ($uploadOk == 0) 
						{
						   	Session::flash('status','failed-upload');
		                	$res = array(
					                'status'        => 'failed-upload'
					            );
					        return json_encode($res);
						} 
						else 
						{
						    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) 
						    {
						        echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
						    } 
						    else 
						    {
			                	$res = array(
						                'status'        => 'failed-upload'
						            );
						        return json_encode($res);
						    }
						}

						$update = Transaction::where('id',$id)->update(array(
							'drugstore_id' 	=> $data['drugstore'],
							'message'		=> $data['message'],
							'status_id'		=> 1,
							'photo' 		=> 'resep/'. $_FILES["photo"]["name"],

						));
						if($id > 0 and $update != 0 && $uploadOk != 0)
						{
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
	            		 $res = array(
		                	'status'		=> 'expired',
	                        'drugstores'  	=> 'null',
	                        'transaction'	=> 'null'
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
    		$res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);
        }
        else if (Request::isMethod('get')) {
        	if ($user = User::where('remember_token',$token)->first()) {
	            if ($user->role_id == 3) {
	            	$drugstores = User::where('role_id',4)->get();
	            	$trans = Transaction::find($id);
	            	if($trans->status_id == 1 or $trans->status_id == 2)
	            	{
		                $drugstores_arr = array();
		                $transaction_arr = array();
		                foreach ($drugstores as $drug) {
		                    $temp = array(
		                        'id'            => (string)$drug->id,
		                        'username'      => $drug->username,
		                        'name'     		=> $drug->name,
		                        'telp'         	=> $drug->telp,
		                        'nip'          	=> $drug->nip,
		                        'address'       => $drug->address,
		                    );
		                    array_push($drugstores_arr, $temp);
		                }
		                $temp2 = array(
	                        'id'            => (string)$trans->id,
	                        'doctor'        => $trans->dokter->name,
	                        'drugstore'     => $trans->apotek->name,
	                        'photo'         => $trans->photo,
	                        'cost'          => $trans->cost,
	                        'message'       => $trans->message,
	                        'duration'      => $trans->duration,
	                        'status'        => $trans->status->name
	                    );
	                    array_push($transaction_arr, $temp2);
		                $res = array(
		                	'status'		=> 'success',
	                        'drugstores'  	=> $drugstores_arr,
	                        'transaction'	=> $transaction_arr
	                    );
	                	return json_encode($res);
	            	}
	            	else
	            	{
	            		 $res = array(
		                	'status'		=> 'expired',
	                        'drugstores'  	=> 'null',
	                        'transaction'	=> 'null'
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
            $res = array(
	                'status'        => 'failed',
	                'transactions'  => 'null'
	            );
	        return json_encode($res);
        }
    }

    public function updateRiwayat($id) {     
    	if(Request::isMethod('get'))
    	{
	        if(Auth::check() && Auth::user()->role_id == 3) {
	        	$history = History::find($id);
	            return view('dokter.riwayat.update', compact('history'));
	        }
    	}
        else
        {
        	if(Auth::check() && Auth::user()->role_id == 3)
        	{
        		$data = Input::all();
			    $id = History::where('id',$id)->update(array(
			    	'doctor_id'		=> Auth::user()->id,  
					'illness'	 	=> $data['illness'],
					'year'			=> $data['year'],
					'description'	=> $data['description']
				));
				if($id > 0)
				{
					Session::flash('status','success');
	                return redirect('dokter/riwayat');
				}
				else
				{
					Session::flash('status','failed');
	                return redirect('dokter/riwayat');
				}
        	}
        }
        return redirect('/');
    }

    public function updateRiwayatApi($id,$token) {     
    	if(Request::isMethod('get'))
    	{
    		if ($user = User::where('remember_token',$token)->first())
    		{
		        if($user->role_id == 3) {
		        	if ($history = History::find($id)) {
		        		$history_arr = array();
	                    $temp = array(
	                        'id'            	=> (string)$history->id,
	                        'illness'        	=> $history->illness,
	                        'year'    			=> $history->year,
	                        'doctor_id'         => $history->doctor->nama,
	                        'description'       => $history->description
	                    );
		                array_push($history_arr, $temp);
			            $res = array(
		                        'status'        => 'success',
		                        'histories'  	=> $history_arr
		                    );
		                return json_encode($res);
		        	}
		        	$res = array(
	                        'status'        => 'not-exist',
	                        'histories'  	=> 'null'
	                    );
	                return json_encode($res);
		        }
		        $res = array(
                        'status'        => 'not-exist',
                        'histories'  	=> 'null'
                    );
                return json_encode($res);
    		}
    		$res = array(
                    'status'        => 'not-exist',
                    'histories'  	=> 'null'
                );
            return json_encode($res);
    	}
        else
        {
        	if ($user = User::where('remember_token',$token)->first()) 
        	{
	        	if($user->role_id == 3)
	        	{
	        		$data = Input::all();
				    $update = History::where('id',$id)->update(array(
				    	'doctor_id'		=> $user->id,  
						'illness'	 	=> $data['illness'],
						'year'			=> $data['year'],
						'description'	=> $data['description']
					));
					if($update > 0)
					{
						$res = array(
		                        'status'        => 'success',
		                    );
		                return json_encode($res);
					}
					else
					{
						$res = array(
		                        'status'        => 'update-failed',
		                    );
		                return json_encode($res);
					}
	        	}
	        	$res = array(
	                    'status'        => 'failed',
	                );
	            return json_encode($res);
        	}
        	$res = array(
                    'status'        => 'failed',
                );
            return json_encode($res);
        }
    }

    public function destroy($id) {
		if(Auth::check() && Auth::user()->role_id == 3) {
			$transaction = Transaction::find($id);
			$filename = $transaction->photo;
			if (file_exists($filename)) {
			  unlink($filename);
			  echo 'File '.$filename.' has been deleted';
			} 
			else 
			{
			  echo 'Could not delete '.$filename.', file does not exist';
			}
			Transaction::where('id', $id)->delete();
			Session::flash('status','deleted');
			return redirect('dokter/resep');
		} 
		else {
			return redirect('/');
		}
	}

	public function destroyApi($id,$token) {
		if ($user = User::where('remember_token',$token)->first()) {
			if($user->role_id == 3) {
				if($transaction = Transaction::find($id))
				{
					if($transaction->status_id == 1 or $transaction->status_id == 2)
					{
						$filename = $transaction->photo;
						if (file_exists($filename)) {
						  unlink($filename);
						  echo 'File '.$filename.' has been deleted';
						} 
						else 
						{
						  echo 'Could not delete '.$filename.', file does not exist';
						}
						Transaction::where('id', $id)->delete();
						$res = array(
				                'status'        => 'deleted',
				            );
				        return json_encode($res);
					}
					$res = array(
			                'status'        => 'expired',
			            );
			        return json_encode($res);
				}
				else
				{
					$res = array(
			                'status'        => 'not-exist',
			            );
			        return json_encode($res);
				}
			} 
			$res = array(
	                'status'        => 'failed',
	            );
	        return json_encode($res);
		}
		else {
			$res = array(
	                'status'        => 'failed',
	            );
	        return json_encode($res);
		}
	}

	public function destroyRiwayat($id) {
		if(Auth::check() && Auth::user()->role_id == 3) {
			History::where('id', $id)->delete();
			Session::flash('status','deleted');
			return redirect('dokter/riwayat');
		} 
		else {
			return redirect('/');
		}
	}

	public function destroyRiwayatApi($id) {
		if ($user = User::where('remember_token',$token)->first())
		{
			if($user->role_id == 3) {
				if ($delete = History::where('id', $id)->delete()) {
					$res = array(
		                'status'        => 'deleted',
		            );
		        return json_encode($res);
				}
				$res = array(
		                'status'        => 'not-exist',
		            );
		        return json_encode($res);
			}
			$res = array(
	                'status'        => 'failed',
	            );
	        return json_encode($res); 
		}
		$res = array(
                'status'        => 'failed',
            );
        return json_encode($res);
	}
}
