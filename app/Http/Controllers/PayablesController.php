<?php

namespace App\Http\Controllers;

use App\Http\Requests\PayablesRequest;
use App\Models\PayableDetails;
use App\Models\Payables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pay = DB::table('payables')
        ->join('vendors','payables.vendorID','=','vendors.vendorID')
        ->join('users','payables.userID','=','users.userID')
        ->get();
        return view('payables.index',compact('pay'));
        // $pay = DB::table('payables')->get();
        // return view('payables.index',compact('pay'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = DB::table('vendors')->get();

        $bills = DB::table('bills')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->get();

        $newID = DB::table('payables')
            ->orderBy('payableID', 'DESC')->first()->payableID + 1;

        return view('payables.create',compact('vendors','bills','newID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PayablesRequest $request)
    {
        // $request->validate([
        //     'vendorID' => 'required|min:1',
        // ]);

        $input = $request->all();
        $input['userID'] = $user = session('user')[0]->userID;

        Payables::create($input);

        $newID = DB::table('payables')
            ->orderBy('payableID', 'DESC')->first()->payableID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('billID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['payableID'] = $newID;
                $detail['billID'] = $value;
                $detail['notes'] = $request['notes'][$key];
                $detail['amount'] = $request['amount'][$key];

                PayableDetails::create($detail);
                $i++;

                // $stock = bill::find($detail['bill_id']);
                // $stock->bill_stock = $stock->bill_stock - $detail['sale_qty'];
                // $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('payables.index')->with('success', "Created new Payable successfully!");
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
        $bills = DB::table('bills')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->get();
        $payables = DB::table('payables')
            ->join('vendors', 'vendors.vendorID', '=', 'payables.vendorID')
            ->join('users', 'users.userID', '=', 'payables.userID')
            ->where(['payables.payableID' => $id])
            ->first();

        $details = DB::table('payabledetails')
            ->join('payables', 'payabledetails.payableID', '=', 'payables.payableID')
            ->join('bills', 'bills.billID', '=', 'payabledetails.billID')
            ->where(['payables.payableID' => $id])
            ->get();
        return view('payables.create', compact('vendors', 'bills', 'payables', 'details'))
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
        $bills = DB::table('bills')
            ->join('vendors', 'vendors.vendorID', '=', 'bills.vendorID')
            ->get();
        $payables = DB::table('payables')
            ->join('vendors', 'vendors.vendorID', '=', 'payables.vendorID')
            ->join('users', 'users.userID', '=', 'payables.userID')
            ->where(['payables.payableID' => $id])
            ->first();

        $details = DB::table('payabledetails')
            ->join('payables', 'payabledetails.payableID', '=', 'payables.payableID')
            ->join('bills', 'bills.billID', '=', 'payabledetails.billID')
            ->where(['payables.payableID' => $id])
            ->get();

        return view('payables.create', compact('vendors', 'bills', 'payables', 'details'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PayablesRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);
        // dd($input["billID"]);

        $so = Payables::find($id);
        $so->update($input);

        $i = 1;
        $cntRow = count($input['billID']);
        $oldDetails = PayableDetails::where("payableID",$input['payableID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = PayableDetails::where("payableID",$input['payableID'])->whereNotIn("payabledetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('billID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['payableID'] = $request['payableID'];
            $detail['billID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = PayableDetails::where("payableID",$detail['payableID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                PayableDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('payables.index')
            ->with('success', 'Payable updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PayableDetails::where('payableID', intval($id))->delete();
        DB::table('payables')->where('payableID', intval($id))->delete();
        return redirect()->route('payables.index')->with('success', "Delete Payable successfully!");
    }
}
