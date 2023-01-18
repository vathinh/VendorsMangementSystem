<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReceivablesRequest;
use App\Models\ReceivableDetails;
use App\Models\Receivables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReceivablesController extends Controller
{
    public function index()
    {
        $rec = DB::table('receivables')
        ->join('customers','receivables.customerID','=','customers.customerID')
        ->join('users','receivables.userID','=','users.userID')
        ->get();
        return view('receivables.index',compact('rec'));
    }

    public function create()
    {
        $customers = DB::table('customers')->get();

        $invoices = DB::table('invoices')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->get();

        $newID = DB::table('receivables')
            ->orderBy('receivableID', 'DESC')->first()->receivableID + 1;

        return view('receivables.create',compact('customers','invoices','newID'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReceivablesRequest $request)
    {
        $request->validate([
            'customerID' => 'required|min:1',
        ]);

        $input = $request->all();
        $input['userID'] = $user = session('user')[0]->userID;

        Receivables::create($input);

        $newID = DB::table('receivables')
            ->orderBy('receivableID', 'DESC')->first()->receivableID;

        // dd($newID);
        if ($request->all()) {
            $i = 1;
            foreach ($request->input('invoiceID') as $key => $value) {
                if ($value == "0") {
                    continue;
                }
                $detail['receivableID'] = $newID;
                $detail['invoiceID'] = $value;
                $detail['notes'] = $request['notes'][$key];
                $detail['amount'] = $request['amount'][$key];

                ReceivableDetails::create($detail);
                $i++;

                // $stock = invoice::find($detail['invoice_id']);
                // $stock->invoice_stock = $stock->invoice_stock - $detail['sale_qty'];
                // $stock->save();
            }
        }
        if ($request->all()) {
            return redirect()->route('receivables.index')->with('success', "Created new Receivable successfully!");
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
        $invoices = DB::table('invoices')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->get();
        $receivables = DB::table('receivables')
            ->join('customers', 'customers.customerID', '=', 'receivables.customerID')
            ->join('users', 'users.userID', '=', 'receivables.userID')
            ->where(['receivables.receivableID' => $id])
            ->first();

        $details = DB::table('receivabledetails')
            ->join('receivables', 'receivabledetails.receivableID', '=', 'receivables.receivableID')
            ->join('invoices', 'invoices.invoiceID', '=', 'receivabledetails.invoiceID')
            ->where(['receivables.receivableID' => $id])
            ->get();
        return view('receivables.create', compact('customers', 'invoices', 'receivables', 'details'))
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
        $invoices = DB::table('invoices')
            ->join('customers', 'customers.customerID', '=', 'invoices.customerID')
            ->get();
        $receivables = DB::table('receivables')
            ->join('customers', 'customers.customerID', '=', 'receivables.customerID')
            ->join('users', 'users.userID', '=', 'receivables.userID')
            ->where(['receivables.receivableID' => $id])
            ->first();

        $details = DB::table('receivabledetails')
            ->join('receivables', 'receivabledetails.receivableID', '=', 'receivables.receivableID')
            ->join('invoices', 'invoices.invoiceID', '=', 'receivabledetails.invoiceID')
            ->where(['receivables.receivableID' => $id])
            ->get();

        return view('receivables.create', compact('customers', 'invoices', 'receivables', 'details'))
            ->with(['isUpdate' => 'Update']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReceivablesRequest $request, $id)
    {
        $input = $request->all();
        // dd($input);
        // dd($input["invoiceID"]);

        $so = Receivables::find($id);
        $so->update($input);

        $i = 1;
        $cntRow = count($input['invoiceID']);
        $oldDetails = ReceivableDetails::where("receivableID",$input['receivableID']);
        $cntOldDetails = $oldDetails->get()->count();
        $diffRow = $cntOldDetails - $cntRow;
        if($diffRow > 0){
            $oldDetails = ReceivableDetails::where("receivableID",$input['receivableID'])->whereNotIn("receivabledetailsID",$input['detailID'])->delete();
        }

        foreach ($request->input('invoiceID') as $key => $value) {
            if ($value == "0") {
                continue;
            }
            $detail['receivableID'] = $request['receivableID'];
            $detail['invoiceID'] = $value;
            $detail['quantity'] = $request['quantity'][$key];
            $detail['price'] = $request['price'][$key];
            $detail['tax'] = $request['tax'][$key];
            $detail['subtotal'] = $request['subtotal'][$key];
            $detail['discount'] = $request['discount'][$key];
            $detail['amount'] = $request['amount'][$key];

            // echo '<pre>' . var_export($detail, true) . '</pre>';
            $oldDetails = ReceivableDetails::where("receivableID",$detail['receivableID'])->get();
            if(isset($oldDetails[$key])){
                $oldDetails[$key]->update($detail);
            }else{
                ReceivableDetails::create($detail);
            }
            $i++;
        }

        return redirect()->route('receivables.index')
            ->with('success', 'Receivable updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReceivableDetails::where('receivableID', intval($id))->delete();
        DB::table('receivables')->where('receivableID', intval($id))->delete();
        return redirect()->route('receivables.index')->with('success', "Delete Receivable successfully!");
    }
}
