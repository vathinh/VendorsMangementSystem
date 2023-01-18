<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Statistical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function checkLogin(Request $request){
        $userName = $request->input('txtname');
        $password = $request->input('txtpassword');
        $user =DB::table('users')->where(['userName'=>$userName])->first();
        if($user !=null && $user->password == $password){
            $request->session()->push("user",$user);
            switch($user->role){
                case("SA1"):
                case("LO1"):
                case("HR1"):
                case("AC1"):
                    return redirect()->route('home');
                break;
                case("SA2"):
                case("LO2"):
                case("HR2"):
                case("AC2"):
                    return redirect()->route('home');
                break;
            default:
            return redirect()->route('home');
            }
        }
        else{
            return view('login')->with(['message' => 'Invalid ID and Password']);
        }

    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        return redirect('login');
    }

    public function days_order(){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date' , 'ASC')->get();

        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data =  json_encode($chart_data);
    }
}
