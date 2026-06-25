<?php

namespace App\Services;

use App\DTOs\Product\CreateProductDTO;
use App\DTOs\Product\UpdateProductDTO;
use App\Exceptions\BusinessException;
use App\Models\Product;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getAll(string $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->productRepository->getAll($categoryId, $perPage);
    }

    public function findOne(string $id): Product
    {
        return $this->productRepository->findOne($id);
    }

    public function new(CreateProductDTO $dto): Product
    {
        $this->categoryRepository->findOne($dto->category_id);

        $product = $this->productRepository->findByNameInCategory($dto->name, $dto->category_id);

        if ($product) {
            if ($product->trashed()) {
                $product->restore();

                return $product;
            }

            throw new BusinessException('Este produto já está cadastrado nesta categoria');
        }

        return $this->productRepository->new($dto);
    }

    public function update(string $id, UpdateProductDTO $dto): Product
    {
        return $this->productRepository->update($id, $dto);
    }

    public function delete(string $id): void
    {
        $this->productRepository->delete($id);
    }
}
