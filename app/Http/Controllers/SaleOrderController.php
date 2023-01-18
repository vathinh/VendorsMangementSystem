<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleOrdersRequest;
use App\Models\SaleOrderDetails;
use App\Models\SaleOrders;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\Environment\Console;

date_default_timezone_set("Asia/Bangkok");
class SaleOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleorders = DB::table('saleorders')
            ->join('customers', 'customers.customerID', '=', 'saleorders.customerID')
            ->join('users', 'users.userID', '=', 'saleorders.userID')
            // ->where(['something' => 'something', 'otherThing' => 'otherThing'])
            ->get();

        return view('saleorders.index', compact('saleorders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $user = Session::get('user')[0];
        // $user = $request->session()->get('user');
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $newOrderID = DB::table('saleorders')
            ->orderBy('orderID', 'DESC')->first()->orderID + 1;

        return view('saleorders.create', compact('customers', 'products', 'newOrderID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaleOrdersRequest $request)
    {
        // dd($request->all());

        // $request->validate([
        //     'customerID' => 'min:1',
        //     'productID' => 'required|array',
        //     'productID.*' => 'required',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        // ]);

        $input['customerID'] = $request['customerID'];
        $input['saleorderDate'] = $request['saleorderDate'];
        $input['total'] = $request['total'];
        $input['description'] = $request['description'];
        $input['userID'] = $user = session('user')[0]->userID;
        $order_id = SaleOrders::create($input)->id;

        $newOrderID = DB::table('saleorders')
            ->orderBy('orderID', 'DESC')->first()->orderID;

        // dd($newOrderID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['orderID'] = $newOrderID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];
                $detail['price'] = $request['price'][$key];
                $detail['tax'] = $request['tax'][$key];
                $detail['subtotal'] = $request['subtotal'][$key];
                $detail['discount'] = $request['discount'][$key];
                $detail['amount'] = $request['amount'][$key];

                SaleOrderDetails::create($detail);
                $i++;

            }
        }
        if ($request->all()) {
            return redirect()->route('saleorders.index')->with('success', "Created new Sale Order successfully!");
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
        //
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $saleorders = DB::table('saleorders')

            ->join('customers', 'customers.customerID', '=', 'saleorders.customerID')
            ->join('users', 'users.userID', '=', 'saleorders.userID')
            ->where(['saleorders.orderID' => $id])
            ->first();

        $details = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('saleorders', 'saleorderdetails.orderID', '=', 'saleorders.orderID')
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')
            ->where(['saleorders.orderID' => $id])
            ->get();

        return view('saleorders.create', compact('customers', 'products', 'saleorders', 'details'))
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
        //
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $saleorders = DB::table('saleorders')
            ->join('customers', 'customers.customerID', '=', 'saleorders.customerID')
            ->join('users', 'users.userID', '=', 'saleorders.userID')
            ->where(['saleorders.orderID' => $id])
            ->first();

        $details = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('saleorders', 'saleorderdetails.orderID', '=', 'saleorders.orderID')
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')
            ->where(['saleorders.orderID' => $id])
            ->get();

        return view('saleorders.create', compact('customers', 'products', 'saleorders', 'details'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleOrdersRequest $request, $id)
    {
        //
        $input = $request->all();
        $request->validate([
            'customerID' => 'required|min:1',
            'productID' => 'required|array',
            'productID.*' => 'required',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
        ]);
        $so = SaleOrders::find($id);
        $so->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = SaleOrderDetails::where("orderID",$input['orderID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = SaleOrderDetails::where("orderID",$input['orderID'])->whereNotIn("saleorderdetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['orderID'] = $request['orderID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            $oldDetails = SaleOrderDetails::where("orderID",$detail['orderID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                SaleOrderDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('saleorders.index')
            ->with('success', 'Sale Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SaleOrderDetails::where('orderID', intval($id))->delete();
        DB::table('saleorders')->where('orderID', intval($id))->delete();
        return redirect()->route('saleorders.index')->with('success', "Delete Sale Order successfully!");
    }
}
