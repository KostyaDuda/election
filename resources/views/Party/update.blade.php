
@extends('layouts.app')

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
    <h1>Редагувати Партію</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('parties.update',$party)}}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Назва Партії</label>
         <input type="text" name="name" id="name" class="form-control" id="exampleInputEmail1" value="{{$party->name}}" required autocomplete="name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Тип Територіального Голосування</label>
    <select name="type" id="type" class="form-control" id="exampleFormControlSelect1">
      <option value="Область" {{ $party->type == 'Область' ? 'selected' : '' }}>Область</option>
      <option value="Район" {{ $party->type == 'Район' ? 'selected' : '' }}>Район</option>
      <option value="Місто" {{ $party->type == 'Місто' ? 'selected' : '' }}>Місто</option>
    </select>
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
@endsection

