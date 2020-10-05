
@extends('layouts.app')

@section('content')

 <div class="container">
 @if($party->type == "Місто")
 <h1>Кандидати партії "{{$party->getParty()->name}}"" виборчого Округу №{{$party->getState()->number}} <img width="100px" src="/img/political.png"><a href="{{route('candidats.create')}}" class="btn btn-warning">Додати Кандидата</a><a href="{{route('candidats.upload')}}" class="btn btn-primary">Завантажити Word</a></h1>
 @endif
 @if($party->type != "Місто")
 <h1>Кандидати партії "{{$party->getParty()->name}}" виборчого типу: {{$party->type}} <img width="100px" src="/img/political.png"><a href="{{route('candidats.create')}}" class="btn btn-warning">Додати Кандидата</a></h1>
 @endif

      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>ПІБ</th>
         <th>Дата Народження</th>
         <th>Партійність</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($candidats as $candidat)
        <tr>
           <th scope="row">{{$candidat->number}}</th>
               <td>{{$candidat->name}}</td>
               <td>{{$candidat->date}}</td>
               <td>{{$candidat->getParty_by_id($candidat->party_id)->name}}</td>
               <td><a href="{{route('candidats.edit',$candidat)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('candidats.destroy',$candidat)}}" method="POST">
               @csrf
               @method('DELETE')
               <input type="submit" class="btn btn-outline-danger" value="Видалити">
               </form>
               </td>
            </tr>
        @endforeach
        </tbody>
      </table>
    

@endsection

