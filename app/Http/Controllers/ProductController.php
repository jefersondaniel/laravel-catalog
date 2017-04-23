<?php

namespace App\Http\Controllers;

use App\Product;
use App\CatalogImport;
use App\Services\CatalogImportService;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var CatalogImportService
     */
    public $catalogImportService;

    /**
     * @var ProductRepository
     */
    public $productRepository;

    /**
     * Creates a new controller instance
     *
     * @param CatalogImportService $catalogImportService
     * @return void
     */
    public function __construct(
        CatalogImportService $catalogImportService,
        ProductRepository $productRepository
    ) {
        $this->catalogImportService = $catalogImportService;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of products
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->paginate(5);
        return view('products/index', ['products' => $products]);
    }

    /**
     * Show the form for importing a catalog
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        return view('products/import');
    }

    /**
     * Process catalog file
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function processImport(Request $request)
    {
        $this->validate(
            $request,
            [
                'attachment' => 'file|required|spreadsheet'
            ]
        );
        $path = $request->attachment->store('uploads');
        $catalogImport = new CatalogImport(['attachment' => $path]);
        $this->catalogImportService->create($catalogImport);
        return view('products/import_status', ['catalogImport' => $catalogImport]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products/edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate(
            $request,
            [
                'name' => 'string|required',
                'category' => 'string|required',
                'free_shipping' => 'integer',
                'description' => 'string',
                'price' => 'numeric|required'
            ]
        );
        $product->fill($request->all());
        $this->productRepository->save($product);
        $request->session()->flash('status', __('app.product_updated'));
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);
    }
}
