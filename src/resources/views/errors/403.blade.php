@extends('layouts.application')

@section('content')
    <div class="error-page error-403">
        <a href="/"><img src="{{ asset('/assets/image/403.png') }}" alt=""></a>
    </div>
@endsection
