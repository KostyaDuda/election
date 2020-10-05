
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
   <h1>Кандидати партії "{{$party->name}}"<img width="100px" src="/img/political.png"><a href="{{route('candidats.create')}}" class="btn btn-warning">Додати Кандидата</a><a href="{{route('candidats.upload')}}" class="btn btn-primary">Завантажити Word</a></h1>
   @foreach($partybystates as $party)
    @if ($party->type != "Місто")
    <a href="{{route('parties.show',$party)}}">
       <div class="state jumbotron" >
         <h1 class="display-4">{{$party->type}}</h1>
       </div>
      </a>
    @endif
    @endforeach
    <div class="state jumbotron" >
         <h1 class="display-4">Місто</h1>

    <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Назва Округу</th>
       </tr>
        </thead>
        <tbody>
        @foreach($partybystates as $party)
        @if ($party->type == "Місто")

        <tr>        
           <th scope="row">{{$party->getState()->id}}</th>
               <td><a href="{{route('parties.show',$party)}}">{{$party->getState()->name}}</a></td>
        </tr>

        @endif
        @endforeach
        </tbody>
      </table>
      </div>
</div>

@endsection

