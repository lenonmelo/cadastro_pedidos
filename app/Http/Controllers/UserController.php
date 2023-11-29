<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        $users = User::paginate(10);
        $loggedId = intval(Auth::id());

        return view('users.index', [
            'users' => $users,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name',
            'email',
            'password',
            'password_confirmation',
        ]);

        $validator =  Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed']
        ], [
            'name.required' => 'Campo Nome é obrigatório',
            'email.required' => 'Campo E-mail é obrigatório',
            'email.email' => 'E-mail não é válido',
            'password.required' => 'Campo Senha é obrigatório',
            'password.min' => 'Senhas devem ter no mínimo :min caracteres',
            'password.confirmed' => 'Senhas não conferem',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.create')
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if ($user) {
            return view('users.edit', ['user' => $user]);
        }

        return view('users.index');
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
        $user = User::find($id);

        if ($user) {
            $data = $request->only([
                'name',
                'email',
                'password',
                'password_confirmation'
            ]);

            $validator =  Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'email', 'max:200']
            ], [
                'name.required' => 'Campo Nome é obrigatório',
                'email.required' => 'Campo E-mail é obrigatório',
                'email.email' => 'E-mail não é válido'
            ]);

            if ($validator->fails()) {
                return redirect()->route('users.edit', ['user' => $user->id])
                    ->withErrors($validator);
            }

            //Alteração do nome
            $user->name = $data['name'];

            //Alteração do email
            if ($user->email != $data['email']) {

                //Verifica se o novo e-mail já existe para poder alterá-lo, caso exista não deixar alterar
                $hasEmail = User::where('email', $data['email'])->get();
                if (count($hasEmail) === 0) {
                    $user->email = $data['email'];
                } else {

                    $validator->errors()->add('email', 'Esse e-mail já existe no sistema');
                }
            }

            //Alteração da senha
            if (!empty($data['password'])) {
                if (strlen($data['password']) >= 4) {
                    if ($data['password'] === $data['password_confirmation']) {
                        $user->password = Hash::make($data['password']);
                    } else {
                        $validator->errors()->add('password', 'Senhas não conferem');
                    }
                } else {
                    $validator->errors()->add('password', 'Senhas devem ter no mínimo :min caracteres');
                }
            }

            if (count($validator->errors()) > 0) {
                return redirect()->route('users.edit', ['user' => $user->id])
                    ->withErrors($validator);
            }

            $user->save();
        }

        return redirect()->route('users.index')->with('success', 'Usuário alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedId = intval(Auth::id());

        if ($loggedId !== intval($id)) {
            $user = User::find($id);
            $user->delete();
        }
        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso.');
    }
}
