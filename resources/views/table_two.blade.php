@extends('layout.admin')

@section('content')
    <div class="table table-responsive">
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
                    <button id="filter" class="btn btn-outline-primary">Filter</button>
                    <button id="reset" class="btn btn-outline-warning">Reset</button>
                </div>
            </div>
            <div class="">
                <table id="users_table" class="table" style="width:100%">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>

    <script>
    $('#filter').on('click', function() {
        $('#users_table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = $('#start_date').val();
            data.end_date = $('#end_date').val();
        });

        $('#users_table').DataTable().ajax.reload();
        return false;
    });

    $('#reset').on('click', function() {
        $('#users_table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = null;
            data.end_date = null;
        });

        $('#users_table').DataTable().ajax.reload();
        return false;
    });
</script>
<script>
    $(document).ready(function() {
        $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('table.two.data') }}",
                type: 'GET'
            },
            columns: [
                // { data: 'id', name: 'id' },
                {
                    data: 'id',
                    name: 'id',
                    render: function(value, type, full, meta) {
                        if (value == '' || value == null) {
                            return 'N/A';
                        }
                        return value;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(value, type, full, meta) {
                        if (value == '' || value == null) {
                            return 'N/A';
                        }
                        return value;
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    render: function(value, type, full, meta) {
                        if (value == '' || value == null) {
                            return 'N/A';
                        }
                        return value;
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(value, type, full, meta) {
                        if (value == '' || value == null) {
                            return 'N/A';
                        }
                        return moment(value).format(
                            'YYYY-MM-DD HH:mm:ss'
                        ); // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'updated_at',
                    name: 'updated_at',
                    render: function(value, type, full, meta) {
                        if (value == '' || value == null) {
                            return 'N/A';
                        }
                        return moment(value).format(
                            'YYYY-MM-DD HH:mm:ss'
                        ); // Return the original data for sorting and other types
                    }
                }
            ],
            dom: 'Bfrtip',

            // buttons: [
            //     'copyHtml5', 'excelHtml5', 'pdfHtml5', 'csvHtml5'
            // ]
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns:[0,1],
                        modifier: {
                            page: 'all' //Export all pages
                            // page: [0, 1] //Export first and second pages
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns:[0,1],
                        modifier: {
                            page: 'all' //Export all pages
                            // page: [0, 1] //Export first and second pages
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns:[0,1],
                        modifier: {
                            page: 'all' //Export all pages
                            // page: [0, 1] //Export first and second pages
                        }
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns:[0,1],
                        modifier: {
                            page: 'all' //Export all pages
                            //page: [0, 1] //Export first and second pages
                        }
                    }
                }
            ]
        });
    });
</script>
@endsection