<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarUploadController extends Controller
{
    public function upload(Request $request) {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = auth()->user()->getAuthIdentifier() . '.' .  $file->extension();

            \Storage::disk('avatars')->put('/' . $fileName, file_get_contents($file));

            return response()->json(
                auth()->user()->getAuthIdentifier()
            );
        }

        return response('Error!');
    }
}
