
@extends('layouts.app')
@section('title', 'Додати Мера')
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
    <h1>Додати Кандидати у мери міста</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('mayors.store')}}">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Прізвище</label>
         <input type="text" name="second_name" id="second_name" class="form-control" id="exampleInputEmail1 " required autocomplete="father_name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Ім'я</label>
         <input type="text" name="first_name" id="first_name" class="form-control" id="exampleInputEmail1" required autocomplete="father_name">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">По Батькові</label>
         <input type="text" name="father_name" id="father_name" class="form-control" id="exampleInputEmail1" required autocomplete="father_name">
  </div>
  <div class="form-group">
    <label>Дата Народження</label>
         <input type="date" name="date" id="date" class="form-control datetimepicker" required> 
  </div>
  <div class="form-group">
  <label for="exampleFormControlSelect1">Партійність</label>
  <input type="text" name="party_affiliation" id="party_affiliation" class="form-control datetimepicker" required> 
  
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
  <script type="text/javascript">
        $(function () {
            $('.datetimepicker').datetimepicker();
        });
    </script>
@endsection

