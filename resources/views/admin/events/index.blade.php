@extends('admin.layouts.app')
@section('title', 'Events Management')
@section('page_title', 'Upcoming Events')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-calendar-event"></i> All Events</h2>
        <a href="{{ route('admin.events.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-plus-lg"></i> New Event</a>
    </div>
    
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Event Details</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($events->count() > 0)
                    @foreach($events as $event)
                    <tr>
                        <td>
                            <div style="font-weight:600; color:var(--text-dark); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ $event->title }}</div>
                            <small style="color:var(--text-light); font-family: 'Jameel Noori Nastaleeq', 'Noto Nastaliq Urdu', serif;">{{ str($event->description)->limit(60) }}</small>
                        </td>
                        <td>
                            <div style="font-weight:600;">{{ $event->event_date->format('M d, Y') }}</div>
                            <small style="color:var(--text-light);">{{ $event->event_date->format('h:i A') }}</small>
                        </td>
                        <td>{{ $event->location ?? 'N/A' }}</td>
                        <td>
                            @if($event->is_active)
                                <span class="badge badge-green">Active</span>
                            @else
                                <span class="badge badge-gray">Draft</span>
                            @endif
                            @if($event->event_date->isPast())
                                <span class="badge badge-red" style="margin-left: 5px;">Past</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:0.5rem;">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-outline btn-xs" title="Edit"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline btn-xs" style="color:#e53e3e; border-color:rgba(229,62,62,0.3);" title="Delete"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-light);">No events scheduled yet.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection

