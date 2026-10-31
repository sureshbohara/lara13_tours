<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.unique' => 'This email is already subscribed to our newsletter.',
            'email.email' => 'Please enter a valid email address.',
        ]);
        Subscriber::updateOrCreate(
            ['email' => $request->email],
            [
                'status' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]
        );
        return back()->with('success', 'Thank you for subscribing to our newsletter! 🎉');
    }
    
}