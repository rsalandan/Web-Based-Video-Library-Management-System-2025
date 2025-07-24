@extends('backend.admin_dashboard')

@section('admin')
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="page-title">Create Video</h4>
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Video</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="card">
            <div class="card-body">

                <form action="{{ route('video.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="mb-4 text-uppercase">
                        <i class="mdi mdi-video-plus me-1"></i> Video Details
                    </h5>

                    <div class="row">
                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title') }}" required>
                        </div>

                        <!-- Category -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select name="category_id" id="category_id" class="form-control select2">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Video File -->
                        <div class="col-md-6 mb-3">
                            <label for="video" class="form-label">Video File (MP4)</label>
                            <input type="file" name="video" class="form-control" id="video" accept="video/mp4"
                                required>
                            @error('video')
                                @if (Str::contains($message, 'greater than 51200'))
                                    <small class="text-danger">Please upload a video file not more than 30MB.</small>
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        </div>

                        <!-- Thumbnail -->
                        <div class="col-md-6 mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image</label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail" accept="image/*">
                            @error('thumbnail')
                                @if (Str::contains($message, 'greater than 2048'))
                                    <small class="text-danger">Please upload a thumbnail file not more than 1MB.</small>
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
