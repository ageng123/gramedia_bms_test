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
            $table->foreign("created_by")->references("id")->on("tabel_user");
            $table->foreign("updated_by")->references("id")->on("tabel_user");
            $table->foreign("deleted_by")->references("id")->on("tabel_user");

        });
        Schema::table("tabel_buku", function(Blueprint $table){
            $table->foreign("created_by")->references("id")->on("tabel_user");
            $table->foreign("updated_by")->references("id")->on("tabel_user");
            $table->foreign("deleted_by")->references("id")->on("tabel_user");
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
