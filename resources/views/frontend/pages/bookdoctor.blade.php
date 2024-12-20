@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Đặt khám</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('bookdoctor.submit') }}" method="POST">
    @csrf
        <div class="form-group">
            <label for="name">Họ và tên</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date">Ngày khám</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="time">Giờ khám</label>
            <input type="time" name="time" id="time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="doctor">Chọn bác sĩ</label>
            <select name="doctor_id" id="doctor" class="form-control" required>
                <option value="">-- Chọn bác sĩ --</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Đặt lịch</button>
    </form>

</div>
@endsection
