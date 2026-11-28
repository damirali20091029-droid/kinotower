@extends('admin.layouts.app')

@section('title', 'Оценки')

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.ratings.index') }}" class="form-inline">
                <select name="film_id" class="form-control mr-2">
                    <option value="">Все фильмы</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" @selected(request('film_id') == $film->id)>
                            {{ $film->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary mr-2">Показать</button>
                <a href="{{ route('admin.ratings.index') }}" class="btn btn-default">Сбросить</a>
            </form>

            @if (! is_null($average))
                <p class="mt-3 mb-0">Средняя оценка фильма: <strong>{{ number_format($average, 2) }}</strong></p>
            @endif
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Фильм</th>
                        <th>Пользователь</th>
                        <th>Оценка</th>
                        <th>Дата</th>
                        <th style="width: 120px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ratings as $rating)
                        <tr>
                            <td>{{ $rating->id }}</td>
                            <td>{{ $rating->film->name ?? '—' }}</td>
                            <td>{{ $rating->user->fio ?? '—' }}</td>
                            <td>{{ $rating->ball }}</td>
                            <td>{{ $rating->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.ratings.destroy', $rating) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Удалить оценку?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Оценок не найдено</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($ratings->hasPages())
            <div class="card-footer">{{ $ratings->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection