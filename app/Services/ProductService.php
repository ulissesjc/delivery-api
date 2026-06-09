<?php

namespace App\Services;

use App\DTOs\CreateProductDTO;
use App\DTOs\UpdateProductDTO;
use App\Exceptions\BusinessException;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function getAll(string $categoryId, int $perPage): LengthAwarePaginator
    {
        return $this->repository->getAll($categoryId, $perPage);
    }

    public function findOne(string $id): Product
    {
        return $this->repository->findOne($id);
    }

    public function new(CreateProductDTO $dto): Product
    {
        if ($this->repository->alreadyExistsInCategory($dto->name, $dto->category_id)) {
            throw new BusinessException('Este produto já está cadastrado nesta categoria');
        }

        return $this->repository->new($dto);
    }

    public function update(string $id, UpdateProductDTO $dto): Product
    {
        return $this->repository->update($id, $dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
