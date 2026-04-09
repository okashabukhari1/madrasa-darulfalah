@extends('admin.layouts.app')
@section('title', 'Gallery Management')
@section('page_title', 'Gallery Media')

@section('content')
<div class="db-card">
    <div class="db-card-header">
        <h2><i class="bi bi-images"></i> Media Gallery</h2>
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-gold btn-sm"><i class="bi bi-cloud-upload"></i> Upload Images</a>
    </div>
    
    @if(session('success'))
        <div style="padding: 1rem; background: rgba(26,107,60,0.1); color: var(--primary); border-radius: 8px; margin: 0 1.5rem 1rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="padding: 1.5rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
        @forelse($gallery as $item)
        <div style="border-radius:12px; overflow:hidden; background:var(--white); box-shadow:var(--shadow-sm); border:1px solid var(--beige-dark); position:relative; aspect-ratio:4/3; group">
            <img src="{{ asset('storage/' . $item->image) }}" style="width:100%; height:100%; object-fit:cover;">
            <div style="position:absolute; inset:0; background:rgba(0,0,0,0.5); opacity:0; transition:0.3s; display:flex; flex-direction:column; justify-content:center; align-items:center; gap:1rem;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                <div style="color:#fff; font-weight:600; text-align:center; padding:0 1rem;">{{ $item->title ?? 'Untitled' }}</div>
                <div style="color:var(--gold); font-size:0.8rem;">{{ $item->category }}</div>
                <div style="display:flex; gap:0.5rem;">
                    <a href="{{ route('admin.gallery.edit', $item->id) }}" style="width:32px; height:32px; border-radius:50%; background:#fff; color:var(--primary); display:flex; align-items:center; justify-content:center; text-decoration:none;"><i class="bi bi-pencil"></i></a>
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this image from gallery?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="width:32px; height:32px; border-radius:50%; background:#fff; color:#ff4d4d; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center;"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1; text-align:center; padding: 4rem; color:var(--text-light);">
            <i class="bi bi-images" style="font-size:3rem; display:block; margin-bottom:1rem; opacity:0.3;"></i>
            No gallery items found.
        </div>
        @endforelse
    </div>
</div>
@endsection
