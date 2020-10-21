
@extends('layouts.app')
@section('title', 'Протокол')
@section('content')
<style>
input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.send{
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.send:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}
</style>
 <div class="container">
    <h1>Протокол Дільниці №{{$protocol->getDstrict()->id}} Виборчого Типу "{{$protocol->type}}" </h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('protocols.update',$protocol)}}">
  @method('PUT')
  @csrf
  <div class="form-group">
                                    
                                        <div class="ui-widget">
	                                         <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		                                          <p><span class="ui-icon ui-icon-alert" style="float: left; margin-bottom: 3.em;"></span>
		                                                <strong>Alert:</strong></p>
	                                          </div>
                                         </div>
                                  

    <label for="exampleInputEmail1">Дільниця</label>
         <input type="number" name="district_id" id="id" value="{{$protocol->district_id}}" class="form-control" id="exampleInputEmail1 " required autocomplete="id">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Виборчий Тип</label>
    <select name="type" id="type" class="form-control" id="exampleFormControlSelect1">
      <option value="Область" {{ $protocol->type == 'Область' ? 'selected' : '' }}>Область</option>
      <option value="Район" {{ $protocol->type == 'Район' ? 'selected' : '' }}>Район</option>
      <option value="Місто" {{ $protocol->type == 'Місто' ? 'selected' : '' }}>Місто</option>
      <option value="Мер" {{ $protocol->type == 'Мер' ? 'selected' : '' }}>Мер</option>
    </select>
  </div>
  <div class="form-group">
  <table class="table">
        <thead class="thead-inverse">
       <tr>
       <th>№</th>
         <th>Назва пункту</th>
         <th>Значення</th>
       </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1.</th>
            <td>Кількість виборчих бюлетенів одержаних дільничною вибрчою комісією</td>
            <td><input type="number" name="p1" id="1" class="form-control" value="{{$protocol->p1}}" required></td>
        </tr>
        <tr>
        <th scope="row">2.</th>
            <td>Кількість невикористаних виборчих бюлетнів, погашених дільничною вибрчою комісією</td>
            <td><input type="number" name="p2" id="2" class="form-control" value="{{$protocol->p2}}" required></td>
        </tr>
        <tr>
        <th scope="row">3.</th>
            <td>Кількість виборців, включених до списку виборців на виборчій дільниці (на момент закінчення голосування)</td>
            <td><input type="number" name="p3" id="3" class="form-control" value="{{$protocol->p3}}" required></td>
        </tr>
        <tr>
        <th scope="row">4.</th>
            <td>Кількість виборців, внесених на виборчій дільниці до витягу із списку виборців для голосування за місцем перебування</td>
            <td><input type="number" name="p4" id="4" class="form-control" value="{{$protocol->p4}}" required></td>
        </tr>
        <tr>
        <th scope="row">5.</th>
            <td>Кількість виборців, які отримали виборчі бюлетені у приміщенні для голосування</td>
            <td><input type="number" name="p5" id="5" class="form-control" value="{{$protocol->p5}}" required></td>
        </tr>
        <tr>
        <th scope="row">6.</th>
            <td>Кількість виборців, які отримали виборчі бюлетені за місцем перебування</td>
            <td><input type="number" name="p6" id="6" class="form-control" value="{{$protocol->p6}}" required></td>
        </tr>
        <tr>
        <th scope="row">7.</th>
            <td>Загальна кількість виборців, які отримали виборчі бюлетені</td>
            <td><input type="number" name="p7" id="7" class="form-control" value="{{$protocol->p7}}" required></td>
        </tr>
        <tr>
        <th scope="row">8.</th>
            <td>Кількість виборчих бюлетенів, що не підлягають врахуванню</td>
            <td><input type="number" name="p8" id="8" class="form-control" value="{{$protocol->p8}}" required></td>
        </tr>
        <tr>
        <th scope="row">9.</th>
            <td>Кількість виборців, які взяли участь у голосуванні на виборчій дільниці </td>
            <td><input type="number" name="p9" id="9" class="form-control" value="{{$protocol->p9}}" required></td>
        </tr>
        <tr>
        <th scope="row">10.</th>
            <td>Кількість виборчих бюлетенів, визнаних недійсними </td>
            <td><input type="number" name="p10" id="10" class="form-control" value="{{$protocol->p10}}" required></td>
        </tr>
        <tr>
        <th scope="row">11.</th>
            <td>Сумарна кількість голосів виборців, які підтримали територіальні виборчі списки усіх місцевих організацій політичних партій</td>
            <td><input type="number" name="p11" id="11" class="form-control" value="{{$protocol->p11}}" required></td>
        </tr>

        </tbody>
      </table>
  </div>
  @if($protocol->type != "Мер")
  <div class="form-group">
  <h3>12.</h3>
  <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>№</th>
         <th>Назва місцевої організації політичної партії</th>
         <th>Кількість голосів виборців, 
            які підтримали територіальний виборчий список місцевої організації політичної партії
            (цифрами)
         </th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($parties_ as $party)
        <tr>
           <th scope="row">{{$party->getParty()->id}}</th>
               <td>{{$party->getParty()->name}}</td>
               </td>
               <td><input class="form-control" type="number"></td>
            </tr>

        @endforeach
        </tbody>
      </table>
      </div>
      <div class="form-group">

  <h3>13.</h3>
  <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>№</th>
         <th>Назва місцевої організації політичної партії</th>
         <th>Кількість голосів виборців,
              які підтримали весь територіальний виборчий список кандидатів у депутати від  місцевої організації політичної партії, 
              не підтримавши окремого кандидата в депутати
         </th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($parties_ as $party)
        <tr>
           <th scope="row">{{$party->getParty()->id}}</th>
               <td>{{$party->getParty()->name}}</td>
               </td>
               <td><input class="form-control" type="number"></td>
            </tr>

        @endforeach
        </tbody>
      </table>
      </div>
      <h3>14.</h3>
   @foreach($parties_ as $party)
    <div class="state jumbotron" >
         <h1 class="display-4">{{$party->getParty()->name}}</h1>
         
           <div class="form-group">
              <table class="table">
                  <thead class="thead-inverse">
                   <tr>
                      <th>#</th>
                      <th>ПІБ</th>
                      <th></th>
                     </tr>
                  </thead>
                <tbody>
                    @foreach($party->getCandidat_all($party->id) as $candidat)
                      <tr>
                      <th scope="row">{{$loop->index +1}}</th>
                      <td>{{$candidat->name}}</td>
                      <td>
                          <input  class="form-control"type="number">
                       </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
           </div>
        </div>
    @endforeach

    @else
    <div class="form-group">
  <h3>12.</h3>
  <table class="table">
        <thead class="thead-inverse">
       <tr>
         <th>№</th>
         <th>Прізвище</th>
         <th>Ім'я</th>
         <th>По Батькові</th>
         <th>Кількість голосів виборців, 
            які підтримали мера
         </th>
         <th></th>

       </tr>
        </thead>
        <tbody>
        @foreach($parties_ as $party)
        <tr>
           <th scope="row">{{$party->id}}</th>
               <td>{{$party->second_name}}</td>
               <td>{{$party->first_name}}</td>
               <td>{{$party->father_name}}</td>
               </td>
               <td><input class="form-control" type="number"></td>
            </tr>

        @endforeach
        </tbody>
      </table>
      </div>
    @endif

  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
@endsection

