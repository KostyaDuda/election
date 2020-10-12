
@extends('layouts.app')
@section('title', 'Мери')
@section('content')
 <div class="container">
 <h1>Кандидати у мери міста<img width="100px" src="img/mace.png"><a href="{{route('mayors.create')}}" class="btn btn-warning">Додати кандидата</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Прізвище</th>
         <th>Ім'я</th>
         <th>По Батькові</th>
         <th>Дата Народження</th>
         <th>Партійність</th>
         <th>К-сть голосів</th>
         <th>%</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($mayors as $mayor)
        <tr>
           <th scope="row">{{$mayor->id}}</th>
               <td>{{$mayor->second_name}}</td>
               <td>{{$mayor->first_name}}</td>
               <td>{{$mayor->father_name}}</td>
               <td>{{$mayor->date}}</td>
               <td>{{$mayor->party_affiliation}}</td>
               <td>-</td>
               <td>-</td>
               <td><a href="{{route('mayors.edit',$mayor)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('mayors.destroy',$mayor)}}" method="POST">
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

