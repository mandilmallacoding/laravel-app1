<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //toaster
        $notification = array(
            'message' => 'Admin logged out successfully.',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
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
        //toaster
        $notification = array(
            'message' => 'Admin profile updated successfully.',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.profile')->with($notification);
    }

    public function ChangePassword(){
        return view('admin.admin_change_password');
    }


    public function updatePassword(Request $request) {
        // Validation
        $request->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|confirmed'
        ]);

        if (!Hash::check($request->oldpassword, auth()->user()->password)) {
            $notification = [
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            ];
            return back()->with($notification);
        }

        // Update The new Password
        auth()->user()->update([
            'password' => Hash::make($request->newpassword)
        ]);

        $notification = [
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($notification);
    }/// end method
}
