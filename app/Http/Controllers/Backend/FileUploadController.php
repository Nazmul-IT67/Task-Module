<?php

namespace App\Http\Controllers\Backend;

use Response;

use App\Models\FileUpload;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use enshrined\svgSanitize\Sanitizer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = 'Uploaded Files';

        $all_uploads = (Auth::user()->user_type == 'seller') ? FileUpload::where('user_id', Auth::user()->id) : FileUpload::query();
        $search = null;
        $sort_by = null;

        if ($request->search != null) {
            $search = $request->search;
            $all_uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }

        $sort_by = $request->sort;
        switch ($request->sort) {
            case 'newest':
                $all_uploads->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $all_uploads->orderBy('created_at', 'asc');
                break;
            case 'smallest':
                $all_uploads->orderBy('file_size', 'asc');
                break;
            case 'largest':
                $all_uploads->orderBy('file_size', 'desc');
                break;
            default:
                $all_uploads->orderBy('created_at', 'desc');
                break;
        }

        $all_uploads = $all_uploads->paginate(60)->appends(request()->query());

        return view('backend.files.index', compact('page_title', 'all_uploads', 'search', 'sort_by'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'Upload New File';
        return view('backend.files.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function upload(Request $request)
    {
        $type = [
            "jpg" => "image",
            "jpeg" => "image",
            "png" => "image",
            "svg" => "image",
            "webp" => "image",
            "gif" => "image",
            "mp4" => "video",
            "mpg" => "video",
            "mpeg" => "video",
            "webm" => "video",
            "ogg" => "video",
            "avi" => "video",
            "mov" => "video",
            "flv" => "video",
            "swf" => "video",
            "mkv" => "video",
            "wmv" => "video",
            "wma" => "audio",
            "aac" => "audio",
            "wav" => "audio",
            "mp3" => "audio",
            "zip" => "archive",
            "rar" => "archive",
            "7z" => "archive",
            "doc" => "document",
            "txt" => "document",
            "docx" => "document",
            "pdf" => "document",
            "csv" => "document",
            "xml" => "document",
            "ods" => "document",
            "xlr" => "document",
            "xls" => "document",
            "xlsx" => "document"
        ];

        if ($request->hasFile('wll_doc_file')) {
            $upload = new FileUpload;
            $extension = strtolower($request->file('wll_doc_file')->getClientOriginalExtension());

            if (env('DEMO_MODE') == 'On' && isset($type[$extension]) && $type[$extension] == 'archive') {
                return '{}';
            }

            if (isset($type[$extension])) {
                // Get original file name without extension
                $originalNameParts = explode('.', $request->file('wll_doc_file')->getClientOriginalName());
                array_pop($originalNameParts); // remove extension part
                $upload->file_original_name = implode('.', $originalNameParts);

                if ($extension == 'svg') {
                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($request->file('wll_doc_file'));
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);
                    // Save cleaned SVG temporarily to a path
                    $tempPath = sys_get_temp_dir() . '/' . uniqid() . '.svg';
                    file_put_contents($tempPath, $cleanSVG);
                    $request->files->set('wll_doc_file', new \Illuminate\Http\File($tempPath));
                }

                // Store file in storage/app/public/uploads/files
                $path = $request->file('wll_doc_file')->store('uploads/files', 'public');
                $size = $request->file('wll_doc_file')->getSize();

                if ($type[$extension] == 'image') {
                    try {
                        $img = Image::make($request->file('wll_doc_file')->getRealPath())->encode();
                        $height = $img->height();
                        $width = $img->width();

                        if ($width > $height && $width > 1500) {
                            $img->resize(1500, null, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        } elseif ($height > 1500) {
                            $img->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }

                        // Save resized image to storage/app/public/uploads/files/filename
                        $img->save(storage_path('app/public/' . $path));
                        clearstatcache();
                        $size = $img->filesize();
                    } catch (\Exception $e) {
                        // Handle exception if needed
                    }
                }

                $upload->extension = $extension;
                $upload->file_name = $path; // relative to storage/app/public
                $upload->user_id = Auth::id();
                $upload->type = $type[$extension];
                $upload->file_size = $size;
                $upload->save();

                return '{}';
            }
        }
    }


    public function destroy($id)
    {
        $file = FileUpload::find($id);

        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File not found!']);
        }

        try {
            $file->delete();
            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully!',
                'id' => $id
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Oops, unable to delete!']);
        }
    }


    public function uploaded_files_bulk_delete(Request $request)
    {
        if ($request->id) {
            foreach ($request->id as $file_id) {
                $upload = FileUpload::findOrFail($file_id);

                try {
                    if (file_exists(public_path() . '/' . $upload->file_name)) {
                        unlink(public_path() . '/' . $upload->file_name);
                    }
                    $upload->delete();
                } catch (\Exception $e) {
                    $upload->delete();
                }
            }
            return 1;
        } else {
            return 0;
        }
    }

    public function get_uploaded_files(Request $request)
    {
        $uploads = FileUpload::where('user_id', Auth::user()->id);

        if ($request->search != null) {
            $uploads->where('file_original_name', 'like', '%' . $request->search . '%');
        }
        if ($request->sort != null) {
            switch ($request->sort) {
                case 'newest':
                    $uploads->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $uploads->orderBy('created_at', 'asc');
                    break;
                case 'smallest':
                    $uploads->orderBy('file_size', 'asc');
                    break;
                case 'largest':
                    $uploads->orderBy('file_size', 'desc');
                    break;
                default:
                    $uploads->orderBy('created_at', 'desc');
                    break;
            }
        }
        return $uploads->paginate(60)->appends(request()->query());
    }

    public function get_preview_files(Request $request)
    {
        $ids = explode(',', $request->ids);
        $files = FileUpload::whereIn('id', $ids)->get();
        $new_file_array = [];
        foreach ($files as $file) {
            $file['file_name'] = my_asset($file->file_name);
            if ($file->external_link) {
                $file['file_name'] = $file->external_link;
            }
            $new_file_array[] = $file;
        }
        return $new_file_array;
    }

    public function show_uploader(Request $request)
    {
        return view('uploader.file-uploader');
    }

    public function uploaded_files_info(Request $request)
    {
        $file = FileUpload::findOrFail($request['id']);

        return view('backend.files.info', compact('file'));
    }
}
