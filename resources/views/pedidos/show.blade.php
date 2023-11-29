@extends('adminlte::page')

@section('title', 'Visualizar pedido')

@section('content_header')
<h1>Visualizar pedido</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Produto</label>
            <div class="col-sm-10">
                {{ $pedido->produto }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Valor</label>
            <div class="col-sm-10">
                {{ $pedido->valor }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Data do pedido</label>
            <div class="col-sm-10">
                {{ $pedido->data }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Cliente</label>
            <div class="col-sm-10">
                {{ $pedido->cliente->nome }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Status do pedido</label>
            <div class="col-sm-10">
                {{ $pedido->pedidoStatus->descricao }}
            </div>
        </div>

        @if ($pedido->imagens->isNotEmpty())
        <div class="form-group row">
            <div class="col-sm-5">
                <div class="text-sm-center">
                    <i class="fa fa-search-plus" aria-hidden="true" style="cursor: pointer;" onclick="mostrarImagem( '{{$pedido->imagens[0]->id }}', '{{ $rotaMostraImagem }}' )"></i>
                </div>
                <div class="text-sm-center">
                    <img src="/images/capa/{{ $pedido->imagens[0]->capa }}" alt="Imagem do Veículo" class="img-fluid">
                </div>
            </div>
        </div>
        @endif

        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>

    </div>
</div>
@include('modal')
@endsection
@section('js')
<script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
<script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
<script src="{{ asset('js/scripts.js') }}" defer></script>
@endsection