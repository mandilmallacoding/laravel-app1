<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function profile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile',compact('adminData'));
    }

    public function EditProfile(){
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_edit_profile',compact('adminData'));
    }

    public function UpdateProfile(Request $request):RedirectResponse{
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        if($request->file('profile_img')){
            $file = $request->file('profile_img');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
        }
        $data->save();
        return redirect()->route('admin.profile');
    }
}
