@extends('layouts.app')

@section('title')
    Create
@endsection

@section('content')
    <form method="post" action="{{route('deals.store')}}">
        @csrf
        <div class="mb-3">
            <label for="deal-name" class="form-label">Deal Name</label>
            <input type="text" class="form-control" name="deal_name" >
        </div>
        <div class="mb-3">
            <label for="deal-amount" class="form-label">Deal Amount</label>
            <input type="text" class="form-control" name="deal_amount" >
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Deal Status</label>
            <select name="status" class="form-select">
              <option value="">...</option>
              <option value="Open">Open</option>
              <option value="Closed">Closed</option>
            </select>
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection