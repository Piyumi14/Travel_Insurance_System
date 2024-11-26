<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('destination');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('medical_expenses')->default(false);
            $table->boolean('trip_cancellation')->default(false);
            $table->integer('number_of_travelers');
            $table->decimal('total_price', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
