<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportsRequest;
use App\Models\ImportDetails;
use App\Models\Imports;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imports=DB::table('imports')
        ->join('bills','bills.billID','=','imports.billID')
        ->join('vendors','vendors.vendorID','=','imports.vendorID')
        ->join('users','users.userID','=','imports.userID')
        ->get();
        return view('imports.index',compact('imports'));
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
        $newID = DB::table('imports')
            ->orderBy('importID', 'DESC')->first()->importID + 1;
        $bills = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('bills', 'billdetails.billID', '=', 'bills.billID')
            ->join('products', 'products.productID', '=', 'billdetails.productID')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->get();
        $billdetails = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'billdetails.productID')->get();
        foreach ($billdetails as $detail) {
            $billProductID[] = $detail->productID;
            $billProductName[] = $detail->productName;
            $billQuantity[] = $detail->dquantity;

        }
        return view('imports.create',compact('vendors','products','newID','bills','billProductID','billProductName','billQuantity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImportsRequest $request)
    {
        $request->validate([
            'vendorID' => 'required|min:1',
            'productID' => 'required|array',
            'productID.*' => 'required',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
            'quantity' => 'required|array|min:1',
            'quantity.*' => 'required|numeric|min:1',
        ]);

        $input = $request->all();
        // dd($input);

        $input['userID'] = $user = session('user')[0]->userID;

        Imports::create($input);

        $newID = DB::table('imports')
            ->orderBy('importID', 'DESC')->first()->importID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('productID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['importID'] = $newID;
                $detail['productID'] = $value;
                $detail['quantity'] = $request['quantity'][$key];

                ImportDetails::create($detail);
                $i++;

                $stock = Products::find($detail['productID']);
                $stock->quantity = $stock->quantity + $detail['quantity'];
                $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('imports.index')->with('success', "Created new Import successfully!");
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
        $imports = DB::table('imports')

            ->join('vendors', 'vendors.vendorID', '=', 'imports.vendorID')
            ->join('users', 'users.userID', '=', 'imports.userID')
            ->where(['imports.importID' => $id])
            ->first();

        $details = DB::table('importdetails')
            ->select("*", "importdetails.quantity as dquantity")
            ->join('imports', 'importdetails.importID', '=', 'imports.importID')
            ->join('products', 'products.productID', '=', 'importdetails.productID')
            ->where(['imports.importID' => $id])
            ->get();

        return view('imports.create', compact('vendors', 'products', 'imports', 'details'))
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
        $imports = DB::table('imports')
            ->join('vendors', 'vendors.vendorID', '=', 'imports.vendorID')
            ->join('users', 'users.userID', '=', 'imports.userID')
            ->where(['imports.importID' => $id])
            ->first();

        $details = DB::table('importdetails')
            ->select("*", "importdetails.quantity as dquantity")
            ->join('imports', 'importdetails.importID', '=', 'imports.importID')
            ->join('products', 'products.productID', '=', 'importdetails.productID')
            ->where(['imports.importID' => $id])
            ->get();

        $bills = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('bills', 'billdetails.billID', '=', 'bills.billID')
            ->join('products', 'products.productID', '=', 'billdetails.productID')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->get();
        $billdetails = DB::table('billdetails')
            ->select("*", "billdetails.quantity as dquantity")
            ->join('products', 'products.productID', '=', 'billdetails.productID')->get();

        foreach ($billdetails as $detail) {
            $billProductID[] = $detail->productID;
            $billProductName[] = $detail->productName;
            $billQuantity[] = $detail->dquantity;
        }

        return view('imports.create', compact('vendors', 'products', 'imports', 'details','bills','billProductID','billProductName','billQuantity'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImportsRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);
        // dd($input["productID"]);

        $bill = Imports::find($id);
        $bill->update($input);

        $i = 1;
        $cntRow = count($input['productID']);
        $oldDetails = ImportDetails::where("importID",$input['importID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = ImportDetails::where("importID",$input['importID'])->whereNotIn("importdetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('productID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['importID'] = $request['importID'];
            $detail['productID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];

            // echo '<pre>' . var_import($detail, true) . '</pre>';
            $oldDetails = ImportDetails::where("importID",$detail['importID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                ImportDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('imports.index')
            ->with('success', 'Import updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ImportDetails::where('importID', intval($id))->delete();
        DB::table('imports')->where('importID', intval($id))->delete();
        return redirect()->route('imports.index')->with('success', "Delete Import successfully!");
    }
}
