@extends('layout.admin')

@section('content')
    <div class="table table-responsive">
        {{-- <form action=""> --}}
            <div class="row">
                <div class="col-md-3">
                    <label for="">Start Date</label>
                    <input class="form-control" type="date" name="start_date" id="start_date">
                </div>
                <div class="col-md-3">
                    <label for="">End Date</label>
                    <input class="form-control" type="date" name="end_date" id="end_date">
                </div>
                <div class="col-md-3">
                    <label for="">Category</label>
                    <input class="form-control" type="text" name="category" id="category">
                </div>
                <div class="col-md-3">
                    <button id="filter" class="btn btn-outline-primary">Filter</button>
                    <button id="reset" class="btn btn-outline-warning">Reset</button>
                </div>
            </div>
        {{-- </form> --}}
        {{ $dataTable->table() }}
    </div>

    <script>
        // $('#tableone-table'); //This id is the dataTable's ID defined in your datatable class
        // .on('preXhr.dt', function(e, settings, data) {
        //     data.start_date = $('#start_date').val();
        //     data.end_date = $('#end_date').val();
        //     data.category = $('#category').val();
        // });

    $('#filter').on('click', function() {
        $('#tableone-table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = $('#start_date').val();
            data.end_date = $('#end_date').val();
            data.category = $('#category').val();
        });

        $('#tableone-table').DataTable().ajax.reload();
        return false;
    });

    $('#reset').on('click', function() {
        $('#tableone-table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = null;
            data.end_date = null;
            data.category = null;
        });

        $('#tableone-table').DataTable().ajax.reload();
        return false;
    });
</script>
@endsection