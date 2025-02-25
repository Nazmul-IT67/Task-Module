$(function ($) {
    // USE STRICT
    "use strict";

    // uploader by Uppy
    WLL.data = {
        csrf: $('meta[name="csrf-token"]').attr("content"),
        appUrl: $('meta[name="app-url"]').attr("content"),
        fileBaseUrl: $('meta[name="file-base-url"]').attr("content"),
    };
    WLL.uploader = {
        data: {
            selectedFiles: [],
            selectedFilesObject: [],
            clickedForDelete: null,
            allFiles: [],
            multiple: false,
            type: "all",
            next_page_url: null,
            prev_page_url: null,
        },
        removeInputValue: function (id, array, elem) {
            var selected = array.filter(function (item) {
                return item !== id;
            });
            if (selected.length > 0) {
                $(elem)
                    .find(".file-amount")
                    .html(WLL.uploader.updateFileHtml(selected));
            } else {
                elem.find(".file-amount").html(WLL.local.choose_file);
            }
            $(elem).find(".selected-files").val(selected);
        },
        removeAttachment: function () {
            $(document).on("click", ".remove-attachment", function () {
                var value = $(this).closest(".file-preview-item").data("id");
                var selected = $(this)
                    .closest(".file-preview")
                    .prev('[data-toggle="wlluploader"]')
                    .find(".selected-files")
                    .val()
                    .split(",")
                    .map(Number);

                WLL.uploader.removeInputValue(
                    value,
                    selected,
                    $(this)
                        .closest(".file-preview")
                        .prev('[data-toggle="wlluploader"]')
                );
                $(this).closest(".file-preview-item").remove();
            });
        },
        deleteUploaderFile: function () {
            $(".wll-uploader-delete").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    var id = $(this).data("id");
                    WLL.uploader.data.clickedForDelete = id;
                    $("#wllUploaderDelete").modal("show");

                    $(".wll-uploader-confirmed-delete").on(
                        "click",
                        function (e) {
                            e.preventDefault();
                            if (e.detail === 1) {
                                var clickedForDeleteObject =
                                    WLL.uploader.data.allFiles[
                                        WLL.uploader.data.allFiles.findIndex(
                                            (x) =>
                                                x.id ===
                                                WLL.uploader.data
                                                    .clickedForDelete
                                        )
                                    ];
                                $.ajax({
                                    url:
                                        WLL.data.appUrl +
                                        "uploaded-files/destroy/" +
                                        WLL.uploader.data.clickedForDelete,
                                    type: "DELETE",
                                    dataType: "JSON",
                                    data: {
                                        id: WLL.uploader.data.clickedForDelete,
                                        _method: "DELETE",
                                        _token: WLL.data.csrf,
                                    },
                                    success: function () {
                                        WLL.uploader.data.selectedFiles =
                                            WLL.uploader.data.selectedFiles.filter(
                                                function (item) {
                                                    return (
                                                        item !==
                                                        WLL.uploader.data
                                                            .clickedForDelete
                                                    );
                                                }
                                            );
                                        WLL.uploader.data.selectedFilesObject =
                                            WLL.uploader.data.selectedFilesObject.filter(
                                                function (item) {
                                                    return (
                                                        item !==
                                                        clickedForDeleteObject
                                                    );
                                                }
                                            );
                                        WLL.uploader.updateUploaderSelected();
                                        WLL.uploader.getAllUploads(
                                            WLL.data.appUrl +
                                                "wll-uploader/get-uploaded-files"
                                        );
                                        WLL.uploader.data.clickedForDelete =
                                            null;
                                        $("#wllUploaderDelete").modal("hide");
                                    },
                                });
                            }
                        }
                    );
                });
            });
        },
        uploadSelect: function () {
            $(".wll-uploader-select").each(function () {
                var elem = $(this);
                elem.on("click", function (e) {
                    var value = $(this).data("value");
                    var valueObject =
                        WLL.uploader.data.allFiles[
                            WLL.uploader.data.allFiles.findIndex(
                                (x) => x.id === value
                            )
                        ];
                    // console.log(valueObject);

                    elem.closest(".wll-file-box-wrap").toggleAttr(
                        "data-selected",
                        "true",
                        "false"
                    );
                    if (!WLL.uploader.data.multiple) {
                        elem.closest(".wll-file-box-wrap")
                            .siblings()
                            .attr("data-selected", "false");
                    }
                    if (!WLL.uploader.data.selectedFiles.includes(value)) {
                        if (!WLL.uploader.data.multiple) {
                            WLL.uploader.data.selectedFiles = [];
                            WLL.uploader.data.selectedFilesObject = [];
                        }
                        WLL.uploader.data.selectedFiles.push(value);
                        WLL.uploader.data.selectedFilesObject.push(valueObject);
                    } else {
                        WLL.uploader.data.selectedFiles =
                            WLL.uploader.data.selectedFiles.filter(function (
                                item
                            ) {
                                return item !== value;
                            });
                        WLL.uploader.data.selectedFilesObject =
                            WLL.uploader.data.selectedFilesObject.filter(
                                function (item) {
                                    return item !== valueObject;
                                }
                            );
                    }
                    WLL.uploader.addSelectedValue();
                    WLL.uploader.updateUploaderSelected();
                });
            });
        },
        updateFileHtml: function (array) {
            var fileText = "";
            if (array.length > 1) {
                var fileText = WLL.local.files_selected;
            } else {
                var fileText = WLL.local.file_selected;
            }
            return array.length + " " + fileText;
        },
        updateUploaderSelected: function () {
            $(".wll-uploader-selected").html(
                WLL.uploader.updateFileHtml(WLL.uploader.data.selectedFiles)
            );
        },
        clearUploaderSelected: function () {
            $(".wll-uploader-selected-clear").on("click", function () {
                WLL.uploader.data.selectedFiles = [];
                WLL.uploader.addSelectedValue();
                WLL.uploader.addHiddenValue();
                WLL.uploader.resetFilter();
                WLL.uploader.updateUploaderSelected();
                WLL.uploader.updateUploaderFiles();
            });
        },
        resetFilter: function () {
            $('[name="wll-uploader-search"]').val("");
            $('[name="wll-show-selected"]').prop("checked", false);
            $('[name="wll-uploader-sort"] option[value=newest]').prop(
                "selected",
                true
            );
        },
        getAllUploads: function (url, search_key = null, sort_key = null) {
            $(".wll-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );
            var params = {};
            if (search_key != null && search_key.length > 0) {
                params["search"] = search_key;
            }
            if (sort_key != null && sort_key.length > 0) {
                params["sort"] = sort_key;
            } else {
                params["sort"] = "newest";
            }
            $.get(url, params, function (data, status) {
                // console.log(data);
                if (typeof data == "string") {
                    data = JSON.parse(data);
                }
                WLL.uploader.data.allFiles = data.data;
                WLL.uploader.allowedFileType();
                WLL.uploader.addSelectedValue();
                WLL.uploader.addHiddenValue();
                // WLL.uploader.resetFilter();
                WLL.uploader.updateUploaderFiles();
                if (data.next_page_url != null) {
                    WLL.uploader.data.next_page_url = data.next_page_url;
                    $("#uploader_next_btn").removeAttr("disabled");
                } else {
                    $("#uploader_next_btn").attr("disabled", true);
                }
                if (data.prev_page_url != null) {
                    WLL.uploader.data.prev_page_url = data.prev_page_url;
                    $("#uploader_prev_btn").removeAttr("disabled");
                } else {
                    $("#uploader_prev_btn").attr("disabled", true);
                }
            });
        },
        showSelectedFiles: function () {
            $('[name="wll-show-selected"]').on("change", function () {
                if ($(this).is(":checked")) {
                    // for (
                    //     var i = 0;
                    //     i < WLL.uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     if (WLL.uploader.data.allFiles[i].selected) {
                    //         WLL.uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = false;
                    //     } else {
                    //         WLL.uploader.data.allFiles[
                    //             i
                    //         ].aria_hidden = true;
                    //     }
                    // }
                    WLL.uploader.data.allFiles =
                        WLL.uploader.data.selectedFilesObject;
                } else {
                    // for (
                    //     var i = 0;
                    //     i < WLL.uploader.data.allFiles.length;
                    //     i++
                    // ) {
                    //     WLL.uploader.data.allFiles[
                    //         i
                    //     ].aria_hidden = false;
                    // }
                    WLL.uploader.getAllUploads(
                        WLL.data.appUrl + "wll-uploader/get-uploaded-files"
                    );
                }
                WLL.uploader.updateUploaderFiles();
            });
        },
        searchUploaderFiles: function () {
            $('[name="wll-uploader-search"]').on("keyup", function () {
                var value = $(this).val();
                WLL.uploader.getAllUploads(
                    WLL.data.appUrl + "wll-uploader/get-uploaded-files",
                    value,
                    $('[name="wll-uploader-sort"]').val()
                );
                // if (WLL.uploader.data.allFiles.length > 0) {
                //     for (
                //         var i = 0;
                //         i < WLL.uploader.data.allFiles.length;
                //         i++
                //     ) {
                //         if (
                //             WLL.uploader.data.allFiles[
                //                 i
                //             ].file_original_name
                //                 .toUpperCase()
                //                 .indexOf(value) > -1
                //         ) {
                //             WLL.uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = false;
                //         } else {
                //             WLL.uploader.data.allFiles[
                //                 i
                //             ].aria_hidden = true;
                //         }
                //     }
                // }
                //WLL.uploader.updateUploaderFiles();
            });
        },
        sortUploaderFiles: function () {
            $('[name="wll-uploader-sort"]').on("change", function () {
                var value = $(this).val();
                WLL.uploader.getAllUploads(
                    WLL.data.appUrl + "wll-uploader/get-uploaded-files",
                    $('[name="wll-uploader-search"]').val(),
                    value
                );

                // if (value === "oldest") {
                //     WLL.uploader.data.allFiles = WLL.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return (
                //                 new Date(a.created_at) - new Date(b.created_at)
                //             );
                //         }
                //     );
                // } else if (value === "smallest") {
                //     WLL.uploader.data.allFiles = WLL.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return a.file_size - b.file_size;
                //         }
                //     );
                // } else if (value === "largest") {
                //     WLL.uploader.data.allFiles = WLL.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             return b.file_size - a.file_size;
                //         }
                //     );
                // } else {
                //     WLL.uploader.data.allFiles = WLL.uploader.data.allFiles.sort(
                //         function(a, b) {
                //             a = new Date(a.created_at);
                //             b = new Date(b.created_at);
                //             return a > b ? -1 : a < b ? 1 : 0;
                //         }
                //     );
                // }
                //WLL.uploader.updateUploaderFiles();
            });
        },
        addSelectedValue: function () {
            for (var i = 0; i < WLL.uploader.data.allFiles.length; i++) {
                if (
                    !WLL.uploader.data.selectedFiles.includes(
                        WLL.uploader.data.allFiles[i].id
                    )
                ) {
                    WLL.uploader.data.allFiles[i].selected = false;
                } else {
                    WLL.uploader.data.allFiles[i].selected = true;
                }
            }
        },
        addHiddenValue: function () {
            for (var i = 0; i < WLL.uploader.data.allFiles.length; i++) {
                WLL.uploader.data.allFiles[i].aria_hidden = false;
            }
        },
        allowedFileType: function () {
            if (WLL.uploader.data.type !== "all") {
                let type = WLL.uploader.data.type.split(",");
                WLL.uploader.data.allFiles = WLL.uploader.data.allFiles.filter(
                    function (item) {
                        return type.includes(item.type);
                    }
                );
            }
        },
        updateUploaderFiles: function () {
            $(".wll-uploader-all").html(
                '<div class="align-items-center d-flex h-100 justify-content-center w-100"><div class="spinner-border" role="status"></div></div>'
            );

            var data = WLL.uploader.data.allFiles;

            setTimeout(function () {
                $(".wll-uploader-all").html(null);

                if (data.length > 0) {
                    for (var i = 0; i < data.length; i++) {
                        var thumb = "";
                        var hidden = "";
                        if (data[i].type === "image") {
                            thumb =
                                '<img src="' +
                                WLL.data.fileBaseUrl +
                                data[i].file_name +
                                '" class="img-fit">';
                        } else {
                            thumb =
                                '<i class="mdi mdi-play-circle-outline"></i>';
                        }
                        var html =
                            '<div class="wll-file-box-wrap" aria-hidden="' +
                            data[i].aria_hidden +
                            '" data-selected="' +
                            data[i].selected +
                            '">' +
                            '<div class="wll-file-box">' +
                            // '<div class="dropdown-file">' +
                            // '<a class="dropdown-link" data-toggle="dropdown">' +
                            // '<i class="la la-ellipsis-v"></i>' +
                            // "</a>" +
                            // '<div class="dropdown-menu dropdown-menu-right">' +
                            // '<a href="' +
                            // WLL.data.fileBaseUrl +
                            // data[i].file_name +
                            // '" target="_blank" download="' +
                            // data[i].file_original_name +
                            // "." +
                            // data[i].extension +
                            // '" class="dropdown-item"><i class="la la-download mr-2"></i>Download</a>' +
                            // '<a href="#" class="dropdown-item wll-uploader-delete" data-id="' +
                            // data[i].id +
                            // '"><i class="la la-trash mr-2"></i>Delete</a>' +
                            // "</div>" +
                            // "</div>" +
                            '<div class="card card-file wll-uploader-select" title="' +
                            data[i].file_original_name +
                            "." +
                            data[i].extension +
                            '" data-value="' +
                            data[i].id +
                            '">' +
                            '<div class="card-file-thumb">' +
                            thumb +
                            "</div>" +
                            '<div class="card-body">' +
                            '<h6 class="d-flex">' +
                            '<span class="text-truncate title">' +
                            data[i].file_original_name +
                            "</span>" +
                            '<span class="ext flex-shrink-0">.' +
                            data[i].extension +
                            "</span>" +
                            "</h6>" +
                            "<p>" +
                            WLL.extra.bytesToSize(data[i].file_size) +
                            "</p>" +
                            "</div>" +
                            "</div>" +
                            "</div>" +
                            "</div>";

                        $(".wll-uploader-all").append(html);
                    }
                } else {
                    $(".wll-uploader-all").html(
                        '<div class="align-items-center d-flex h-100 justify-content-center w-100 nav-tabs"><div class="text-center"><h3>No files found</h3></div></div>'
                    );
                }
                WLL.uploader.uploadSelect();
                WLL.uploader.deleteUploaderFile();
            }, 300);
        },
        inputSelectPreviewGenerate: function (elem) {
            elem.find(".selected-files").val(WLL.uploader.data.selectedFiles);
            elem.next(".file-preview").html(null);

            if (WLL.uploader.data.selectedFiles.length > 0) {
                $.post(
                    WLL.data.appUrl + "wll-uploader/get_file_by_ids",
                    {
                        _token: WLL.data.csrf,
                        ids: WLL.uploader.data.selectedFiles.toString(),
                    },
                    function (data) {
                        elem.next(".file-preview").html(null);

                        if (data.length > 0) {
                            elem.find(".file-amount").html(
                                WLL.uploader.updateFileHtml(data)
                            );
                            for (var i = 0; i < data.length; i++) {
                                var thumb = "";
                                if (data[i].type === "image") {
                                    thumb =
                                        '<img src="' +
                                        data[i].file_name +
                                        '" class="img-fit">';
                                } else {
                                    thumb = '<i class="la la-file-text"></i>';
                                }
                                var html =
                                    '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                    data[i].id +
                                    '" title="' +
                                    data[i].file_original_name +
                                    "." +
                                    data[i].extension +
                                    '">' +
                                    '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                    thumb +
                                    "</div>" +
                                    '<div class="col body">' +
                                    '<h6 class="d-flex">' +
                                    '<span class="text-truncate title">' +
                                    data[i].file_original_name +
                                    "</span>" +
                                    '<span class="flex-shrink-0 ext">.' +
                                    data[i].extension +
                                    "</span>" +
                                    "</h6>" +
                                    "<p>" +
                                    WLL.extra.bytesToSize(data[i].file_size) +
                                    "</p>" +
                                    "</div>" +
                                    '<div class="remove">' +
                                    '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                    '<i class="mdi mdi-close-circle"></i>' +
                                    "</button>" +
                                    "</div>" +
                                    "</div>";

                                elem.next(".file-preview").append(html);
                            }
                        } else {
                            elem.find(".file-amount").html(
                                WLL.local.choose_file
                            );
                        }
                    }
                );
            } else {
                elem.find(".file-amount").html(WLL.local.choose_file);
            }

            // if (WLL.uploader.data.selectedFiles.length > 0) {
            //     elem.find(".file-amount").html(
            //         WLL.uploader.updateFileHtml(WLL.uploader.data.selectedFiles)
            //     );
            //     for (
            //         var i = 0;
            //         i < WLL.uploader.data.selectedFiles.length;
            //         i++
            //     ) {
            //         var index = WLL.uploader.data.allFiles.findIndex(
            //             (x) => x.id === WLL.uploader.data.selectedFiles[i]
            //         );
            //         var thumb = "";
            //         if (WLL.uploader.data.allFiles[index].type == "image") {
            //             thumb =
            //                 '<img src="' +
            //                 WLL.data.appUrl +
            //                 "/public/" +
            //                 WLL.uploader.data.allFiles[index].file_name +
            //                 '" class="img-fit">';
            //         } else {
            //             thumb = '<i class="la la-file-text"></i>';
            //         }
            //         var html =
            //             '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
            //             WLL.uploader.data.allFiles[index].id +
            //             '" title="' +
            //             WLL.uploader.data.allFiles[index].file_original_name +
            //             "." +
            //             WLL.uploader.data.allFiles[index].extension +
            //             '">' +
            //             '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
            //             thumb +
            //             "</div>" +
            //             '<div class="col body">' +
            //             '<h6 class="d-flex">' +
            //             '<span class="text-truncate title">' +
            //             WLL.uploader.data.allFiles[index].file_original_name +
            //             "</span>" +
            //             '<span class="ext">.' +
            //             WLL.uploader.data.allFiles[index].extension +
            //             "</span>" +
            //             "</h6>" +
            //             "<p>" +
            //             WLL.extra.bytesToSize(
            //                 WLL.uploader.data.allFiles[index].file_size
            //             ) +
            //             "</p>" +
            //             "</div>" +
            //             '<div class="remove">' +
            //             '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
            //             '<i class="la la-close"></i>' +
            //             "</button>" +
            //             "</div>" +
            //             "</div>";

            //         elem.next(".file-preview").append(html);
            //     }
            // } else {
            //     elem.find(".file-amount").html("Choose File");
            // }
        },
        editorImageGenerate: function (elem) {
            if (WLL.uploader.data.selectedFiles.length > 0) {
                for (
                    var i = 0;
                    i < WLL.uploader.data.selectedFiles.length;
                    i++
                ) {
                    var index = WLL.uploader.data.allFiles.findIndex(
                        (x) => x.id === WLL.uploader.data.selectedFiles[i]
                    );
                    var thumb = "";
                    if (WLL.uploader.data.allFiles[index].type === "image") {
                        thumb =
                            '<img src="' +
                            WLL.data.fileBaseUrl +
                            WLL.uploader.data.allFiles[index].file_name +
                            '">';
                        elem[0].insertHTML(thumb);
                        // console.log(elem);
                    }
                }
            }
        },
        dismissUploader: function () {
            $("#wllUploaderModal").on("hidden.bs.modal", function () {
                $(".wll-uploader-backdrop").remove();
                $("#wllUploaderModal").remove();
            });
        },
        trigger: function (
            elem = null,
            from = "",
            type = "all",
            selectd = "",
            multiple = false,
            callback = null
        ) {
            // $("body").append('<div class="wll-uploader-backdrop"></div>');

            var elem = $(elem);
            var multiple = multiple;
            var type = type;
            var oldSelectedFiles = selectd;
            if (oldSelectedFiles !== "") {
                WLL.uploader.data.selectedFiles = oldSelectedFiles
                    .split(",")
                    .map(Number);
            } else {
                WLL.uploader.data.selectedFiles = [];
            }
            if ("undefined" !== typeof type && type.length > 0) {
                WLL.uploader.data.type = type;
            }

            if (multiple) {
                WLL.uploader.data.multiple = true;
            } else {
                WLL.uploader.data.multiple = false;
            }

            // setTimeout(function() {
            $.post(
                WLL.data.appUrl + "wll-uploader",
                { _token: WLL.data.csrf },
                function (data) {
                    $("body").append(data);
                    $("#wllUploaderModal").modal("show");
                    WLL.plugins.wllUppy();
                    WLL.uploader.getAllUploads(
                        WLL.data.appUrl + "wll-uploader/get-uploaded-files",
                        null,
                        $('[name="wll-uploader-sort"]').val()
                    );
                    WLL.uploader.updateUploaderSelected();
                    WLL.uploader.clearUploaderSelected();
                    WLL.uploader.sortUploaderFiles();
                    WLL.uploader.searchUploaderFiles();
                    WLL.uploader.showSelectedFiles();
                    WLL.uploader.dismissUploader();

                    $("#uploader_next_btn").on("click", function () {
                        if (WLL.uploader.data.next_page_url != null) {
                            $('[name="wll-show-selected"]').prop(
                                "checked",
                                false
                            );
                            WLL.uploader.getAllUploads(
                                WLL.uploader.data.next_page_url
                            );
                        }
                    });

                    $("#uploader_prev_btn").on("click", function () {
                        if (WLL.uploader.data.prev_page_url != null) {
                            $('[name="wll-show-selected"]').prop(
                                "checked",
                                false
                            );
                            WLL.uploader.getAllUploads(
                                WLL.uploader.data.prev_page_url
                            );
                        }
                    });

                    $(".wll-uploader-search i").on("click", function () {
                        $(this).parent().toggleClass("open");
                    });

                    $('[data-toggle="wllUploaderAddSelected"]').on(
                        "click",
                        function () {
                            if (from === "input") {
                                WLL.uploader.inputSelectPreviewGenerate(elem);
                            } else if (from === "direct") {
                                callback(WLL.uploader.data.selectedFiles);
                            }
                            $("#wllUploaderModal").modal("hide");
                        }
                    );
                }
            );
            // }, 50);
        },
        initForInput: function () {
            $(document).on(
                "click",
                '[data-toggle="wlluploader"]',
                function (e) {
                    if (e.detail === 1) {
                        var elem = $(this);
                        var multiple = elem.data("multiple");
                        var type = elem.data("type");
                        var oldSelectedFiles = elem
                            .find(".selected-files")
                            .val();

                        multiple = !multiple ? "" : multiple;
                        type = !type ? "" : type;
                        oldSelectedFiles = !oldSelectedFiles
                            ? ""
                            : oldSelectedFiles;

                        WLL.uploader.trigger(
                            this,
                            "input",
                            type,
                            oldSelectedFiles,
                            multiple
                        );
                    }
                }
            );
        },
        previewGenerate: function () {
            $('[data-toggle="wlluploader"]').each(function () {
                var $this = $(this);
                var files = $this.find(".selected-files").val();
                if (files != "") {
                    $.post(
                        WLL.data.appUrl + "wll-uploader/get_file_by_ids",
                        { _token: WLL.data.csrf, ids: files },
                        function (data) {
                            $this.next(".file-preview").html(null);

                            if (data.length > 0) {
                                $this
                                    .find(".file-amount")
                                    .html(WLL.uploader.updateFileHtml(data));
                                for (var i = 0; i < data.length; i++) {
                                    var thumb = "";
                                    if (data[i].type === "image") {
                                        thumb =
                                            '<img src="' +
                                            data[i].file_name +
                                            '" class="img-fit">';
                                    } else {
                                        thumb =
                                            '<i class="la la-file-text"></i>';
                                    }
                                    var html =
                                        '<div class="d-flex justify-content-between align-items-center mt-2 file-preview-item" data-id="' +
                                        data[i].id +
                                        '" title="' +
                                        data[i].file_original_name +
                                        "." +
                                        data[i].extension +
                                        '">' +
                                        '<div class="align-items-center align-self-stretch d-flex justify-content-center thumb">' +
                                        thumb +
                                        "</div>" +
                                        '<div class="col body">' +
                                        '<h6 class="d-flex">' +
                                        '<span class="text-truncate title">' +
                                        data[i].file_original_name +
                                        "</span>" +
                                        '<span class="ext flex-shrink-0">.' +
                                        data[i].extension +
                                        "</span>" +
                                        "</h6>" +
                                        "<p>" +
                                        WLL.extra.bytesToSize(
                                            data[i].file_size
                                        ) +
                                        "</p>" +
                                        "</div>" +
                                        '<div class="remove">' +
                                        '<button class="btn btn-sm btn-link remove-attachment" type="button">' +
                                        '<i class="la la-close"></i>' +
                                        "</button>" +
                                        "</div>" +
                                        "</div>";

                                    $this.next(".file-preview").append(html);
                                }
                            } else {
                                $this
                                    .find(".file-amount")
                                    .html(WLL.local.choose_file);
                            } 
                        }
                    );
                }
            });
        },
    };
    WLL.plugins = {
        notify: function (heading = "Success", message = "", icon = "") {
            $.toast({
                heading: heading,
                text: message,
                icon: icon,
                showHideTransition: "fade",
                position: "top-right",
            });
        },
        wllUppy: function () {
            if ($("#wll-upload-files").length > 0) {
                var uppy = Uppy.Core({
                    autoProceed: true,
                });
                uppy.use(Uppy.Dashboard, {
                    target: "#wll-upload-files",
                    inline: true,
                    showLinkToFileUploadResult: false,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hidePauseResumeButton: true,
                    hideUploadButton: true,
                    proudlyDisplayPoweredByUppy: false,
                    locale: {
                        strings: {
                            addMoreFiles: WLL.local.add_more_files,
                            addingMoreFiles: WLL.local.adding_more_files,
                            dropPaste:
                                WLL.local.drop_files_here_paste_or +
                                " %{browse}",
                            browse: WLL.local.browse,
                            uploadComplete: WLL.local.upload_complete,
                            uploadPaused: WLL.local.upload_paused,
                            resumeUpload: WLL.local.resume_upload,
                            pauseUpload: WLL.local.pause_upload,
                            retryUpload: WLL.local.retry_upload,
                            cancelUpload: WLL.local.cancel_upload,
                            xFilesSelected: {
                                0: "%{smart_count} " + WLL.local.file_selected,
                                1: "%{smart_count} " + WLL.local.files_selected,
                            },
                            uploadingXFiles: {
                                0:
                                    WLL.local.uploading +
                                    " %{smart_count} " +
                                    WLL.local.file,
                                1:
                                    WLL.local.uploading +
                                    " %{smart_count} " +
                                    WLL.local.files,
                            },
                            processingXFiles: {
                                0:
                                    WLL.local.processing +
                                    " %{smart_count} " +
                                    WLL.local.file,
                                1:
                                    WLL.local.processing +
                                    " %{smart_count} " +
                                    WLL.local.files,
                            },
                            uploading: WLL.local.uploading,
                            complete: WLL.local.complete,
                        },
                    },
                });
                uppy.use(Uppy.XHRUpload, {
                    endpoint: WLL.data.appUrl + "wll-uploader/upload",
                    fieldName: "wll_doc_file",
                    formData: true,
                    headers: {
                        "X-CSRF-TOKEN": WLL.data.csrf,
                    },
                });
                uppy.on("upload-success", function () {
                    WLL.uploader.getAllUploads(
                        WLL.data.appUrl + "wll-uploader/get-uploaded-files"
                    );
                });
            }
        },
    };

    WLL.extra = {
        refreshToken: function () {
            $.get(WLL.data.appUrl + "/refresh-csrf").done(function (data) {
                WLL.data.csrf = data;
            });
            // console.log(WLL.data.csrf);
        },
        bytesToSize: function (bytes) {
            var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
            if (bytes == 0) return "0 Byte";
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
        },
    };
});
