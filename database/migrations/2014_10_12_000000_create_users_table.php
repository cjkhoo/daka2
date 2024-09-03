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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loc_id')->nullable()->comment('上班地點');
            $table->string('username')->unique()->comment('ID');
            $table->string('name')->comment('姓名');      
            $table->string('password')->comment('密碼');      
            $table->integer('user_level')->default(3)->comment('等級'); // 1: admin, 2: staff_in, 3: staff_out
            $table->boolean('is_delete')->default(false)->comment('是否删除');            
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
