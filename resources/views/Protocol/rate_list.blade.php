
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
    <h1>Протокол ТВК  Виборчого Типу "{{$type}}" <a href="{{route('export.protocol',$type)}}" class="btn btn-primary">Експортувати</a></h1>
        
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
            <td>{{$list_p[0]}}</td>
        </tr>
        <tr>
        <th scope="row">2.</th>
            <td>Кількість невикористаних виборчих бюлетнів, погашених дільничною вибрчою комісією</td>
            <td>{{$list_p[1]}}</td>
        </tr>
        <tr>
        <th scope="row">3.</th>
            <td>Кількість виборців, включених до списку виборців на виборчій дільниці (на момент закінчення голосування)</td>
            <td>{{$list_p[2]}}</td>
        </tr>
        <tr>
        <th scope="row">4.</th>
            <td>Кількість виборців, внесених на виборчій дільниці до витягу із списку виборців для голосування за місцем перебування</td>
            <td>{{$list_p[3]}}</td>
        </tr>
        <tr>
        <th scope="row">5.</th>
            <td>Кількість виборців, які отримали виборчі бюлетені у приміщенні для голосування</td>
            <td>{{$list_p[4]}}</td>
        </tr>
        <tr>
        <th scope="row">6.</th>
            <td>Кількість виборців, які отримали виборчі бюлетені за місцем перебування</td>
            <td>{{$list_p[5]}}</td>
        </tr>
        <tr>
        <th scope="row">7.</th>
            <td>Загальна кількість виборців, які отримали виборчі бюлетені</td>
            <td>{{$list_p[6]}}</td>
        </tr>
        <tr>
        <th scope="row">8.</th>
            <td>Кількість виборчих бюлетенів, що не підлягають врахуванню</td>
            <td>{{$list_p[7]}}</td>
        </tr>
        <tr>
        <th scope="row">9.</th>
            <td>Кількість виборців, які взяли участь у голосуванні на виборчій дільниці </td>
            <td>{{$list_p[8]}}</td>
        </tr>
        <tr>
        <th scope="row">10.</th>
            <td>Кількість виборчих бюлетенів, визнаних недійсними </td>
            <td>{{$list_p[9]}}</td>
        </tr>
        <tr>
        <th scope="row">11.</th>
            <td>Сумарна кількість голосів виборців, які підтримали територіальні виборчі списки усіх місцевих організацій політичних партій</td>
            <td>{{$list_p[10]}}</td>
        </tr>

        </tbody>
      </table>
  </div>
        </tbody>

        @if($type == "Мер")
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
         <th>%</th>

       </tr>
        </thead>
        <tbody>
        @foreach($pmayor as  $mayor)
        <tr>
           <th scope="row">{{$loop->index +1}}</th>
               <td>{{$mayor->getMayor()->second_name}}</td>
               <td>{{$mayor->getMayor()->first_name}}</td>
               <td>{{$mayor->getMayor()->father_name}}</td>
               </td>
               <td>{{$mayor->count_voises}}</td>
               <td>{{ number_format(($mayor->count_voises*100)/$pmayor_sum_voises, 2, '.', '')}}</td>
            </tr>
        @endforeach
        </tbody>
      </table>
      </div>

        @else

      </table>
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
         <th>%</th>

       </tr>
        </thead>
        <tbody>
        @foreach($p12 as $p)
        <tr>
           <th scope="row">{{$loop->index +1}}</th>
               <td>{{$p->getParty_by_protocol()->name}}</td>
               </td>
               <td>{{$p->count_voises}}</td>
               <td>{{ number_format(($p->count_voises*100)/$pmayor_p12_voises, 2, '.', '')}}</td>
            </tr>
            
        @endforeach
        </tbody>
      </table>
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
        @foreach($p13 as $p)
        <tr>
           <th scope="row">{{$loop->index +1}}</th>
               <td>{{$p->getParty_by_protocol()->name}}</td>
               </td>
               <td>{{$p->p13_count}}</td>
            </tr>

        @endforeach
        </tbody>
      </table>
     
      <h3>14.</h3>
    @foreach($p12 as  $p)
    <div class="state jumbotron" >
         <h1 class="display-4">{{$p->getParty_by_protocol()->name}}</h1>
         
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
                    @foreach($p14 as  $candidat)
                    @if($candidat->party_id == $p->party_id)
                      <tr>
                      <th scope="row">{{$candidat->getCandidat()->number}}</th>
                      <td>{{$candidat->getCandidat()->name}}</td>
                      <td>
                          {{$candidat->count_voises}}
                       </td>
                      </tr>
                      @endif
                    @endforeach
                </tbody>
              </table>
           </div>
        </div>
    @endforeach
    </div>
    @endif
  </div>
@endsection

