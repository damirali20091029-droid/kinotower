@extends('admin.layouts.app')

@section('title', 'Жанры фильма: ' . $film->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.films.categories.create', $film) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить жанр
            </a>
            <a href="{{ route('admin.films.index') }}" class="btn btn-default">К списку фильмов</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 80px">ID</th>
                        <th>Жанр</th>
                        <th style="width: 140px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <form action="{{ route('admin.films.categories.destroy', [$film, $category]) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Убрать жанр у фильма?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">У фильма пока нет жанров</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection