@extends('app')

@section('titulo', 'Cadastrar Nova Diarista')

@section('main')
<h1>Cadastrar diarista</h1>
<form action="{{route('diaristas.store')}}" method="POST" enctype="multipart/form-data">


    @include('_form')

    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>
@endsection
