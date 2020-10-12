
@extends('layouts.app')
@section('title', 'Субєкти Подання')
@section('content')
<style>
 a{
  text-decoration: none;
 }
</style>
 <div class="container">
 <h1>Cуб'єкти Подання<img width="100px" src="/img/delivery-box.png"><a href="{{route('presents.create')}}" class="btn btn-warning">Додати</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Пріоритетність</th>
         <th>Назва</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($presents as $present)
        <tr>
           <th scope="row">{{$loop->index + 1}}</th>
               @if (isset($present->priority))
               <td>{{$present->priority}}</td>
               @endif
               @if (!isset($present->priority))
               <td>-</td>
               @endif
               <td>{{$present->name}}</td>
               <td><a href="{{route('presents.show', $present)}}" class="btn btn-outline-warning">Раби</a></td>
               <td><a href="{{route('presents.edit', $present)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('presents.destroy',$present)}}" method="POST">
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

