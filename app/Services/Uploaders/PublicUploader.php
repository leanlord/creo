<?php

namespace App\Services\Uploaders;

use Illuminate\Http\Request;

class PublicUploader implements Uploader
{
    protected Request $request;
    protected $user;
    protected string $disk = 'avatars';
    protected $file;
    protected string $filename;

    public function __construct(Request $request) {
        $this->file = \request()->file('avatar');
        $this->request = $request;
    }

    public function load() {
        \Storage::disk($this->disk)
            ->put(
                '/tmp/' . $this->filename,
                file_get_contents($this->file)
            );
    }

    public function save() {
        if ($this->hasOld()) {
            $this->deleteOld();
        }
        \Storage::disk($this->disk)->move('/tmp/' . $this->user->avatar, $this->user->avatar);
    }

    public function delete(string $prefix = '') {
        if ($this->user->avatar && \Storage::disk('avatars')->exists("/$prefix$this->user->avatar")) {
            \Storage::disk($this->disk)->delete("/$prefix$this->user->avatar");
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

    public function makeFilename() {
        $this->filename = $this->user->getAuthIdentifier() .
            time() .
            '.' . $this->file->extension();
    }

    public function moveFile(string $prefix = '') {
            \Storage::disk($this->disk)->move("/$prefix" . $this->user->avatar, $this->user->avatar);

    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void {
        $this->user = $user;
    }
}
