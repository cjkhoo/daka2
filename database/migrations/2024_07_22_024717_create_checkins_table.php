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

        Schema::create('check_ins', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // $table->foreignId('loc_id')->constrained('locations')->onDelete('cascade');

            $table->integer('user_id');                  
            $table->date('date')->comment('日期');
            $table->string('user_name')->comment('姓名');
            $table->integer('check_in_loc_id')->comment('上班地點ID');   
            $table->string('check_in_loc_name')->comment('上班地點');
            $table->string('check_in_loc_latlong')->comment('上班地點緯度經度');    
            $table->dateTime('check_in_time')->comment('登記時間');  
            $table->string('check_in_latlong')->comment('登記緯度經度');                      
            $table->decimal('check_in_distance', 8, 2)->comment('登記的距離工作地點');
            $table->integer('check_out_loc_id')->nullable()->comment('下班地點ID');   
            $table->string('check_out_loc_name')->nullable()->comment('下班地點');
            $table->string('check_out_loc_latlong')->nullable()->comment('下班地點緯度經度');
            $table->dateTime('check_out_time')->nullable()->comment('登出時間');
            $table->string('check_out_latlong')->nullable()->comment('登出緯度經度');
            $table->decimal('check_out_distance', 8, 2)->nullable()->comment('登出的距離工作地點');
            $table->boolean('is_delete')->default(false)->comment('是否删除');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_ins');
    }
};
