@extends('layout')

@section('cabecalho')
    Adicionar Série
@endsection

@section('conteudo')

@include('series.components.form', [
    'action' => route('criar_serie'),
    'nome' => old('nome'),
    'botao' => 'Adicionar'
])


@endsection