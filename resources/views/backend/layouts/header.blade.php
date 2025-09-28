<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('backend/img/icons/favicon.png') }}" type="image/x-icon">

    <title>Simple Task</title>

    <!-- Toaster -->
    <link rel="stylesheet" href="{{ asset('backend/css/toastr.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet">
    <!-- Main CSS -->
    <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">

</head>
