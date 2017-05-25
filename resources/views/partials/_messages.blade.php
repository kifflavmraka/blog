@if (Session::has('success'))
    <div class="alert alert-success">
        <strong>Success: {{ Session::get('success') }}</strong>
    </div>
@endif

{{--works when js validation is off--}}
@if (count($errors) > 0)
    <div class="aler alert-danger" role="alert">
        <strong>Errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif