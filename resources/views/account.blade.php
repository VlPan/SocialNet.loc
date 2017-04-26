@extends('layouts.master')

@section('title')
    Account
@endsection

@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    </head>
    {{--<section class="row new-post">--}}
    <div class="col-md-6 col-md-offset-3">
        <header><h3>Настройки аккаунта</h3></header>
        <form action="{{ route('account.save') }}" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="first_name">Имя:</label>
                <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}"
                       id="first_name">
            </div>
            <div class="form-group">
                <label for="second_name">Фамилия:</label>
                <input type="text" name="second_name" class="form-control" value="{{ $user->second_name }}"
                       id="second_name">
            </div>
            <div class="form-group">
                <label for="status">Статус:</label>
                <input type="text" name="status" class="form-control" value="{{ $user->status }}" id="status">
            </div>
            <div class="form-group">
                <label for="country">Страна:</label>
                <input type="text" name="country" class="form-control" value="{{ $user->country }}" id="country">
            </div>
            <div class="form-group">
                <label for="city">Город:</label>
                <input type="text" name="city" class="form-control" value="{{ $user->city }}" id="city">
            </div>
            <div class="form-group">
                <label for="image">Аватар (только .jpg расширение)</label>
                <input type="file" name="image" class="form-control" id="image">
            </div>
            <h2>Ваш пол: {{$user->gender}}</h2>
            <div class="form-group">
                <label for="gender">Выберете пол:</label>
                <select class="form-control" id="gender" name="gender">
                    <option>Мужской</option>
                    <option>Женский</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
            <input type="hidden" value="{{ Session::token() }}" name="_token">


        </form>
    </div>
    {{--</section>--}}
    @if (Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
        {{--<section class="row new-post">--}}
        <div class="col-md-6 col-md-offset-3">
            <div class="user_img" style="margin-top: 20px;">
                <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}"
                     alt="" class="img-responsive">
            </div>

        </div>
        {{--</section>--}}

    @endif
@endsection