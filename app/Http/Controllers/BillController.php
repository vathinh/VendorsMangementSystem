<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillsRequest;
use App\Models\BillDetails;
use App\Models\Bills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bi=DB::table('bills')
        ->join('users','users.userID','=','bills.userID')
        ->join('vendors','vendors.vendorID','=','bills.vendorID')
        ->get();

        return view('bills.index')->with(['bi'=>$bi]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = DB::table('vendors')->get();
        $products = DB::table('products')->get();
        $newID = DB::table('bills')
            ->orderBy('billID', 'DESC')->first()->billID + 1;
        $pos = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('purchaseorders', 'purchaseorderdetails.purchaseorderID', '=', 'purchaseorders.purchaseorderID')
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')
            ->join('vendors', 'vendors.vendorID', '=', 'purchaseorders.vendorID')
            ->get();
        $podetails = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')->get();

        foreach ($podetails as $detail) {
            $poProductID[] = $detail->productID;
            $poProductName[] = $detail->productName;
            $poQuantity[] = $detail->dquantity;
            $poPrice[] = $detail->price;
            $poTax[] = $detail->tax;
            $poDiscount[] = $detail->discount;
        }
        return view('bills.create',compact('vendors','products','newID','pos','poProductID','poProductName','poQuantity','poPrice','poTax','poDiscount','podetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillsRequest $request)
    {
        // $request->validate([
        //     'vendorID' => 'required|min:1',
        //     'productID' => 'required|array',
        //     'productID.*' => 'required',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        // ]);


        $input = $request->all();
        $input['userID'] = $user = session('user')[0]->userID;

        Bills::create($input);

        $newID = DB::table('bills')
            ->orderBy('billID', 'DESC')->first()->billID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['billID'] = $newID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];
                $detail['price'] = $request['price'][$key];
                $detail['tax'] = $request['tax'][$key];
                $detail['subtotal'] = $request['subtotal'][$key];
                $detail['discount'] = $request['discount'][$key];
                $detail['amount'] = $request['amount'][$key];

                BillDetails::create($detail);
                $i++;

                // $stock = Product::find($detail['product_id']);
                // $stock->product_stock = $stock->product_stock - $detail['sale_qty'];
                // $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('bills.index')->with('success', "Created new Bill successfully!");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vendors = DB::table('vendors')->get();
        $products = DB::table('products')->get();
        $bills = DB::table('bills')

            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->join('users', 'users.userID', '=', 'bills.userID')
            ->where(['bills.billID' => $id])
            ->first();

        $details = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('bills', 'billdetails.billID', '=', 'bills.billID')
            ->join('products', 'products.productID', '=', 'billdetails.productID')
            ->where(['bills.billID' => $id])
            ->get();

        return view('bills.create', compact('vendors', 'products', 'bills', 'details'))
            ->with(['isUpdate' => 'Show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vendors = DB::table('vendors')->get();
        $products = DB::table('products')->get();
        $bills = DB::table('bills')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->join('users', 'users.userID', '=', 'bills.userID')
            ->where(['bills.billID' => $id])
            ->first();

        $details = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('bills', 'billdetails.billID', '=', 'bills.billID')
            ->join('products', 'products.productID', '=', 'billdetails.productID')
            ->where(['bills.billID' => $id])
            ->get();

        $pos = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('purchaseorders', 'purchaseorderdetails.purchaseorderID', '=', 'purchaseorders.purchaseorderID')
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')
            ->join('vendors', 'vendors.vendorID', '=', 'purchaseorders.vendorID')
            ->get();
        $podetails = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')->get();

        foreach ($podetails as $detail) {
            $poProductID[] = $detail->productID;
            $poProductName[] = $detail->productName;
            $poQuantity[] = $detail->dquantity;
            $poPrice[] = $detail->price;
            $poTax[] = $detail->tax;
            $poDiscount[] = $detail->discount;
        }

        return view('bills.create', compact('vendors', 'products', 'bills', 'details','pos','poProductID','poProductName','poQuantity','poPrice','poTax','poDiscount'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillsRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);
        // dd($input["productID"]);

        $bills = Bills::find($id);
        $bills->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = BillDetails::where("billID",$input['billID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = BillDetails::where("billID",$input['billID'])->whereNotIn("billdetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['billID'] = $request['billID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = BillDetails::where("billID",$detail['billID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                BillDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('bills.index')
            ->with('success', 'Bill updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        BillDetails::where('billID', intval($id))->delete();
        DB::table('bills')->where('billID', intval($id))->delete();
        return redirect()->route('bills.index')->with('success', "Delete Bill successfully!");
    }
}
