
@extends('layouts.app')

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
    <h1>Додати Члена ДВК</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('members.store')}}">
  @csrf
  <div class="form-group">
    <label>П.І.Б.</label>
         <input type="text" name="name" id="name" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Дата Народження</label>
         <input type="date" name="date" id="date" class="form-control datetimepicker" required> 
  </div>
  <div class="form-group">
    <label>Номер Телефону</label>
         <input type="text" name="number" id="number" class="form-control" required>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Дільниця</label>
         <input type="number" name="district_id" id="district_id" class="form-control" required>
         @foreach ($errors->all() as $error)                             
                                        <div class="ui-widget">
	                                         <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		                                          <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		                                                <strong>Alert:</strong> {{ $error }}</p>
	                                          </div>
                                         </div>
                                    @endforeach
  </div>
  <div class="form-group">
    <label>Посада</label>
    <select name="position" id="position" class="form-control" id="exampleFormControlSelect1">
      <option value="Член">Член</option>
      <option value="Голова">Голова</option>
      <option value="Заступник">Заступник</option>
      <option value="Секретар">Секретар</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Суб'єкт подання</label>
    <select name="present_id" id="present_id" class="form-control" id="exampleFormControlSelect1">
      @foreach($presents as $present)
                <option value="{{ $present->id }}">{{ $present->priority.' '.$present->name}}</option>
            @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
    </script>
@endsection

