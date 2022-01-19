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

            \Storage::disk('avatars')->put('/tmp/' . $fileName, file_get_contents($file));

            $user = auth()->user();
            if ($user->avatar) {
                \Storage::disk('avatars')->delete('/tmp/' . $user->avatar);
            }

            $request->session()->flash('oldAvatar', $user->avatar);
            $user->avatar = $fileName;
            $user->save();

            return response()->json(
                $fileName
            );
        }

        return response('Error!');
    }

    public function save(Request $request) {
        if ($request->session()->has('oldAvatar')) {
            \Storage::disk('avatars')->delete('/' . $request->session()->pull('oldAvatar'));
        }
        \Storage::disk('avatars')->move('/tmp/' . auth()->user()->avatar, auth()->user()->avatar);
        \Storage::disk('avatars')->delete('/tmp/' . auth()->user()->avatar);

        return response()->json('Avatar has been saved');
    }
}
