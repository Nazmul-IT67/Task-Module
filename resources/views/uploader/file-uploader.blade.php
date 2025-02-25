<!-- Modal -->
<div class="modal fade" id="wllUploaderModal" tabindex="-1" aria-labelledby="wllUploaderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content h-100">
            <div class="modal-header pb-0 bg-light">
                <ul class="nav nav-tabs" id="wllTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="select-file-tab" data-bs-toggle="tab"
                            data-bs-target="#wll-select-file" type="button" role="tab"
                            aria-controls="wll-select-file" aria-selected="true">Select File</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-new-tab" data-bs-toggle="tab"
                            data-bs-target="#wll-upload-new" type="button" role="tab"
                            aria-controls="wll-upload-new" aria-selected="false">Upload New</button>
                    </li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content h-100" id="wllTabContent">
                    <div class="tab-pane fade show active h-100" id="wll-select-file" role="tabpanel"
                        aria-labelledby="select-file-tab" tabindex="0">
                        <div class="wll-uploader-filter pt-1 pb-3 border-bottom mb-4">
                            <div class="row align-items-center gutters-5 gutters-md-10 position-relative">
                                <div class="col-xl-2 col-md-3 col-5">
                                    <div class="">
                                        <!-- Input -->
                                        <select class="form-control form-control-xs wll-selectpicker"
                                            name="wll-uploader-sort">
                                            <option value="newest" selected>Sort by newest</option>
                                            <option value="oldest">Sort by oldest</option>
                                            <option value="smallest">Sort by smallest</option>
                                            <option value="largest">Sort by largest</option>
                                        </select>
                                        <!-- End Input -->
                                    </div>
                                </div>
                                <div class="col-md-3 col-5">
                                    <div class="custom-control custom-radio">
                                        <input type="checkbox" class="custom-control-input" name="wll-show-selected"
                                            id="wll-show-selected" name="stylishRadio">
                                        <label class="custom-control-label" for="wll-show-selected">
                                            Selected Only
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl-3 ms-auto me-0 col-2 position-static">
                                    <div class="wll-uploader-search text-end">
                                        <input type="text" class="form-control form-control-xs"
                                            name="wll-uploader-search"
                                            placeholder="Search your files">
                                        <i class="search-icon d-md-none"><span></span></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="wll-uploader-all clearfix c-scrollbar-light">
                            <div class="align-items-center d-flex h-100 justify-content-center w-100">
                                <div class="text-center">
                                    <h3>No files found</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade h-100" id="wll-upload-new" role="tabpanel"
                        aria-labelledby="upload-new-tab" tabindex="0">
                        <div id="wll-upload-files" class="h-100">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between bg-light">
                <div class="flex-grow-1 overflow-hidden d-flex">
                    <div class="">
                        <div class="wll-uploader-selected">0 File selected</div>
                        <button type="button"
                            class="btn-link btn btn-sm p-0 wll-uploader-selected-clear">Clear</button>
                    </div>
                    <div class="mb-0 ml-3">
                        <button type="button" class="btn btn-sm btn-primary"
                            id="uploader_prev_btn">Prev</button>
                        <button type="button" class="btn btn-sm btn-primary"
                            id="uploader_next_btn">Next</button>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-primary"
                    data-toggle="wllUploaderAddSelected">Add Files</button>
            </div>
        </div>
    </div>
</div>
