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
            $table->increments('id')->unsigned()->index();
            $table->string('title')->index();;
            $table->text('body');
            $table->decimal('price')->index();;
            $table->decimal('old_price')->nullable();
            $table->integer('photo_id')->unsigned()->nullable()->index();
            $table->integer('quantity')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->dateTime('published_on')->useCurrent();
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
