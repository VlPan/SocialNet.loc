@extends('layouts.master')

@section('content')
    @include('includes.message-block')

    <head>
        <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    </head>


    <section class="row new-post">
        <div class="col-md-1">
            <div class="user_img">
                <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}"
                     alt="" class="img-responsive">
                <a href="{{route('page',['id'=>$user->id])}}">{{$user->first_name}} {{$user->second_name}}</a>
            </div>
        </div>
        <div class="col-md-6 col-md-offset-2">
            <header><h3>О чем вы думаете?</h3></header>
            <form action="{{ route('post.create') }}" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="body" id="new-post" cols="30" rows="5"
                              placeholder="Разместите здесь ваш пост"></textarea>
                </div>
                <button class="btn btn-primary">Опубликовать</button>
                {{ csrf_field() }}
            </form>
        </div>
    </section>




    <section class="row posts">
        <div class="col-md-6 col-md-offset-3">
            <header><h3>Последние Посты пользователей:</h3></header>
            @foreach($posts as $post)
                <div class="col-md-4">
                    <div class="user_img_" style="margin-top: 20px;">
                        <img src="{{ route('account.image', ['filename' => $post->user->first_name . '-' . $post->user->id . '.jpg']) }}"
                             alt="Изображение Отсутствует" class="img-responsive">
                    </div>

                    <a href="{{route('page', ['id'=>$post->user->id])
                   }}">{{$post->user->first_name}} {{$post->user->second_name}}</a>

                </div>
                <span class="likes_number"> {{$post->likes}} </span>  <i class="fa fa-heart" aria-hidden="true"></i>
                <span class="likes_number">{{$post->dislikes}}  </span>     <i class="fa fa-thumbs-down"
                                                                               aria-hidden="true"></i>
                <article class="post" data-postid="{{ $post->id }}">
                    <p>
                        {{$post->body}}
                    </p>
                    <div class="info">
                        Опубликовано {{$post->user->first_name}} , дата: {{ $post->created_at }}
                    </div>

                    <hr>
                    <div class="interaction">
                        <a href="#"
                           class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'  }}</a>
                        |
                        <a href="#"
                           class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike'  }}</a>

                        @if(Auth::user() == $post->user)

                            <a href="#" class="edit">Edit</a>

                            <a href="{{ route('post.delete', ['post_id' =>                                     $post->id])}}">Delete</a>
                        @endif

                    </div>
                </article>
            @endforeach()

            <div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Edit Post</h4>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="post-body">Edit the post</label>
                                    <textarea name="post-body" id="post-body" rows="5" class="form-control"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


        </div>
    </section>

    <script>
        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
        var urlLike = '{{ route('like') }}';

    </script>
@endsection