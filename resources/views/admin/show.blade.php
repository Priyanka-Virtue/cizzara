@extends('layouts.app-new')

@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- <div class="user-avatar-section">
                    <div class=" d-flex align-items-center flex-column">
                        <img class="img-fluid rounded mb-3 mt-4" src="../../assets/img/avatars/10.png" height="120" width="120" alt="User avatar">
                        <div class="user-info text-center">
                            <h4>{{ $video->name }}</h4>
                            <span class="badge bg-label-info rounded-pill">Pending</span>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="d-flex justify-content-between flex-wrap my-2 py-3">
                    <div class="d-flex align-items-center me-4 mt-3 gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-check mdi-24px"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-0">1.23k</h4>
                            <span>Tasks Done</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-3 gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-primary rounded">
                                <i class="mdi mdi-star-outline mdi-24px"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-0">568</h4>
                            <span>Projects Done</span>
                        </div>
                    </div>
                </div> -->
                @if (session('succcess'))
                <div class="alert alert-success" role="alert">
                    {{ session('succcess') }}
                </div>
                @endif
                <h5 class="pb-3 border-bottom mb-3">Details</h5>
                <div class="info-container">
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Title:</span>
                            <span>{{ $video->title }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Description:</span>
                            <span>{{ $video->description }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Upload Time:</span>
                            <span>{{ $video->created_at->format('Y-m-d H:i:s') }}</span>
                        </li>


                        <li class="mb-3">
                            <span class="h6">StageName:</span>
                            <span>{{$video->auditionDetails->stagename}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Audition city:</span>
                            <span>{{$video->auditionDetails->auditioncity}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Music Experience:</span>
                            <span>{{$video->auditionDetails->music_experience}}</span>
                        </li>

                    </ul>
                    <hr/>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <span class="h6">Contestant Name:</span>
                            <span><a href="{{ route('admin.users.show', $video->user) }}"> {{ $video->user->name }} </a></span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Email:</span>
                            <span>{{$video->user->email}}</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Status:</span>
                            <span class="badge bg-label-success rounded-pill text-uppercase">{{$video->state}}</span>
                        </li>


                        <li class="mb-3">
                            <span class="h6">Contact:</span>
                            <span>(123) 456-7890</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Languages:</span>
                            <span>French</span>
                        </li>
                        <li class="mb-3">
                            <span class="h6">Country:</span>
                            <span>United Kingdom</span>
                        </li>
                    </ul>

                    <div class="d-grid w-100 mt-4">
                        <form action="{{ route('admin.videos.updateStatus', $video) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- <div class="input-group">
                            <button class="btn btn-outline-primary waves-effect" type="submit">Change Status</button>
                            <select class="form-select" id="inputGroupSelect03" id="status" name="status" aria-label="status">
                            <option value="pending" @if ($video->state == 'pending') selected @endif>Pending</option>
                                    <option value="round-1" @if ($video->state == 'round-1') selected @endif>Round 1</option>
                                    <option value="round-2" @if ($video->state == 'round-2') selected @endif>Round 2</option>
                                    <option value="rejected" @if ($video->state == 'rejected') selected @endif>Rejected</option>
                            </select>
                          </div> -->
                            <div class="form-group">
                                <label for="status">Change Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="pending" @if ($video->state == 'pending') selected @endif>Pending</option>
                                    <option value="round-1" @if ($video->state == 'round-1') selected @endif>Round 1</option>
                                    <option value="round-2" @if ($video->state == 'round-2') selected @endif>Round 2</option>
                                    <option value="rejected" @if ($video->state == 'rejected') selected @endif>Rejected</option>
                                </select>
                            </div>
                            <button class="btn btn-primary waves-effect mt-1 waves-light w-100">Change Status</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <!-- /User Card -->


    </div>


    <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="card mb-4">
            <div class="card-body">
                <video width="100%" controls>
                    <source src="{{ asset('storage/'.$video->file_path) }}">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>


</div>

@endsection
