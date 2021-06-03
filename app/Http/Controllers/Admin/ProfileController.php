<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function profile($id)
    {
        $dec = Crypt::decrypt($id);
        $user = User::findOrfail($dec);
        return view('Admin.user_profile.profile', compact('user'));
    }

    public function changeProfile(Request $request, $id)
    {
        $user = User::findOrfail($id);
        if ($request->username === $user->username) {
            $is_valid_user_name = 'required';
        }else {
            $is_valid_user_name = 'required|unique:users,username';
        }
        if ($request->email === $user->email) {
            $is_valid_email = 'required';
        }else {
            $is_valid_email = 'required|unique:users,email';
        }
        $request->validate([
            'name' => 'required',
            'username' => $is_valid_user_name,
            'email' => $is_valid_email,
            'password' => 'required',
        ]);
        if (Hash::check($request->password , $user->password )) 
        {
            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
            ]);
            return redirect()->back()->with('success','Profil berhasil diubah');
        } else {
            return redirect()->back()->with('error','Password Anda tidak sesuai');
        }
    }

    public function password()
    {
        $user = User::findOrfail(auth()->user()->id);
        return view('Admin.user_profile.password', compact('user'));
    }

    public function changePassword(Request $request, $id)
    {
    $request->validate([
            'new_password' => 'required|min:8|same:confirm-password|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{6,}$/',
        ]);
        $user = User::findOrfail($id);
        if (Hash::check($request->currentPassword , $user->password )) 
        {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->back()->with('success','Password berhasil diubah');
        } else {
            return redirect()->back()->with('error','Password lama Anda tidak sesuai');
        }
    }
}
