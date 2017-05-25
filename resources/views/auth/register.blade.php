@extends('main')


@section('title', '| Register')


@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::open() !!}

                {{ Form::label('name', 'Name:') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}

                {{ Form::label('email', 'E-mail:') }}
                {{ Form::email('email', null, array('class' => 'form-control')) }}

                {{ Form::label('password', 'Password:') }}
                {{ Form::password('password', array('class' => 'form-control')) }}

                {{ Form::label('password_confirmation', 'Confirm Password:') }}
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}

                {{ Form::submit('Register', array('class' => 'btn btn-primary btn-block form-spacing-top')) }}

            {!! Form::close() !!}
        </div>
    </div>

@stop