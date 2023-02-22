<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('admin.index',compact('products'));

    }

    public function deleteproduct(Request $request, Product $product) {

        $product_id = $request -> product_id;
        $message = $product->deleteproduct($product_id);
        $products = Product::all();
        return view('admin.index',compact('message','products'));

    }

    public function addproduct(Request $request) {
        return view('admin.add');
    }

    public function createproduct(Request $request){
        // サムネイル画像保存
        $path = public_path('img');
        $upload_dir = $path . '/';
        $thumbnail_file = $_FILES['thumbnail'];
        $thumbnail_filename = basename($thumbnail_file['name']);
        $tmp_path = $thumbnail_file['tmp_name'];
        $thumbnail_file_err = $thumbnail_file['error'];
        $thumbnail_filesize = $thumbnail_file['size'];
        $save_thumbnail_filename = date('YmdHis') . $thumbnail_filename;
        move_uploaded_file($tmp_path, $upload_dir . $save_thumbnail_filename);

        // 詳細画像保存
        $detail_file = $_FILES['detail'];
        $detail_filename = basename($thumbnail_file['name']);
        $tmp_path = $detail_file['tmp_name'];
        $detail_file_err = $detail_file['error'];
        $detail_filesize = $detail_file['size'];
        $save_detail_filename = date('YmdHis') . $detail_filename;
        move_uploaded_file($tmp_path, $upload_dir . $save_detail_filename);

        //postの値を取得
        $name=$_POST['name'];
        $description=$_POST['description'];
        $quantity=$_POST['quantity'];
        $price=$_POST['price'];

        Product::insert([
            'version'=>1,
            'name'=>$name,
            'description'=>$description,
            'thumbnail'=>$save_thumbnail_filename,
            'image1'=>$save_detail_filename,
            'quantity'=>$quantity,
            'price'=>$price,
            'stock'=>0,
            'is_active'=>0
        ]);
        return view('admin.add');
    }

    public function updateproduct($productid,Request $request){
        // サムネイル画像保存
        $path = public_path('img');
        $upload_dir = $path . '/';
        $thumbnail_file = $_FILES['thumbnail'];
        $thumbnail_filename = basename($thumbnail_file['name']);
        $tmp_path = $thumbnail_file['tmp_name'];
        $thumbnail_file_err = $thumbnail_file['error'];
        $thumbnail_filesize = $thumbnail_file['size'];
        $save_thumbnail_filename = date('YmdHis') . $thumbnail_filename;
        move_uploaded_file($tmp_path, $upload_dir . $save_thumbnail_filename);

        // 詳細画像保存
        $detail_file = $_FILES['detail'];
        $detail_filename = basename($thumbnail_file['name']);
        $tmp_path = $detail_file['tmp_name'];
        $detail_file_err = $detail_file['error'];
        $detail_filesize = $detail_file['size'];
        $save_detail_filename = date('YmdHis') . $detail_filename;
        move_uploaded_file($tmp_path, $upload_dir . $save_detail_filename);

        //postの値を取得
        $name=$_POST['name'];
        $description=$_POST['description'];
        $quantity=$_POST['quantity'];
        $price=$_POST['price'];
        $stock=$_POST['stock'];

        Product::where('id',$productid)->update([
            'version'=>1,
            'name'=>$name,
            'description'=>$description,
            'thumbnail'=>$save_thumbnail_filename,
            'image1'=>$save_detail_filename,
            'quantity'=>$quantity,
            'price'=>$price,
            'stock'=>$stock,
            'is_active'=>0
        ]);

        $products = Product::all();
        return view('admin.index',compact('products'));
    }
 }
