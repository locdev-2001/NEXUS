<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
}
