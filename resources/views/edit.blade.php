@extends('app')

@section('titulo', 'Editar Cadastro de Diarista')

@section('main')
<h1>Editar diarista</h1>
<form action="{{route('diaristas.update', $diarista)}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @include('_form')
    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>
@endsection
