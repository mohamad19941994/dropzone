<?php

namespace App\Http\Controllers;

use App\Models\ImageUpload;
use http\Env\Response;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{

    public function index()
    {
        return view('image_upload');
    }

    public function store(Request $request)
    {
        $image = $request->file('file');
        $imagename = $image->getClientOriginalName();
        $image->move(public_path('images'), $imagename);

        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imagename;
        $imageUpload->save();

        return response()->json(['success' => $imagename]);

    }

    public function destroy(Request $request)
    {
        $filename = $request->get('filename');
        ImageUpload::where('filename', $filename)->delete();
        $path = public_path(). '/images/'.$filename;

        if (file_exists($path)){
            unlink($path);
        }
        return $filename;
    }
}
