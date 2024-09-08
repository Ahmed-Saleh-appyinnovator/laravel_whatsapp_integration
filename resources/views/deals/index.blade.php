@extends('layouts.app')

@section('title')
    Index
@endsection

@section('content')

    <div class="text-center">
        <a href="{{route('deals.create')}}" class="btn btn-primary">Add Deal</a>
    </div>

    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Deal Name</th>
            <th scope="col">Deal Status</th>
            <th scope="col">Amount</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($deals as $deal)
                
                <tr>
                <th scope="row">{{$deal['id']}}</th>
                <td>{{$deal['name']}}</td>
                <td>{{$deal['status']}}</td>
                <td>{{$deal['amount']}}</td>
                <td>{{$deal['date']}}</td>
                <td>
                    <a href="{{route('deals.show',$deal['id'])}}" class="btn btn-info">View</a>
                </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection