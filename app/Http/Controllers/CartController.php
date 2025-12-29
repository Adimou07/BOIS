<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index(): View
    {
        $cartItems = $this->getCartItems();
        $cartTotal = $cartItems->sum(fn($item) => $item->getTotalPrice());
        $cartCount = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
        ]);

        $quantity = $request->quantity;
        
        // Vérifier stock disponible
        if ($quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant'
            ], 400);
        }

        // Vérifier quantité minimum
        if ($quantity < $product->min_order_quantity) {
            return response()->json([
                'success' => false,
                'message' => "Quantité minimum: {$product->min_order_quantity}"
            ], 400);
        }

        // Vérifier si produit pro pour utilisateur non-pro
        if ($product->is_professional_only && (!auth()->user() || !auth()->user()->isProfessional())) {
            return response()->json([
                'success' => false,
                'message' => 'Ce produit est réservé aux professionnels'
            ], 403);
        }

        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();
        $unitPrice = $product->getPriceForUser(auth()->user()?->isProfessional());

        // Vérifier si le produit est déjà dans le panier
        $existingItem = CartItem::forCart($sessionId, $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            
            if ($newQuantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stock insuffisant pour cette quantité totale'
                ], 400);
            }

            $existingItem->update([
                'quantity' => $newQuantity,
                'unit_price' => $unitPrice // Mise à jour du prix
            ]);
        } else {
            CartItem::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice
            ]);
        }

        $cartCount = $this->getCartCount();
        
        return response()->json([
            'success' => true,
            'message' => 'Produit ajouté au panier',
            'cartCount' => $cartCount
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Vérifier que l'item appartient à l'utilisateur/session
        if (!$this->cartItemBelongsToUser($cartItem)) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $quantity = $request->quantity;
        $product = $cartItem->product;

        if ($quantity > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock insuffisant'
            ], 400);
        }

        if ($quantity < $product->min_order_quantity) {
            return response()->json([
                'success' => false,
                'message' => "Quantité minimum: {$product->min_order_quantity}"
            ], 400);
        }

        $cartItem->update(['quantity' => $quantity]);

        return response()->json([
            'success' => true,
            'itemTotal' => $cartItem->getTotalPrice(),
            'cartTotal' => $this->getCartTotal(),
            'cartCount' => $this->getCartCount()
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove(CartItem $cartItem): JsonResponse
    {
        if (!$this->cartItemBelongsToUser($cartItem)) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produit retiré du panier',
            'cartTotal' => $this->getCartTotal(),
            'cartCount' => $this->getCartCount()
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear(): JsonResponse
    {
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        CartItem::forCart($sessionId, $userId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Panier vidé'
        ]);
    }

    /**
     * Get cart count for header display
     */
    public function count(): JsonResponse
    {
        return response()->json([
            'count' => $this->getCartCount()
        ]);
    }

    /**
     * Get cart items for current user/session
     */
    private function getCartItems()
    {
        $userId = auth()->id();
        $sessionId = $userId ? null : session()->getId();

        return CartItem::with('product.primaryImage')
            ->forCart($sessionId, $userId)
            ->get();
    }

    /**
     * Get total cart amount
     */
    private function getCartTotal(): float
    {
        return $this->getCartItems()->sum(fn($item) => $item->getTotalPrice());
    }

    /**
     * Get total items count in cart
     */
    private function getCartCount(): int
    {
        return $this->getCartItems()->sum('quantity');
    }

    /**
     * Check if cart item belongs to current user/session
     */
    private function cartItemBelongsToUser(CartItem $cartItem): bool
    {
        $userId = auth()->id();
        
        if ($userId) {
            return $cartItem->user_id === $userId;
        }
        
        return $cartItem->session_id === session()->getId();
    }
}