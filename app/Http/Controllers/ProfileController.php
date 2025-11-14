<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};

class ProfileController extends Controller
{
    protected $data = [];

    public function index()
    {
        $this->data['user'] = Sentinel::getUser();
        return view('profile._aside', $this->data);
    }

    public function edit()
    {
        $this->data['user'] = Sentinel::getUser();
        return view('profile.update-profile', $this->data);
    }

    public function update(Request $request)
    {
        $profileImage = $request->validate([
            "image" => ["nullable", "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", new MultipleFile(52428800, 5), new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls'])],
        ]);
        $user = Sentinel::getUser();

       if($request->hasFile('image')){
            $image_path = uploadFile($request,'user-profile','image');
            $image = basename($image_path);
            User::where('id', $user->id)->update([
                'image' => $image,
                'image_path' => $image_path,
            ]);
       }

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function change_password()
    {
        $this->data['user'] = Sentinel::getUser();
        return view('profile.update-password', $this->data);
    }

    public function update_password(ProfileRequest $request)
    {
        $password = $request['password'];

        $user = Sentinel::getUser();

        User::where('id',$user->id)->update([
            'password' => Hash::make($password),
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password updated successfully.');
    }
}
