@extends('layouts.drivvo')

@section('title', 'Users Management')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #333;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .search-icon {
        color: #3498db;
        font-size: 24px;
    }
    .btn-add-user {
        background: white;
        border: 2px solid #3498db;
        color: #3498db;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-add-user:hover {
        background: #3498db;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    .user-table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .user-table {
        width: 100%;
        margin: 0;
    }
    .user-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    .user-table thead th {
        padding: 16px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: capitalize;
        letter-spacing: 0.5px;
        border: none;
    }
    .user-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
        font-size: 14px;
    }
    .user-table tbody tr:last-child td {
        border-bottom: none;
    }
    .user-table tbody tr:hover {
        background: #f8f9fa;
    }
    .user-name {
        font-weight: 600;
        color: #333;
        font-size: 15px;
    }
    .user-email {
        color: #666;
        font-size: 14px;
    }
    .user-title {
        color: #999;
        font-size: 13px;
        font-style: italic;
    }
    .badge-role {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .badge-admin {
        background: #e3f2fd;
        color: #1976d2;
    }
    .badge-manager {
        background: #fff3e0;
        color: #f57c00;
    }
    .badge-driver {
        background: #f3e5f5;
        color: #7b1fa2;
    }
    .badge-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.3px;
    }
    .badge-active {
        background: #d4edda;
        color: #155724;
    }
    .badge-inactive {
        background: #f8d7da;
        color: #721c24;
    }
    .action-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    .action-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 16px;
        color: white;
    }
    .action-icon-btn:hover {
        transform: translateY(-1px);
    }
    .action-icon-btn.btn-view {
        background: #17a2b8;
    }
    .action-icon-btn.btn-view:hover {
        background: #138496;
    }
    .action-icon-btn.btn-edit {
        background: #3498db;
    }
    .action-icon-btn.btn-edit:hover {
        background: #2980b9;
    }
    .action-icon-btn.btn-delete {
        background: #e74c3c;
    }
    .action-icon-btn.btn-delete:hover {
        background: #c0392b;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .empty-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
        margin-bottom: 24px;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }
    .empty-title {
        font-size: 24px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
    }
    .empty-description {
        font-size: 15px;
        color: #999;
        margin-bottom: 24px;
    }
    
    /* Custom Pagination Style */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-top: 1px solid #e9ecef;
        margin-top: -1px;
    }
    
    .pagination-info {
        color: #6c757d;
        font-size: 14px;
    }
    
    .pagination-links {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .pagination-links .page-link {
        padding: 8px 16px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        background: white;
    }
    
    .pagination-links .page-link:hover {
        background: #f8f9fa;
        border-color: #3498db;
        color: #3498db;
    }
    
    .pagination-links .page-link.active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }
    
    .pagination-links .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }
</style>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-users-cog"></i>
        Users Management
    </h1>
    <a href="{{ route('users.create') }}" class="btn-add-user">
        <i class="fas fa-plus me-2"></i>
        Add New User
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($users->count() > 0)
<div class="user-table-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Title/Position</th>
                <th>User Type/Authorization</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
            <tr>
                <td>{{ $users->firstItem() + $index }}</td>
                <td>
                    <div class="user-name">{{ $user->name }}</div>
                </td>
                <td>
                    <div class="user-email">{{ $user->email }}</div>
                </td>
                <td>
                    <div class="user-title">{{ $user->title ?? '-' }}</div>
                </td>
                <td>
                    @if($user->user_type == 'admin')
                        <span class="badge-role badge-admin">Administrator</span>
                    @elseif($user->user_type == 'manager')
                        <span class="badge-role badge-manager">Sales</span>
                    @elseif($user->user_type == 'driver')
                        <span class="badge-role badge-driver">Operation</span>
                    @else
                        <span class="badge-role" style="background: #f5f5f5; color: #666;">User</span>
                    @endif
                </td>
                <td>
                    @if(($user->status ?? 'active') == 'active')
                        <span class="badge-status badge-active">Active</span>
                    @else
                        <span class="badge-status badge-inactive">Inactive</span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('users.show', $user) }}" class="action-icon-btn btn-view" title="View User">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', $user) }}" class="action-icon-btn btn-edit" title="Edit User">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, '{{ $user->name }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-icon-btn btn-delete" title="Delete User">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($users->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
        </div>
        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($users->onFirstPage())
                <span class="page-link disabled">
                    <i class="fas fa-chevron-left"></i> Previous
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="page-link">
                    <i class="fas fa-chevron-left"></i> Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach(range(1, $users->lastPage()) as $page)
                @if($page == $users->currentPage())
                    <span class="page-link active">{{ $page }}</span>
                @else
                    <a href="{{ $users->url($page) }}" class="page-link">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="page-link">
                    Next <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-link disabled">
                    Next <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    </div>
    @endif
</div>

@else
<div class="empty-state">
    <div class="empty-icon">
        <i class="fas fa-users-cog" style="color: white;"></i>
    </div>
    <h3 class="empty-title">No Users Yet</h3>
    <p class="empty-description">
        Start by adding your first user to manage the system.
    </p>
    <a href="{{ route('users.create') }}" class="btn-add-user">
        <i class="fas fa-plus me-2"></i>
        Add First User
    </a>
</div>
@endif

@push('scripts')
<script>
function confirmDelete(event, userName) {
    event.preventDefault();
    
    if (confirm('Are you sure you want to delete user "' + userName + '"?\n\nThis action cannot be undone.')) {
        event.target.submit();
    }
    
    return false;
}
</script>
@endpush
@endsection
