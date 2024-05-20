<?php

namespace App\Http\Controllers\Api\Private;

use App\Http\Controllers\Controller;
use App\Models\Parking;
use App\Models\ParkingCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ParkingController extends Controller
{
    public function getAllParkings()
    {
        $parkings = Parking::all();
        
        foreach ($parkings as $parking) {
            $parking->free_space = $parking->free_space;
        }

        return response()->json($parkings);
    }

    public function getSinglePark($id)
    {
        $parking = Parking::findOrFail($id);

        $parking->free_space = $parking->free_space;

        return response()->json($parking);
    }

    public function order(Request $request, $parkingId)
    {
        $request->validate([
            'car_number' => 'required|string|max:7',
        ]);
    
        $user = Auth::user();
    
        // Check if the car is already active in another parking
        $activeCar = ParkingCar::where('car_number', $request->car_number)
                                 ->where('is_active', true)
                                 ->first();

        if ($activeCar) {
            return response()->json(['message' => 'This car is already active in another parking'], 422);
        }

        $activeUser = ParkingCar::where('user_id', $user -> id)
                                ->where('is_active', true)
                                ->first();
        if ($activeUser) {
            return response()->json(['message' => 'You already have an active order'], 422);
        }
    
        $parking = Parking::findOrFail($parkingId);
    
        $order = ParkingCar::create([
        
            'user_id' => $user->id,
            'parking_id' => $parking->id,
            'car_number' => $request->car_number,
            'ordered_at' => now()
        ]);
    
        return response()->json($order, 201);
    }

    public function getOrder()
    {
        $user = Auth::user();

        $invoice = $user->getInvoice();

        if ($invoice) {
            return response()->json($invoice);
        }

        return null;
    }

    public function pay($orderid) 
    {
        $order = ParkingCar::findOrFail($orderid);
        if ($order) {
            $order->paid_at = now();
            $order->is_active = 0; 
            $order->save();
            return 'success';
        }

    }

    public function history()
    {
        $user = Auth::user();
        $orders = ParkingCar::where('user_id', $user->id)
                            ->get(); // Use get() instead of all()
        return $orders;
    }
    

    public function getUser() 
    {
        return Auth::user();
    }

    
public function updateUser(Request $request)
{
    // Retrieve the authenticated user
    $user = Auth::user();

    // Validate the incoming request data
    $request->validate([
        'phone' => 'required|string', // Add any validation rules as needed
    ]);

    // Update the phone number
    $user->phone = $request->input('phone');

    // Save the changes to the database
    $user->save();

    // Optionally, you can return a response to indicate success or redirect the user
    return response()->json(['message' => 'Phone number updated successfully']);
}
    

}
