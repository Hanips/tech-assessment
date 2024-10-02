<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = Product::where('status', 'active')->get();
        return view('landingpage', compact('products'));
    }

    public function productList()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('products.detail', compact('product'));
    }

    public function create()
    {
        $ar_status = Product::getStatusOptions();
        return view('products.form', compact('ar_status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'photo' => 'required|image',
            'status' => 'required',
        ]);

        if(!empty($request->photo)){
            $fileName = 'product_'.$request->id.'.'.$request->photo->extension();
            $request->photo->move(public_path('img'),$fileName);
        }
        else{
            $fileName = '';
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'photo' => $fileName,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $ar_status = Product::getStatusOptions();
        return view('products.form_edit', compact('product', 'ar_status'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required',
        ]);

        $namaFileFotoLama = $product->photo;

        // Cek apakah user mengunggah foto baru
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($namaFileFotoLama && file_exists(public_path('img/'.$namaFileFotoLama))) {
                unlink(public_path('img/'.$namaFileFotoLama));
            }

            $fileName = 'buku_'.$product->id.'.'.$request->photo->extension();
            $request->photo->move(public_path('img'), $fileName);

            $product->photo = $fileName;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'url_buku' => $request->url_buku,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }


    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }
}
