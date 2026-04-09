<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = \App\Models\Message::latest()->get();
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = \App\Models\Message::findOrFail($id);
        
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }
        
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\Message::findOrFail($id)->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
