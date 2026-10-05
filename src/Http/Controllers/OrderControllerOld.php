<?php

namespace Oscar\PooPractice\Http\Controllers;

class OrderControllerOld extends Controller
{
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'customer_email' => 'required|email',
            'amount' => 'required|numeric|min:0',
            'is_vip' => 'boolean',
        ]);

        // business logic
        $amount = $request->amount;
        if ($request->is_vip) {
            $amount = $amount * 0.85;
        }

        // persistence
        $order = new Order();
        $order->customer_email = $request->customer_email;
        $order->amount = $amount;
        $order->save();

        // side effect
        Mail::raw("Your order total is {$amount}", function ($message) use ($request) {
            $message->to($request->customer_email)->subject('Order confirmation');
        });

        Log::info("Order created for {$request->customer_email}");

        // response
        return response()->json(['total' => $amount]);
    }
}
