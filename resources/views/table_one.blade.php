@extends('layout.admin')

@section('content')
    <div class="table table-responsive">
        {{ $dataTable->table() }}
    </div>
@endsection