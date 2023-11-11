@extends('templates.template')

@section('insert_head')
    <link rel="stylesheet"  href="{{ asset('css/index.css') }}">
@endsection

@section('insert_body')
    <main>
        <div class="container">
            <div>
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

                                    <form action="{{ route('contatos.destroy', [Crypt::encrypt($contato->id)]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="excluirContato()">Excluir</button>
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
    <script>
        function excluirContato() {
        event.preventDefault();

        Swal.fire({
            title: 'Você tem certeza?',
            text: 'Esta ação é irreversível!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('form').submit();
                }
            });
        }
    </script>

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
