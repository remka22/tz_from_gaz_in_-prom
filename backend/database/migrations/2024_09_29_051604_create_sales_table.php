<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // ID товара
            $table->unsignedBigInteger('user_id');    // ID пользователя, который совершил покупку
            $table->integer('quantity');              // Количество купленных товаров
            $table->decimal('total_price', 10, 2);    // Общая цена покупки
            $table->timestamp('sale_date')->useCurrent(); // Дата и время покупки
            $table->timestamps();

            // Внешние ключи
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
