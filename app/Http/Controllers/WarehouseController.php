<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importIndex()
    {
        $import=DB::table('imports')
        // ->select('importID','vendorID','billID')
        ->join('bills','bills.billID','=','imports.billID')
        ->join('vendors','vendors.vendorID','=','imports.vendorID')
        // ->where(['something' => 'something', 'otherThing' => 'otherThing'])
        ->get();
        return view('imports.index')->with(['import'=>$import]);
    }

    public function exportIndex()
    {
        $exports=DB::table('exports')
        ->join('invoices','invoices.invoiceID','=','exports.invoiceID')
        ->join('customers','customers.customerID','=','exports.customerID')
        ->join('users','users.userID','=','exports.userID')
        // ->join('invoices','invoices.invoiceID','=','exports.invoiceID')
        ->get();
        return view('exports.index')->with(['exports'=>$exports]);
    }

    public function warehouse()
    {
        $warehouse=DB::table('products')->get();
        return view('warehouse.all-products')->with(['warehouse'=>$warehouse]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function importCreate(){
        $billdetail = DB::table('products')
        ->join('billdetails','billdetails.productID','=','products.productID')
        // ->where(['something' => 'something', 'otherThing' => 'otherThing'])
        ->get();
        foreach($billdetail as $bi ){
            $billID = $bi->billID;
        }

        $products = DB::table('products')->get();
        $joinbill=DB::table('bills')
        ->join('vendors','vendors.vendorID','=','bills.vendorID')
        ->join('billdetails','billdetails.billID','=','bills.billID')
        ->where('bills.billID',$billID)
        ->get();
        return view('warehouse.createimport',compact('joinbill','products'));
    }

    public function exportCreate(){
        $billdetail = DB::table('products')
        ->join('billdetails','billdetails.productID','=','products.productID')
        ->get();
        foreach($billdetail as $bi ){
            $billID = $bi->billID;
        }
        $products = DB::table('products')->get();
        $joinbill=DB::table('invoices')
        ->join('customers','customers.customerID','=','invoices.customerID')
        ->get();
        return view('exports.create',compact('joinbill','products'));
    }

}
