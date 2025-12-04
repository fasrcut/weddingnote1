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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // 'create', 'update', 'delete'
            $table->string('target_name'); // ឈ្មោះភ្ញៀវដែលត្រូវបានកែ
            $table->text('details')->nullable(); // បរិយាយ (ឧ. ប្តូរលុយពី 10 ទៅ 20)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
