@extends('admin')
@section('content')
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title h3">All Files</h3>
                    <a href="{{ route('uploaded-files.create') }}" class="btn btn-info">Upload New Files</a>
                </div>

                <div class="row btn-danger">
                    <div class="col-md-2">
                        <!-- Button to trigger modal -->
                        <button id="openModalBtn" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#customModal">
                            Delete Selected
                        </button>
                    </div>

                    <div class="col-md-3">
                        <select class="form-control form-control-xs" name="sort" onchange="sort_uploads()">
                            <option value="newest" @if ($sort_by == 'newest') selected="" @endif>
                                Sort by newest</option>
                            <option value="oldest" @if ($sort_by == 'oldest') selected="" @endif>
                                Sort by oldest</option>
                            <option value="smallest" @if ($sort_by == 'smallest') selected="" @endif>
                                Sort by smallest</option>
                            <option value="largest" @if ($sort_by == 'largest') selected="" @endif>
                                Sort by largest</option>
                        </select>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex">
                            <input type="text" id="search" name="search" class="form-control"
                                placeholder="Search Your File">
                            <button type="submit" class="btn btn-info">Search</button>
                        </div>
                    </div>
                </div>
                <div class="hr-line">
                    <hr>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input id="check-all" type="checkbox" class="form-check-input dt-checkboxes">
                                    Select All
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">

                        @foreach ($all_uploads as $key => $file)
                            @php
                                if ($file->file_original_name == null) {
                                    $file_name = 'Unknown';
                                } else {
                                    $file_name = $file->file_original_name;
                                }
                                $file_path = my_asset($file->file_name);
                                if ($file->external_link) {
                                    $file_path = $file->external_link;
                                }

                            @endphp
                            <div class="col-6 col-md-3">
                                <!-- Image card -->
                                <div class="card border border-1 border-primary">
                                    <div class="card-body position-relative p-1">
                                        <div class="threedot">
                                            <!-- image checkbox -->
                                            <label class="form-check-label thumb-selectbox">
                                                <input type="checkbox" class="form-check-input dt-checkboxes check-one"
                                                    name="id[]" value="{{ $file->id }}">
                                            </label>

                                            <div class="dropdown card-widgets thumb-dropdown">
                                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="align-middle" data-feather="more-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <!-- item-->
                                                    <a href="javascript:void(0)" class="dropdown-item"
                                                        onclick="detailsInfo(this)" data-id="{{ $file->id }}">
                                                        <i class="align-middle me-1" data-feather="info"></i>
                                                        <span>File Info</span>
                                                    </a>
                                                    <a href="{{ my_asset($file->file_name) }}" target="_blank"
                                                        download="{{ $file_name }}.{{ $file->extension }}"
                                                        class="dropdown-item">
                                                        <i class="align-middle me-1" data-feather="download"></i>
                                                        <span>Download</span>
                                                    </a>
                                                    <a href="javascript:void(0)" class="dropdown-item"
                                                        onclick="copyUrl(this)" data-url="{{ my_asset($file->file_name) }}">
                                                        <i class="align-middle me-1" data-feather="copy"></i>
                                                        <span>Copy Link</span>
                                                    </a>
                                                    <a href="javascript:void(0)" class="dropdown-item confirm-delete"
                                                        data-href="{{ route('uploaded-files.destroy', $file->id) }}">
                                                        <i class="align-middle me-1" data-feather="trash-2"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thumb-img">
                                            @if ($file->type == 'image')
                                                <img src="{{ $file_path }}" alt="img-fluid" class="img-fit">
                                            @elseif($file->type == 'video')
                                                <i class="mdi mdi-play-circle-outline"></i>
                                            @else
                                                <i class="mdi mdi-file-document"></i>
                                            @endif
                                        </div>
                                    </div> <!-- end card-body-->
                                    <div class="card-footer p-0 ps-1 pe-1">
                                        <h6 class="d-flex m-0">
                                            <span class="text-truncate title">{{ $file_name }}</span>
                                            <span class="ext">.{{ $file->extension }}</span>
                                        </h6>
                                        <span>{{ formatBytes($file->file_size) }}</span>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        @endforeach
                    </div>
                    <div class="showing text-center mb-3">
                        {!! $all_uploads->appends(request()->input())->links('vendor.pagination.custom') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Delete modal -->
    @include('backend.files.modals.bulk_delete')
    <!-- Info modal -->
    @include('backend.files.modals.info')
@endsection

@section('footer_js')
    @include('js.admin.uploads')
@endsection
