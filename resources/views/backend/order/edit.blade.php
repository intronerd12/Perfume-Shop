@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
  <h5 class="card-header">Order Edit</h5>
  <div class="card-body">
    @if($order)
      @if(session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
      @endif
      <form action="{{route('order.update',$order->id)}}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="status">Status :</label>
          <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
            <option value="">-- Select Status --</option>
            <option value="new" {{($order->status=='new')? 'selected' : ''}}>New</option>
            <option value="process" {{($order->status=='process')? 'selected' : ''}}>Process</option>
            <option value="delivered" {{($order->status=='delivered')? 'selected' : ''}}>Delivered</option>
            <option value="cancel" {{($order->status=='cancel')? 'selected' : ''}}>Cancel</option>
          </select>
          @error('status')
            <span class="invalid-feedback" role="alert">{{$message}}</span>
          @enderror
          <small class="text-muted">Email notification will be sent to customer after update</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
      </form>
    @else
      <div class="alert alert-danger">Order not found</div>
    @endif
  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }

</style>
@endpush
