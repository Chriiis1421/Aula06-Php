<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VeterinarioController extends Controller {
    

    public $veterinarios = [[
        "id" => 1,
        "CRMV" => "CRMV-SP",
        "nome" => "Guilherme Chapaval",
        "especialidade" => "Chegar atrasado nas aulas"
    ]];

    public function __construct() {
        
        $aux = session('veterinarios');

        if(!isset($aux)) {
            session(['veterinarios' => $this->veterinarios]);
        }
    }

    public function index() {
        
        $dados = session('veterinarios');
        $clinica = "VetClin DWII";

        // Passa um array "dados" com os "veterinarios" e a string "clínicas"
        return view('veterinarios.index', compact(['dados', 'clinica']));
        // return view('veterinarios.index')->with('dados', $dados)->with('clinica', $clinica);
    }

    public function create() {

        return view('veterinarios.create');
    }

    public function store(Request $request) {
        
        $aux = session('veterinarios');
        $ids = array_column($aux, 'id');

        if(count($ids) > 0) {
            $new_id = max($ids) + 1;
        }
        else {
            $new_id = 1;   
        }

        $novo = [
            "id" => $new_id,
            "CRMV" => $request->CRMV,
            "nome" => $request->nome,
            "especialidade" => $request->especialidade
        ];

        array_push($aux, $novo);
        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }

    public function show($id) {
        
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id'));

        $dados = $aux[$index];

        return view('veterinarios.show', compact('dados'));
    }

    public function edit($id) {

        $aux = session('veterinarios');
            
        $index = array_search($id, array_column($aux, 'id'));

        $dados = $aux[$index];    

        return view('veterinarios.edit', compact('dados'));        
    }

    public function update(Request $request, $id) {
        
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id'));

        $novo = [
            "id" => $id,
            "CRMV" => $request->CRMV,
            "nome" => $request->nome,
            "especialidade" => $request->especialidade
        ];

        $aux[$index] = $novo;
        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }

    public function destroy($id) {
        $aux = session('veterinarios');
        
        $index = array_search($id, array_column($aux, 'id')); 

        unset($aux[$index]);

        session(['veterinarios' => $aux]);

        return redirect()->route('veterinarios.index');
    }
}
