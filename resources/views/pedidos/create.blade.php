@extends('adminlte::page')

@section('title', 'Novo pedido')

@section('content_header')
<h1>Novo pedido</h1>
@endsection

@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <h5><i class="icon fas fa-ban"></i> Erros:</h5>

    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <p>Campos marcados com * são obrigatórios.</p>
        {!! Form::open(['route' => 'pedidos.store', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true]) !!}
        {!! csrf_field() !!}

        <div class="form-group row">
            {!! Form::label('produto', 'Produto:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('produto', old('produto'), ['class' => 'form-control ' . ($errors->has('produto') ? 'is-invalid' : '')]) !!}
                @error('nome')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('valor', 'Valor:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('valor', old('valor'), ['id'=>'valor', 'class' => 'form-control ' . ($errors->has('valor') ? 'is-invalid' : '')]) !!}
                @error('cpf')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('data', 'Data do pedido:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('data', old('data'), ['id' => 'data_pedido', 'class' => 'form-control ' . ($errors->has('data') ? 'is-invalid' : '')]) !!}
                @error('data')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('cliente_id', 'Cliente:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('cliente_id', ['' => 'Selecione um cliente'] + $clientes->pluck('nome', 'id')->toArray(), old('cliente_id'), ['id' => 'cliente_id', 'class' => 'form-control' . ($errors->has('cliente_id') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('pedido_status_id', 'Status do pedido:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::select('pedido_status_id', ['' => 'Selecione um tatus'] + $pedidoStatus->pluck('descricao', 'id')->toArray(), old('pedido_status_id'), ['id' => 'pedido_status_id', 'class' => 'form-control' . ($errors->has('pedido_status_id') ? ' is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('imagem', 'imagem:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-10">
                {!! Form::file('imagem') !!}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {!! Form::submit('Cadastrar', ['class' => 'btn btn-success']) !!}
                {!! link_to_route('pedidos.index', 'Voltar', [], ['class' => 'btn btn-secondary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
@endsection

@section('js')
<script src="{{ asset('js/jquery.mask.min.js') }}" defer></script>
<script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
<script src="{{ asset('js/scripts.js') }}" defer></script>
@endsection