@extends('layouts.master')

@section('content')
    @include('includes.message-block')
    <head>
        <link rel="stylesheet" href="{{asset('css/message_panel.css')}}">
    </head>

    <div class="container">



    @foreach($messages as $message)
        <div class="row">
                <div class="col-md-6">
            <div class="message">

                <h2>
                    <a href="{{ route('page',['id'=>$message->id_sender]) }}">{{\App\User::find($message->id_sender)->first_name}}  {{\App\User::find($message->id_sender)->second_name}}</a>
                </h2>
            <div class="user_img_panel" style="margin-top: 20px;">
                <a href="{{ route('page',['id'=>$message->id_sender]) }}"><img src="{{ route('account.image', ['filename' => \App\User::find($message->id_sender)->first_name    . '-' . $message->id_sender. '.jpg']) }}"
                     alt="Изображение Отсутствует" class="img-responsive">
                </a>
            </div>
                <i class="fa fa-long-arrow-right fa-6" aria-hidden="true"></i>
                    <div class="user_img_panel" style="margin-top: 20px;">
                        <a href="{{ route('page',['id'=>$message->id_getter]) }}"><img src="{{ route('account.image', ['filename' => \App\User::find($message->id_getter)->first_name    . '-' . $message->id_getter. '.jpg']) }}"
                                                                                       alt="Изображение Отсутствует" class="img-responsive">
                        </a>
                    </div>
                </div>

            <h3>
                {{$message->text}}
            </h3>

                @if(\App\User::find($message->id_sender)->id == Auth::user()->id)
            <div class="info">
               <em>Сообщение Отправлено в {{ $message->created_at }}, получатель </em>
                <a href="{{route('page',['id'=>$message->id_getter])}}">{{
                \App\User::find($message->id_getter)->first_name
                  }}
                </a>
                <br>
                <a class="btn btn-primary" href="{{route('make.message',['id'=>$message->id_getter])}}">Написать</a>
                <a class="btn btn-danger" href="{{route('delete.message',['id'=>$message->id])}}">Удалить</a>
            </div>
                    @else
                    <div class="info">
                        <em>Сообщение Получено в {{ $message->created_at }}, От                          </em>
                        <a href="{{route('make.message',['id'=>$message->id_sender])}}">{{
                \App\User::find($message->id_sender)->first_name
                  }}
                        </a>
                        <br>
                       <a class="btn btn-success" href="{{route('make.message',['id'=>$message->id_sender])}}">Ответить</a>
                        <a class="btn btn-danger" href="{{route('delete.message',['id'=>$message->id])}}">Удалить</a>
                    </div>


                @endif
            <hr>
                </div>
        </div>
    @endforeach()
        </div>



@endsection