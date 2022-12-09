<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();

        return view('product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:255'],
            'detail' => ['required', 'string'],
        ]);
   
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try { 
            Product::create([ 
                'name'      => $request->name,
                'detail'    => $request->detail
            ]);
        } catch (\Exception $e) {
            return back()->with(["status" => "failure", "message" => $e->getMessage()])->withInput();
        }
        return redirect()->route('product.index')->with(["status" => "success", "message" => "Product created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:255'],
            'detail' => ['required', 'string'],
        ]);
   
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try { 
            $product->update([ 
                'name'      => $request->name,
                'detail'    => $request->detail
            ]);
        } catch (\Exception $e) {
            return back()->with(["status" => "failure", "message" => $e->getMessage()])->withInput();
        }
        return redirect()->route('product.index')->with(["status" => "success", "message" => "Product updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with(["status" => "success", "message" => "Product deleted successfully"]);
    }
}
