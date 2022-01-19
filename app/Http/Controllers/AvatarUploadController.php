<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAvatarRequest;
use App\Services\Uploaders\Uploader;

class AvatarUploadController extends Controller
{
    protected Uploader $uploader;
    protected string $tmpPrefix = 'tmp/';

    public function __construct(Uploader $uploader) {
        $this->uploader = $uploader;
    }

    public function upload(UploadAvatarRequest $request) {
        if ($request->hasFile('avatar')) {
            $this->uploader->load(); // loading new temporary file
            $this->uploader->deleteFor(auth()->user(), $this->tmpPrefix); // deleting old temporary file
            session(['oldAvatar' => auth()->user()->avatar]);

            session(['tmp_avatar' => $this->uploader->getFilename()]);
            return response()->json(
                $this->uploader->getFilename()
            );
        }

        return response('Error!');
    }

    public function save() {
        if ($this->uploader->hasOld()) {
            $this->uploader->deleteOld();
        }

        auth()->user()->avatar = session()->get('tmp_avatar');
        auth()->user()->save();

        $this->uploader->save($this->tmpPrefix);

        return response()->json('Avatar has been saved');
    }
}
