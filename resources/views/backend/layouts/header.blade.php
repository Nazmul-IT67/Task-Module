<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="app-url" content="{{ getBaseURL() }}">
    <meta name="file-base-url" content="{{ getFileBaseURL() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="BhorerAlo">
    <meta name="keywords"
        content="BhorerAlo, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="shortcut icon" href="{{ asset('backend/img/icons/favicon.png') }}" type="image/x-icon">

    <title>Bhorer-Alo Admin Dashboard</title>
    {{-- Toaster --}}
    <link rel="stylesheet" href="{{ asset('backend/css/toastr.min.css')}}">
    <!-- Uppy CSS -->
    <link rel="stylesheet" href="{{ asset('backend/css/uppy.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    <!-- Main CSS -->
    <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">


    @stack('css')

    <script>
        var WLL = WLL || {};
        WLL.local = {
            nothing_selected: '{!! 'Nothing selected', null, true !!}',
            nothing_found: '{!! 'Nothing found', null, true !!}',
            choose_file: 'Choose file',
            file_selected: 'File selected',
            files_selected: 'Files selected',
            add_more_files: 'Add more files',
            adding_more_files: 'Adding more files',
            drop_files_here_paste_or: 'Drop files here, paste or',
            browse: 'Browse',
            upload_complete: 'Upload complete',
            upload_paused: 'Upload paused',
            resume_upload: 'Resume upload',
            pause_upload: 'Pause upload',
            retry_upload: 'Retry upload',
            cancel_upload: 'Cancel upload',
            uploading: 'Uploading',
            processing: 'Processing',
            complete: 'Complete',
            file: 'File',
            files: 'Files',
        }
    </script>
</head>
