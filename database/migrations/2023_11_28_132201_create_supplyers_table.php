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
        Schema::create('supplyers', function (Blueprint $table) {
            $table->id();
            $table->string('supplyer_name');
            $table->string('supplyer_contact');
            $table->string('supplyer_type');
            $table->string('supplyer_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplyers');
    }
};
