@extends('layouts.master')

@section('title')
    Account
@endsection


<head>
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
</head>


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <h3>{{$user->first_name}}</h3>
                @if(Auth::user()->id != $user->id)

                @if(\App\Friend::where('id_sender',$user->id)->Orwhere('id_getter',$user->id)->first())
                    <a href="{{route('add.friend', ['id'=>$user->id])}}" role="button" class="btn btn-success">
                        Удалить из друзй
                    </a>
                @else
                    <a href="{{route('add.friend', ['id'=>$user->id])}}" role="button" class="btn btn-success">
                        Добавить в друзья
                    </a>
                @endif
                @endif


                <hr>
                <div>
                    <img src="{{ route('account.image', ['filename' => $user->first_name . '-' . $user->id . '.jpg']) }}"
                         alt="" class="img-responsive">
                </div>
                <h2>Количество постов: {{$posts_count}}</h2>

            </div>



            <div class="col-md-4 col-md-offset-1">
                <h2>Список Друзей:</h2>
                <hr>

                @foreach($friends as $friend)
                    {{--{{dump($friend)}}--}}
                    {{--{{dump($user->id)}}--}}
                @if($friend->id_sender != $user->id)

                    <h3>Имя:
                        <a href="{{route('page',['id'=>$user->where('id',$friend->id_sender)->first()                                        ->id])}}">{{$user->where('id',$friend->id_sender)->first()                                        ->first_name}}</a>
                    </h3>
                    <div class="friends-image">
                        <img src="{{ route('account.image', ['filename' => $user->where('id',$friend->id_sender)->first()                                        ->first_name . '-' . $user->where('id',$friend->id_sender)->first()                                        ->id . '.jpg']) }}"
                             alt="" class="img-responsive">
                    </div>
                    @else
                        <h3>Имя:
                            <a href="{{route('page',['id'=>$user->where('id',$friend->id_getter)->first()                                        ->id])}}">{{$user->where('id',$friend->id_getter)->first()                                        ->first_name}}</a>
                        </h3>
                        <div class="friends-image">
                            <img src="{{ route('account.image', ['filename' => $user->where('id',$friend->id_getter)->first()                                        ->first_name . '-' . $user->where('id',$friend->id_getter)->first()                                        ->id . '.jpg']) }}"
                                 alt="" class="img-responsive">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            @foreach($posts as $post)

                <a href="{{route('page',['id'=>$user->id])}}">{{$user->first_name}}</a>

                <span class="likes_number"> {{$post->likes}} </span>  <i class="fa fa-heart" aria-hidden="true"></i>

                <span class="likes_number">{{$post->dislikes}}  </span>     <i class="fa fa-thumbs-down"
                                                                               aria-hidden="true"></i>
                <article class="post" data-postid="{{ $post->id }}">
                    <p>
                        {{$post->body}}
                    </p>
                    <div class="info">
                        Опубликовано {{$user->first_name}} , дата: {{ $post->created_at }}
                    </div>
                    <hr>
                    <div class="interaction">
                        <a href="#"
                                    class="like">{{ Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 1 ? 'You like this post' : 'Like' : 'Like'}}</a>


                        <a href="#"
                                    class="like">{{  Auth::user()->likes()->where('post_id', $post->id)->first() ? Auth::user()->likes()->where('post_id', $post->id)->first()->like == 0 ? 'You don\'t like this post' : 'Dislike' : 'Dislike' }}</a>

                        @if(Auth::user()->id == $post->user_id)

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
    </div>

    <script>

        var token = '{{ Session::token() }}';
        var urlEdit = '{{ route('edit') }}';
        var urlLike = '{{ route('like') }}';

    </script>
@endsection
