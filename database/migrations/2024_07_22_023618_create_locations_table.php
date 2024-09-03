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
       Schema::create('locations', function (Blueprint $table) {
        $table->id();
       $table->string('loc_name')->comment('上班地點');
        $table->string('code')->comment('區號');
        $table->decimal('latitude', 10, 8)->comment('緯度');
        $table->decimal('longitude', 11, 8)->comment('經度');
        $table->date('start_date')->nullable()->comment('開始日期');
        $table->date('end_date')->nullable()->comment('結束日期');
        $table->boolean('is_delete')->default(false)->comment('是否删除');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
