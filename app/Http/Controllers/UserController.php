<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Comic;
use App\Models\History;
use App\Models\Bookmark;

class UserController extends Controller
{
    protected function history()
    {
    	$history = History::where('user_id', Auth::user()->id)
    			->orderBy('created_at', 'DESC')
    			->get();

    	return view('user.history', compact('history'));
    }

    protected function bookmarks()
    {
        $bookmarks = Bookmark::join('comics', 'bookmarks.comic_id', 'comics.id')
                ->where('bookmarks.user_id', Auth::user()->id)
                ->orderBy('comics.updated_at', 'desc')
                ->paginate(20);
        // dd($comics);

    	return view('user.bookmarks', compact('bookmarks'));
    }

    protected function settings()
    {
        $user = Auth::user();
        
        // dd($user->comments->count());

        return view('user.settings', compact('user'));
    }

    protected function profileUpdate(Request $request)
    {

        // dd($request);
        $request->validate([
            'name' => 'required',
            'img_path' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        $user = User::find(Auth::user()->id);
        $user->name = $request->input('name');
        // $request->file('img_path') == null ? 'images/sancomics_cover.png' : $request->file('img_path')
        if ($request->hasFile('img_path')) {

            $deleteFile = Storage::delete('public/' . $user->img_path);
            
            $path = $request->file('img_path')->storeAs(
                'images/profile/' . $user->username,
                $user->username . '.' . $request->file('img_path')->extension(),
                'public'
            );

            $user->img_path = $path;
        }
        $user->save();

        return redirect()->route('user.settings')->with('success', 'Profile Updated.');
    }

    protected function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (password_verify($request->input('current_password'), Auth::user()->password)) {

            $user = User::find(Auth::user()->id);
            $user->password = password_hash($request->input('new_password'), PASSWORD_DEFAULT);
            $user->save();

            return redirect()->route('login')->with(Auth::logout())->with('status', 'Password changed, please login.');
        }

        return redirect()->route('user.settings')->with('error', 'Current password is incorrect.');
    }
}
