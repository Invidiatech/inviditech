<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Models\Follow;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $articles = Article::with(['category', 'tags'])
            ->where('user_id', $user->id)
            ->when(!Auth::check() || Auth::id() !== $user->id, function ($query) {
                return $query->published();
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        $articlesCount = Article::where('user_id', $user->id)
            ->when(!Auth::check() || Auth::id() !== $user->id, function ($query) {
                return $query->published();
            })
            ->count();
            
        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        
        $isFollowing = Auth::check() ? Auth::user()->isFollowing($user) : false;
        
        return view('profiles.show', compact(
            'user', 
            'articles', 
            'articlesCount', 
            'followersCount',
            'followingCount',
            'isFollowing'
        ));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }
    
    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        
        // Handle profile image
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $data['profile_image'] = $request->file('profile_image')
                ->store('profiles', 'public');
        }
        
        // Handle cover image
        if ($request->hasFile('cover_image')) {
            if ($user->cover_image) {
                Storage::disk('public')->delete($user->cover_image);
            }
            
            $data['cover_image'] = $request->file('cover_image')
                ->store('covers', 'public');
        }
        
        // Update password if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        
        $user->update($data);
        
        return redirect()->route('profile.show', $user->username)
            ->with('success', 'Profile updated successfully!');
    }
    
    public function follow(User $user)
    {
        $currentUser = Auth::user();
        
        if ($currentUser->id === $user->id) {
            return response()->json([
                'error' => 'You cannot follow yourself'
            ], 400);
        }
        
        $exist = Follow::where('follower_id', $currentUser->id)
            ->where('following_id', $user->id)
            ->first();
            
        if ($exist) {
            $exist->delete();
            $following = false;
        } else {
            Follow::create([
                'follower_id' => $currentUser->id,
                'following_id' => $user->id
            ]);
            
            // Send notification
            $user->notify(new \App\Notifications\NewFollower($currentUser));
            
            $following = true;
        }
        
        $followerCount = $user->followers()->count();
        
        return response()->json([
            'following' => $following,
            'followerCount' => $followerCount
        ]);
    }
    
    public function followers($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $followers = User::whereHas('following', function ($query) use ($user) {
            $query->where('following_id', $user->id);
        })->paginate(20);
        
        return view('profiles.followers', compact('user', 'followers'));
    }
    
    public function following($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        
        $following = User::whereHas('followers', function ($query) use ($user) {
            $query->where('follower_id', $user->id);
        })->paginate(20);
        
        return view('profiles.following', compact('user', 'following'));
    }
    
    public function bookmarks()
    {
        $user = Auth::user();
        
        $articles = Article::with(['user', 'category', 'tags'])
            ->whereHas('bookmarks', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(10);
            
        return view('profiles.bookmarks', compact('articles'));
    }
}
