@extends('layouts.app')

@section('content')
    <h1>Create a New Post</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf  <!-- CSRF token for security -->

        <!-- Title Field -->
        <div class="form-group">
            <label for="title">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                class="form-control"
                value="{{ old('title') }}"
                required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Content Field -->
        <div class="form-group">
            <label for="content">Content</label>
            <textarea
                id="content"
                name="content"
                class="form-control"
                rows="5"
                required>{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Publish Post</button>

        <!-- Optional Back Button -->
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
@endsection
