<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Laravel Blog</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Home <span class="sr-only">(current)</span></a></li>
                <li class="{{ Request::is('blog') ? 'active' : '' }}"><a href="{{ route('blog.index') }}">Blog</a></li>
                <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">About</a></li>
                <li class="{{ Request::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                @if(Auth::check())
                <li class="{{ Request::is('posts') ? 'active' : '' }}"><a href="{{ route('posts.index') }}">Posts Index</a></li>
                <li class="{{ Request::is('posts/create') ? 'active' : '' }}"><a href="{{ route('posts.create') }}">Posts Create</a></li>
                <li class="{{ Request::is('categories/index') ? 'active' : '' }}"><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="{{ Request::is('tags/index') ? 'active' : '' }}"><a href="{{ route('tags.index') }}">Tags</a></li>
                @endif
            </ul>

            <ul class="nav navbar-nav navbar-right">

                @if( Auth::check())
                    {{--Logout POST request--}}
                    <div>
                        <a href="{{ url('auth/logout') }}"
                           onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="btn btn-primary" style="margin-top: 8px;">Logout</a>
                        <form id="logout-form"
                              action="{{ url('auth/logout') }}"
                              method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }} " class="btn btn-primary" style="margin-top: 8px;">Login</a>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>