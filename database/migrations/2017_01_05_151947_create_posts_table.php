<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // posts table
        Schema::create('posts', function(Blueprint $table){
          $table->increments('id'); // table Id's
          $table -> integer('author_id')->unsigned()->default(1);
          $table->string('title')->unique()->nullable();
          $table->string('description')->nullable(); // for meta description
          $table->text('body')->nullable(); // our posts
          $table->string('slug')->unique();
          $table->string('images')->nullable();
          $table->boolean('active')->default(0);
          $table->timestamps();

          // FK
          $table->foreign('author_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop posts table
        Schema::dropIfExists('posts');
    }
}
