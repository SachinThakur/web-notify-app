@extends('layouts.grain')

@section('title', 'Dashboard')

@section('content')

@include('components.notification')

<div class="card mb-3 mb-md-4">

	<div class="card-body">
		<!-- Breadcrumb -->
		<nav class="d-none d-md-block" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('notification.index') }}">Notification</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">{{ $notification->id ? 'Edit' : 'Create New' }} Notification</li>
			</ol>
		</nav>
		<!-- End Breadcrumb -->

		<div class="mb-3 mb-md-4 d-flex justify-content-between">
			<div class="h3 mb-0">{{ $notification->id ? 'Edit' : 'Create New' }} Notification</div>
		</div>


		<!-- Form -->
		<div>
			<form method="post" action="{{ $notification->id ? route('notification.update', $notification) : route('notification.store') }}">
                @if($notification->id)
				<input type="hidden" name="_method" value="patch">
                @endif
				@csrf
				<div class="form-row">
					<div class="form-group col-12 col-md-6">
						<label for="name">Name</label>
						<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $notification->name) }}" id="name" name="name" placeholder="notification Name">
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="email">Email</label>
						<input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email', $notification->email) }}" id="email" name="email" placeholder="notification Email">
					</div>
				</div>
				@if(!$notification->id)
				<div class="form-row">
					<div class="form-group col-12 col-md-6">
						<label for="password">Password</label>
						<input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="password_confirmation">Confirm Password</label>
						<input type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
					</div>
				</div>
				@endif

				<button type="submit" class="btn btn-primary float-right">{{ $notification->id ? 'Update' : 'Create' }}</button>
			</form>
		</div>
		<!-- End Form -->
	</div>
</div>
@endsection