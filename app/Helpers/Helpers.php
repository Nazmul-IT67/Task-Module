<?php

use Illuminate\Support\Str;

// Edit Button
if (!function_exists('edit_btn')) {
    function edit_btn($route)
    {
        $edit_btn = '<a href="' . $route . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="warning-tooltip" data-bs-title="' . ("Edit") . '" class="btn btn-sm btn-outline-warning"> <i class="mdi mdi-square-edit-outline"></i></a>';
        return $edit_btn;
    }
}

// Delete Button
if (!function_exists('trash_btn')) {
    function trash_btn($route)
    {
        $trash_btn = '<a href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="danger-tooltip" data-bs-title="' . ("Trash") . '" class="btn btn-sm btn-outline-danger confirm-trash" data-href="' . $route . '"><i class="mdi mdi-delete"></i></a>';
        return $trash_btn;
    }
}
