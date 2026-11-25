@extends('admin.layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="card">
        <div class="card-body">
            Добро пожаловать, {{ auth('admin')->user()->name }}!
        </div>
    </div>
@endsection