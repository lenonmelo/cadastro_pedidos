@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes
    <a href="{{ route('clientes.create') }}" class="btn btn-sm btn-success">Novo cliente</a>
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
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nome }}</td>
                    <td>{{ $cliente->cpf }}</td>
                    <td>{{ $dateConverter->converter($cliente->data_nasc) }}</td>
                    <td>{{ $cliente->telefone }}</td>
                    <td>
                        <a href="{{ route('clientes.edit', ['cliente' => $cliente->id]) }}" title="Alterar">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                        <form class="d-inline" method="POST" action="{{ route('clientes.destroy', ['cliente' => $cliente->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir esse cliente?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                            </button>
                        </form>
                        <a href="{{ route('clientes.show', ['cliente' => $cliente->id]) }}" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $clientes->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection