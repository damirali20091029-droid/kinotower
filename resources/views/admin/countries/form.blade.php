@extends('admin.layouts.app')

@section('title', isset($country) ? 'Изменение страны' : 'Добавление страны')

@section('content')
    <div class="card card-primary">
        <form action="{{ isset($country) ? route('admin.countries.update', $country) : route('admin.countries.store') }}"
              method="POST">
            @csrf
            @if (isset($country))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" name="name" id="name" maxlength="50"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $country->name ?? '') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.countries.index') }}" class="btn btn-default">Отмена</a>
            </div>
        </form>
    </div>
@endsection