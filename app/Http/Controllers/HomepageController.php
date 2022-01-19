<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;
use App\Services\Settings\UsersSettings;

class HomepageController extends Controller
{
    protected UsersSettings $settings;
    protected $user;
    protected UpdateAccountRequest $request;

    public function __construct(UpdateAccountRequest $request) {
        $this->request = $request;
        $this->settings = new UsersSettings();
    }

    public function index() {
        $this->deleteAvatar();
        return view('pages.account');
    }

    /*
     * Обновление личных данных пользователя
     */
    public function update() {
        $this->user = auth()->user(); // it equals null in the constructor for some reasons
        $validated = $this->request->validated();

        if ($this->emailExists($validated['email'])) {
            return view('pages.account')->withErrors([
                'emailExists' => 'Этот адрес электронной почты занят.',
            ]);
        }

        $this->fillAll($validated);
        $this->user->save();
        auth()->login($this->user, true);

        return view('pages.account');
    }

    protected function emailExists(string $newEmail): bool {
        // Если такой емейл уже существует...
        if ($this->user->email != $newEmail) {
            return !empty(User::query()
                ->where('email', $newEmail)
                ->get());
        }

        return false;
    }

    protected function fillAll(array $validated) {
        // Заполнение каждого аттрибута пользователя для сохранения
        foreach ($this->settings->getAttributes() as $attribute) {
            $this->user->$attribute = $validated[$attribute];
        }
        if (isset($validated['password'])) {
            $this->user->password = $validated['password'];
        }
    }

    protected function deleteAvatar() {
        if (\Storage::disk('avatars')->exists('tmp/' . auth()->user()->avatar)) {
            \Storage::disk('avatars')->delete('tmp/' . auth()->user()->avatar);
        }
    }
}
