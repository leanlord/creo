<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarUploadController extends Controller
{
    public function upload(Request $request) {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = auth()->user()->getAuthIdentifier() . '.' .  $file->extension();
            $file->storeAs('avatars/', $fileName);

            return response(null, 204);
        }

        return response('Error!');
    }
}
