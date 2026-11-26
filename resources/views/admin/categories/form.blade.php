@extends('admin.layouts.app')

@section('title', isset($category) ? 'Изменение жанра' : 'Добавление жанра')

@section('content')
    <div class="card card-primary">
        <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
              method="POST">
            @csrf
            @if (isset($category))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" name="name" id="name" maxlength="150"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $category->name ?? '') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="parent_id">Родительский жанр</label>
                    <select name="parent_id" id="parent_id"
                            class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">— без родителя —</option>
                        @foreach ($parents as $parent)
                            <option value="{{ $parent->id }}"
                                @selected(old('parent_id', $category->parent_id ?? null) == $parent->id)>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-default">Отмена</a>
            </div>
        </form>
    </div>
@endsection