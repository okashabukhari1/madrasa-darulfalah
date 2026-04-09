<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class PublicMessageController extends Controller
{
    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with('success', 'JazakAllah Khair! Your message has been received. We will respond within 24-48 hours, InshAllah.');
    }
}
