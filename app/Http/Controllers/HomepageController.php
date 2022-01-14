<?php

    namespace App\Http\Controllers;

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
        public function update(Request $request) {
            $validateFields = $request->validate([
                'email' => 'email',
                'password' => 'nullable|min:7',
                'first_name' => 'nullable',
                'last_name' => 'nullable',
                'number' => 'nullable',
            ]);

            $user = auth()->user();
            $user->password = $request->get('password') ??
                auth()->user()->getAuthPassword();
            // Заполнение каждого аттрибута пользователя для сохранения
            foreach ($this->settings->getAttributes() as $attribute) {
                $user->$attribute = $validateFields[$attribute];
            }

            $email = null;
            // Если такой емейл уже существует
            if (auth()->user()->email != $request->input('email')) {
                $email = User::select('email')
                    ->where('email',
                        $request->input('email')
                    )->first();
            }

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
