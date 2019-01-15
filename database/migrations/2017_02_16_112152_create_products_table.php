<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('json');  //  !!!  D A   C A N C E L L A R E !!!
            $table->string('asin')->unique();
            $table->string('detailpageurl')->nullable();
            $table->string('largeimageurl')->nullable();
            $table->integer('largeimageheight')->nullable();
            $table->integer('largeimagewidth')->nullable();
            $table->string('title');
            $table->string('brand')->nullable();
            $table->mediumText('feature')->nullable();
            $table->string('color')->nullable();
            $table->mediumText('editorialreviewcontent')->nullable();
            $table->float('price', 8, 2)->nullable();  // 8 cifre totali di cui 2 decimali
            $table->float('lowestnewprice', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
