<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_products', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');
            $table->unsignedInteger('product_id');
             $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
             $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
 
            //SETTING THE PRIMARY KEYS
            $table->primary(['tag_id','product_id']);
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
        Schema::dropIfExists('tags_products');
    }
}
