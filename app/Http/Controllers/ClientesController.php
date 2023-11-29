<?php

namespace App\Http\Controllers;

use App\Library\DataNascimentoValidation;
use App\Library\DateMysqlToView;
use App\Library\DateViewToMysql;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use LaravelLegends\PtBrValidatorValidator;

class ClientesController extends Controller
{

    /*
    * Inclusão de middleware de permissão
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::where('ativo', '1')->paginate(10);

        // Conversor de data de Mysql para mostrar na view
        $dateConverter = new DateMysqlToView();

        return view('clientes.index', [
            'clientes' => $clientes,
            'dateConverter' => $dateConverter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'nome',
            'cpf',
            'data_nasc',
            'telefone'
        ]);

        //Realiza a validação de campos obrigatórios
        $validator = Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:15'],
            'data_nasc' => ['required']
        ], [
            'nome.required' => 'Campo Nome é obrigatório',
            'cpf.required' => 'Campo CPF é obrigatório',
            'data_nasc.required' => 'Campo Data de nascimento é obrigatório'

        ]);


        //Caso os campos estejam em brancos, retorna as mensagens de erros
        if ($validator->fails()) {
            return redirect()->route('clientes.create')
                ->withErrors($validator)
                ->withInput();
        }

        //Realiza a validação do CPF
        $validaCpf = Validator::make(
            ['cpf' => $data['cpf']],
            ['cpf' => 'cpf']
        );

        if ($validaCpf->fails()) {
            return redirect()->route('clientes.create')
                ->withErrors($validaCpf)
                ->withInput();
        }

        //Verifica se existe um cliente com o mesmo CPF
        $existeCpf = Cliente::where('cpf', $data['cpf'])->where('ativo', 1)->get();
        if (count($existeCpf) > 0) {
            $validator->errors()->add('cpf', 'Já existe um cliente com esse CPF no sistema');
        }

        //Realiza a validação da data de nascimento
        $dataNascimentoValidate = new DataNascimentoValidation();
        if (!$dataNascimentoValidate->validate($data['data_nasc'])) {
            $validator->errors()->add('data_nasc', 'Data de nascimento não pode ser maior que a data atual');
        }

        if (count($validator->errors()) > 0) {
            return redirect()->route('clientes.create')
                ->withErrors($validator)
                ->withInput();
        }

        $cliente = new Cliente();

        //Seta campos para serem incluidos
        $cliente->nome = $data['nome'];
        $cliente->cpf = $data['cpf'];
        $dateConersos = new DateViewToMysql();
        $cliente->data_nasc = $dateConersos->converter($data['data_nasc']);

        //Caso for preenchido o telefone o mesmo é incluido no cadastro
        if (isset($data['telefone'])) {
            $cliente->telefone = $data['telefone'];
        }

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        $dateConverter = new DateMysqlToView();
        $cliente->data_nasc = $dateConverter->converter($cliente->data_nasc);

        if ($cliente) {
            return view('clientes.show', ['cliente' => $cliente]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);

        if ($cliente) {
            //Converte a data de mysql para mostrar na view
            $dateConverter = new DateMysqlToView();
            $cliente->data_nasc = $dateConverter->converter($cliente->data_nasc);

            return view('clientes.edit', ['cliente' => $cliente]);
        }

        return view('clientes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        $data = $request->only([
            'nome',
            'cpf',
            'data_nasc',
            'telefone'
        ]);

        //Realiza a validação de campos obrigatórios
        $validator = Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:15'],
            'data_nasc' => ['required']
        ], [
            'nome.required' => 'Campo Nome é obrigatório',
            'cpf.required' => 'Campo CPF é obrigatório',
            'data_nasc.required' => 'Campo Data de nascimento é obrigatório'

        ]);

        //Caso os campos estejam em brancos, retorna as mensagens de erros
        if ($validator->fails()) {
            return redirect()->route('clientes.edit', ['cliente' => $cliente->id])
                ->withErrors($validator)
                ->withInput();
        }

        //Realiza a validação do CPF
        $validaCpf = Validator::make(
            ['cpf' => $data['cpf']],
            ['cpf' => 'cpf']
        );

        if ($validaCpf->fails()) {
            return redirect()->route('clientes.edit', ['cliente' => $cliente->id])
                ->withErrors($validaCpf)
                ->withInput();
        }

        //Alteração do cpf
        if ($cliente->cpf != $data['cpf']) {
            //Verifica se existe um cliente com o mesmo CPF
            $existeCpf = Cliente::where('cpf', $data['cpf'])->where('ativo', 1)->get();
            if (count($existeCpf) > 0) {
                $validator->errors()->add('cpf', 'Já existe um cliente com esse CPF no sistema');
            }
        }

        //Realiza a validação da data de nascimento
        $dataNascimentoValidate = new DataNascimentoValidation();
        if (!$dataNascimentoValidate->validate($data['data_nasc'])) {
            $validator->errors()->add('data_nasc', 'Data de nascimento não pode ser maior que a data atual');
        }

        if (count($validator->errors()) > 0) {
            return redirect()->route('clientes.edit', ['cliente' => $cliente->id])
                ->withErrors($validator)
                ->withInput();
        }

        //Seta campos para serem alterados
        $cliente->nome = $data['nome'];
        $cliente->cpf = $data['cpf'];
        $dateConersos = new DateViewToMysql();
        $cliente->data_nasc = $dateConersos->converter($data['data_nasc']);

        //Caso for preenchido o telefone o mesmo é incluido no cadastro
        if (isset($data['telefone'])) {
            $cliente->telefone = $data['telefone'];
        }

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Realiza a desativação do cliente(ativo = 0)
        $cliente = Cliente::find($id);
        $cliente->ativo = 0;
        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso.');
    }
}
