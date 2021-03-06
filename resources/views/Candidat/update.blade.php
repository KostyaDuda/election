
@extends('layouts.app')
@section('title', 'Оновити')
@section('content')
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.send{
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.send:hover {
    background-color: #45a049;
} 

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
 <div class="container">
    <h1>Оновити Дані Кандидата</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('candidats.update',$candidat)}}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Порядковий номер в ТВК</label>
         <input type="text" name="number" id="number" value="{{$candidat->id}}" class="form-control" id="exampleInputEmail1 " required autocomplete="id">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">П.І.Б.</label>
         <input type="text" name="name" id="name" value="{{$candidat->name}}" class="form-control" id="exampleInputEmail1 " required autocomplete="id">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Дата Народження</label>
         <input type="text" name="date" id="date" value="{{$candidat->date}}" class="form-control" id="exampleInputEmail1 " required autocomplete="id">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Партійність</label>
    <select name="party_id" id="party_id" class="form-control" id="exampleFormControlSelect1">
      @foreach($partiesbystates as $partiesbystate)
           @if (isset($partiesbystate->getState()->name))
                <option value="{{ $partiesbystate->id }}" {{ $partiesbystate->id == $candidat->party_id ? 'selected' : '' }}>{{ $partiesbystate->getParty()->name .' '. $partiesbystate->type .' '. $partiesbystate->getState()->name}}</option>
           @endif
           @if (!isset($partiesbystate->getState()->name))
                <option value="{{ $partiesbystate->id }}" {{ $partiesbystate->id == $candidat->party_id ? 'selected' : '' }}>{{ $partiesbystate->getParty()->name .' '. $partiesbystate->type  }}</option>
           @endif
            @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
@endsection

