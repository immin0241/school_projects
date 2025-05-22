<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'userid' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
            'type' => ['required', 'string', Rule::in(['01', '02'])],
        ], [
            'name.required' => '이름은 필수 항목입니다.',
            'name.string' => '이름은 문자열이어야 합니다.',

            'userid.required' => '아이디는 필수 항목입니다.',
            'userid.string' => '아이디는 문자열이어야 합니다.',
            'userid.lowercase' => '아이디는 소문자여야 합니다.',
            'userid.unique' => '입력한 아이디는 이미 사용 중입니다.',

            'password.required' => '비밀번호는 필수 항목입니다.',
            'password.confirmed' => '비밀번호 확인이 일치하지 않습니다.',
        ]);

        $user = User::create([
            'userid' => $request->userid,
            'name' => $request->name,
            'type' => $request->type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect(route('main', absolute: false))->with("message", "회원가입이 완료되었습니다.");
    }
}
