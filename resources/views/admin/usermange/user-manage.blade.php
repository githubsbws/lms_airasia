@extends('admin.layouts.mainlayout')

@section('title', __('admin/menuleft.admin_user_manage'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">{{ __('admin/menuleft.home') }}</a></li>
    <li class="breadcrumb-item"><a href="#">{{ __('admin/menuleft.member_management') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('admin/menuleft.admin_user_manage') }}</li>
@endsection

@section('content')
@endsection