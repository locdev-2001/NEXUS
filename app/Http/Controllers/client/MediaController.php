<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    //
    public function storeMedia(Request $request)
    {
        $currentDate = now()->format('Y-m-d');
        $path = 'uploads/tmp/'.$currentDate;
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $name = uniqid().'.'.$extension;
        $filePath = $file->storeAs($path, $name, 'public');
        return response()->json([
            'name' => $filePath,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
    public function deleteMedia(Request $request){
        $media = $request->input('media');
        if(File::exists(public_path('storage/'.$media))){
            File::delete(public_path('storage/'.$media));
            return response()->json(['message'=>'removed']);
        }
        else{
            return response()->json(['error'=>'media not found']);
        }
    }
}
