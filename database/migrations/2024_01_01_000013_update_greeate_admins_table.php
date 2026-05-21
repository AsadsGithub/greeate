<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('greeate_admins', function (Blueprint $table) {
            if (!Schema::hasColumn('greeate_admins', 'notification_settings')) {
                $table->json('notification_settings')->nullable()->after('two_factor_confirmed_at');
            }
            if (!Schema::hasColumn('greeate_admins', 'timezone')) {
                $table->string('timezone', 50)->default('UTC')->after('language');
            }
        });
    }
    public function down(): void {
        Schema::table('greeate_admins', function (Blueprint $table) {
            $table->dropColumn(['notification_settings']);
        });
    }
};