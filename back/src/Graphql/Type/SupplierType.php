<?php

declare(strict_types=1);

namespace App\Graphql\Type;

use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\SourceField;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type(class: Supplier::class, name: 'Supplier')]
#[SourceField(name: 'id', outputType: 'ID')]
#[SourceField(name: 'code')]
#[SourceField(name: 'name')]
class SupplierType
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @param Product[] $prefetchedProducts
     * @return Product[]
     */
    #[Field(prefetchMethod: "prefetchProducts")]
    public function getProducts(Supplier $supplier, $prefetchedProducts): array
    {
        $products = [];

        foreach ($prefetchedProducts as $product) {
            if ($product->getSupplier() === $supplier) {
                $products[] = $product;
            }
        }

        return $products;
    }

    /**
     * @param Supplier[] $suppliers
     * @return Product[]
     */
    public function prefetchProducts(iterable $suppliers): array
    {
        $supplierIds = array_map(function(Supplier $supplier) {
            return $supplier->getId();
        }, $suppliers);


        return $this->em->getRepository(Product::class)
            ->findBySupplierIds($supplierIds);
    }
}
