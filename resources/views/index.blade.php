@extends('templates.template')

@section('insert_head')
    <link rel="stylesheet"  href="{{ asset('css/index.css') }}">
@endsection

@section('insert_body')
    <main>
        <div class="container">
            <div>
                <div class="session-auth">
                    @auth()
                        <a href="{{route('auth.logout')}}">
                            <button class="btn btn-success">Logout</button>
                        </a>
                    @else
                        <a href="{{route('login')}}">
                            <button class="btn btn-success">Fazer login</button>
                        </a>

                        <p class="information">Pare realizar operações CRUD, é necessário estar autenticado. Para se autenticar, insira o e-mail e senha presentes nas seeder Users.</p>
                    @endauth
                </div>


                <div class="add-contact">
                    <h2>Contatos</h2>
                    <a href="{{route('contatos.create')}}" class="btn btn-outline-success">
                        Criar contato <i class="fa-solid fa-plus"></i>
                    </a>
                </div>

                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Contato</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contatos as $contato)
                            <tr>
                                <th scope="row">{{$contato->nome}}</th>
                                <td>{{$contato->email}}</td>
                                <td>{{$contato->contato}}</td>
                                <td class="btns">
                                    <a href="{{route('contatos.show', Crypt::encrypt([$contato->id]))}}">
                                        <button class="btn btn-success">Visualizar</button>
                                    </a>
                                    <a href="{{route('contatos.edit', Crypt::encrypt([$contato->id]))}}">
                                        <button class="btn btn-warning">Editar</button>
                                    </a>

                                    <form action="{{route('contatos.destroy', Crypt::encrypt([$contato->id]))}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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
