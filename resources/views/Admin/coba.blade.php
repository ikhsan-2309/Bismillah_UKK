@extends('admin.layouts.app')

@section('content')
  <section class="section">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          List kategori
          <button type="button" class="btn btn-outline-primary float-end"
            onclick="addForm('{{ route('kategori.store') }}')">+ Category</button>
        </h5>
        <div>
          <div class="card-body">
            {{ $dataTable->table() }}
          </div>
        </div>
  </section>
@endsection


@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
