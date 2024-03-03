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
                    <label for="">Category</label>
                    <input class="form-control" type="text" name="category" id="category">
                </div>
                <div class="col-md-3">
                    <button id="filter" class="btn btn-outline-primary">Filter</button>
                    <button id="reset" class="btn btn-outline-warning">Reset</button>
                </div>
            </div>
            <div class="">
                <table id="chale_errors_report" class="table" style="width:100%">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Nominee</th>
                            <th>Nominee Phone</th>
                            <th>Nominator Phone</th>
                            <th>Code</th>
                            <th>Transaction ID</th>
                            <th>Response</th>
                            <th>Age Range</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                </table>
            </div>
    </div>

    <script>
    $('#filter').on('click', function() {
        $('#tableone-table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = $('#start_date').val();
            data.end_date = $('#end_date').val();
        });

        $('#tableone-table').DataTable().ajax.reload();
        return false;
    });

    $('#reset').on('click', function() {
        $('#tableone-table') //This id is the dataTable's ID defined in your datatable class
        .on('preXhr.dt', function(e, settings, data) {
            data.start_date = null;
            data.end_date = null;
        });

        $('#tableone-table').DataTable().ajax.reload();
        return false;
    });
</script>
<script>
    $(document).ready(function() {
        $('#chale_errors_report').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('chale.errors.report') }}",
                type: 'GET'
            },
            columns: [
                // { data: 'id', name: 'id' },
                {
                    data: 'nominee',
                    name: 'nominee',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'nominee_phone',
                    name: 'nominee_phone',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'nominator_phone',
                    name: 'nominator_phone',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'code',
                    name: 'code',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'transaction_id',
                    name: 'transaction_id',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'response',
                    name: 'response',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'dob',
                    name: 'dob',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return data; // Return the original data for sorting and other types
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, full, meta) {
                        if (data == '' || data == null) {
                            // Format the date using Moment.js
                            return 'N/A'; // Customize the format
                        }
                        return moment(data).format(
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
                // {
                //     extend: 'csv',
                //     exportOptions: {
                //         modifier: {
                //             page: 'all'
                //         }
                //     }
                // },
                // {
                //     extend: 'excel',
                //     exportOptions: {
                //         modifier: {
                //             page: 'all'
                //         }
                //     }
                // },
                // {
                //     extend: 'pdf',
                //     exportOptions: {
                //         modifier: {
                //             page: 'all'
                //         }
                //     }
                // },
                // {
                //     extend: 'print',
                //     exportOptions: {
                //         modifier: {
                //             page: 'all'
                //         }
                //     }
                // }
            ]
        });
    });
</script>
@endsection