<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Controllers\Controller;
use Image;
use App\Photo;
use File;

class PhotoController extends Controller
{

    /**
     * Display view for homepage
     *
     * @param Photo $images
     * @return $this
     */
    public function index(Photo $images)
    {
        return view('welcome')->with('images', $images->orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePhotoRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(StorePhotoRequest $request)
    {
        //TODO
        // Find a safe way to getClientOriginalExtension()

        //Construct file and path info
        $file       = $request->file('photo');
        $ext        = '.' . $file->getClientOriginalExtension();
        $filename   = time() . $ext;
        $basePath   = '/uploads/img/' . $filename;
        $thumbPath  = '/uploads/img/thumb/' . $filename;
        $localPath   = public_path() . $basePath;
        $localThumbPath  = public_path() . $thumbPath;
        //DB info
        $mimeType       = $file->getClientMimeType();
        $slug           = Photo::generateUniqueSlug(8);
        //Save the full image and the thumb to the server
        $imageFull = Image::make($file->getRealPath())
                        ->save($localPath);
        $imageThumb = Image::make($file->getRealPath())
                        ->widen(400)
                        ->save($localThumbPath);

        //Create the DB entry
        $imageStore = Photo::create([
            'path' => $basePath,
            'thumb_path' => $thumbPath,
            'mime_type' => $mimeType,
            'slug' => $slug
        ]);
        if($request->ajax()) {
            return response()->json($imageStore);
        } else {
            return redirect()->route('home')->with([
                'global-message' => 'Uploaded!',
                'message-type' => 'flash-success'
            ]);
        }
    }

    /**
     * Serve the raw image to the browser by
     * finding the slug associated with the file
     *
     * @param $slug
     * @param Photo $image
     * @return mixed
     */
    public function serve($slug, Photo $image)
    {
        $image = $image->findBySlug($slug);

        return response(
            File::get(
                public_path() . $image->path
            )
        )->header('content-type', $image->mime_type);
    }
}