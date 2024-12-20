<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên người đặt
            $table->string('phone'); // Số điện thoại
            $table->date('date'); // Ngày khám
            $table->time('time'); // Giờ khám
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // Liên kết với bác sĩ
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); // Trạng thái
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
