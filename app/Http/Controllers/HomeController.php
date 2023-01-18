<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $receivable = DB::table('receivables')->sum('total');
        $payable = DB::table('payables')->sum('total');
        $invoice = DB::table('invoices')->sum('total');
        $bill = DB::table('bills')->sum('total');
        $unpaidrec = $invoice - $receivable;
        $unpaidpay = $bill - $payable;
        $profit = $invoice - $bill;
        $realprofit = $receivable - $payable;

        return view('home', compact('receivable', 'payable', 'invoice', 'unpaidrec', 'bill', 'unpaidpay', 'profit', 'realprofit'));
    }

}
