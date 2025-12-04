<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // ឈ្មោះ
            $table->decimal('amount', 10, 2); // លុយ
            $table->integer('guests_count')->default(1); // ចំនួនមនុស្ស
            $table->string('image_path')->nullable(); // រូបវិក័យបត្រ
            $table->text('description')->nullable(); // Note
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
