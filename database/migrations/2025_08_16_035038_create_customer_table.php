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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->date('dob');
            $table->string('phone_number', 20);
            $table->string('email', 100)->unique();
            
            $table->unsignedBigInteger('nationality_id')->nullable()->index();

            // relasi ke nationality
            $table->foreign('nationality_id')
                  ->references('id')->on('nationality')
                  ->onUpdate('cascade')
                  ->nullOnDelete();

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
        Schema::dropIfExists('customer');
    }
};
