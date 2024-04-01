<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// xoa file hinh anh cũ
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Products - Online Store";
        $viewData["products"] = Product::all();
        return view('admin.product.index')->with("viewData", $viewData);
    }
    public function store(Request $request)
    {

        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|gt:0",
            'product_image' => 'image',
        ]);

        $creationData = $request->only(["name", "description", "price"]);
        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $new_image = current(explode('.', $get_name_image));

            $new_image = $new_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/product', $new_image);
            $creationData['image'] = $new_image;
            Product::create($creationData);

            return back();
        }

        $creationData['image'] = '';
        Product::create($creationData);

        Product::create($creationData);
        // $newProduct = new Product();
        // $newProduct->setName($request->input('name'));
        // $newProduct->setDescription($request->input('description'));
        // $newProduct->setPrice($request->input('price'));
        // $newProduct->setImage("game.png");



        // if ($request->hasFile('image')) {
        //     $imageName = $newProduct->getId().".".$request->file('image')->extension();
        //     Storage::disk('public')->put(
        //         $imageName,
        //         file_get_contents($request->file('image')->getRealPath())
        //     );
        //         $newProduct->setImage($imageName);
        //         $newProduct->save();
        //     }

        return back();
    }
    public function delete($id)
    {
        Product::destroy($id);
        return back();
    }

    public function edit($id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Product - Online Store";
        $viewData["product"] = Product::findOrFail($id);
        return view('admin.product.edit')->with("viewData", $viewData);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|gt:0",
            'product_image' => 'image',
        ]);
        $product = Product::findOrFail($id);
        $product->setName($request->input('name'));
        $product->setDescription($request->input('description'));
        $product->setPrice($request->input('price'));


        $get_image = $request->file('product_image');

        $image = '';

        if ($request->file('product_image') == null) {
            $image = Product::where('id', $id)->value('image');
        }

        if ($get_image) {

            // xóa hình ảnh cũ
            if ($product->image) {
                $oldImagePath = public_path('uploads/product/' . $product->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $get_name_image = $get_image->getClientOriginalName();
            $new_image = current(explode('.', $get_name_image));

            $new_image = $new_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/product', $new_image);
            $product->setImage($new_image);
            $product->save();
            return redirect()->route('admin.product.index');
        }

        $product->setImage($image);
        // if ($request->hasFile('image')) {
        //     $imageName = $product->getId() . "." . $request->file('image')->extension();
        //     Storage::disk('public')->put(
        //         $imageName,
        //         file_get_contents($request->file('image')->getRealPath())
        //     );
        //     $product->setImage($imageName);
        // }

        $product->save();
        return redirect()->route('admin.product.index');
    }
}
