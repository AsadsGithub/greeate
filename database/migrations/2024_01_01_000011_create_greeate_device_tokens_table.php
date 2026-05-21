<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('greeate_device_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('greeate_admins')->cascadeOnDelete();
            $table->string('token');
            $table->string('platform')->default('web');
            $table->json('topics')->nullable();
            $table->timestamps();
            $table->unique(['admin_id', 'token']);
        });
    }
    public function down(): void { Schema::dropIfExists('greeate_device_tokens'); }
};