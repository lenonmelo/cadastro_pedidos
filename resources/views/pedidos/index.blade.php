@extends('adminlte::page')

@section('title', 'Pedidos')

@section('content_header')
<h1>Pedidos
    <a href="{{ route('pedidos.create') }}" class="btn btn-sm btn-success">Novo pedido</a>
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
        <div class="fa-pull-right">
        <a href="{{ route('pedidos.exportar') }}" class="btn btn-sm btn-success">Exportar pedidos</a>
        </div>
    
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Valor</th>
                    <th>Data do pedido</th>
                    <th>Cliente</th>
                    <th>Status do pedido</th>
                    <th></th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                <tr>
                    <td class="align-middle">{{ $pedido->id }}</td>
                    <td class="align-middle">{{ $pedido->produto }}</td>
                    <td class="align-middle">{{ $decimalConversor->converter($pedido->valor) }}</td>
                    <td class="align-middle">{{ $dateConversor->converter($pedido->data) }}</td>
                    <td class="align-middle">{{ $pedido->cliente->nome }}</td>
                    <td class="align-middle">{{ $pedido->pedidoStatus->descricao }}</td>
                    <td class="align-middle">
                        @if (count($pedido->imagens) > 0)
                            <img src="/images/capa/{{ $pedido->imagens[0]->capa }}" alt="Imagem do Veículo" class="img-fluid">
                        @else
                        --
                        @endif
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('pedidos.edit', ['pedido' => $pedido->id]) }}" title="Alterar">
                            <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                        </a>
                        <form class="d-inline" method="POST" action="{{ route('pedidos.destroy', ['pedido' => $pedido->id]) }}" onsubmit="return confirm('Tem certeza que deseja excluir esse pedido?')">
                            @method('DELETE')
                            @csrf
                            <button type="submit" title="Excluir" style="border: none; background: none; padding: 0; cursor: pointer;">
                                <i class="fa fa-trash-alt text-primary" aria-hidden="true" style="cursor: pointer;"></i>
                            </button>
                        </form>
                        <a href="{{ route('pedidos.show', ['pedido' => $pedido->id]) }}" title="Visualizar"><i class="fa fa-eye" aria-hidden="true"></i></a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $pedidos->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection