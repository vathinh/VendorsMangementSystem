<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pro=DB::table('products')->get();
        return view('products.index')->with(['pro'=>$pro]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        $data = array();
        $newid = DB::table('products')->orderby('productID','DESC')->first()->productID+1;
        $data['productName'] = $request->input('productName');
        $data['manufacture'] = $request->input('manufacture');
        $data['salesprice'] = $request->input('salesprice');
        $data['purchaseprice'] = $request->input('purchaseprice');
        $data['quantity'] = $request->input('quantity');
        $data['category'] = $request->input('category');
        $data['status'] = $request->input('status');
        $data['picture'] = $request->input('picture');
        $get_image = $request->file('picture');
        if($get_image){
            // $get_image->getClientOriginalName();
            $get_name_picture = 'product'.$newid.'.jpg';
            // $name_picture = current(explode('.',$get_name_picture));
            // $new_picture = $name_picture . rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $data['picture'] = $get_name_picture;
            $get_image->move('img/product/',$get_name_picture);



        }
        DB::table('products')->insert(
            $data
        );
        if($request->all()){
            return redirect()->route('products.index')->with('success',"Created product successfully!");
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
        $pro = DB::table('products')
        ->where('productID', intval($id))
        ->first();
        return view('products.update',['pro'=>$pro]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        $data = array();

        $data['productName'] = $request->input('productName');
        $data['manufacture'] = $request->input('manufacture');
        $data['salesprice'] = $request->input('salesprice');
        $data['purchaseprice'] = $request->input('purchaseprice');
        $data['quantity'] = $request->input('quantity');
        $data['category'] = $request->input('category');
        $data['status'] = $request->input('status');
        $get_image = $request->file('picture');
        if($get_image){
            $get_name_picture = 'product'.$id.'.jpg';
            $data['picture'] = $get_name_picture;
            $get_image->move('img/product/',$get_name_picture);



        }
        DB::table('products')->where('productID', intval($id))->update(
            $data
        );
        if($request->all()){
            return redirect()->route('products.index')->with('success',"Update product successfully!");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('products')->where('productID', intval($id))->delete();
        return redirect()->route('products.index')->with('success',"Delete product successfully!");
    }
}
