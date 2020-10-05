
@extends('layouts.app')

@section('content')
<style>
a h1
{
    text-decoration: none;
}
.state:hover
{
    background-color: #d45148
}
</style>
 <div class="container">
   <h1>Кандидати Округу№{{$state->number}}"<img width="100px" src="/img/political.png"><a href="{{route('candidats.create')}}" class="btn btn-warning">Додати Кандидата</a><a href="{{route('candidats.upload')}}" class="btn btn-primary">Завантажити Word</a></h1>
   @foreach($parties as $party)
    <div class="state jumbotron" >
         <h1 class="display-4">{{$party->getParty()->name}}</h1>
         

    <table class="table">
        <thead class="thead-inverse">
       <tr>
       <th>#</th>
         <th>ПІБ</th>
         <th>Дата Народження</th>
         <th></th>
         <th></th>
       </tr>
        </thead>
        <tbody>
        @foreach($party->getCandidat_all($party->id) as $candidat)
        <tr>
        <th scope="row">{{$loop->index +1}}</th>
               <td>{{$candidat->name}}</td>
               <td>{{$candidat->date}}</td>
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
      </div>
      @endforeach

</div>

@endsection

