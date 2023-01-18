<?php

namespace App\Http\Controllers;

use App\Http\Requests\VendorsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ven=DB::table('vendors')->get();
            return view('vendors.index')->with(['ven'=>$ven]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VendorsRequest $request)
    {
        $vendorName = $request->input('vendorName');
        $taxNumber = $request->input('taxNumber');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $unpaid = $request->input('unpaid');
        $status = $request->input('status');
        $description = $request->input('description');

        DB::table('vendors')->insert([

            'vendorName' => $vendorName,
            'taxNumber' => $taxNumber,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'unpaid' => $unpaid,
            'status' => $status,
            'description' => $description
        ]);
        if($request->all()){
            return redirect()->route('vendors.index')->with('success',"Created vendor successfully!");
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ven = DB::table('vendors')
        ->where('vendorID', intval($id))
        ->first();
        return view('vendors.update',['ven'=>$ven]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VendorsRequest $request, $id)
    {
        $vendorName = $request->input('vendorName');
        $taxNumber = $request->input('taxNumber');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $unpaid = $request->input('unpaid');
        $status = $request->input('status');
        $description = $request->input('description');

        DB::table('vendors')
        ->where('vendorID', intval($id))
        ->update(['vendorName'=>$vendorName, 'taxNumber'=>$taxNumber, 'address'=>$address,'phone'=>$phone,'email'=>$email,'unpaid'=>$unpaid,'status'=>$status,'description'=>$description]);
        return redirect()->route('vendors.index')->with('success',"Updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('vendors')->where('vendorID', intval($id))->delete();
        return redirect()->route('vendors.index');
    }

    public function checkstatus($id)
    {
        $vendors = DB::table('vendors')
            ->where(['vendorID' => $id])
            ->first();
        DB::table('vendors')->where(['vendorID' => $id])
            ->update(['status' => !$vendors->status]);
        return redirect()->route('vendors.index')->with('success', "Change vendor's status successfully!");
    }
}
