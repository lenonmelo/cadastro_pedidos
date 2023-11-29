@extends('adminlte::page')

@section('title', 'Visualizar cliente')

@section('content_header')
<h1>Visualizar cliente</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nome</label>
            <div class="col-sm-10">
                {{ $cliente->nome }}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">CPF</label>
            <div class="col-sm-10">
                {{ $cliente->cpf }}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Data de nascimento</label>
            <div class="col-sm-10">
                {{ $cliente->data_nasc }}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Telefone</label>
            <div class="col-sm-10">
                {{ $cliente->telefone }}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</div>
@endsection