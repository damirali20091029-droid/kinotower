@extends('admin.layouts.app')

@section('title', 'Отзывы')

@section('content')
    <div class="card">
        <div class="card-header">
            <form method="GET" action="{{ route('admin.reviews.index') }}" class="form-inline">
                <select name="film_id" class="form-control mr-2">
                    <option value="">Все фильмы</option>
                    @foreach ($films as $film)
                        <option value="{{ $film->id }}" @selected(request('film_id') == $film->id)>
                            {{ $film->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-secondary mr-2">Показать</button>
                <a href="{{ route('admin.reviews.index') }}" class="btn btn-default">Сбросить</a>
            </form>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>Фильм</th>
                        <th>Пользователь</th>
                        <th>Отзыв</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th style="width: 220px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->film->name ?? '—' }}</td>
                            <td>{{ $review->user->fio ?? '—' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($review->message, 80) }}</td>
                            <td>{{ $review->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                @if ($review->is_approved)
                                    <span class="badge badge-success">Одобрен</span>
                                @else
                                    <span class="badge badge-warning">На модерации</span>
                                @endif
                            </td>
                            <td>
                                @unless ($review->is_approved)
                                    <form action="{{ route('admin.reviews.approved', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                                    </form>
                                @endunless
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Удалить отзыв?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Отзывов не найдено</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($reviews->hasPages())
            <div class="card-footer">{{ $reviews->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection