@extends('admin.layouts.app')

@section('title', 'Жанры')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить жанр
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 80px">ID</th>
                        <th>Название</th>
                        <th>Родительский жанр</th>
                        <th style="width: 220px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->parent->name ?? '—' }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-info">Изменить</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Удалить жанр?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center">Жанров пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="card-footer">{{ $categories->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection