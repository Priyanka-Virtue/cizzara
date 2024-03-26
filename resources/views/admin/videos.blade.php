@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Videos /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Show Videos</h5>
    <form action="{{ route('admin.videos.index') }}" method="GET">
        <div class="p-3">
            <div class="row">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="round-1">Round 1</option>
                            <option value="round-2">Round 2</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contestant">Search by Contestant Name:</label>
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Enter User Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">

                        <button type="submit" name="submit" value="submit" class="btn btn-primary btn-block mt-4">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Contestant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($videos as $video)
                <tr>
                    <td><a href="{{ route('admin.videos.show', $video) }}">{{ $video->original_name }}</a></td>
                    <td>{{ $video->state }}</td>
                    <td>{{ $video->user->name }}</td>
                    <td>
                        <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-primary">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No videos found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="justify-content-center">
        <div class="col-md-6 mx-auto">
            <hr />
            {{ $videos->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
