@extends('admin.layouts.app')

@section('title', 'Пользователи')

@section('content')
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'active' ? 'active' : '' }}"
                       href="{{ route('admin.users.index') }}">Активные</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'deleted' ? 'active' : '' }}"
                       href="{{ route('admin.users.index', ['status' => 'deleted']) }}">Удалённые</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $status === 'all' ? 'active' : '' }}"
                       href="{{ route('admin.users.index', ['status' => 'all']) }}">Все</a>
                </li>
            </ul>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 60px">ID</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Пол</th>
                        <th>Дата рождения</th>
                        <th>Статус</th>
                        <th style="width: 160px">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fio }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->gender->name ?? '—' }}</td>
                            <td>{{ $user->birthday?->format('d.m.Y') ?? '—' }}</td>
                            <td>
                                @if ($user->trashed())
                                    <span class="badge badge-danger">Удалён {{ $user->deleted_at->format('d.m.Y') }}</span>
                                @else
                                    <span class="badge badge-success">Активен</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->trashed())
                                    <form action="{{ route('admin.users.restore', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Восстановить</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                          class="d-inline" onsubmit="return confirm('Удалить пользователя?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Пользователей не найдено</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="card-footer">{{ $users->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection