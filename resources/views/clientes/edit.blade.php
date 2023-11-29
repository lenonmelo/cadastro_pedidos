@extends('adminlte::page')

@section('title', 'Alterar cliente')

@section('content_header')
<h1>Alterar cliente</h1>
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
        {!! Form::open(['route' => ['clientes.update', 'cliente' => $cliente->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        {!! csrf_field() !!}

        <div class="form-group row">
            {!! Form::label('nome', 'Nome:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('nome', $cliente->nome, ['class' => 'form-control ' . ($errors->has('nome') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('cpf', 'CPF:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-5">
                {!! Form::text('cpf', $cliente->cpf, ['class' => 'form-control ' . ($errors->has('cpf') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('data_nasc', 'Data de nascimento:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('data_nasc', $cliente->data_nasc, ['id' => 'data_nasc', 'class' => 'form-control ' . ($errors->has('data_nasc') ? 'is-invalid' : '')]) !!}
                @error('data_nasc')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('telefone', 'Telefone:', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('telefone', $cliente->telefone, ['id'=>'telefone', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
                {!! link_to_route('clientes.index', 'Voltar', [], ['class' => 'btn btn-secondary']) !!}
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