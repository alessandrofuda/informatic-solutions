<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVaryColumnsToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('from_user_email')->default('');
            $table->string('from_user_ip')->default('');
            $table->string('from_user_url')->default('');
            $table->boolean('comment_approved')->default(0);  // 0 1
            $table->string('comment_agent')->default('');  // user agent
            $table->unsignedBigInteger('comment_parent')->default(0); //per commenti annidati
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['from_user_email','from_user_ip','from_user_url','comment_approved','comment_agent','comment_parent']);
        });
    }
}
