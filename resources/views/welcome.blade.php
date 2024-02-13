<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!--TOKEN-->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Validations</title>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!--FIilepond css Plugin-->
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <!--Filepond Image Preview-->
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->

    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #form_container {
            width: 300px;
        }

        #submit_btn {
            margin-top: 20px;
        }

        a.filepond--credits {
            display: none;
        }
    </style>
</head>

<body class="">
    <div class="container">
        <div class="row">
            <div class="" id="form_container">
                <form action="{{ route('product.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
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
                    </div>
                    <div class="mb-3">
                        <label class="text-muted" for="">Product Name</label>
                        <input class="form-control" type="text" name="name" id="name">
                    </div>
                    <div class="mb-3">
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
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!--FIilepond js Plugin-->
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<!--Filepond Image Preview js-->
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>

<script>
    // Get a reference to the file input element
    const inputElement = document.querySelector('input[type="file"]');
    FilePond.registerPlugin(FilePondPluginImagePreview);
    // Create a FilePond instance
    const pond = FilePond.create(inputElement);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    FilePond.setOptions({
        imagePreviewMaxHeight: 150,
        imagePreviewMaxWidth: 150,

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
