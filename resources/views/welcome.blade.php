@extends('layout.admin')

@section('content')
    
<style>
    #left_column,
    #right_column {
        /* width: 300px; */
        min-height: 100vh;
        display: flex;
        /* flex-direction: column; */
        justify-content: center;
        align-items: center;
        /* text-align: center; */
    }

    #left_column {
        border: 1px solid rgb(206, 197, 197);
    }

    #right_column {
        /* background-color: #0e6efd; */
    }

    #submit_btn {
        margin-top: 20px;
    }

    a.filepond--credits {
        display: none !important;
    }
    fieldset{
        /* border-style:solid; */
    }
    /* Toastr specific styles */
    .toast-success {
        background-color: green;
        color: white;
    }

    /* .filepond--item {width: calc(33% - 0.5em);} */
</style>

</head>

<body class="">
<div class="row">
    <ul>
        <li><a href="{{ route('table.one') }}">Table One</a></li>
        <li><a href="{{ route('table.two') }}">Table Two</a></li>
        <li><a href="">Table Three</a></li>
    </ul>
</div>
{{-- <div class="container"> --}}
<div class="row">
    <div class="col-md-6" id="left_column">
        {{-- <div class="row">
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif
        </div> --}}
        <form action="{{ route('product.create') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <label class="text-muted" for="">Product Name</label>
                <input class="form-control" type="text" name="name" id="name">
            </div>
            <div class="row mb-3">
                <label class="text-muted" for="">Product Image</label>
                <input class="form-control" type="file" name="image" id="">
                <input class="form-control" type="text" hidden name="temporal_file_id" id="temporal_file_id">
            </div>
            <div class="mt-3">
                <button class="btn btn-primary w-100" id="submit_btn">Submit</button>
            </div>
        </form>
    </div>
</div>
{{-- </div> --}}
<div class="container">
    <h1>STATIC FULL CALENDAR</h1>
    <span class="text-danger">(Scroll down for DYNAMIC CALENDAR)</span>
    <div id="static_calendar"></div>
</div>
<div class="container">
    <h1>DYNAMIC FULL CALENDAR</h1>
    <div id="dynamic_calendar"></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!--Filepond js-->
@include('filepond.js_cdn')

<!--Fullpage.js js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

@include('full_calendar.calendar_js')

<!--Toastr js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@if (Session::has('success'))
<script>
    toastr.options = {
        'progressBar': true,
        'closeButton': true,
    };
    toastr.success("{{ Session::get('success') }}", 'success', {
        timeOut: 10000
    });
</script>
@endif

<script>
// Get a reference to the file input element
const inputElement = document.querySelector('input[type="file"]');

FilePond.registerPlugin(FilePondPluginImagePreview);
FilePond.registerPlugin(FilePondPluginMediaPreview);
FilePond.registerPlugin(FilePondPluginPdfPreview);

// Create a FilePond instance
const pond = FilePond.create(inputElement);

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
FilePond.setOptions({
    stylePanelLayout: 'integrated',
    server: {
        process: {
            url: '/file/save', // Your process route
            method: 'POST', // or 'PUT'
            withCredentials: false, // set to true if you need to send cookies with the request
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                // 'Accept' : 'application/json'
                // 'Content-Type' : 'application/json',
            },
            onload: (response) => {
                // const message = response.message;
                // handle successful upload response
                const content = JSON.parse(response);
                completed_upload = 'Uploaded';
                $('#temporal_file_id').val(content.temp_file_id)
                console.log(content.temp_file_id);
                console.log(content.message);
            },
            onerror: (error) => {
                // handle upload error
                console.error('Error uploading file:', error);
            }
        },
        revert: './revert', // Your revert route
        restore: './restore', // Your restore route
        load: './load', // Your load route
        fetch: './fetch', // Your fetch route
    },
});
</script>
<script>

</script>
@endsection