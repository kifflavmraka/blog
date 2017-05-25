@extends('main')


@section('title', '| Login')


@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::open() !!}

                {{ Form::label('email', 'E-mail:') }}
                {{ Form::email('email', null, array('class' => 'form-control')) }}

                {{ Form::label('password', 'Password:') }}
                {{ Form::password('password', array('class' => 'form-control btn-h1-spacing')) }}

                <br>

                {{ Form::label('remember', 'Remember me') }}
                {{ Form::checkbox('remember') }}
                <br>
                {{ Form::submit('login', array('class' => 'btn btn-primary btn-block')) }}

                <p><a href="{{ url('password/reset') }}">Forgot Password?</a></p>
            {!! Form::close() !!}
        </div>
    </div>

@stop
