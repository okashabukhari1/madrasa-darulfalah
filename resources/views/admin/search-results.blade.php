@extends('admin.layouts.app')

@section('title', 'Search Results')
@section('page_title', 'Global Search Results')

@section('content')
<div class="search-stats mb-4">
    <p class="text-muted">Showing results for: <strong class="text-primary">"{{ $q }}"</strong></p>
</div>

<div class="row g-4">
    <!-- Students Results -->
    <div class="col-md-6">
        <div class="db-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-mortarboard me-2"></i>Students ({{ $results['students']->count() }})</h3>
                <a href="{{ route('admin.students.index', ['search' => $q]) }}" class="btn-view-all">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($results['students'] as $student)
                    <div class="list-item d-flex align-items-center p-3 border-bottom">
                        <div class="item-icon bg-primary-light text-primary me-3">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="item-info flex-grow-1">
                            <h4 class="mb-0">{{ $student->name }} <small class="text-muted">({{ $student->student_id }})</small></h4>
                            <div class="d-flex gap-3 mt-1">
                                <span class="urdu-font badge bg-light text-dark">{{ $student->urdu_name }}</span>
                                <span class="badge bg-soft-info">{{ ucfirst($student->program) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No students found.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Teachers Results -->
    <div class="col-md-6">
        <div class="db-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-person-video3 me-2"></i>Teachers ({{ $results['teachers']->count() }})</h3>
                <a href="{{ route('admin.teachers.index') }}" class="btn-view-all">View Directory</a>
            </div>
            <div class="card-body p-0">
                @forelse($results['teachers'] as $teacher)
                    <div class="list-item d-flex align-items-center p-3 border-bottom">
                        <div class="item-icon bg-secondary-light text-secondary me-3">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="item-info flex-grow-1">
                            <h4 class="mb-0">{{ $teacher->name }}</h4>
                            <div class="d-flex gap-3 mt-1">
                                <span class="urdu-font badge bg-light text-dark">{{ $teacher->urdu_name }}</span>
                                <span class="badge bg-soft-success">{{ $teacher->specialization }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No teachers found.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Courses Results -->
    <div class="col-md-6">
        <div class="db-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-book me-2"></i>Courses ({{ $results['courses']->count() }})</h3>
                <a href="{{ route('admin.courses.index') }}" class="btn-view-all">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($results['courses'] as $course)
                    <div class="list-item d-flex align-items-center p-3 border-bottom">
                        <div class="item-icon bg-success-light text-success me-3">
                            <i class="bi bi-journal-code"></i>
                        </div>
                        <div class="item-info flex-grow-1">
                            <h4 class="mb-0">{{ $course->title }}</h4>
                            <div class="d-flex gap-3 mt-1">
                                <span class="urdu-font badge bg-light text-dark text-lg">{{ $course->urdu_title }}</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.courses.show', $course->id) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></a>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No courses found.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Books Results -->
    <div class="col-md-6">
        <div class="db-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><i class="bi bi-journal-bookmark-fill me-2"></i>Library ({{ $results['books']->count() }})</h3>
                <a href="{{ route('admin.books.index') }}" class="btn-view-all">Go to Library</a>
            </div>
            <div class="card-body p-0">
                @forelse($results['books'] as $book)
                    <div class="list-item d-flex align-items-center p-3 border-bottom">
                        <div class="item-icon bg-warning-light text-warning me-3">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <div class="item-info flex-grow-1">
                            <h4 class="mb-0">{{ $book->title }}</h4>
                            <small class="text-muted">By: {{ $book->author }}</small>
                        </div>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No books found.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
    .urdu-font {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    .bg-primary-light { background: rgba(10, 102, 194, 0.1); }
    .bg-secondary-light { background: rgba(108, 117, 125, 0.1); }
    .bg-success-light { background: rgba(25, 135, 84, 0.1); }
    .bg-warning-light { background: rgba(255, 193, 7, 0.1); }
    .btn-view-all {
        font-size: 0.85rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
    }
    .btn-view-all:hover { text-decoration: underline; }
    .list-item:last-child { border-bottom: none !important; }
    .list-item:hover { background: #f8fafc; }
    .item-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
</style>
@endsection
