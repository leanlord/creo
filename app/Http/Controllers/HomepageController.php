<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\UpdateAccountRequest;
    use App\Models\User;
    use App\Services\Settings\UsersSettings;
    use Illuminate\Http\Request;

    class HomepageController extends Controller
    {
        protected UsersSettings $settings;
        protected $user;

        public function __construct() {
            $this->settings = new UsersSettings();
        }

        public function index() {
            return view('pages.account');
        }

        /*
         * Обновление личных данных пользователя
         */
        public function update(UpdateAccountRequest $request) {
            $this->user = auth()->user(); // it equals null in the constructor for some reasons
            $validated = $request->validated();
            $this->user->password = $validated['password'] ??
                auth()->user()->getAuthPassword();

            if ($this->emailExists($validated['email'])) {
                return view('pages.account')->withErrors([
                    'emailExists' => 'Этот адрес электронной почты занят.'
                ]);
            }

            $this->fillAll($validated);
            $this->user->save();
            auth()->login($this->user, true);

            return view('pages.account');
        }

        protected function emailExists(string $newEmail): bool {
            $email = null;
            // Если такой емейл уже существует...
            if ($this->user->email != $newEmail) {
                $email = User::query()
                    ->where('email', $newEmail)
                    ->get();
            }
            return $email !== null;
        }

        protected function fillAll(array $validated) {
            // Заполнение каждого аттрибута пользователя для сохранения
            foreach ($this->settings->getAttributes() as $attribute) {
                $this->user->$attribute = $validated[$attribute];
            }
        }
    }
