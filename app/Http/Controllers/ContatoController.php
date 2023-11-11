<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ContatoController extends Controller
{
    private $contatos;
    public function __construct(Contato $contatos)
    {
        $this->contatos = $contatos;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contatos = $this->contatos->all();
        return view('index', compact('contatos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $request->validate([
            'nome' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'contato' => ['required', 'size:9'],
        ], [
            'nome.required' => 'O campo nome é obrigatório!',
            'nome.min' => 'O campo nome deve ter pelo menos 5 caracteres!',
            'email.required' => 'O campo email é obrigatório!',
            'email.email' => 'O email não é válido!',
            'contato.required' => 'O campo contato é obrigatório!',
            'contato.max' => 'O campo contato não pode ter mais de 9 caracteres!',
        ]);

        $this->contatos->create([
            'nome' => $request->nome,
            'email' => $request->email,
            'contato' => $request->contato,
        ]);

        $successMessage = 'Contato criado com sucesso!';
        return redirect()->route('contatos.index')->with('success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contato = $this->contatos->find(Crypt::decrypt($id))->first();
        $form = 'disabled';
        return view('form', compact('contato', 'form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contato = $this->contatos->find(Crypt::decrypt($id))->first();
        return view('form', compact('contato'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id){
        $contato = $this->contatos->find(Crypt::decrypt($id));

        try{
            tap( $this->contatos->find($contato->id))->update([
                'nome' => $request->nome,
                'email' => $request->email,
                'contato' => $request->contato
            ]);

            $successMessage = 'Contato atualizado com sucesso!';
            return redirect()->route('contatos.show', Crypt::encrypt($contato->id))->with('success', $successMessage);


        }catch (QueryException $e){
            return back()->withError('Erro ao salvar o contato.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id){
        $contato = $this->contatos->find(Crypt::decrypt($id));
        $contato->delete();

        return redirect()->route('contatos.index');
    }
}
