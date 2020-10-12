
@extends('layouts.app')
@section('title', 'Пошук')
@section('content')

 <div class="container">
 <div class="row">
 <div class="col-lg-9 col-md-9">
 <h1>Члени ДВК<img width="100px" src="/img/team.png"><a href="{{route('members.create')}}" class="btn btn-warning">Додати Члена ДВК</a><a href="{{route('members.upload')}}" class="btn btn-primary">Завантажити</a></h1>
 </div>
 <div class="col-lg-3 col-md-3/">
   <h3>Пошук</h3>
   <form action="{{route('members.search')}}" method="POST">
               @csrf
               <input type="text" name="name" id="name">
               <input type="submit"  class="btn btn-outline-primary" value="Шукати">
  </form>
  </div>
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
         <th>Дільниця</th>
         <th>ПІБ</th>
         <th>Посада</th>
         <th>Дата Народження</th>
         <th>Номер Телефону</th>
         <th>Партійність</th>
         <th>Пріоритетність</th>
         <th></th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($members as $member)
        <tr>
           <th scope="row">{{$member->id}}</th>
               <td>{{$member->district_id}}</td>
               <td>{{$member->name}}</td>
               <td>{{$member->position}}</td>
               <td>{{$member->date}}</td>
               <td>{{$member->number}}</td>
               <td>{{$member->getPresent()->name}}</td>
               <td>{{$member->priority}}</td>
               <td><a href="{{route('members.edit',$member)}}" class="btn btn-outline-success">Редагувати</a></td>
               <td>
               <form action="{{route('members.destroy',$member)}}" method="POST">
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
</div>    

@endsection

