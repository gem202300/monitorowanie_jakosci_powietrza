<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // автоматичний інкремент
            $table->string('name');
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('maintenance');
            $table->string('address');
            $table->float('longitude');
            $table->float('latitude');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
