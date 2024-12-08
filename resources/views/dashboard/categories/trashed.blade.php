@extends('dashboard.layouts.app')
@section('title', 'Trashed Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Trashed</li>

@endsection
@section('content')
<div class="container my-4">
    <!-- Action Buttons and Search Bar -->

    <!-- Data Table Heading -->
    <h2 class="mb-4">Categories List</h2>

    <!-- Data Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Parent</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->child->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $category->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $category->status }}
                            </span>
                        </td>
                        <td>{{ $category->created_at->format('d M Y') }}</td>
                        <td>


                            <form action="{{ route('categories.restore', $category->id) }}" method="post" style="display: inline;">
                            @csrf                                
                            <button type="submit" class="btn btn-outline-primary btn-sm me-2">Restore</button>
                            </form>

                            <form action="{{ route('categories.forcedelete', $category->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                    Force Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No Data Available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination (if applicable) -->
    {{-- <div class="d-flex justify-content-center mt-3">
        {{ $categories->links() }}
    </div> --}}
</div>
@endsection
