
@extends('layouts.app')
@section('title', 'Округи')
@section('content')
<style>
 a{
  text-decoration: none;
 }
</style>
 <div class="container">
 <div class="row">
    <div class="col-lg-5 col-md-5"> 
        <h1>Протоколи ДВК<img width="100px" src="/img/vote.png"><a href="{{route('protocols.check_data')}}" class="btn btn-danger">Глобальна перевірка</a>
    </div>
    <div class="col-lg-5 col-md-5"> 
        <h2>Кількість зроблених {{$count}}/{{3*$count_dis}}</h2></h1>
    </div>  
 <div class="col-lg-4 col-md-4">   
    <h3>Місто<a href="{{route('protocols.create_','Місто')}}" class="btn btn-success">+</a><h5 style="color:blue;">{{$count_city}}/{{$count_dis}}</h5></h3> 
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Дільниця</th>
         <th>Статус</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($protocols_city as $protocol_city)
        <tr>
           <th scope="row">{{$protocol_city->district_id}}</th>
           @if ($protocol_city->status != 1)
               <td><div class="ui-state-error ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-alert"></span></div></td>
           @else
               <td><div class="ui-state-active ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-circle-check"></span></div></td>
           @endif
               <td>
               <a href="{{route('protocols.edit',$protocol_city)}}" class="btn btn-warning">
               <span class="ui-icon ui-icon-pencil" ></span>
               </a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

      <!-- <div class="col-lg-3 col-md-3">   
    <h3>Район<a href="{{route('protocols.create')}}" class="btn btn-success">+</a><h5 style="color:blue;">{{$count_rayon_}}/{{$count_dis}}</h5></h3> 
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Дільниця</th>
         <th>Статус</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($protocols_rayon_ as $protocol_rayon_)
        <tr>
           <th scope="row">{{$protocol_rayon_->district_id}}</th>
               @if ($protocol_rayon_->status != 1)
               <td><div class="ui-state-error ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-alert"></span></div></td>
               @else
               <td><div class="ui-state-active ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-circle-check"></span></div></td>
                @endif
               <td>
               <a href="{{route('protocols.edit',$protocol_rayon_)}}" class="btn btn-warning">
               <span class="ui-icon ui-icon-pencil"></span>
               </a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div> -->

      <div class="col-lg-4 col-md-4">   
    <h3>Область<a href="{{route('protocols.create_','Область')}}" class="btn btn-success">+</a><h5 style="color:blue;">{{$count_oblast_}}/{{$count_dis}}</h5></h3> 
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Дільниця</th>
         <th>Статус</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($protocols_oblast_ as $protocol_oblast_)
        <tr>
           <th scope="row">{{$protocol_oblast_->district_id}}</th>
                @if ($protocol_oblast_->status != 1)
               <td><div class="ui-state-error ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-alert"></span></div></td>
               @else
               <td><div class="ui-state-active ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-circle-check"></span></div></td>
                @endif
               <td><a href="{{route('protocols.edit',$protocol_oblast_)}}" class="btn btn-warning">
               <span class="ui-icon ui-icon-pencil"></span>
               </a></td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

      <div class="col-lg-4 col-md-4">   
    <h3>Мери<a href="{{route('protocols.create_','Мер')}}" class="btn btn-success">+</a><h5 style="color:blue;">{{$count_mayor_}}/{{$count_dis}}</h5></h3> 
      <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>Дільниця</th>
         <th>Статус</th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($protocols_mayor_ as $protocol_mayor)
        <tr>
           <th scope="row">{{$protocol_mayor->district_id}}</th>
               @if ($protocol_mayor->status != 1)
               <td><div class="ui-state-error ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-alert"></span></div></td>
               @else
               <td><div class="ui-state-active ui-corner-all" style="padding: 0 .6em;"><span class="ui-icon ui-icon-circle-check"></span></div></td>
                @endif
               <td>
               <a href="{{route('protocols.edit',$protocol_mayor)}}" class="btn btn-warning">
               <span class="ui-icon ui-icon-pencil"></span>
               </a>
               </td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>
      </div>

</div>
</div>
@endsection

