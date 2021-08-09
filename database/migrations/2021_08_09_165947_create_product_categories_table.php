<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    // MENJALANKAN MIGRATION
    public function up()
    {
        // SCHEMA TABLE
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->softDeletes(); // KARENA ADA DELETE_AT DI TABLE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // SEPERTI ROLLBACK
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
