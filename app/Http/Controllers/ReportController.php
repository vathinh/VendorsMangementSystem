<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Statistical;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $income = DB::table('receivables')->sum('total');
        $expense = DB::table('payables')->sum('total');
        $profit = $income - $expense;
        $re = DB::table('tbl_statistical')->get();
        $rec = DB::table('receivables')->get();
        $pay = DB::table('payables')->get();

        $i = 1;

        while ($i <= 12) {
            $monthlyProfit[] = DB::table('tbl_statistical')->whereMonth('order_date', '=', $i)->whereYear('order_date', date("Y"))->sum('profit');
            $monthlyRev[] = DB::table('receivables')->whereMonth('receivableDate', '=', $i)->whereYear('receivableDate', date("Y"))->sum('total');
            $monthlyExp[] = DB::table('payables')->whereMonth('payableDate', '=', $i)->whereYear('payableDate', date("Y"))->sum('total');
            $i++;
        }

        return view('reports.index', compact('profit', 're', 'monthlyProfit', 'monthlyRev', 'monthlyExp')); //->with(['re'=>$re]);
    }

    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];

        $get = Statistical::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    //lọc doanh số theo 7 ngày , tháng này , tháng trước , 365 ngày
    public function dashboard_filter(Request $request)
    {
        $data = $request->all();

        // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();

        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();

        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();

        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == 'daily') {

            $get = Statistical::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'monthly') {

            $get = Statistical::whereBetween('order_date', [$dauthangtruoc, $cuoithangtruoc])->orderBy('order_date', 'ASC')->get();
        } elseif ($data['dashboard_value'] == 'quaterly') {

            $get = Statistical::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'ASC')->get();
        } else {

            $get = Statistical::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'ASC')->get();
        }

        foreach ($get as $key => $val) {
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    //hiện thị biểu đồ doanh số theo 30days lên trước
    public function days_order()
    {
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date', [$sub30days, $now])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
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
