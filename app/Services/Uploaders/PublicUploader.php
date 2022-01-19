<?php

namespace App\Services\Uploaders;

use Illuminate\Http\Request;

class PublicUploader implements Uploader
{
    protected string $disk = 'avatars';
    protected $file;
    protected string $filename = '';

    public function __construct(Request $request) {
        $this->file = $request->file('avatar');
    }

    public function load() {
        $this->setFilenameFor(auth()->user());
        \Storage::disk($this->disk)
            ->put(
                '/tmp/' . $this->filename,
                file_get_contents($this->file)
            );
    }

    public function save(string $prefix) {
        if ($this->hasOld()) {
            $this->deleteOld();
        }
        $this->moveFileFor(auth()->user(), $prefix);
    }

    public function deleteFor($user, string $prefix = '') {
        if ($user->avatar && \Storage::disk('avatars')->exists("/$prefix$user->avatar")) {
            \Storage::disk($this->disk)->delete("/$prefix$user->avatar");
        }
    }

    public function deleteOld() {
        if (\Storage::disk('avatars')->exists('/' . $this->getOld())) {
            \Storage::disk($this->disk)->delete('/' . $this->getOld());
        }
    }

    public function hasOld(): bool {
        return session()->has('oldAvatar');
    }

    public function getOld() {
        return session()->get('oldAvatar');
    }

    public function getFilename(): string {
        return $this->filename;
    }

    protected function setFilenameFor($user) {
        if($this->filename == '') {
            $this->filename = $user->getAuthIdentifier() .
                time() .
                '.' . $this->file->extension();
        }
    }

    public function moveFileFor($user, string $prefix = '') {
        \Storage::disk($this->disk)->move("/$prefix" . $user->avatar, $user->avatar);
    }
}
