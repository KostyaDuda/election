
@extends('layouts.app')

@section('content')
 <div class="container">
 <h1>Облік Округів<img width="100px" src="img/capitol.png"><a href="{{route('states.create')}}" class="btn btn-warning">Додати Округ</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Назва</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($states as $state)
        <tr>
           <th scope="row">{{$state->number}}</th>
               <td>{{$state->name}}</td>
               <td><a href="{{route('states.edit', $state)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('states.destroy',$state)}}" method="POST">
               @csrf
               @method('DELETE')
               <input type="submit" class="btn btn-outline-danger" value="Видалити">
               </form>
               </td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

@endsection

