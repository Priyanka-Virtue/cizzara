@extends('layouts.auth')

@section('content')
<style>
    .wizard .nav-tabsxxx>li:not(.active) a i {
        color: #000 !important;
    }

    .main-container {
        /* height: 100vh; */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .main-container h2 {
        /* margin: 0 0 80px 0; */
        color: #555;
        font-size: 30px;
        font-weight: 300;
    }

    .radio-buttons {
        width: 100%;
        margin: 0 auto;
        text-align: center;
    }

    .custom-radio input {
        display: none;
    }

    .radio-btn {
        margin: 10px;
        width: 220px;
        height: 240px;
        border: 3px solid transparent;
        display: inline-block;
        border-radius: 10px;
        position: relative;
        text-align: center;
        box-shadow: 0 0 20px #c3c3c367;
        cursor: pointer;
    }

    .radio-btn>i {
        color: #ffffff;
        background-color: #9c6868;
        font-size: 20px;
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%) scale(2);
        border-radius: 50px;
        padding: 3px 5px;
        transition: 0.5s;
        pointer-events: none;
        opacity: 0;
    }

    .radio-btn .hobbies-icon {
        width: 150px;
        height: 150px;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .radio-btn .hobbies-icon img {
        display: block;
        width: 100%;
        margin-bottom: 20px;

    }

    .radio-btn .hobbies-icon i {
        color: #FFDAE9;
        line-height: 80px;
        font-size: 60px;
    }

    .radio-btn .hobbies-icon h3 {
        color: #555;
        font-size: 18px;
        font-weight: 300;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .custom-radio input:checked+.radio-btn {
        border: 2px solid #9c6868;
    }

    .custom-radio input:checked+.radio-btn>i {
        opacity: 1;
        transform: translateX(-50%) scale(1);
    }

    label.disabled,
    .disabled {
        opacity: 0.8;
        cursor: not-allowed;

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


@php

$uploaded_videos_types = [];
$styles = ['Jazz'=>['img'=>'https://img.freepik.com/free-vector/sport-equipment-concept_1284-13034.jpg?size=626&ext=jpg'],
'Classical' => ['img'=>'https://img.freepik.com/free-vector/hand-drawn-flat-design-poetry-illustration_23-2149279810.jpg?size=626&ext=jpg'],
'Pop' => ['img'=>'https://img.freepik.com/free-vector/hand-drawn-twerk-illustration_23-2149447957.jpg?size=626&ext=jpg']];
@endphp


<form action="{{ route('video.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="main-container">
        <!-- <h2>Select the type of your video</h2> -->
        <div class="alert alert-info" >You can add upto {{env('MAX_VIDEO_FILE_UPLOAD', 2)}} different style videos, however If you upload only one video it won't affect the ranking and won't affect chance to be selected for next round.</div>
        <!-- <div class="radio-buttons">
            @foreach($styles as $style => $style_details)
            @if(!in_array($style, $uploaded_videos_types))
            <label class="custom-radio">
                <input type="radio" value="{{$style}}" name="style" required>
                <span class="radio-btn"><i class="mdi mdi-check"></i>
                    <div class="hobbies-icon">
                        <img src="{{$style_details['img']}}">
                        <h3 class="">{{$style}}</h3>
                    </div>
                </span>
            </label>
            @else
            <label disabled class="custom-radio disabled">
                <span class="radio-btn disabled"><i class="mdi mdi-check"></i>
                    <div class="hobbies-icon">
                        <img src="{{$style_details['img']}}">
                        <h3 class="mb-0">{{$style}}</h3>Video Uploaded
                    </div>
                </span>
            </label>
            @endif
            @endforeach
        </div> -->

    </div>
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
        <input type="file" accept="video/*" class="form-control-file" id="videoFile" name="videoFile" required>Max file size allowed: {{env('MAX_VIDEO_FILE_SIZE', 100000) / 1000}}MB
    </div>
    <button type="submit" class="btn btn-primary">Upload Video</button>
</form>

@endsection
