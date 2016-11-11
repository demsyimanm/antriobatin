<?php
namespace App\Http\Controllers;
use Auth;
use Request;
use Input;
use Session;
use App\User;
use App\Transaction;
use App\History;

class PasienController extends Controller
{
    public function home() {     
        if(Auth::check() && Auth::user()->role_id == 2) {
        	$transactions = Transaction::where('user_id',Auth::user()->id)->where('status_id','!=','5')->orderBy('id','DESC')->get();
            return view('pasien.resep.manage',compact('transactions'));
        }
        return redirect('/');
    }

    public function finished() {     
        if(Auth::check() && Auth::user()->role_id == 2) {
        	$transactions = Transaction::where('user_id',Auth::user()->id)->where('status_id','=','5')->orderBy('id','DESC')->get();
            return view('pasien.resep.finished',compact('transactions'));
        }
        return redirect('/');
    }

    public function history() {     
        if(Auth::check() && Auth::user()->role_id == 2) {
            $histories = History::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
            return view('pasien.resep.history',compact('histories'));
        }
        return redirect('/');
    }

    public function homeApi($token) {     
        
        if($user = User::where('remember_token',$token)->first()) {
            if ( $user->role_id == 2) {
                $transactions = Transaction::where('user_id',$user->id)->orderBy('id','DESC')->get();
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

    public function homeApibyId($id,$token) {     
        
        if($user = User::where('remember_token',$token)->first()) {
            if ( $user->role_id == 2) {
                $transactions = Transaction::where('id',$id)->get();
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

    public function finsihedApi($token) {     
        
        if($user = User::where('remember_token',$token)->first() ) {
            if ($user->role_id == 2) {
                $transactions = Transaction::where('user_id',$user->id)->where('status_id','=','5')->orderBy('id','DESC')->get();
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

    public function historyApi($token) {     
        if ($user = User::where('remember_token',$token)->first()) {
            if($user->role_id == 2) {
                $histories = History::where('user_id',$user->id)->orderBy('id','DESC')->get();
                $history_arr = array();
                    foreach ($histories as $history) {
                        $temp = array(
                            'id'                => (string)$history->id,
                            'illness'           => $history->illness,
                            'year'              => $history->year,
                            'doctor_id'         => $history->dokter->name,
                            'description'       => $history->description
                        );
                        array_push($history_arr, $temp);
                    }
                    $res = array(
                            'status'        => 'success',
                            'histories'     => $history_arr
                        );
                    return json_encode($res);
            }
            $res = array(
                    'status'        => 'failed',
                    'histories'     => 'null'
                );
            return json_encode($res);
        }
        $res = array(
                'status'        => 'failed',
                'histories'     => 'null'
            );
        return json_encode($res);
    }

    public function historyByIdApi($id,$token) {     
        if ($user = User::where('remember_token',$token)->first()) {
            if($user->role_id == 2 or $user->role_id == 3) {
                $histories = History::where('id',$id)->get();
                $history_arr = array();
                    foreach ($histories as $history) {
                        $temp = array(
                            'id'                => (string)$history->id,
                            'illness'           => $history->illness,
                            'year'              => $history->year,
                            'doctor_id'         => $history->dokter->name,
                            'description'       => $history->description
                        );
                        array_push($history_arr, $temp);
                    }
                    $res = array(
                            'status'        => 'success',
                            'histories'     => $history_arr
                        );
                    return json_encode($res);
            }
            $res = array(
                    'status'        => 'failed',
                    'histories'     => 'null'
                );
            return json_encode($res);
        }
        $res = array(
                'status'        => 'failed',
                'histories'     => 'null'
            );
        return json_encode($res);
    }
}
