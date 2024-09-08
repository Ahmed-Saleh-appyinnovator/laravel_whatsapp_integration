@extends('layouts.app')

@section('title')
    Show
@endsection

@section('content')
    <div class="mt-4">
        <div class="card">
            <div class="card-header">
                Deal Info
            </div>

                
            <div class="card-body">
                <h5 class="card-title">Name: {{$deals['name']}} </h5>
                <p class="card-text">Amount: {{$deals['amount']}}</p>
            </div>

        </div>
    </div>
@endsection