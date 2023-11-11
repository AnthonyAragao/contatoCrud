@extends('templates.template')

@section('insert_head')
    <link rel="stylesheet"  href="{{ asset('css/login.css') }}">
@endsection

@section('insert_body')
    <main>
        <div class="container">
            <div class="erros">
                @if ($mensagem = Session::get('erro'))
                    {{ $mensagem }}
                @endif

                @if ($errors->any())
                    @foreach ($errors->all() as $erro)
                        {{ $erro }} <br>
                    @endforeach
                @endif
            </div>

            <form method="POST" action="{{route('auth.login')}}">
                @csrf

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" placeholder="Insira seu Email">
                </div>


                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" name="password"  placeholder="Insira sua Senha">
                </div>

                <div class="btn">
                    <button type="submit" class="btn btn-primary mt-2">Entrar</button>
                </div>
            </form>
        </div>

    </main>
@endsection
