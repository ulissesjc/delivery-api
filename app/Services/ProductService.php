<?php

namespace App\Services;

use App\DTOs\CreateProductDTO;
use App\DTOs\UpdateProductDTO;
use App\Exceptions\BusinessException;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
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

        if ($this->productRepository->alreadyExistsInCategory($dto->name, $dto->category_id)) {
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
