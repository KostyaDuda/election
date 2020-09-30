
@extends('layouts.app')

@section('content')
<style>
 a{
  text-decoration: none;
 }
</style>
 <div class="container">
 <h1>Облік Округів<img width="100px" src="img/capitol.png"><a href="{{route('states.create')}}" class="btn btn-warning">Додати Округ</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Назва</th>
         <th></th>
         <th></th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($states as $state)
        <tr>
           <th scope="row">{{$state->number}}</th>
               <td>{{$state->name}}</td>
               <td><a href="{{route('repair')}}" class="btn btn-outline-primary">Кандидати</a></td>
               <td><a href="{{route('states.show', $state)}}" class="btn btn-outline-warning">Дільниці</a></td>
               <td><a href="{{route('states.edit', $state)}}" class="btn btn-outline-success">Редагувати</a></td>
               @if ($state->districts->count() > 0)
               <td><div  class="btn btn-outline-danger" value="Видалити" data-toggle="modal" data-target="#exampleModal">Видалити</div></td>
               @endif
               @if ($state->districts->count() == 0)
               <td>
               <form action="{{route('states.destroy',$state)}}" method="POST">
               @csrf
               @method('DELETE')
               <input type="submit" class="btn btn-outline-danger" value="Видалити">         
               </form>
               </td>
               @endif
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Помилка</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Даний округ має дільниці. Щоб видалити даний Оркуг - видаліть дільниці даного округу
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
      </div>
    </div>
  </div>
</div>

@endsection

