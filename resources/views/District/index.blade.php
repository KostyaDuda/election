
@extends('layouts.app')

@section('content')

 <div class="container">
 <h1>Виборчі Дільниці<img width="100px" src="img/tent.png"><a href="{{route('districts.create')}}" class="btn btn-warning">Створити дільницю</a></h1>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Назва</th>
         <th>Тип</th>
         <th>Округ</th>
         <th>Адреса</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($districts as $district)
        <tr>
           <th scope="row">{{$district->id}}</th>
               <td>{{$district->name}}</td>
               <td>{{$district->type}}</td>
               <td>{{$district->getState()->name}}</td>
               <td>{{$district->adress}}</td>
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

