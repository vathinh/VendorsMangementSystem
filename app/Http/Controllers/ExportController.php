<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportsRequest;
use App\Models\ExportDetails;
use App\Models\Exports;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exports = DB::table('exports')
            ->join('invoices', 'invoices.invoiceID', '=', 'exports.invoiceID')
            ->join('customers', 'customers.customerID', '=', 'exports.customerID')
            ->join('users', 'users.userID', '=', 'exports.userID')
            ->get();
        return view('exports.index', compact('exports'));
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
        $newID = DB::table('exports')
            ->orderBy('exportID', 'DESC')->first()->exportID + 1;
        $invoices = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('invoices', 'invoicedetails.invoiceID', '=', 'invoices.invoiceID')
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->get();
        $invoicedetails = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')->get();
        foreach ($invoicedetails as $detail) {
            $invoiceProductID[] = $detail->productID;
            $invoiceProductName[] = $detail->productName;
            $invoiceQuantity[] = $detail->dquantity;
        }

        return view('exports.create', compact('customers', 'products', 'newID', 'invoices', 'invoiceProductID', 'invoiceProductName', 'invoiceQuantity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExportsRequest $request)
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
        foreach ($request->input('productID') as $key => $value) {
            $stock = Products::find($value);
            if ($stock->quantity - $input['quantity'][$key] <= 0) {
                return Redirect::back()->withErrors([$stock->productName. '\'s quantity is not enough!']);
            }
        }
        $input['userID'] = $user = session('user')[0]->userID;

        Exports::create($input);

        $newID = DB::table('exports')
            ->orderBy('exportID', 'DESC')->first()->exportID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['exportID'] = $newID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];

                ExportDetails::create($detail);
                $i++;

                $stock = Products::find($detail['productID']);
                $stock->quantity = $stock->quantity - $detail['quantity'];
                $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('exports.index')->with('success', "Created new Export successfully!");
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
        $exports = DB::table('exports')

            ->join('customers', 'customers.customerID', '=', 'exports.customerID')
            ->join('users', 'users.userID', '=', 'exports.userID')
            ->where(['exports.exportID' => $id])
            ->first();

        $details = DB::table('exportdetails')
            ->select("*", "exportdetails.quantity as dquantity")
            ->join('exports', 'exportdetails.exportID', '=', 'exports.exportID')
            ->join('products', 'products.productID', '=', 'exportdetails.productID')
            ->where(['exports.exportID' => $id])
            ->get();

        return view('exports.create', compact('customers', 'products', 'exports', 'details'))
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
        $exports = DB::table('exports')
            ->join('customers', 'customers.customerID', '=', 'exports.customerID')
            ->join('users', 'users.userID', '=', 'exports.userID')
            ->where(['exports.exportID' => $id])
            ->first();

        $details = DB::table('exportdetails')
            ->select("*", "exportdetails.quantity as dquantity")
            ->join('exports', 'exportdetails.exportID', '=', 'exports.exportID')
            ->join('products', 'products.productID', '=', 'exportdetails.productID')
            ->where(['exports.exportID' => $id])
            ->get();

        $invoices = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('invoices', 'invoicedetails.invoiceID', '=', 'invoices.invoiceID')
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->get();
        $invoicedetails = DB::table('invoicedetails')
            ->select("*", "invoicedetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'invoicedetails.productID')->get();

        foreach ($invoicedetails as $detail) {
            $invoiceProductID[] = $detail->productID;
            $invoiceProductName[] = $detail->productName;
            $invoiceQuantity[] = $detail->dquantity;
        }

        return view('exports.create', compact('customers', 'products', 'exports', 'details', 'invoices', 'invoiceProductID', 'invoiceProductName', 'invoiceQuantity'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExportsRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);
        // dd($input["productID"]);

        $invoice = Exports::find($id);
        $invoice->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = ExportDetails::where("exportID", $input['exportID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if ($diffRow > 0) {
            $oldDetails = ExportDetails::where("exportID", $input['exportID'])->whereNotIn("exportdetailsID", $input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['exportID'] = $request['exportID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = ExportDetails::where("exportID", $detail['exportID'])->get();
            if (isset($oldDetails[$key])) {
                $oldDetails[$key]->update($detail);
            } else {
                ExportDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('exports.index')
            ->with('success', 'Export updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExportDetails::where('exportID', intval($id))->delete();
        DB::table('exports')->where('exportID', intval($id))->delete();
        return redirect()->route('exports.index')->with('success', "Delete Export successfully!");
    }
}
