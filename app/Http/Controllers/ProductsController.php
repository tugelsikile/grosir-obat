<?php

namespace App\Http\Controllers;

use App\Product;
use App\Medicine\PriceLabel;
use App\Medicine\Medicine;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->price_label = new PriceLabel();
        $this->medicine = new Medicine();
    }

    public function index(Request $request)
    {
        $products = $this->medicine->list();
        $label_harga = $this->price_label->list();

        $cari_label = $request->price_label;

        return view('products.index', ['products'=>$products,'label_harga'=>$label_harga,'cari_label'=>$cari_label]);
    }

    public function store(Request $request)
    {
        $newProduct = $request->validate([
            'name'         => 'required|max:20',
            'cash_price'   => 'required|numeric',
            'credit_price' => 'nullable|numeric',
            'unit_id'      => 'required|numeric|exists:product_units,id',
        ]);

        Product::create($newProduct);

        flash(trans('product.created'), 'success');

        return redirect()->route('products.index');
    }

    public function update(Request $request, Product $product)
    {
        $productData = $request->validate([
            'name'         => 'required|max:20',
            'cash_price'   => 'required|numeric',
            'credit_price' => 'nullable|numeric',
            'unit_id'      => 'required|numeric|exists:product_units,id',
        ]);

        $routeParam = $request->only('page', 'q');

        $product->update($productData);

        flash(trans('product.updated'), 'success');

        return redirect()->route('products.index', $routeParam);
    }

    public function destroy(Request $request, Product $product)
    {
        $requestData = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $routeParam = $request->only('page', 'q');

        if ($requestData['product_id'] == $product->id && $product->delete()) {
            flash(trans('product.deleted'), 'success');

            return redirect()->route('products.index', $routeParam);
        }

        flash(trans('product.undeleted'), 'error');

        return back();
    }

    public function priceList()
    {
        $products = Product::orderBy('name')->with('unit')->get();

        return view('products.price-list', compact('products'));

        // $pdf = \PDF::loadView('products.price-list', compact('products'));
        // return $pdf->stream('price-list.pdf');
    }
}
