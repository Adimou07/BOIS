<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)
            ->with(['product', 'product.primaryImage'])
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        // Calculate totals
        $subtotal = $cartItems->sum(function ($item) use ($user) {
            $isProfessional = $user && $user->type === 'professional';
            $price = $item->product->getPriceForUser($isProfessional);
            return $price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'subtotal', 'user'));
    }

    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_postal_code' => 'required|string|max:10',
            'shipping_country' => 'required|string|max:255',
            'billing_same_as_shipping' => 'boolean',
            'billing_name' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_address' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_city' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'billing_postal_code' => 'required_if:billing_same_as_shipping,false|string|max:10',
            'billing_country' => 'required_if:billing_same_as_shipping,false|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Votre panier est vide.');
        }

        DB::beginTransaction();
        
        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) use ($user) {
                $isProfessional = $user && $user->type === 'professional';
                $price = $item->product->getPriceForUser($isProfessional);
                return $price * $item->quantity;
            });

            $deliveryCost = 0; // TODO: Calculate delivery cost
            $taxAmount = 0; // TODO: Calculate tax if needed
            $total = $subtotal + $deliveryCost + $taxAmount;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_cost' => $deliveryCost,
                'tax_amount' => $taxAmount,
                'total' => $total,
                'shipping_name' => $validated['shipping_name'],
                'shipping_address' => $validated['shipping_address'],
                'shipping_city' => $validated['shipping_city'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_country' => $validated['shipping_country'],
                'billing_name' => $validated['billing_same_as_shipping'] ?? false 
                    ? $validated['shipping_name'] 
                    : $validated['billing_name'],
                'billing_address' => $validated['billing_same_as_shipping'] ?? false 
                    ? $validated['shipping_address'] 
                    : $validated['billing_address'],
                'billing_city' => $validated['billing_same_as_shipping'] ?? false 
                    ? $validated['shipping_city'] 
                    : $validated['billing_city'],
                'billing_postal_code' => $validated['billing_same_as_shipping'] ?? false 
                    ? $validated['shipping_postal_code'] 
                    : $validated['billing_postal_code'],
                'billing_country' => $validated['billing_same_as_shipping'] ?? false 
                    ? $validated['shipping_country'] 
                    : $validated['billing_country'],
                'company_name' => $user->company_name,
                'siret' => $user->siret,
                'notes' => $validated['notes'],
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;
                $isProfessional = $user && $user->type === 'professional';
                $unitPrice = $product->getPriceForUser($isProfessional);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $unitPrice * $cartItem->quantity,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'wood_type' => $product->wood_type,
                    'conditioning' => $product->conditioning,
                    'usage_type' => $product->usage_type,
                ]);
            }

            // Clear cart
            CartItem::where('user_id', $user->id)->delete();

            DB::commit();

            return redirect()->route('orders.confirmation', $order)
                ->with('success', 'Votre commande a été créée avec succès !');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création de votre commande.');
        }
    }

    /**
     * Show order confirmation
     */
    public function confirmation(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product', 'user']);
        
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Show user's orders
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show specific order
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['items.product.primaryImage', 'user']);
        
        return view('orders.show', compact('order'));
    }
}
