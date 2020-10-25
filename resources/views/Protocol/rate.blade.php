
@extends('layouts.app')
@section('title', 'Кандидати')
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
   <h1>Рейтингові списки<img width="100px" src="/img/diagram.png"></h1>
   @foreach($types as $type)
    @if ($type != "Місто")
               <a href="{{route('protocols.rate_list',$type)}}">
                <div class="state jumbotron" >
                     <h1 class="display-4">{{$type}}</h1>
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
        @foreach($states as $state)
    

        <tr>        
           <th scope="row">{{$state->id}}</th>
               <td><a href="{{route('protocols.rate_state',$state->id)}}">{{$state->name}}</a></td>
        </tr>

        @endforeach
        </tbody>
      </table>
      </div>
</div>

@endsection

