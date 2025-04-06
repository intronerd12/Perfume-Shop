<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsDiscountNullable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('discount', 8, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->double('discount', 8, 2)->nullable(false)->change();
        });
    }
}