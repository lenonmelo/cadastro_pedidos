<?php

namespace App\Http\Controllers;

use App\Library\DateMysqlToView;
use App\Library\DateViewToMysql;
use App\Library\DecimalMysqlToView;
use App\Library\DecimalViewToMysql;
use App\Library\FilesPedidos;
use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\PedidosImagem;
use App\Models\PedidoStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Writer;

class PedidosController extends Controller
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
        $pedidos = Pedido::where('ativo', '1')->paginate(10);

        // Conversor de valores decimais de Mysql para mostrar na view
        $decimalConversor = new DecimalMysqlToView();

        // Conversor de data de Mysql para mostrar na view
        $dateConversor = new DateMysqlToView();

        return view('pedidos.index', [
            'pedidos' => $pedidos,
            'decimalConversor' => $decimalConversor,
            'dateConversor' => $dateConversor
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::where('ativo', 1)->get();
        $pedidoStatus = PedidoStatus::all();

        return view('pedidos.create', [
            'clientes' => $clientes,
            'pedidoStatus' => $pedidoStatus
        ]);
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
            'produto',
            'valor',
            'data',
            'cliente_id',
            'pedido_status_id',
            'imagem'
        ]);

        //Realiza a validação de campos obrigatórios
        $validator = Validator::make($data, [
            'produto' => ['required', 'string', 'max:255'],
            'valor' => ['required'],
            'data' => ['required'],
            'cliente_id' => ['required', 'integer'],
            'pedido_status_id' => ['required', 'integer'],
            'imagem' => ['file', 'max:2048', 'mimes:jpeg,jpg,png']
        ], [
            'produto.required' => 'Campo Produto é obrigatório',
            'valor.required' => 'Campo Valor é obrigatório',
            'data.required' => 'Campo Data é obrigatório',
            'cliente_id.required' => 'Campo Cliente é obrigatório',
            'pedido_status_id.required' => 'Campo Status do pedido é obrigatório',
            'imagem.mimes' => 'A imagem deve ser com extensão jpg, jpeg ou png',
            'imagem.max' => 'A imagem deve ter no máximo 2MB'
        ]);

        //Caso os campos estejam em brancos, retorna as mensagens de erros
        if ($validator->fails()) {
            return redirect()->route('pedidos.create')
                ->withErrors($validator)
                ->withInput();
        }

        $pedido = new Pedido();

        //Seta campos para serem incluidos
        $pedido->produto = $data['produto'];

        //Realiza a conversão do valor para incluir no banco de dados
        $decimalConversor = new DecimalViewToMysql();
        $pedido->valor = $decimalConversor->converter($data['valor']);

        //Realiza a conversão da data para incluir no banco de dados
        $dateConersos = new DateViewToMysql();
        $pedido->data = $dateConersos->converter($data['data']);

        $pedido->cliente_id = $data['cliente_id'];
        $pedido->pedido_status_id = $data['pedido_status_id'];

        $pedido->save();

        // Captura a imagem do post
        $image = $request->file('imagem');
        if ($image) {
            //Realiza realiza o upload da imagem original, 
            // cria a capa e salvar no banco com a devida relação com o pedido
            $pedidoImagem = new PedidosImagem();
            $filesPedidos = new FilesPedidos();
            $nomeArquivo = $filesPedidos->upload($image);
            $pedidoImagem->pedido_id = $pedido->id;
            $pedidoImagem->imagem = $nomeArquivo;
            $pedidoImagem->capa = $nomeArquivo;
            $pedidoImagem->save();
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pedido = Pedido::find($id);

        if ($pedido) {
            //Converte a data de mysql para mostrar na view
            $dateConverter = new DateMysqlToView();
            $pedido->data = $dateConverter->converter($pedido->data);

            // Conversor de valores decimais de Mysql para mostrar na view
            $decimalConversor = new DecimalMysqlToView();
            $pedido->valor = $decimalConversor->converter($pedido->valor);

            $rotaMostraImagem = Route('pedidos.mostrarImagem');
            return view('pedidos.show', [
                'pedido' => $pedido,
                'rotaMostraImagem' => $rotaMostraImagem
            ]);
        }

        return view('clientes.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pedido = Pedido::find($id);

        if ($pedido) {
            //Converte a data de mysql para mostrar na view
            $dateConverter = new DateMysqlToView();
            $pedido->data = $dateConverter->converter($pedido->data);

            // Conversor de valores decimais de Mysql para mostrar na view
            $decimalConversor = new DecimalMysqlToView();
            $pedido->valor = $decimalConversor->converter($pedido->valor);

            //Busca os clientes e o status dos pedidos para mostrar o dropdown na view
            $clientes = Cliente::where('ativo', 1)->get();
            $pedidoStatus = PedidoStatus::all();

            return view('pedidos.edit', [
                'pedido' => $pedido,
                'clientes' => $clientes,
                'pedidoStatus' => $pedidoStatus
            ]);
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
        $pedido = Pedido::find($id);

        $data = $request->only([
            'produto',
            'valor',
            'data',
            'cliente_id',
            'pedido_status_id',
            'imagem'
        ]);

        //Realiza a validação de campos obrigatórios
        $validator = Validator::make($data, [
            'produto' => ['required', 'string', 'max:255'],
            'valor' => ['required'],
            'data' => ['required'],
            'cliente_id' => ['required', 'integer'],
            'pedido_status_id' => ['required', 'integer'],
            'imagem' => ['file', 'max:2048', 'mimes:jpeg,jpg,png']
        ], [
            'produto.required' => 'Campo Produto é obrigatório',
            'valor.required' => 'Campo Valor é obrigatório',
            'data.required' => 'Campo Data é obrigatório',
            'cliente_id.required' => 'Campo Cliente é obrigatório',
            'pedido_status_id.required' => 'Campo Status do pedido é obrigatório',
            'imagem.mimes' => 'A imagem deve ser com extensão jpg, jpeg ou png',
            'imagem.max' => 'A imagem deve ter no máximo 2MB'
        ]);

        //Caso os campos estejam em brancos, retorna as mensagens de erros
        if ($validator->fails()) {
            return redirect()->route('pedidos.edit', ['pedido' => $pedido->id])
                ->withErrors($validator)
                ->withInput();
        }

        //Seta campos para serem incluidos
        $pedido->produto = $data['produto'];

        //Realiza a conversão do valor para incluir no banco de dados
        $decimalConversor = new DecimalViewToMysql();
        $pedido->valor = $decimalConversor->converter($data['valor']);

        //Realiza a conversão da data para incluir no banco de dados
        $dateConersos = new DateViewToMysql();
        $pedido->data = $dateConersos->converter($data['data']);

        $pedido->cliente_id = $data['cliente_id'];
        $pedido->pedido_status_id = $data['pedido_status_id'];

        $pedido->save();
        // Captura a imagem do post
        $image = $request->file('imagem');
        if ($image) {

            $filesPedidos = new FilesPedidos();

            //Caso existe a imagem no pedido, as mesmas são excluidas das devidas pastas e do banco de dados.
            if ($pedido->imagens) {
                foreach ($pedido->imagens as $imagem) {
                    if ($filesPedidos->delete($imagem->imagem)) {
                        $imagem->delete();
                    }
                }
            }

            //Realiza realiza o upload da imagem original, 
            // cria a capa e salvar no banco com a devida relação com o pedido
            $pedidoImagem = new PedidosImagem();

            $nomeArquivo = $filesPedidos->upload($image);
            $pedidoImagem->pedido_id = $pedido->id;
            $pedidoImagem->imagem = $nomeArquivo;
            $pedidoImagem->capa = $nomeArquivo;
            $pedidoImagem->save();
        }
        return redirect()->route('pedidos.index')->with('success', 'Pedido alterado com sucesso.');
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
        $pedido = Pedido::find($id);
        $pedido->ativo = 0;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído com sucesso.');
    }

    /**
     * Show image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showImage(Request $request)
    {
        //Captura id da imagem
        $id = $request->input('id');
        $imagens = PedidosImagem::find($id);
        return view('pedidos.image', [
            'imagens' => $imagens
        ]);
    }

    /**
     * Export csv file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        // Crie um objeto Writer
        $csv = Writer::createFromString('');

        $csv->setDelimiter(";");

        // Adicione cabeçalhos
        $csv->insertOne(
            [
                'ID',
                'Produtos ',
                'Valor',
                'Data do Pedido',
                'Cliente',
                'Status do pedido',
            ]
        );

        //Converte a data de mysql para exportar
        $dateConverter = new DateMysqlToView();

        // Conversor de valores decimais de Mysql para exportar
        $decimalConversor = new DecimalMysqlToView();

        //Captura os pedidos para serem exportados
        $pedidos = Pedido::where('ativo', '1')->get();
        foreach ($pedidos as $pedido) {
            //Incluindo os pedidos na exportação
            $csv->insertOne(
                [
                    $pedido->id,

                    mb_convert_encoding($pedido->produto, 'ISO-8859-1', 'UTF-8'),
                    $decimalConversor->converter($pedido->valor),
                    $dateConverter->converter($pedido->data),
                    mb_convert_encoding($pedido->cliente->nome, 'ISO-8859-1', 'UTF-8'),
                    mb_convert_encoding($pedido->pedidoStatus->descricao, 'ISO-8859-1', 'UTF-8'),

                ]
            );
        }

        // Configura a resposta HTTP para entregar o arquivo CSV
        return response()->stream(
            function () use ($csv) {
                echo $csv;
            },
            200,
            [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="pedidos-' . date('dmYHis') . '.csv"',
            ]
        );
    }
}
