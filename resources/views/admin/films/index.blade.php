@extends('admin.layouts.app')

@section('title', 'Фильмы')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.films.create') }}" class="btn btn-primary mb-2">
                <i class="fas fa-plus"></i> Добавить фильм
            </a>

            <form method="GET" action="{{ route('admin.films.index') }}" class="form-inline">
                <select name="country_id" class="form-control mr-2 mb-2">
                    <option value="">Все страны</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected(request('country_id') == $country->id)>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>

                <select name="category_id" class="form-control mr-2 mb-2">
                    <option value="">Все жанры</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="btn btn-secondary mr-2 mb-2">Применить</button>
                <a href="{{ route('admin.films.index') }}" class="btn btn-default mb-2">Сбросить</a>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Название</th>
                        <th>Страна</th>
                        <th>Жанры</th>
                        <th>Год</th>
                        <th>Мин.</th>
                        <th>Возраст</th>
                        <th style="width: 380px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($films as $film)
                        <tr>
                            <td>{{ $film->id }}</td>
                            <td>{{ $film->name }}</td>
                            <td>{{ $film->country->name ?? '—' }}</td>
                            <td>{{ $film->categories->pluck('name')->join(', ') ?: '—' }}</td>
                            <td>{{ $film->year_of_issue }}</td>
                            <td>{{ $film->duration }}</td>
                            <td>{{ $film->age }}+</td>
                            <td>
                                <a href="{{ route('admin.films.categories.index', $film) }}"
                                   class="btn btn-sm btn-secondary">Жанры</a>
                                <a href="{{ route('admin.reviews.index', ['film_id' => $film->id]) }}"
                                   class="btn btn-sm btn-warning">Отзывы</a>
                                <a href="{{ route('admin.ratings.index', ['film_id' => $film->id]) }}"
                                   class="btn btn-sm btn-warning">Оценки</a>
                                <a href="{{ route('admin.films.edit', $film) }}"
                                   class="btn btn-sm btn-info">Изменить</a>
                                <form action="{{ route('admin.films.destroy', $film) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Удалить фильм?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Фильмов не найдено</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($films->hasPages())
            <div class="card-footer">{{ $films->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection