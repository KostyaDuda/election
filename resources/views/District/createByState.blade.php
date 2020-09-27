
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
    <h1>Створити Дільницю</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('districts.store')}}">
  @csrf
  <div class="form-group">
    <label for="exampleInputEmail1">Назва</label>
         <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;" name="id" id="id" class="form-control" id="exampleInputEmail1 " required autocomplete="id">

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
    <label for="exampleInputEmail1">Тип</label>
    <select name="type" id="type" class="form-control" id="exampleFormControlSelect1">
      <option value="Велика">Велика</option>
      <option value="Середня">Середня</option>
      <option value="Мала">Мала</option>
      <option value="Спец дільниця">Спец дільниця</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Округ</label>
    <select name="state_id" id="state_id" class="form-control" id="exampleFormControlSelect1">
                <option value="{{ $state_->id }}">{{ $state_->name }}</option>
    </select>
  </div>
  <div class="form-group">
    <label>Адреса Дільниці</label>
    <input type="text" name="adress" id="adress" class="form-control" id="exampleInputEmail1 " required autocomplete="adress">
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Ввести</button>
  </form>
  </div>
    </script>
@endsection

