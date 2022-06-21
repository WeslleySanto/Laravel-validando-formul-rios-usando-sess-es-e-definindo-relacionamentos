@extends('layout')

@section('cabecalho')
    Temporadas de '{!! $series->nome !!}'
@endsection

@section('conteudo')

<ul class="list-group">
    @foreach($seasons as $season)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        Temporada {{$season->numero}}
        <span class="badge bg-secondary">
            {{$season->episodes->count()}}
        </span>
    </li>
    @endforeach
</ul>
@endsection