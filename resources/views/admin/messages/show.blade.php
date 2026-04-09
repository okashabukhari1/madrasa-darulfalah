@extends('admin.layouts.app')
@section('title', 'View Message')
@section('page_title', 'Inquiry Details')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="db-card">
        <div class="db-card-header">
            <h2><i class="bi bi-envelope-open"></i> {{ $message->subject }}</h2>
            <div style="display:flex; gap:0.5rem;">
                <a href="{{ route('admin.messages.index') }}" class="btn btn-outline btn-sm">Back to Inbox</a>
                <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline btn-sm" style="color:#ff4d4d; border-color:rgba(255,107,107,0.3);"><i class="bi bi-trash"></i> Delete</button>
                </form>
            </div>
        </div>
        
        <div class="db-card-body" style="padding: 2.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--beige-dark);">
                <div>
                    <h3 style="margin: 0 0 0.25rem 0; color: var(--text-dark);">{{ $message->name }}</h3>
                    <p style="margin: 0; color: var(--gold-dark); font-weight: 500;">{{ $message->email }}</p>
                    @if($message->phone)
                        <p style="margin: 0.25rem 0 0 0; color: var(--text-light); font-size: 0.9rem;"><i class="bi bi-telephone"></i> {{ $message->phone }}</p>
                    @endif
                </div>
                <div style="text-align: right; color: var(--text-light); font-size: 0.9rem;">
                    <div>Received</div>
                    <div style="font-weight: 600; color: var(--text-dark);">{{ $message->created_at->format('M d, Y') }}</div>
                    <div>{{ $message->created_at->format('h:i A') }}</div>
                </div>
            </div>

            <div style="background: var(--beige-light); padding: 2rem; border-radius: 12px; line-height: 1.6; color: var(--text-dark); position: relative;">
                <i class="bi bi-quote" style="position: absolute; top: 1rem; left: 1rem; font-size: 2rem; opacity: 0.1; color: var(--gold-dark);"></i>
                <div style="white-space: pre-wrap;">{{ $message->message }}</div>
            </div>

            <div style="margin-top: 3rem; text-align: center;">
                <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-gold" style="padding: 0.75rem 2.5rem;">
                    <i class="bi bi-reply"></i> Reply via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
