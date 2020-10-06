
@extends('layouts.app')

@section('content')

 <div class="container">
 <div class="row">
 <h1>Члени ДВК Дільниці №{{$district->id}}<img width="100px" src="/img/team.png"><a href="{{route('members.create')}}" class="btn btn-warning">Додати Члена ДВК</a><a href="#" class="btn btn-primary">Завантажити</a></h1>

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
        @foreach($members_main as $member)
        <tr>
           <th scope="row">{{$loop->index + 1}}</th>
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
        @foreach($members_other as $member)
        <tr>
           <th scope="row">{{$loop->index + $count}}</th>
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

