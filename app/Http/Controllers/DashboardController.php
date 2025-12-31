<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistiques du mois actuel
        $currentMonth = Carbon::now();
        $monthlyOrders = Order::where('user_id', $user->id)
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->get();
            
        $monthlyTotal = $monthlyOrders->sum('total_amount');
        $monthlyCount = $monthlyOrders->count();
        
        // Statistiques de l'année actuelle
        $yearlyOrders = Order::where('user_id', $user->id)
            ->whereYear('created_at', $currentMonth->year)
            ->get();
            
        $yearlyTotal = $yearlyOrders->sum('total_amount');
        $yearlyCount = $yearlyOrders->count();
        
        // Commandes récentes
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->limit(5)
            ->get();
        
        // Statistiques par mois (12 derniers mois)
        $monthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $orders = Order::where('user_id', $user->id)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->get();
                
            $monthlyStats[] = [
                'month' => $month->format('M Y'),
                'total' => $orders->sum('total_amount'),
                'count' => $orders->count()
            ];
        }
        
        // Produits les plus achetés
        $topProducts = Order::where('user_id', $user->id)
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.name, products.wood_type, SUM(order_items.quantity) as total_quantity, SUM(order_items.unit_price * order_items.quantity) as total_spent')
            ->groupBy('products.id', 'products.name', 'products.wood_type')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
        
        return view('dashboard.index', compact(
            'monthlyTotal', 'monthlyCount',
            'yearlyTotal', 'yearlyCount',
            'recentOrders', 'monthlyStats', 'topProducts'
        ));
    }
}
