@extends('main')


@section('title', '| Edit Post')


@section('stylesheets')
    {!! Html::style('css/select2.css') !!}
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector:'textarea'
        });
    </script>
@endsection


@section('content')
    <div class="row">
        {!! Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'put', 'files' => true] ) !!}
        <div class="col-md-8">
            {{ Form::label('title', 'Title:') }}
            {{ Form::text('title', null, ['class' => 'form-control input-lg']) }}

            {{ Form::label('slug', 'Slug:', ['class' => 'form-spacing-top']) }}
            {{ Form::text('slug', null, array('class' => 'form-control', 'required' => '',
                                              'minlength' => '5', 'maxlength' => '255')) }}

            {{ Form::label('category_id', 'Category') }}
            {{ Form::select('category_id', $categories, null, array('class' => 'form-control')) }}

            {{ Form::label('tags', 'Tags:', ['class' => 'form-spacing-top']) }}
            {{ Form::select('tags[]', $tags, null, ['class' => 'form-control select2-multi', 'multiple' => 'multiple']) }}

            {{ Form::label('featured_image', 'Upload featured Image:', ['class' => 'form-spacing-top']) }}
            {{ Form::file('featured_image') }}

            {{ Form::label('body', 'Body:', ['class' => 'form-spacing-top']) }}
            {{ Form::textarea('body', null, ["class" => 'form-control']) }}
        </div>
            <div class="col-md-4">
                <div class="well">
                    <dl class="dt-horizontal">
                        <dt>Created at:</dt>
                        <dd>{{ date('j M Y H:i', strtotime($post->updated_at)) }}</dd>
                    </dl>

                    <dl class="dt-horizontal">
                        <dt>Last updated:</dt>
                        <dd>{{ date('j M Y H:i', strtotime($post->updated_at)) }}</dd>
                    </dl>

                    <hr>

                    <div class="row">
                        <div class="col-sm-6">
                            {{--dopylnitelnata biblioteka ot laravel 4--}}
                            {{--"The more Laravel way?!--}}
                            {{ Form::submit('Save Changes', ['class' => 'btn btn-success btn-block']) }}
                        </div>
                        <div class="col-sm-6">
                            {!! Html::linkRoute('posts.show', 'Cancel', array($post->id), array('class' => 'btn btn-danger btn-block')) !!}
                        </div>
                    </div>
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection


@section('scripts')
    {!! Html::script('js/select2.min.js') !!}
    <script type="text/javascript">
        $('.select2-multi').select2();
        $('.select2-multi').select2().val({!! json_encode($post->tags()->allRelatedIds()) !!}).trigger('change')
    </script>
@endsection