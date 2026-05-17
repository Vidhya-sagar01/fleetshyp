<?php

namespace App\Http\Controllers;

use App\Models\ProductCatelog;
use Illuminate\Http\Request;

class ProductCatelogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('seller.tools.productcatelog');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCatelog $productCatelog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCatelog $productCatelog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCatelog $productCatelog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCatelog $productCatelog)
    {
        //
    }
}