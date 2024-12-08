@extends('dashboard.layouts.app')
@section('title','Cerate New Category')
@section('breadcrumb')
@parent
<li class="breadcrumb-item ">Categories</li>
<li class="breadcrumb-item active">Create </li>
@endsection
@section('content')
<div class="container my-4">
    <h2 class="mb-4">Create New Record</h2>
    <form method="POST" action="{{route('categories.store')}}">
        @csrf   
        <!-- Name Field -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        
        <!-- Description Field -->
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" placeholder="Enter description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image</label>
            <input class="form-control" type="file" id="image" accept="image/*">
        </div>
        
        <!-- Parent Selector -->
        <select class="form-select form-select-lg mb-3 form-control" aria-label="Large select example" name="parent_id">
            <option value="" selected>Primary Category</option>
            @foreach ($parents as $parent)
            <option value="{{$parent->id}}">{{$parent->name}}</option>  
            @endforeach
          </select>
          
        <!-- Status Radio Buttons -->
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="active" value="active" checked>
                <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="archived" value="inactive">
                <label class="form-check-label" for="inactive">Archived</label>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


@endsection