<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $records = Product::paginate(10);

        return Inertia::render('Products/Index', ['records' => $records]);
    }

    public function create()
    {
        return Inertia::render('Products/Create');
    }

    public function store(ProductRequest $request)
    {

        $record = new Product($request->all());
        $record->save();

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $record = Product::find($id);

        return Inertia::render('Products/Edit', ['record' => $record]);
    }

    public function update(ProductRequest $request, $id)
    {
        $record = Product::find($id);
        $record->update($request->all());

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $record = Product::find($id);
        $record->delete();

        return redirect()->back();
    }
}
