<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{
    public function create()
    {
        return view('login');
    }


    public function auth(Request $request){
         // validação
         $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ],[
            'email.required' => 'O campo email é obrigatorio!',
            'email.email' => 'O email não é valido',
            'password.required' => 'O campo senha é obrigatorio!'
        ]);
        // dados do login
        $email = trim($request->email);
        $password = trim($request->password);


        $usuario = User::where('email', $email)->first();

         // Verifica se existe usuario
         if(!$usuario){
            return redirect()->back()->with('erro', 'Usuário não encontrado na nossa base de dados');
        }

        // Verifica se a senha do usuario esta correta
        if(!Hash::check($password, $usuario->password)){
            return redirect()->back()->with('erro', 'Usuário ou senha invalido');
        }

         // Autentica o usuário
         if($usuario && Hash::check($password, $usuario->password)){
            Auth::login($usuario);
            // Redireciona para uma rota
            return redirect()->route('contatos.index');
        }
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('contatos.index');
    }


}

