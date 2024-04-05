@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Gurus /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Show Gurus</h5>
    <div class="p-3">
        <div class="row">
            <div class="col-md-7">
            <form action="{{ route('admin.gurus.create') }}" method="POST">
                    <div class="input-group">
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Search by Name" aria-label="Search by Contestant Name" aria-describedby="button-addon2">
                        <input type="text" class="form-control" id="e" name="e" placeholder="Search by Name" >
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <!-- <form action="{{ route('admin.gurus.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Search by Name" aria-label="Search by Contestant Name" aria-describedby="button-addon2">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">Search</button>
                    </div>
                </form> -->
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Guru</th>
                    <th>Email</th>


                    <th>Active</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($gurus as $user)
                <tr>
                    {{-- <td><a href="{{ route('admin.gurus.show', $user) }}">{{ $user->name  }}</a></td> --}}
                    <td>{{ $user->name  }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <div class="form-check form-switch mb-2">
                            <input class="status-switch form-check-input" type="checkbox" data-user-id="{{ $user->id }}" {{ $user->is_active == 1 ? 'checked' : '' }}>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="justify-content-center">
        <div class="col-md-6 mx-auto">
            <hr />
            {{ $gurus->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
@section('bottom')
<script>
    $(document).ready(function() {
        $('.status-switch').change(function() {
            var user_id = $(this).data('user-id');
            var is_active = $(this).prop('checked') ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '{{ route("admin.gurus.update-status") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    user_id: user_id,
                    is_active: is_active
                },
                success: function(response) {
                    // Handle success, if needed
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle error, if needed
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection
