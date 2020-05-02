<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 64)->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('album_category', function (Blueprint $table) {
            $table->id();
            $table->integer('album_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->unique(['album_id','category_id']);
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
        Schema::dropIfExists('album_categories');
    }
}
