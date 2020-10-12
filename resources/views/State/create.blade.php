
@extends('layouts.app')
@section('title', 'Додати Округ')
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
    <h1>Додати Округ</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('states.store')}}">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Номер Оругу</label>
         <input type="number" name="number" id="number" class="form-control" id="exampleInputEmail1"  required autocomplete="number">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Назва Округу</label>
         <input type="text" name="name" id="name" class="form-control" id="exampleInputEmail1" value="Округ №" required autocomplete="name">
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
@endsection

