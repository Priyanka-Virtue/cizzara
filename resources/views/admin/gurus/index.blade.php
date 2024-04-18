@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-1"><span class="text-muted fw-light">Gurus /</span><?php echo date('Y') ?></h4>
<hr class="my-3" />

<div class="card">

    <h5 class="card-header">List Gurus  <a class="btn btn-outline-primary float-end" href="{{route('gurus.create')}}">Add Guru</a></h5>

    <!-- <div class="p-3">
        <div class="row">
            <div class="col-md-10">
                <form method="POST" action="{{ isset($userDetail) ? route('gurus.update', $userDetail->id) : route('gurus.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($userDetail))
                    @method('PUT')
                    @endif
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Guru" value="{{ isset($userDetail) ? $userDetail->name : old('name') }}">
                        <input type="text" class="form-control" id="email" name="email" placeholder="guru@cizzara.in" value="{{ isset($userDetail) ? $userDetail->email : old('email') }}">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="999999999" value="{{ isset($userDetail) ? $userDetail->phone : old('phone') }}">
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" {{ (isset($userDetail) && $userDetail->is_active == 1) ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ (isset($userDetail) && $userDetail->is_active == 0) ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">{{ isset($userDetail) ? 'Update Guru' : 'Add Guru' }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-2">

            </div>
        </div>
    </div> -->


    <div class="table-responsive text-nowrap">

        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Guru</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Active</th>
                    <th>For Audition</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($gurus ?? [] as $user)
                <tr>
                    <td>{{ $user->name  }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                        <div class="form-check form-switch mb-2">
                            <input class="status-switch form-check-input" type="checkbox" data-user-id="{{ $user->id }}" {{ $user->is_active == 1 ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        @php
                        $plans = App\Models\Plan::where('is_active', 1)->get();
                        @endphp
                        @foreach($plans as $plan)
                        @php
                        $checked = App\Models\Plan::where('id', $plan->id)->whereJsonContains('gurus', $user->id)->exists();

                        @endphp
                        <div class="form-check form-switch mb-2">
                            <input class="audition-switch form-check-input" type="checkbox" data-plan-id="{{ $plan->id }}" data-user-id="{{ $user->id }}" {{ $checked??'' == 1 ? 'checked' : '' }}>
                            <label>{{$plan->name}}</label>
                        </div>
                        @endforeach


                    </td>
                    <td>
                        <!-- Edit Button -->
                        <a href="{{ route('gurus.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                        <!-- Delete Button -->
                        <!-- <form action="{{ route('gurus.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form> -->


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
            {{ ($gurus ?? null) ? $gurus->appends(request()->input())->links() : "" }}
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
                    Toast.fire({
                            icon: 'success',
                            title: 'Status updated successfully',
                        });
                },
                error: function(xhr, status, error) {
                    // Handle error, if needed
                    // console.error(xhr.responseText);
                    Toast.fire({
                        icon: 'error',
                        title: 'Could not update status',
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        const toastPlacementExample = document.querySelector('.toast-placement-ex'),
            toastPlacementBtn = document.querySelector('#showToastPlacement');
        let selectedType, selectedPlacement, toastPlacement;
        $('.audition-switch').change(function() {
            var userId = $(this).data('user-id');
            var planId = $(this).data('plan-id');
            var newStatus = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '{{ route("admin.gurus.assign-audition") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: newStatus,
                    plan_id: planId,
                    user_id: userId
                },
                success: function(response) {
                    console.log(response);

                    Toast.fire({
                            icon: 'success',
                            title: 'audition assignment updated successfully',
                        });

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);

                    Toast.fire({
                            icon: 'error',
                            title: 'audition assignment failed',
                        });

                }


            });
        });
    });
</script>
@endsection
