<?php

declare(strict_types=1);

namespace App\Graphql\Type;

use App\Entity\Product;
use App\Entity\Variant;
use Doctrine\ORM\EntityManagerInterface;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\SourceField;
use TheCodingMachine\GraphQLite\Annotations\Type;

#[Type(class: Product::class, name: 'Product')]
#[SourceField(name: 'id', outputType: 'ID')]
#[SourceField(name: 'reference')]
#[SourceField(name: 'name')]
#[SourceField(name: 'supplier')]
class ProductType
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @param Variant[] $prefetchedVariants
     * @return Variant[]
     */
    #[Field(prefetchMethod: "prefetchVariants")]
    public function getVariants(Product $product, $prefetchedVariants): array
    {
        $variants = [];

        foreach ($prefetchedVariants as $variant) {
            if ($variant->getProduct() === $product) {
                $variants[] = $variant;
            }
        }

        return $variants;
    }

    /**
     * @param Product[] $products
     * @return Variant[]
     */
    public function prefetchVariants(iterable $products): array
    {
        $productIds = array_map(function(Product $product) {
            return $product->getId();
        }, $products);


        return $this->em->getRepository(Variant::class)
            ->findByProductIds($productIds);
    }
}
