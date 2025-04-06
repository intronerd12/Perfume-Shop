<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Support\Facades\DB;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    private $errors = [];

    public function model(array $row)
    {
        try {
            DB::beginTransaction();
            
            Log::info('Processing row:', $row); // Debug logging

            $product = new Product([
                'title' => $row['title'],
                'price' => $row['price'],
                'discount' => $row['discount'] ?? 0,
                'size' => $row['size'],
                'condition' => $row['condition'],
                'status' => $row['status'] ?? 'active',
                'stock' => $row['stock'] ?? 0,
                'brand_id' => $row['brand_id'],
                'cat_id' => $row['category_id'],
                'child_cat_id' => $row['sub_category_id'] ?? null,
                'is_featured' => $row['is_featured'] ?? 0,
                'description' => $row['description'] ?? '',
            ]);

            DB::commit();
            return $product;
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errors[] = "Error on row {$row['title']}: " . $e->getMessage();
            Log::error('Import error:', ['error' => $e->getMessage(), 'row' => $row]);
            return null;
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'size' => 'required|string',
            'condition' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
