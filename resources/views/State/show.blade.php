
@extends('layouts.app')
@section('title', 'Дільниці Округу')
@section('content')

 <div class="container">
 <h1>{{$state->name}}<img width="100px" src="http://election/img/tent.png"><a href="{{route('districts.create_',$state)}}" class="btn btn-success">Додати Дільницю</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Назва</th>
         <th>Тип</th>
         <th>Округ</th>
         <th>Адреса</th>
         <th></th>
         <th>Кількість Дільниць: {{$count}}</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($districts as $district)
        <tr>
           <th scope="row">{{$district->id}}</th>
               <td>{{$district->type}}</td>
               <td>{{$district->getState()->name}}</td>
               <td>{{$district->adress}}</td>
               <td><a href="{{route('districts.show',$district)}}" class="btn btn-outline-warning">Склад ДВК</a></td>
               <td><a href="{{route('districts.edit',$district)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('districts.destroy',$district)}}" method="POST">
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

