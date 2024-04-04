@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Users /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">
    <h5 class="card-header">Show Users</h5>
    <div class="p-3">
        <div class="row">
            <div class="col-md-7">
                @include('partials.export-btns', ['exportAction' => route('export.userList')])
            </div>
            <div class="col-md-5">
                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" id="contestant" name="contestant" placeholder="Search by Contestant Name" aria-label="Search by Contestant Name" aria-describedby="button-addon2">
                        <button type="submit" name="submit" value="submit" class="btn btn-primary waves-effect" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead class="table-light">
                <tr>
                <td><input class="form-check-input" type="checkbox" name="selectAll" id="selectAll" value="selectAll"></td>
                    <th>Contestant</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Birthdate</th>
                    <th>Education</th>
                    <th>Occupation</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($users as $user)
                <tr>
                <td><input class="form-check-input" type="checkbox" name="selectedRecords[]" value="{{ $user->id }}"></td>

                    <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->details->last_name .' '.$user->details->first_name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->details->phone }}</td>
                    <td>{{ $user->details->date_of_birth }}</td>
                    <td>{{ $user->details->education }}</td>
                    <td>{{ $user->details->occupation }}</td>
                    <td>{{ $user->details->city }}</td>
                    <td>{{ $user->details->state }}</td>
                    <td>{{ $user->details->pin_code }}</td>
                    <td>{{ $user->details->address }}</td>

                    <td>
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary">View</a>
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
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>

</div>

@endsection
@section('bottom')
<script src="{{ asset('assets/js/export.js') }}"></script>
@endsection
