@extends('dashboard.layouts.app')
@section('title', 'Categories')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>

@endsection
@section('content')
<div class="container my-4">
    <!-- Action Buttons and Search Bar -->
    <div class=" align-items-center mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Create New Category</a>
        <a href="{{route('categories.trashed')}}" class="btn btn-secondary">Trashed</a>
    </div>
        <form action="{{URL::current()}}" method="get">
            <input type="text" class="form-control w-50" name="name" placeholder="Search..." aria-label="Search" value="{{request()->query('name')}}">

            <select name="status" class="form-control w-25" style="display: inline" id="">
                <option value="">ALL</option>
                <option value="active" @selected(request()->query('status') == 'active')>Active</option>
                <option value="archived" @selected(request()->query('status') == 'archived')>Archived</option>
            </select>
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>

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
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-outline-primary btn-sm me-2">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                    Delete
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

     
    <div class="d-flex justify-content-center mt-3">
        {{ $categories->withQueryString()->links() }}
    </div> 
</div>
@endsection
