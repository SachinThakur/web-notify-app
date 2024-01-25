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
				<li class="breadcrumb-item active" aria-current="page">Create New Notification</li>
			</ol>
		</nav>
		<!-- End Breadcrumb -->

		<div class="mb-3 mb-md-4 d-flex justify-content-between">
			<div class="h3 mb-0">Create New Notification</div>
		</div>


		<!-- Form -->
		<div>
			<form method="post" action="{{ route('notification.store') }}">               
				@csrf
				<div class="form-row">
					<div class="form-group col-12 col-md-6">
						<label for="name">Notification Type</label>	
						<select class="form-control" id="type" name="notification_type" aria-label="Default select example">
							<option value="" selected>--please select--</option>
							<option value="marketing">Marketing</option>
							<option value="invoices">Invoices</option>
							<option value="system">System</option>
						</select>
						<!-- <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $notification->name ?? '') }}" id="name" name="name" placeholder="notification Name"> -->
					</div>
					<div class="form-group col-12 col-md-6">
						<label for="msg">Message</label>
						<input type="text" class="form-control{{ $errors->has('msg') ? ' is-invalid' : '' }}" value="{{ old('msg', $notification->email ?? '') }}" id="msg" name="msg" placeholder="Notification Message">
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-12 col-md-6">
						<label for="expiry_date">Expiry Date</label>
						<input type="date" min="<?php echo date("Y-m-d"); ?>" class="form-control{{ $errors->has('expiry_date') ? ' is-invalid' : '' }}" value="{{ old('expiry_date', $notification->name ?? '') }}" id="expiry_date" name="expiry_date" placeholder="Date">
					</div>
					<div class="form-group col-12 col-md-6">
						<input type="checkbox" class="form-check-input1 mt-6" id="sentToAll" checked name="sentToAll">
						<label class="form-check-label" for="sentToAll">Sent To All</label>	
					</div>
				</div>
				<div class="form-row optional-input">
					<div class="form-group col-12 col-md-6 d-none">						
						<label for="name">Select Users</label>	
						<select multiple  class="form-control" id="user_ids" name ="user_ids[]" aria-label="Default select example">
						<option>-- select users --</option>
						@foreach($users  as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
						</select>
						<!-- <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name', $notification->name ?? '') }}" id="name" name="name" placeholder="notification Name"> -->
					</div>
				</div>
				
				<button type="submit" class="btn btn-primary float-right">Create</button>
			</form>
		</div>
		<!-- End Form -->
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$('#sentToAll').click(function(){
    if($(this).is(':checked')){
        $('.optional-input div').addClass('d-none');
    } else {
        $('.optional-input div').removeClass('d-none');
    }
});
</script>
@endsection