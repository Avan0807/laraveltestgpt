<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    // Nếu bạn muốn xác định chính xác bảng (không cần thiết 
    // nếu bảng tên mặc định là 'doctors', vì Laravel sẽ suy ra từ tên model)
    // protected $table = 'doctors';

    // Đặt cột khóa chính (nếu khác 'id')
    // protected $primaryKey = 'id';

    // Chỉ định các cột cho phép "mass assignment"
    protected $fillable = [
        'name',
        'specialty',
        'email',
        'phone',
        'address',
        'status',
    ];

    
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'doctor_id');
    }
    // Nếu cần kiểu enum, có thể viết accessor/mutator 
    // hoặc cast (trong Laravel 9+):
    // protected $casts = [
    //     'status' => StatusEnum::class, // tự định nghĩa Enum
    // ];
}
