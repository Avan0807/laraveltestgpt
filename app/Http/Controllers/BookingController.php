<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor; // Model Doctor

class BookingController extends Controller
{
    public function bookdoctor()
    {
        // Lấy danh sách bác sĩ từ database
        $doctors = Doctor::all();

        // Render view và truyền danh sách bác sĩ
        return view('frontend.pages.bookdoctor', compact('doctors'));
    }

    public function store(Request $request)
    {
        // Xử lý lưu thông tin đặt khám
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'date' => 'required|date',
            'time' => 'required',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        // Thêm logic lưu dữ liệu vào database
        Booking::create($validated);

        return redirect()->route('bookdoctor')->with('success', 'Đặt khám thành công!');
    }
}
