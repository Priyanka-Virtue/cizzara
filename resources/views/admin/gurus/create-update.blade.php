@extends('layouts.app-new')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Gurus /</span><?php echo date('Y') ?></h4>
<hr class="my-5" />

<div class="card">

    <h5 class="card-header">{{ isset($userDetail) ? 'Edit Guru' : 'Add Guru' }}</h5>
    <div class="p-3">
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
    </div>




</div>

@endsection
