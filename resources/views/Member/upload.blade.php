
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
    <h1>Додати Членів ДВК</h1>
  <form method="POST" enctype="multipart/form-data" action="{{route('members.read_file')}}">
  @csrf
  <div class="form-group">
    <label for="exampleFormControlFile1">Файл</label>
    <input type="file" name="file" class="form-control-file" id="exampleFormControlFile1">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Суб'єкт подання</label>
    <select name="present_id" id="present_id" class="form-control" id="exampleFormControlSelect1">
      @foreach($presents as $present)
                <option value="{{ $present->id }}">{{ $present->priority.' '.$present->name}}</option>
            @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary btn-warning">Завантажити</button>
  </form>
  </div>
    </script>
@endsection

