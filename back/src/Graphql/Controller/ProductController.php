<?php

declare(strict_types=1);

namespace App\Graphql\Controller;

use App\Entity\Product;
use App\Graphql\Manager\ProductManager;
use TheCodingMachine\GraphQLite\Annotations\Autowire;
use TheCodingMachine\GraphQLite\Annotations\Mutation;

class ProductController
{
    #[Mutation]
    public function saveProduct(
        Product $product,
        #[Autowire]
        ProductManager $productManager,
    ): Product {
        $productManager->saveProduct($product);

        return $product;
    }
}
