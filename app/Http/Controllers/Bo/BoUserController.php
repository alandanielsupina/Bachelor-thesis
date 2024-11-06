<?php

namespace App\Http\Controllers\Bo;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BoUserController extends Controller
{
    public function all()
    {
        $users = User::withTrashed()->get();

        return view('bo.admin.users.all')->with('users', $users);
    }

    public function create()
    {
        return view('bo.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        session()->flash('success', 'Úspešné vytvorenie používateľa');

        return redirect()->route('bo.users.create');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('bo.admin.users.edit')->with('user', $user);
    }

    public function updateOthers(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($request->all());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        session()->flash('success-others', 'Úspešné upravenie používateľa');

        return redirect()->route('bo.users.edit', $user->id);
    }
    
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::withTrashed()->find($id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success-password', 'Úspešné upravenie hesla používateľa');

        return redirect()->route('bo.users.edit', $user->id);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        // TODO: toto asi logicky nejde, lebo by som na to potreboval web token, aby server vedel dačo poslať klientovi bez requestu klienta
        // $me = Auth::user();
        // Auth::setUser($user);
        // Auth::logout();
        // Auth::setUser($me);

        $user->delete();

        //TODO: ako to spraviť pre špecifického usera???
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('bo.users.all');
    }

    public function restore($id)
    {
        User::withTrashed()->find($id)->restore();

        return redirect()->route('bo.users.all');
    }

    public function assignRole($id)
    {
        User::withTrashed()->find($id)->assignRole('owner');

        return redirect()->route('bo.users.all');
    }

    public function removeRole($id)
    {
        User::withTrashed()->find($id)->removeRole('owner');

        return redirect()->route('bo.users.all');
    }
}
