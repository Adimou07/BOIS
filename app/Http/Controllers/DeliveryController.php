<?php

namespace App\Http\Controllers;

use App\Models\DeliveryZone;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DeliveryController extends Controller
{
    /**
     * Calculate delivery cost and info for postal code
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'postal_code' => 'required|string|regex:/^[0-9]{5}$/',
            'order_amount' => 'required|numeric|min:0'
        ]);

        $postalCode = $request->postal_code;
        $orderAmount = (float) $request->order_amount;

        $deliveryZone = DeliveryZone::findByPostalCode($postalCode);

        if (!$deliveryZone) {
            return response()->json([
                'success' => false,
                'message' => 'Désolé, nous ne livrons pas dans cette zone pour le moment.',
                'available' => false
            ]);
        }

        $deliveryCost = $deliveryZone->calculateDeliveryCost($orderAmount);
        $isFree = $deliveryZone->isFreeDelivery($orderAmount);
        $amountForFreeDelivery = $deliveryZone->getAmountForFreeDelivery($orderAmount);

        return response()->json([
            'success' => true,
            'available' => true,
            'zone_name' => $deliveryZone->name,
            'delivery_cost' => $deliveryCost,
            'is_free' => $isFree,
            'delivery_time' => $deliveryZone->getDeliveryTimeEstimate(),
            'free_delivery_threshold' => $deliveryZone->free_delivery_threshold,
            'amount_for_free_delivery' => $amountForFreeDelivery,
            'total_with_delivery' => $orderAmount + $deliveryCost
        ]);
    }

    /**
     * Get all available delivery zones
     */
    public function zones(): JsonResponse
    {
        $zones = DeliveryZone::active()
            ->ordered()
            ->select('name', 'postal_codes', 'delivery_cost', 'free_delivery_threshold')
            ->get()
            ->map(function ($zone) {
                return [
                    'name' => $zone->name,
                    'delivery_cost' => $zone->delivery_cost,
                    'free_delivery_threshold' => $zone->free_delivery_threshold,
                    'postal_codes_sample' => array_slice($zone->postal_codes, 0, 5) // Échantillon des codes
                ];
            });

        return response()->json([
            'zones' => $zones
        ]);
    }
}