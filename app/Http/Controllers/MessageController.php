<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Sends form data from main page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function send(Request $request) {
        $validatedFields = $request->validate([
            'number' => 'required',
            'name' => 'required',
        ]);

        $message = new Message();
        $message->number = $validatedFields['number'];
        $message->name = $validatedFields['name'];

        $message->save();

        return redirect('/');
    }
}
