<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();;
            $table->string('slug')->nullable();;
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            // $table->string('image')->nullable();
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->foreignUuid('category_id')->nullable()->references('id')->on('categories');
            $table->foreignUuid('sub_category_id')->nullable()->references('id')->on('sub_categories');
            $table->foreignUuid('brand_id')->nullable()->references('id')->on('brands');
            $table->enum('is_featured', ['Yes', 'No'])->default('No');       //enum
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->enum('track_qty', ['Yes', 'No'])->default('No');      //enum
            $table->integer('qty')->nullable()->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
