
@extends('layouts.app')

@section('content')
 <div class="container">
 <h1>Облік Партій<img width="100px" src="img/achievement.png"><a href="{{route('parties.create')}}" class="btn btn-warning">Додати Партію</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Назва</th>
         <th>Тип Територіального Голосування</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($parties as $party)
        <tr>
           <th scope="row">{{$party->id}}</th>
               <td>{{$party->name}}</td>
               <td>{{$party->type}}</td>
               <td><a href="{{route('parties.edit', $party)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('parties.destroy',$party)}}" method="POST">
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

