<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function show($id)
    {
        $event = Event::active()->findOrFail($id);
        
        return view('public.events.show', compact('event'));
    }
}
