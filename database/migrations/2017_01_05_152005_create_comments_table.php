<?php 

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // comments table
        Schema::create('comments', function(Blueprint $table){
          $table->increments('id');
          $table->integer('on_post')->unsigned()->default(0);
          $table->foreign('on_post')
                ->references('id')->on('posts')
                ->onDelete('cascade');
          $table->integer('from_user')->unsigned()->default(0);
          $table->text('body'); // our comments
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
        Schema::dropIfExists('comments');
    }
}
