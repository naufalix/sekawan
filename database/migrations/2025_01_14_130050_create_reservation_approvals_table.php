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
        Schema::create('reservation_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id');
            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('approver_id');
            $table->foreign('approver_id')->references('id')->on('approvers')->onUpdate('cascade')->onDelete('cascade');
            $table->string('approval_level');
            $table->string('status');
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_approvals');
    }
};
