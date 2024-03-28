@extends('layouts.auth')

@section('content')
<style>
    .wizard .nav-tabsxxx>li:not(.active) a i {
        color: #000 !important;
    }
</style>
@include('partials.steps', ['active' => 'upload'])
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="videoTitle">Video Title</label>
        <input type="text" class="form-control" id="videoTitle" name="videoTitle" required>
        <input type="hidden" id="plan" name="plan" value="{{request()->plan}}">
    </div>
    <div class="form-group">
        <label for="videoDescription">Video Description</label>
        <textarea class="form-control" id="videoDescription" name="videoDescription" rows="3"></textarea>
    </div>
    <div class="form-group">
        <label for="videoFile">Choose Video File</label>
        <input type="file" accept="video/*" class="form-control-file" id="videoFile" name="videoFile" required>Max file size allowed: 80MB
    </div>
    <button type="submit" class="btn btn-primary">Upload Video</button>
</form>

@endsection
