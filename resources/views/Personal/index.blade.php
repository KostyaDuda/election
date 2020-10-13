
@extends('layouts.app')
@section('title', 'Округи')
@section('content')
<style>
 a{
  text-decoration: none;
 }
</style>
 <div class="container">
 <h1>Склад ТВК<img width="100px" src="img/capitol.png"></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>ПІБ</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($personals as $personal)
        <tr>
           <th scope="row">{{$personal->id}}</th>
               <td>{{$personal->name}}</td>
               <td><a href="{{route('personals.show', $personal)}}" class="btn btn-outline-primary">Дільниці</a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

@endsection

