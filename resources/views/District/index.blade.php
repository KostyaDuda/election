
@extends('layouts.app')

@section('content')

 <div class="container">
 <div class="row">
 <div class="col-lg-7 col-md-7">
 <h1>Виборчі Дільниці<img width="100px" src="img/tent.png"><a href="{{route('districts.create')}}" class="btn btn-warning">Створити дільницю</a></h1>
 </div>
 <div class="col-lg-5 col-md-5"> 
  <h3>Пошук</h3>
  <form action="{{route('districts.search')}}" method="POST">
               @csrf
               <input type="number" name="id" id="id">
               <input type="submit"  class="btn btn-outline-primary" value="Шукати">
  </form>
  </div>
  </div>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Назва</th>
         <th>Тип</th>
         <th>Округ</th>
         <th>Адреса</th>
         <th>Кількість Дільниць: {{$count}}</th>
         <th></th>
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
      {{ $districts->links() }}
      </div>

@endsection

