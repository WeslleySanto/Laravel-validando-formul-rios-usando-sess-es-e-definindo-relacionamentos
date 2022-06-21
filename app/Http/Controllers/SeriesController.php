<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Serie;
use Illuminate\Http\Request;
use App\Http\Requests\SeriesFormRequest;
use App\Season;

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
        // dd($request->all());
        $serie = Serie::create($request->all());

        $seasons = [];

        for ($i = 1; $i <= $request->seasonQty; $i++){
            $seasons[] = [
                'series_id' => $serie->id,
                'numero' => $i
            ];

        }

        Season::insert($seasons);

        $episodes = [];
        // dd($serie->temporadas);
        foreach ($serie->temporadas as $season) {
            for ($j = 1; $j <= $request->episodePerSeason; $j++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'numero' => $j
                ];
            }
        }

        Episode::insert($episodes);

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
