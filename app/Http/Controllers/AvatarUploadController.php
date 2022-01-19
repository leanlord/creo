<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarUploadController extends Controller
{
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function upload() {
        if ($this->request->hasFile('avatar')) {
            $file = $this->request->file('avatar');
            $fileName = auth()->user()->getAuthIdentifier() .
                time() .
                '.' .  $file->extension();

            \Storage::disk('avatars')->put('/tmp/' . $fileName, file_get_contents($file));

            $this->deleteExistingAvatar(auth()->user(), 'tmp/');
            $user = auth()->user();
            $this->request->session()->flash('oldAvatar', $user->avatar);

            $user->avatar = $fileName;
            $user->save();

            return response()->json(
                $fileName
            );
        }

        return response('Error!');
    }

    public function save() {
        if ($this->hasOldAvatar()) {
            $this->deleteExistingAvatar();
        }
        \Storage::disk('avatars')->move('/tmp/' . auth()->user()->avatar, auth()->user()->avatar);

        return response()->json('Avatar has been saved');
    }

    protected function deleteExistingAvatar($user = null, string $prefix = '') {
        if ($user) {
            if ($user->avatar) {
                \Storage::disk('avatars')->delete("/$prefix$user->avatar");
            }
        } elseif ($this->hasOldAvatar()) {
            \Storage::disk('avatars')->delete('/' . $this->getOldAvatar());
        }
    }

    protected function hasOldAvatar(): bool {
        return $this->request->session()->has('oldAvatar');
    }

    protected function getOldAvatar() {
        return $this->request->session()->pull('oldAvatar');
    }
}
