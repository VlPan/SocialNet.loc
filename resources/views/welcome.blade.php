@extends('layouts.master')

@section('title')
    Добро Пожаловать!
@endsection
@section('content')


    <head>
        <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    </head>

    @include('includes.message-block')

    <div class="container">
        <h1 class="title">Добро Пожаловать!</h1>
        <p class="title">Зарегестрируйтесь или авторизируйтесь</p>

        <section class="inputs">
            <div class="row">
                <div class="col-md-4 panell">
                    <div class="colorful friends"><img src="{{ asset('images/friends.jpg') }}" alt=""></div><p>Общайтесь с друзьями!!</p>
                    <div class="colorful posts"><img src="{{ asset('images/posts.png') }}" alt=""> </div> <p>Публикуйте посты!</p>
                    <div class="colorful likes"><img src="{{ asset('images/likes.jpg') }}" alt=""></div><p>Ставьте лайки или дизлайки :)</p>
                </div><i class="fa fa-address-book" aria-hidden="true"></i>
                <div class="col-md-4 col-md-offset-3">
                    <div class="block">
                        <h3>Регистрация:</h3>

                        <form action="{{ route('signup') }}" method="post">
                            <div class="form-group has-error has-success{{ $errors->has('email') ? 'has-error has-feedback' : '' }}">
                                <label for="email">Ваш Email</label>
                                <input type="text" name="email" id="email" value="{{ Request:: old('email') }}">
                            </div>
                            <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <label for="first_name">Ваше Имя:</label>
                                <input type="text" name="first_name" id="first_name"
                                       value="{{ Request:: old('first_name') }}">
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password">Ваш Пароль:</label>
                                <input type="password" name="password" id="password"
                                       value="{{ Request:: old('password') }}">
                            </div>
                            <button type="submit" class="btn btn-success">Зарегистрироваться</button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>


                    <div class="block">
                        <h3>Авторизация:</h3>
                        <form action="{{ route('signIn') }}" method="post">
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email">Ваш Email</label>
                                <input type="text" name="email" id="email" value="{{ Request:: old('email') }}">
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password">Ваш Пароль:</label>
                                <input type="password" name="password" id="password"
                                       value="{{ Request:: old('password') }}">
                            </div>
                            <button type="submit" class="btn btn-success">Войти <i class="fa fa-sign-in" aria-hidden="true"></i>     </button>
                            <input type="hidden" name="_token" value="{{ Session::token() }}">
                        </form>
                    </div>

                </div>
            </div>


        </section>
    </div>



    <div>

    </div>



@endsection