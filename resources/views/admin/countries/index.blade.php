@extends('admin.layouts.app')

@section('title', 'Страны')

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Добавить страну
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 80px">ID</th>
                        <th>Название</th>
                        <th style="width: 220px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($countries as $country)
                        <tr>
                            <td>{{ $country->id }}</td>
                            <td>{{ $country->name }}</td>
                            <td>
                                <a href="{{ route('admin.countries.edit', $country) }}" class="btn btn-sm btn-info">Изменить</a>
                                <form action="{{ route('admin.countries.destroy', $country) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Удалить страну?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Стран пока нет</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($countries->hasPages())
            <div class="card-footer">{{ $countries->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection