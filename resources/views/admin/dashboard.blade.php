@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            @if(Session('message'))
                <h2 class="alert alert-success">{{ Session('message') }}</h2>
            @endif
            <div class="me-md-3 me-xl-5">
                <h2>Dashboard</h2>
            </div>
        </div>
    </div>
@endsection
