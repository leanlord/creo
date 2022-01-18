<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AvatarUploadController extends Controller
{
    public function upload(Request $request) {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = auth()->user()->getAuthIdentifier() .
                time() .
                '.' .  $file->extension();

            \Storage::disk('avatars')->put('/' . $fileName, file_get_contents($file));

            $user = auth()->user();
            if ($user->avatar) {
                \Storage::disk('avatars')->delete('/' . $user->avatar);
            }

            $user->avatar = $fileName;
            $user->save();

            return response()->json(
                $fileName
            );
        }

        return response('Error!');
    }
}
