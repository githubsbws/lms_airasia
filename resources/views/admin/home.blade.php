@extends('admin.layouts.mainlayout')

@section('title', __('admin/menuleft.home'))

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/menuleft.home') }}</li>
@endsection

@section('content')
    <p class="text-muted">หน้านี้ใช้ layout ฝั่ง Admin (AdminLTE v4 + Bootstrap 5) — สำหรับทดสอบ sidebar/header/footer</p>
@endsection
