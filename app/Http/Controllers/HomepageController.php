<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\UserRequest;
    use App\Models\User;
    use App\Services\Settings\UsersSettings;
    use Illuminate\Http\Request;

    class HomepageController extends Controller
    {
        protected UsersSettings $settings;

        public function __construct() {
            $this->settings = new UsersSettings();
        }

        public function index() {
            return view('pages.account');
        }

        /*
         * Обновление личных данных пользователя
         */
        public function update(UserRequest $request) {
            $validated = $request->validated();
            $user = auth()->user();
            $user->password = $validated['password'] ??
                auth()->user()->getAuthPassword();
            // Заполнение каждого аттрибута пользователя для сохранения
            foreach ($this->settings->getAttributes() as $attribute) {
                $user->$attribute = $validated[$attribute];
            }

            $email = null;
            // Если такой емейл уже существует...
            if (auth()->user()->email != $validated['email']) {
                $email = User::select('email')
                    ->where('email',
                        $request->input('email')
                    )->first();
            }
            // ...то сообщить об этом пользователю
            if ($email !== null) {
                return view('pages.account', [
                    'errors' =>
                        'Этот адресс электронной почты уже занят другим пользователем!'
                    ]
                );
            }

            $user->save();
            auth()->login($user, true);

            return view('pages.account', ['success' => true]);
        }
    }
