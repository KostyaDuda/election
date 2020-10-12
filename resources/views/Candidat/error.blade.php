
@extends('layouts.app')
@section('title', 'Помилка')
@section('content')

   <div class="container">
     <h1>Помилка введення даниз з файлу</h1>
     <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>#</th>
       </tr>
        </thead>
        <tbody>
        @foreach($error_array as $eror)
        <tr>
               <td>{{$eror}}</td>
            </tr>
        @endforeach
        </tbody>
      </table>
   </div>

@endsection

