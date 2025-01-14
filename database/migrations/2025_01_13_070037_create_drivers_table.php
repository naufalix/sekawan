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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id');
            $table->foreign('office_id')->references('id')->on('offices')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->string('license_number');
            $table->string('phone');
            $table->timestamps();
            $table->string('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
