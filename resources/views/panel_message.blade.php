@extends('layouts.master')

@section('content')
    @include('includes.message-block')
    <head>
        <link rel="stylesheet" href="{{asset('css/message_panel.css')}}">
    </head>

    <div class="container">
    @foreach($messages as $message)
            <div class="message">

                <h2>
                    <a href="{{ route('page',['id'=>$message->id_sender]) }}">{{\App\User::find($message->id_sender)->first_name}}  {{\App\User::find($message->id_sender)->second_name}}</a>
                </h2>
            <div class="user_img_panel" style="margin-top: 20px;">
                <a href="{{ route('page',['id'=>$message->id_sender]) }}"><img src="{{ route('account.image', ['filename' => \App\User::find($message->id_sender)->first_name    . '-' . $message->id_sender. '.jpg']) }}"
                     alt="Изображение Отсутствует" class="img-responsive">
                </a>
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
            </div>
                    @else
                    <div class="info">
                        <em>Сообщение Получено в {{ $message->created_at }}, От                          </em>
                        <a href="{{route('page',['id'=>$message->id_sender])}}">{{
                \App\User::find($message->id_sender)->first_name
                  }}
                        </a>
                    </div>


                @endif
            <hr>
        </div>

    @endforeach()
    </div>

@endsection