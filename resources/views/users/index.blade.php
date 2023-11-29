@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
<h1>Usuários
    <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Novo usuário</a>
</h1>
@endsection

@section('content')
@if (session('error'))
<div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> Erros: </h5>
    <ul>
        <li>{{ session('error') }}</li>
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', ['user' => $user->id]) }}" title="Alterar">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                        @if ($loggedId !== intval($user->id))
                        <form class="d-inline" method="POST" action="{{ route('users.destroy', ['user' => $user->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir esse usuário?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection