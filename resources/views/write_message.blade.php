@extends('layouts.master')

@section('content')
    @include('includes.message-block')

    <div class="row">
    <div class="col-md-6">
    <form action="{{ route('get.message',['id'=>$user->id])}}" method="post">
        <div class="form-group">
                    <textarea class="form-control" name="text" id="new-message" cols="30" rows="10" placeholder="Ваше сообщение"></textarea>
        </div>
        <button class="btn btn-primary">Отправить</button>
        {{ csrf_field() }}
    </form>
    </div>
        <div class="col-md-3" >
            <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}">
            <h3><a href="{{route('page',['id'=>$user->id])}}}">{{$user->first_name}}  {{$user->second_name}}</a></h3>
        </div>
    </div>
@endsection