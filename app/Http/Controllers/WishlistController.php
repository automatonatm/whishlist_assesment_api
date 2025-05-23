<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller {
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $wishlist = auth()->user()->wishlist()
            ->with('product')
            ->paginate($perPage);
    
        
        return response()->json([
            'current_page' => $wishlist->currentPage(),
            'last_page' => $wishlist->lastPage(),
            'per_page' => $wishlist->perPage(),
            'total' => $wishlist->total(),
            'data' => $wishlist->map(fn ($item) => $item->product)
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $user = $request->user();
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        return response()->json(['message' => 'Product added to wishlist'], 201);

       
    }

    public function remove(Request $request, Product $product)
    {
        $deleted = Wishlist::where('user_id', $request->user()->id)
        ->where('product_id', $product->id)
        ->delete();
        return response()->json(['message' => 'Removed from wishlist']);
    }
}
