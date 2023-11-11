@extends('templates.template')

@section('insert_head')
    <link rel="stylesheet"  href="{{ asset('css/form.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
@endsection

@section('insert_body')
    <main>
        @if (isset($contato))
            <form method="POST" action="{{ route('contatos.update', [Crypt::encrypt($contato->id)]) }}">
            @method('PUT')
        @else
            <form action="{{route('contatos.store')}}" method="POST">
        @endif
            @csrf
            <div class="container">
                <div>
                    <a href="{{route('contatos.index')}}" class="return">
                        <i class="fa-solid fa-arrow-left fa-bounce"></i> Retorna para listagem
                    </a>

                    <div class="texts">
                        @if (isset($contato))
                            <h2>Modificar contato</h2>
                        @else
                            <h2>Criar contato</h2>
                        @endif
                    </div>


                    <div class="input-group">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" minlength="5" required
                            {{ isset($form) ? $form : null }} placeholder="Insira o nome"
                            value="{{ isset($contato) ? $contato->nome : old('nome') }}">
                    </div>

                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required
                            {{ isset($form) ? $form : null }}  placeholder="Insira o email "
                            value="{{ isset($contato) ? $contato->email : old('email') }}">
                    </div>


                    <div class="input-group">
                        <label for="contato">Contato:</label>
                        <input type="text" id="contato" name="contato" required maxlength="9" minlength="9"
                            {{ isset($form) ? $form : null }}  placeholder="Insira o telefone"
                            value="{{ isset($contato) ? $contato->contato : old('contato') }}">
                    </div>


                    <div class="btns">
                        @if(request()->routeIs('contatos.show'))
                            <a href="{{route('contatos.edit', Crypt::encrypt([$contato->id]) )}}" class="btn btn-success">
                                Modificar
                            </a>
                        @else
                            <button type="submit" class="btn btn-success">Salvar</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
    </main>
@endsection

@section('insert_script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Sucesso!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 3000, // Tempo em milissegundos (3 segundos)
            showConfirmButton: false
        });
    </script>
    @endif
@endsection
