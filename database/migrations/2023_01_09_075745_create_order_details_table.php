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
        Schema::create('order_details', function (Blueprint $table) {
            // $table->unsignedBigInteger('order_id');
            // $table->unsignedBigInteger('product_id');
            $table->foreignId('order_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->integer('unit_price');
            $table->integer('quantity');
            $table->float('discount');
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
        Schema::dropIfExists('order_details');
        $table->dropForeign('order_details_order_id_foreign');
        $table->dropColumn('order_id');
        $table->dropForeign('order_details_product_id_foreign');
        $table->dropColumn('product_id');
    }
};
