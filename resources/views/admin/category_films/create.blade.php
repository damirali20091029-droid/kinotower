@extends('admin.layouts.app')

@section('title', 'Добавление жанра к фильму: ' . $film->name)

@section('content')
    <div class="card card-primary">
        <form action="{{ route('admin.films.categories.store', $film) }}" method="POST">
            @csrf

            <div class="card-body">
                @if ($categories->isEmpty())
                    <p class="mb-0">Все существующие жанры уже добавлены к этому фильму.</p>
                @else
                    <div class="form-group">
                        <label for="category_id">Жанр</label>
                        <select name="category_id" id="category_id" required
                                class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">— выберите жанр —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
            </div>

            <div class="card-footer">
                @if ($categories->isNotEmpty())
                    <button type="submit" class="btn btn-primary">Добавить</button>
                @endif
                <a href="{{ route('admin.films.categories.index', $film) }}" class="btn btn-default">Назад</a>
            </div>
        </form>
    </div>
@endsection