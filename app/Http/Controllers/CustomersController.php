<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class CustomersController extends Controller
{

    public function index()
    {
        $customers = DB::table('customers')->get();
        return view('customers.index')->with([
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return view('customers.create')->with(['customers' => '']);;
    }
    public function store(CustomersRequest $request)
    {
        $name = $request->input('txtname');
        $tax = $request->input('txttax');
        $address = $request->input('txtaddress');
        $phone = $request->input('txtphone');
        $email = $request->input('txtemail');
        $status = $request->input('status');
        $unpaid = $request->input('unpaid');
        $description = $request->input('txtdescription');
        DB::table('customers')->insert([
            'customerName' => $name,
            'taxNumber' => $tax,
            'address' => $address,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
            'unpaid' => $unpaid,
            'status' => $status,
            'description' => $description
        ]);
        return redirect()->route('customers.index')->with('success', "Create customer successfully!");
    }
    public function edit($id)
    {
        $customers = DB::table('customers')
            ->where(['customerID' => $id])
            ->first();
        return view('customers.update', ['customers' => $customers]);
    }
    public function update(CustomersRequest $request, $id)
    {
        $name = $request->input('txtname');
        $tax = $request->input('txttax');
        $address = $request->input('txtaddress');
        $phone = $request->input('txtphone');
        $email = $request->input('txtemail');
        $status = $request->input('status');
        $unpaid = $request->input('unpaid');
        $description = $request->input('txtdescription');
        $customers = DB::table('customers')
            ->where('customerID', intval($id))
            ->update([
                'customerName' => $name,
                'taxNumber' => $tax,
                'address' => $address,
                'phone' => $phone,
                'email' => $email,
                'status' => $status,
                'unpaid' => $unpaid,
                'status' => $status,
                'description' => $description
            ]);
        return redirect()->route('customers.index')->with('success', "Update customer successfully!");
    }
    public function destroy($id)
    {
        DB::table('customers')
            ->where('customerID', intval($id))
            ->delete();
        return redirect()->route('customers.index')->with('success', "Delete customer successfully!");
    }
    public function checkstatus($id)
    {
        $customer = DB::table('customers')
            ->where(['customerID' => $id])
            ->first();
        DB::table('customers')->where(['customerID' => $id])
            ->update(['status' => !$customer->status]);
        return redirect()->route('customers.index')->with('success', "Change customer's status successfully!");
    }
}
