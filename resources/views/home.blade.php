@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div id="app">
                <app></app>
            </div>
 
    <script src="{{ mix('js/app.js') }}"></script>
        </div>
    </div>
</div>
@endsection
