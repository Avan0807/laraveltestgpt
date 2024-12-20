<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // Tên bảng trong database (nếu không tuân theo quy tắc Laravel)
    protected $table = 'bookings';

    // Các cột có thể điền dữ liệu (mass assignment)
    protected $fillable = [
        'name',
        'phone',
        'date',
        'time',
        'doctor_id',
        'status',
    ];

    /**
     * Liên kết với Model Doctor (Many-to-One)
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }
    

}
