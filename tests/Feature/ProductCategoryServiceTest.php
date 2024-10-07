<?php

namespace Tests\Feature;

use App\Helpers\UnitTestHelper;
use App\Models\ProductCategory;
use App\Services\ProductCategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

uses(RefreshDatabase::class);

it('lists product categories', function () {
    // Inisialisasi user dan login
    UnitTestHelper::initUserLogin();

    // Buat beberapa kategori produk
    ProductCategory::factory()->count(10)->create();

    // Panggil service untuk list dengan limit dan tanpa pencarian
    $limit = 5;
    $search = '';
    $response = (new ProductCategoryService())->listProductCategory($limit, $search);

    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('List product category');
});

it('lists product categories with search filter', function () {
    // Inisialisasi user dan login
    $user = UnitTestHelper::initUserLogin();

    // Buat store untuk user
    $store = $user->store; // Asumsikan ini sudah diinisialisasi dengan benar

    // Buat beberapa kategori produk, satu dengan kata kunci 'Electronics'
    ProductCategory::factory()->count(5)->create(['store_id' => $store->id]);
    ProductCategory::factory()->create(['name' => 'Electronics', 'store_id' => $store->id]);

    // Panggil service untuk list dengan pencarian 'lectro'
    $limit = 10;
    $search = 'lectro';
    $response = (new ProductCategoryService())->listProductCategory($limit, $search);
    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('List product category');
    expect($response[2]['product_categories'][0]['name'])->toBe('Electronics');
});


it('creates a product category', function () {
    // Factory untuk membuat user
    UnitTestHelper::initUserLogin();
    // Data untuk product category
    $categoryData = [
        'name' => 'Electronics',
        'is_active' => true,
    ];

    // Panggil service untuk create product category
    $response = (new ProductCategoryService())->createProductCategory($categoryData);

    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('Kategori berhasil tambahkan');
    expect(ProductCategory::where('name', 'Electronics')->exists())->toBeTrue();
});
it('updates a product category', function () {
    $user = UnitTestHelper::initUserLogin();

    // Buat store untuk user
    $store = $user->store; // Asumsikan ini sudah diinisialisasi dengan benar

    // Buat product category awal
    $existingCategory = ProductCategory::factory()->create([
        'name' => 'Old Name',
        'is_active' => true,
        'store_id' => $store->id, // Set store_id untuk product category
    ]);

    // Data untuk update
    $updateData = [
        'name' => 'New Name',
        'is_active' => 0,
    ];

    // Panggil service untuk update
    $response = (new ProductCategoryService())->updateProductCategory($updateData, $existingCategory->id);

    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('Kategori berhasil diperbaharui');

    $updatedCategory = ProductCategory::find($existingCategory->id);
    expect($updatedCategory->name)->toBe('New Name');
    expect($updatedCategory->is_active)->toBe(0);
});
it('deletes a product category', function () {
    $user = UnitTestHelper::initUserLogin();

    // Buat store untuk user
    $store = $user->store; // Asumsikan ini sudah diinisialisasi dengan benar

    // Buat product category dengan store_id yang sesuai
    $category = ProductCategory::factory()->create([
        'store_id' => $store->id, // Set store_id untuk product category
    ]);

    // Panggil service untuk delete
    $response = (new ProductCategoryService())->deleteProductCategory($category->id);

    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('Kategori berhasil dihapus');
    expect(ProductCategory::find($category->id))->toBeNull();
});

it('fetches product category details', function () {
    $user = UnitTestHelper::initUserLogin();

    // Buat store untuk user
    $store = $user->store; // Asumsikan ini sudah diinisialisasi dengan benar

    // Buat product category dengan store_id yang sesuai
    $category = ProductCategory::factory()->create([
        'store_id' => $store->id, // Set store_id untuk product category
    ]);

    // Panggil service untuk mendapatkan detail kategori produk
    $response = (new ProductCategoryService())->getDetailProductCategory($category->id);

    // Assertions
    expect($response[0])->toBe(true);
    expect($response[1])->toBe('Detail kategori');
    expect($response[2]['id'])->toBe($category->id);
    expect($response[2]['name'])->toBe($category->name);
    expect($response[2]['slug'])->toBe($category->slug);
    expect($response[2]['sequence'])->toBe($category->sequence);
    expect($response[2]['is_active'])->toBe($category->is_active == 1);
});

it('fails to fetch product category details if not found', function () {
    // Inisialisasi user dan login
    UnitTestHelper::initUserLogin();

    // Panggil service dengan id yang tidak ada
    $response = (new ProductCategoryService())->getDetailProductCategory(999);

    // Assertions
    expect($response[0])->toBe(false);
    expect($response[1])->toBe('Data tidak ditemukan');
});
