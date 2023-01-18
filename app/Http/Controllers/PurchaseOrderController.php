<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseOrdersRequest;
use App\Models\PurchaseOrderDetails;
use App\Models\PurchaseOrders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseorders = DB::table('purchaseorders')
        ->join('vendors','vendors.vendorID','=','purchaseorders.vendorID')
        ->join('users','users.userID','=','purchaseorders.userID')
        ->get();
        return view('purchaseorders.index',compact('purchaseorders'));
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
        $newOrderID = DB::table('purchaseorders')
        ->orderBy('purchaseorderID', 'DESC')->first()->purchaseorderID + 1;

        return view('purchaseorders.create',compact('vendors','products', 'newOrderID'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PurchaseOrdersRequest $request)
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

        $input['vendorID'] = $request['vendorID'];
        $input['purchaseorderDate'] = $request['purchaseorderDate'];
        $input['total'] = $request['total'];
        $input['description'] = $request['description'];
        $input['userID'] = $user = session('user')[0]->userID;
        $order_id = PurchaseOrders::create($input)->id;

        $newOrderID = DB::table('purchaseorders')
            ->orderBy('purchaseorderID', 'DESC')->first()->purchaseorderID;

        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['purchaseorderID'] = $newOrderID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];
                $detail['price'] = $request['price'][$key];
                $detail['tax'] = $request['tax'][$key];
                $detail['subtotal'] = $request['subtotal'][$key];
                $detail['discount'] = $request['discount'][$key];
                $detail['amount'] = $request['amount'][$key];

                PurchaseOrderDetails::create($detail);
                $i++;

            }
        }
        if ($request->all()) {
            return redirect()->route('purchaseorders.index')->with('success', "Created new Purchase Order successfully!");
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
        $vendors = DB::table('vendors')->get();
        $products = DB::table('products')->get();
        $purchaseorders = DB::table('purchaseorders')

            ->join('vendors', 'vendors.vendorID', '=', 'purchaseorders.vendorID')
            ->join('users', 'users.userID', '=', 'purchaseorders.userID')
            ->where(['purchaseorders.purchaseorderID' => $id])
            ->first();

        $details = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('purchaseorders', 'purchaseorderdetails.purchaseorderID', '=', 'purchaseorders.purchaseorderID')
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')
            ->where(['purchaseorders.purchaseorderID' => $id])
            ->get();

        return view('purchaseorders.create', compact('vendors', 'products', 'purchaseorders', 'details'))
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
        $vendors = DB::table('vendors')->get();
        $products = DB::table('products')->get();
        $purchaseorders = DB::table('purchaseorders')
            ->join('vendors', 'vendors.vendorID', '=', 'purchaseorders.vendorID')
            ->join('users', 'users.userID', '=', 'purchaseorders.userID')
            ->where(['purchaseorders.purchaseorderID' => $id])
            ->first();

        $details = DB::table('purchaseorderdetails')
            ->select("*", "purchaseorderdetails.quantity as dquantity")
            ->join('purchaseorders', 'purchaseorderdetails.purchaseorderID', '=', 'purchaseorders.purchaseorderID')
            ->join('products', 'products.productID', '=', 'purchaseorderdetails.productID')
            ->where(['purchaseorders.purchaseorderID' => $id])
            ->get();

        return view('purchaseorders.create', compact('vendors', 'products', 'purchaseorders', 'details'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PurchaseOrdersRequest $request, $id)
    {
        //
        $input = $request->all();
        // dd($input);
        // dd($input["productID"]);

        $request->validate([
            'vendorID' => 'required|min:1',
            'productID' => 'required|array',
            'productID.*' => 'required',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        $so = PurchaseOrders::find($id);
        $so->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = PurchaseOrderDetails::where("purchaseorderID",$input['orderID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = PurchaseOrderDetails::where("purchaseorderID",$input['orderID'])->whereNotIn("purchaseorderdetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['purchaseorderID'] = $request['orderID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = PurchaseOrderDetails::where("purchaseorderID",$detail['purchaseorderID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                PurchaseOrderDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('purchaseorders.index')
            ->with('success', 'Purchase Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PurchaseOrderDetails::where('purchaseorderID', intval($id))->delete();
        DB::table('purchaseorders')->where('purchaseorderID', intval($id))->delete();
        return redirect()->route('purchaseorders.index')->with('success', "Delete Purchase Order successfully!");;
    }
}
