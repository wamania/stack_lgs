<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\Supplier;
use App\Entity\Variant;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:fixtures:generate',
    description: 'Generate fixtures',
)]
class FixturesGenerateCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $productNames = [
            'Tshirt',
            'Basket',
            'Montre',
            'Stylo',
        ];

        $colors = [
            'red',
            'blue',
            'yellow',
            'black',
            'white',
            'pruple'
        ];

        $suppliers = [];
        for ($i = 0; $i < 10; ++$i) {
            $code = sprintf('S%d', $i);
            $suppliers[$code] = (new Supplier())
                ->setCode($code)
                ->setName(sprintf('Supplier %d', $i));
        }

        $products = [];
        for ($i = 0; $i < 100; ++$i) {
            $ref = sprintf('Product%d', $i);
            $products[$ref] = (new Product())
                ->setReference($ref)
                ->setName($productNames[array_rand($productNames)])
                ->setSupplier($suppliers[array_rand($suppliers)]);
        }

        $variants = [];
        for ($i = 0; $i < 300; ++$i) {
            $sku = sprintf('AAA%d%d', substr((string) time(), -6), $i);
            $variants[$sku] = (new Variant())
                ->setCreatedAt(new \DateTimeImmutable())
                ->setSku($sku)
                ->setColor($colors[array_rand($colors)])
                ->setPrice(rand(100, 10000)/100)
                ->setProduct($products[array_rand($products)]);
        }

        // YAML
        $tabProducts = [];
        /** @var Product $product */
        foreach ($products as $product) {
            $tabProducts[$product->getReference()] = [
                'reference' => $product->getReference(),
                'name' => $product->getName(),
                'supplier' => sprintf('@%s', $product->getSupplier()->getCode())
            ];
        }

        $tabVariants = [];
        /** @var Variant $variant */
        foreach ($variants as $variant) {
            $tabVariants[$variant->getSku()] = [
                'sku' => $variant->getSku(),
                'color' => $variant->getColor(),
                'price' => $variant->getPrice(),
                'createdAt' => sprintf('<(new \DateTimeImmutable("%s"))>', $variant->getCreatedAt()->format('Y-m-d H:i:s')),
                'product' => sprintf('@%s', $variant->getProduct()->getReference()),
            ];
        }

        $tabSuppliers = [];
        /** @var Supplier $supplier */
        foreach ($suppliers as $supplier) {
            $tabSuppliers[$supplier->getCode()] = [
                'code' => $supplier->getCode(),
                'name' => $supplier->getName(),
            ];
        }

        $yaml = \Symfony\Component\Yaml\Yaml::dump([
            'App\Entity\Supplier' => $tabSuppliers,
            'App\Entity\Product' => $tabProducts,
            'App\Entity\Variant' => $tabVariants,
        ]);

        file_put_contents('fixtures/fixtures.yaml', $yaml);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
