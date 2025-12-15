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
        Schema::table('device_repairs', function (Blueprint $table) {
            $table->unsignedBigInteger('device_report_id')->nullable()->after('device_id');
            $table->index('device_report_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_repairs', function (Blueprint $table) {
            $table->dropIndex(['device_report_id']);
            $table->dropColumn('device_report_id');
        });
    }
};
