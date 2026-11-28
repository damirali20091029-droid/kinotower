@extends('admin.layouts.app')

@section('title', isset($film) ? 'Изменение фильма' : 'Добавление фильма')

@section('content')
    @php
        $fields = [
            'name' => ['Название', 'text', true],
            'duration' => ['Длительность (мин)', 'number', true],
            'year_of_issue' => ['Год выпуска', 'number', true],
            'age' => ['Возрастное ограничение', 'number', true],
            'link_img' => ['Ссылка на постер', 'text', false],
            'link_kinopoisk' => ['Ссылка на Кинопоиск', 'text', false],
            'link_video' => ['Ссылка на видео', 'text', true],
        ];
    @endphp

    <div class="card card-primary">
        <form action="{{ isset($film) ? route('admin.films.update', $film) : route('admin.films.store') }}"
              method="POST">
            @csrf
            @if (isset($film))
                @method('PUT')
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="country_id">Страна</label>
                    <select name="country_id" id="country_id" required
                            class="form-control @error('country_id') is-invalid @enderror">
                        <option value="">— выберите страну —</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}"
                                @selected(old('country_id', $film->country_id ?? null) == $country->id)>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                @foreach ($fields as $field => [$label, $type, $required])
                    <div class="form-group">
                        <label for="{{ $field }}">{{ $label }}</label>
                        <input type="{{ $type }}" name="{{ $field }}" id="{{ $field }}"
                               class="form-control @error($field) is-invalid @enderror"
                               value="{{ old($field, $film->$field ?? '') }}" @required($required)>
                        @error($field)
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.films.index') }}" class="btn btn-default">Отмена</a>
            </div>
        </form>
    </div>
@endsection