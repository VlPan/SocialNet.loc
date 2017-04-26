<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('dashboard') }}">На Главную</a>
            <ul class="nav navbar-nav navbar-right">
                <li><img src="{{ route('account.image', ['filename' => Auth::user()->first_name . '-' . Auth::user()->id . '.jpg']) }}" style="width: 100px; height: 60px;"></li>
                <li><a href="{{route('page',['id' => Auth::user()->id])}}">{{Auth::user()->first_name}} {{Auth::user()->second_name}}</a></li>
                <li><a href="{{ route('account') }}">Настройки <i class="fa fa-cog" aria-hidden="true"></i></a></li>
                <li class="messages"><a href="{{route('get.panel')}}">Сообщения <i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                <li><a href="{{ route('logout') }}">Выйти</a></li>

            </ul>
        </div>


    </div>
</nav>