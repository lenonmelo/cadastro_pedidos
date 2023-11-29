@extends('adminlte::page')

@section('title', 'Alterar Usuário')

@section('content_header')
<h1>Alterar Usuário</h1>
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
        {!! Form::open(['route' => ['users.update', 'user' => $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}
        {!! csrf_field() !!}

        <div class="form-group row">
            {!! Form::label('name', 'Nome:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('name', $user->name, ['class' => 'form-control ' . ($errors->has('name') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('email', 'E-mail:*', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-5">
                {!! Form::email('email', $user->email, ['class' => 'form-control ' . ($errors->has('email') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('password', 'Nova Senha:', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::password('password', ['class' => 'form-control ' . ($errors->has('password') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            {!! Form::label('password_confirmation', 'Confirmação da senha:', ['class' => 'col-sm-2 col-form-label']) !!}
            <div class="col-sm-3">
                {!! Form::password('password_confirmation', ['class' => 'form-control ' . ($errors->has('password_confirmation') ? 'is-invalid' : '')]) !!}
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                {!! Form::submit('Salvar', ['class' => 'btn btn-success']) !!}
                {!! link_to_route('users.index', 'Voltar', [], ['class' => 'btn btn-secondary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection