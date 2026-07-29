<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->integer('quantity')->default(1); // Add quantity with default 1
    });
}

    public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('quantity');
    });
}

};
