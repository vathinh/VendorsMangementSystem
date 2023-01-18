<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoicesRequest;
use App\Models\InvoiceDetails;
use App\Models\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $in=DB::table('invoices')
        ->join('customers','customers.customerID','=','invoices.customerID')
        ->join('saleorders','saleorders.orderID','=','invoices.orderID')
        ->get();
        return view('invoices.index')->with(['in'=>$in]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $newID = DB::table('invoices')
            ->orderBy('invoiceID', 'DESC')->first();
        if($newID==null)
            $newID = 1;
        else
            $newID = $newID->invoiceID + 1;

        $sos = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('saleorders', 'saleorderdetails.orderID', '=', 'saleorders.orderID')
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')
            ->join('customers', 'customers.customerID', '=', 'saleorders.customerID')
            ->get();
        $sodetails = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')->get();
        foreach ($sodetails as $detail) {
            $soProductID[] = $detail->productID;
            $soProductName[] = $detail->productName;
            $soQuantity[] = $detail->dquantity;
            $soPrice[] = $detail->price;
            $soTax[] = $detail->tax;
            $soDiscount[] = $detail->discount;
        }
        return view('invoices.create',compact('customers','products','newID','sos','soProductID','soProductName','soQuantity','soPrice','soTax','soDiscount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InvoicesRequest $request)
    {
        // $request->validate([
        //     'customerID' => 'required|min:1',
        //     'productID' => 'required|array',
        //     'productID.*' => 'required',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        // ]);

        $input = $request->all();
        $input['userID'] = $user = session('user')[0]->userID;

        Invoices::create($input);

        $newID = DB::table('invoices')
            ->orderBy('invoiceID', 'DESC')->first()->invoiceID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['invoiceID'] = $newID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];
                $detail['price'] = $request['price'][$key];
                $detail['tax'] = $request['tax'][$key];
                $detail['subtotal'] = $request['subtotal'][$key];
                $detail['discount'] = $request['discount'][$key];
                $detail['amount'] = $request['amount'][$key];

                InvoiceDetails::create($detail);
                $i++;

                // $stock = Product::find($detail['product_id']);
                // $stock->product_stock = $stock->product_stock - $detail['sale_qty'];
                // $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('invoices.index')->with('success', "Created new Invoice successfully!");
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
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $invoices = DB::table('invoices')

            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->join('users', 'users.userID', '=', 'invoices.userID')
            ->where(['invoices.invoiceID' => $id])
            ->first();

        $details = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('invoices', 'invoicedetails.invoiceID', '=', 'invoices.invoiceID')
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')
            ->where(['invoices.invoiceID' => $id])
            ->get();

        return view('invoices.create', compact('customers', 'products', 'invoices', 'details'))
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
        $customers = DB::table('customers')->get();
        $products = DB::table('products')->get();
        $invoices = DB::table('invoices')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->join('users', 'users.userID', '=', 'invoices.userID')
            ->where(['invoices.invoiceID' => $id])
            ->first();

        $details = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('invoices', 'invoicedetails.invoiceID', '=', 'invoices.invoiceID')
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')
            ->where(['invoices.invoiceID' => $id])
            ->get();

        $sos = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('saleorders', 'saleorderdetails.orderID', '=', 'saleorders.orderID')
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')
            ->join('customers', 'customers.customerID', '=', 'saleorders.customerID')
            ->get();
        $sodetails = DB::table('saleorderdetails')
            ->select("*", "saleorderdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'saleorderdetails.productID')->get();

        foreach ($sodetails as $detail) {
            $soProductID[] = $detail->productID;
            $soProductName[] = $detail->productName;
            $soQuantity[] = $detail->dquantity;
            $soPrice[] = $detail->price;
            $soTax[] = $detail->tax;
            $soDiscount[] = $detail->discount;
        }

        return view('invoices.create', compact('customers', 'products', 'invoices', 'details','sos','soProductID','soProductName','soQuantity','soPrice','soTax','soDiscount'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InvoicesRequest $request, $id)
    {
        // $request->validate([
        //     'customerID' => 'required|min:1',
        //     'productID' => 'required|array',
        //     'productID.*' => 'required',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        //     'quantity' => 'required|array|min:1',
        //     'quantity.*' => 'required|numeric|min:1',
        // ]);
        $input = $request->all();
        // dd($input);
        // dd($input["productID"]);

        $so = Invoices::find($id);
        $so->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = InvoiceDetails::where("invoiceID",$input['invoiceID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = InvoiceDetails::where("invoiceID",$input['invoiceID'])->whereNotIn("invoicedetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['invoiceID'] = $request['invoiceID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = InvoiceDetails::where("invoiceID",$detail['invoiceID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                InvoiceDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InvoiceDetails::where('invoiceID', intval($id))->delete();
        DB::table('invoices')->where('invoiceID', intval($id))->delete();
        return redirect()->route('invoices.index')->with('success', "Delete Invoice successfully!");
    }
}
