<?php

namespace App\Http\Controllers;

use App\Models\UserFavorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        // Favorite hanya untuk user yang login
        $this->middleware('auth');
    }

    public function index()
    {
        $favorites = UserFavorite::with('tool.category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('favorites.index', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'tool_id' => 'required|exists:tools,id',
        ]);

        $favorite = UserFavorite::where('tool_id', $request->tool_id)
            ->where('user_id', auth()->id())
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['favorited' => false]);
        } else {
            UserFavorite::create([
                'tool_id' => $request->tool_id,
                'user_id' => auth()->id(),
            ]);
            return response()->json(['favorited' => true]);
        }
    }
}
