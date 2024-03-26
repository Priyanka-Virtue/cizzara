@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
        @include('partials.steps', ['active' => 'upload'])
            <div class="card">
                <div class="card-header">Upload Your Video</div>
                <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif
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
                            <textarea class="form-control" id="videoDescription" name="videoDescription" rows="3" ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="videoFile">Choose Video File</label>
                            <input type="file" accept="video/*" class="form-control-file" id="videoFile" name="videoFile" required>Max file size allowed: 500MB
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Video</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
