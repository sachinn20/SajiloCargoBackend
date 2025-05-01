@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0 text-primary fw-bold">User Management</h2>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-start border-success border-4" role="alert">
            <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-3">#</th>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td>
                                @if($user->profile_photo)
                                    <div class="avatar-wrapper">
                                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" class="rounded-circle shadow-sm" width="50" height="50">
                                    </div>
                                @else
                                    <div class="avatar-placeholder bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-user text-secondary"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </td>
                            <td>{{ $user->phone_number ?? '-' }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger">{{ ucfirst($user->role) }}</span>
                                @elseif($user->role == 'staff')
                                    <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end gap-2 pe-3">
                                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fa-solid fa-users text-muted mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0">No users found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Responsive table styles -->
<style>
    @media (max-width: 767.98px) {
        .table-responsive {
            border-radius: 0.25rem;
        }

        .table th:not(:first-child):not(:last-child),
        .table td:not(:first-child):not(:last-child) {
            display: none;
        }

        .table th:first-child,
        .table td:first-child {
            width: 20%;
        }

        .table th:last-child,
        .table td:last-child {
            width: 30%;
        }

        .table td:first-child {
            font-weight: bold;
        }
    }
</style>
@endsection
