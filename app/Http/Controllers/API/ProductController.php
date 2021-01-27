<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Product;
use Image;
use App\Http\Resources\ProductCollection;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return new ProductCollection(Product::orderBy('id','desc')->paginate(10));
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required | min:5 | max:20',
            'description' => 'required | min:20 max:500',
            'price' => 'required',
        ]);

        
        if($request->image){
           
            
        }

        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        if($request->image){
            /*If image file is not empty, save image with name*/
            $extention = explode('/',explode(':',explode(';',$request->image)[0])[1])[1];
            $image_name = rand().time().'.'.$extention;
            $upload_path = public_path('images/products/'.$image_name);
            $image = Image::make($request->image)->save($upload_path);
            $product->image = $image_name;
        }
        $product->save();

        return response()->json('success',200);
        
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product =  Product::find($id);
        return response()->json(['product'=>$product]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' => 'required | min:5 | max:20',
            'description' => 'required | min:20 max:500',
            'price' => 'required',
        ]);

        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;

        /*If new file added, remove the previous one from storate and save new one*/
        if(($request->image != '') && $request->image != $product->image){
            if($product->image != "" && file_exists(public_path('images/products/').$product->image)){
                unlink(public_path('images/products/').$product->image);
            }
            $extention = explode('/',explode(':',explode(';',$request->image)[0])[1])[1];
            $image_name = rand().time().'.'.$extention;
            $upload_path = public_path('images/products/'.$image_name);
            $image = Image::make($request->image)->save($upload_path);
            $product->image = $image_name;
        }
        $product->save();

        return response()->json('success',200);
    }


    /*Delete with the file*/
    public function destroy($id)
    {

        $product = Product::find($id);
        if($product->image != "" && file_exists(public_path('images/products/').$product->image)){
            unlink(public_path('images/products/').$product->image);
        }
        $product->delete();
    }
}
