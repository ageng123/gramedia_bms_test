<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table("tabel_user", function(Blueprint $table){
           $table->index(["email", "created_by", "updated_by", "deleted_by","updated_at", "deleted_at"],"index_user");

        });
        Schema::table("tabel_buku", function(Blueprint $table){
            $table->index(["judul", "created_by", "updated_by", "deleted_by", "updated_at", "deleted_at"], "index_buku");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
