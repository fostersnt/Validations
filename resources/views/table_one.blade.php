@extends('layout.admin')

@section('content')
    <div class="table table-responsive">
        <form action="">
            <div class="row">
                <div class="col-md-4">
                    <label for="">Start Date</label>
                    <input class="form-control" type="text" name="start_date" id="start_date">
                </div>
                <div class="col-md-4">
                    <label for="">End Date</label>
                    <input class="form-control" type="text" name="end_date" id="end_date">
                </div>
                <div class="col-md-4">
                    <label for="">Category</label>
                    <input class="form-control" type="text" name="category" id="category">
                </div>
            </div>
        </form>
        {{ $dataTable->table() }}
    </div>
@endsection