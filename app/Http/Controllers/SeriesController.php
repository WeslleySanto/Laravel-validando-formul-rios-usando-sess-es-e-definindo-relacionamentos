<?php

namespace App\Http\Controllers;

use App\Serie;
use Illuminate\Http\Request;
use App\Http\Requests\SeriesFormRequest;

class SeriesController extends Controller
{
    public function index(Request $request) {
        $series = Serie::query()->orderBy('nome')->get();

        $mensagem = $request->session()->get('mensagem');

        return view('series.index', compact('series', 'mensagem'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {

        $serie = Serie::create($request->all());

        return redirect()
            ->route('listar_series')
            ->with('mensagem', "Série '{$serie->nome}' incluida com sucesso!");
    }

    public function destroy (Serie $series)
    {
        $series->delete();

        return redirect()
            ->route('listar_series')
            ->with('mensagem', "Série '{$series->nome}' removida com sucesso");
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return redirect()
            ->route('listar_series')
            ->with('mensagem', "Série '{$series->nome}' atualizada com sucesso");

    }

}
