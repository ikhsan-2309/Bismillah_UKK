@extends('admin.layouts.app')

@section('content')
  <div class="row">
    <div class="card">
      <div class="card-body px-4 py-4-5">
        <div class="row text-center">
          <div class="col-12">
            <h3 class="font-extrabold mb-3">You are logged in as a Cashier</h3>
            <a href="{{ route('transaksi.baru') }}" class="btn btn-primary btn-flat">New Transaction</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
