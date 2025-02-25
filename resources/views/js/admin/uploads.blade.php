<script type="text/javascript">
    $(document).on("change", "#check-all", function() {
        if (this.checked) {
            // Iterate each checkbox
            $('.check-one:checkbox').each(function() {
                this.checked = true;
            });
        } else {
            $('.check-one:checkbox').each(function() {
                this.checked = false;
            });
        }
    });

    function detailsInfo(e) {
        var id = $(e).data('id')
        $('#infoModal').modal('show');
        $.post('{{ route('uploaded_files_info') }}', {
            _token: WLL.data.csrf,
            id: id
        }, function(data) {
            $('#info-modal-content').empty();
            $('#info-modal-content').html(data);
        });
    }

    function copyUrl(e) {
        var url = $(e).data('url');
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(url).select();
        try {
            document.execCommand("copy");
            WLL.plugins.notify("Success", "Link copied to clipboard",
                "success");
        } catch (err) {
            WLL.plugins.notify("Error", "Oops, unable to copy", "error");
        }
        $temp.remove();
    }

    function sort_uploads(el) {
        $('#sort_uploads').submit();
    }

    // Delete selectedFiles
    window.bulk_delete = function() {
        var selectedFiles = [];
        $('input[name="id[]"]:checked').each(function() {
            selectedFiles.push($(this).val());
        });

        console.log("Selected File IDs:", selectedFiles);

        if (selectedFiles.length === 0) {
            alert("⚠ No files selected!");
            return;
        }

        var formData = new FormData();
        selectedFiles.forEach(id => formData.append("id[]", id));

        console.log("FormData Debug:", [...formData]);

        $.ajax({
            url: "{{ route('uploaded_files_bulk_delete') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response == 1) {
                    toastr.success("Files deleted successfully", "Success");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    toastr.error("Oops, unable to delete", "Error");
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    };


    // singleDelete
    $(".confirm-delete").click(function(e) {
        e.preventDefault();
        var deleteUrl = $(this).data("href");
        var fileCard = $(this).closest(".col-6.col-md-3"); // Find the parent div of the file

        $.ajax({
            url: deleteUrl,
            type: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message, "Success");

                    // Remove the file card smoothly
                    fileCard.fadeOut(500, function() {
                        $(this).remove();
                    });
                } else {
                    toastr.error(response.message, "Error");
                }
            },
            error: function(xhr) {
                toastr.error("Something went wrong!", "Error");
            }
        });
    });
</script>
