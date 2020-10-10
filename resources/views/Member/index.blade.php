
@extends('layouts.app')

@section('content')

 <div class="container">
 <div class="row">
 <div class="col-lg-7 col-md-7">
 <h1>Члени ДВК<img width="100px" src="/img/team.png"><a href="{{route('members.create')}}" class="btn btn-warning">Додати Члена ДВК</a><a href="{{route('members.upload')}}" class="btn btn-primary">Завантажити</a></h1>
 </div>
 <div class="col-lg-3 col-md-2">
   <h3>Пошук</h3>
   <form action="{{route('members.search')}}" method="POST">
               @csrf
               <input type="text" name="name" id="name">
               <input type="submit"  class="btn btn-outline-primary" value="Шукати">
  </form>
  </div>
  <div class="col-lg-2 col-md-2">
  <ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ "Звіти" }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('export.export_all') }}">
                                        {{ __('Вивеcти Членів ДВК по дільницям для жеребкування') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('export.export_all_') }}">
                                        {{ __('Вивеcти Членів ДВК по дільницям По посадам') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('export.check') }}">
                                        {{ __('Перевірка Кількості людей на ДВК') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('export.kvoty') }}">
                                        {{ __('Квоти') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('export.mains') }}">
                                        {{ __('Керівний склад ДВК') }}
                                    </a>
                                </div>
                            </li>
                            </ul>
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
         <th>Кількість людей: {{$count}}</th>
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
      {{ $members->links() }}
</div>    
</div>    

@endsection

