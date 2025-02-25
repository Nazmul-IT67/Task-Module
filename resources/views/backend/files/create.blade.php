@extends('admin')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-5">
                            <h4>Drag & drop your files</h4>
                        </div>
                        <div class="col-sm-7">
                            <div class="text-sm-end">
                                <a href="{{ route('uploaded-files.index') }}" class="btn btn-danger mb-2"><i class="align-middle" data-feather="arrow-left"></i> Back</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="wll-upload-files" class="h-420px" style="min-height: 65vh">
                                
                            </div>
                        </div>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
@endsection
@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			WLL.plugins.wllUppy();
		});
	</script>
@endsection