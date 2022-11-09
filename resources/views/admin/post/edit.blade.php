@extends('layouts.master')

@section('title', 'Edit Post')

@section('content')

<div class="container-fluid px-4">
    <div class="card mt-4">



        <div class="card-header">
            <h4>Edit Posts
                <a href="{{ url('admin/posts') }}" class="btn btn-secondary float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">

            @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

            <form action="{{ url('admin/update-post/'. $posts->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="">Category</label>
                    <select name="category_id" required class="form-control">
                        <option value=""> -- Select Category -- </option>
                        @foreach ($category as $item)
                            <option value="{{ $item->id }}" {{ $posts->category_id == $item->id ? 'selected':''}} >{{ $item->name }}</option>
                        @endforeach

                    </select>
                </div>
                <div class="mb-3">
                    <label for=""> Post Name</label>
                    <input type="text" name="name" value="{{ $posts->name }}" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">slug</label>
                    <input type="text" name="slug" value="{{ $posts->slug }}" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Description</label>
                    <textarea name="description" class="form-control" id="mySummernote" rows="4">{!! $posts->description !!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="">Youtube Iframe Link</label>
                    <input type="text" name="yt_iframe" value="{{ $posts->yt_iframe }}" class="form-control" />
                </div>

                <h4>SEO Tags</h4>
                <div class="mb-3">
                    <label for="">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $posts->meta_title }}" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="4">{!! $posts->meta_description !!}</textarea>
                </div>
                <div class="mb-3">
                    <label for="">Meta Keyword</label>
                    <textarea name="meta_keyword" class="form-control" rows="4">{!! $posts->meta_keyword !!}</textarea>
                </div>

                <h4>Status</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="">Status</label>
                            <input type="checkbox" name="status" {{ $posts->status == '1' ? 'checked':'' }}>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary float-end">Save Post</button>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
