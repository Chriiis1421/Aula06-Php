<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    
    public $especialidades = [[
        "id" => 1,
        "nome" => "Cardiologista",
        "descricao" => "Profissinal especialista em questões do coração"
    ]];

    public function __construct() {
        
        $aux = session('especialidades');

        if(!isset($aux)) {
            session(['especialidades' => $this->especialidades]);
        }
    }

    public function index() {
        
        $dados = session('especialidades');
        return view('especialidades.index', compact(['dados']));
    }

    
    public function create()
    {
        return view('veterinarios.create');
    }

    
    public function store(Request $request)
    {
        $aux = session('especialidade');
        $ids = array_column($aux, 'id');

        if(count($ids) > 0) {
            $new_id = max($ids) + 1;
        }
        else {
            $new_id = 1;   
        }

        $novo = [
            "id" => $new_id,
            "nome" => $request->nome,
            "descricao" => $request->descricao
        ];

        array_push($aux, $novo);
        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }

    
    public function show($id)
    {
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id'));

        $dados = $aux[$index];

        return view('veterinarios.show', compact('dados'));
    }

    
    public function edit($id)
    {
        $aux = session('veterinarios');
            
        $index = array_search($id, array_column($aux, 'id'));

        $dados = $aux[$index];    

        return view('veterinarios.edit', compact('dados'));
    }

    
    public function update(Request $request, $id)
    {
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id'));

        $novo = [
            "id" => $id,
            "nome" => $request->nome,
            "descricao" => $request->descricao,
        ];

        $aux[$index] = $novo;
        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }

    
    public function destroy($id)
    {
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id')); 

        unset($aux[$index]);

        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }
}
