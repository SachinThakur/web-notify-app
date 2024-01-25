@extends('layouts.grain')

@section('title', 'Notifications')

@section('content')

@include('components.notification')

<div class="card mb-3 mb-md-4">

	<div class="card-body">
		<!-- Breadcrumb -->
		<nav class="d-none d-md-block" aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item active" aria-current="page">Notifications</li>
			</ol>
		</nav>
		<!-- End Breadcrumb -->

		<div class="mb-3 mb-md-4 d-flex justify-content-between">
			<div class="h3 mb-0">Notifications</div>
			<a href="{{ route('notification.create') }}" class="btn btn-primary">
				Add new
			</a>
		</div>


		<!-- Notifications -->
		<div class="table-responsive-xl">
			<table class="table text-nowrap mb-0">
				<thead>
				<tr>
					<th class="font-weight-semi-bold border-top-0 py-2">Type</th>
					<th class="font-weight-semi-bold border-top-0 py-2">Message</th>
					<th class="font-weight-semi-bold border-top-0 py-2">Sent Date</th>
					<th class="font-weight-semi-bold border-top-0 py-2">Expiry Date</th>
				</tr>
				</thead>
				<tbody>
				@forelse($notifications  as $notification)
				<tr>
					<td class="align-middle py-3">
						<div class="d-flex align-items-center">							
							{{ $notification->data['type'] }}
						</div>
					</td>
					<td class="py-3">{{ $notification->data['message'] }}</td>
					<td class="py-3">{{ $notification->created_at->diffForHumans() }}</td>
					<td class="py-3">{{ $notification->data['expiry'] ?? '-' }}</td>						
				</tr>
				@empty
				<tr>
					<td colspan="5" class="align-center">
						<strong>No records found</strong><br>
					</td>
				</tr>
				@endforelse

				</tbody>
			</table>
			
			
		</div>
		<!-- End Users -->
	</div>
</div>
@endsection