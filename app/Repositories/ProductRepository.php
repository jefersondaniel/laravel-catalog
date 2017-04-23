<?php

namespace App\Repositories;

use App\Product;

class ProductRepository
{
    /**
     * Store a product, updating it if already exists
     *
     * @param Product $product
     * @return void
     */
    public function updateOrCreate(Product $product)
    {
        Product::updateOrCreate(
            ['lm' => $product->lm],
            $product->getAttributes()
        );
    }

    /**
     * Paginate products
     *
     * @param integer $limit
     * @return Collection|Product
     */
    public function paginate($limit)
    {
        return Product::paginate($limit);
    }

    /**
     * Delete a product
     *
     * @param Product $product
     * @return void
     */
    public function delete(Product $product)
    {
        $product->delete();
    }

    /**
     * Save a product
     *
     * @param Product $product
     * @return void
     */
    public function save(Product $product)
    {
        $product->save();
    }
}
