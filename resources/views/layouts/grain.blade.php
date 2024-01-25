<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('graindashboard/css/graindashboard.css') }}" rel="stylesheet">
</head>

  <body class="has-sidebar has-fixed-sidebar-and-header">
	@include('components.header')

    <main class="main">
	  @include('components.sidebar')
      

      <div class="content">
        <div class="py-4 px-3 px-md-4">

			@yield('content')

        </div>
		
		@include('components.footer')

      </div>
    </main>


	<script src="{{ mix('graindashboard/js/graindashboard.js') }}"></script>
	<script src="{{ mix('graindashboard/js/graindashboard.vendor.js') }}"></script>
	<script type="text/javascript">
		
		function sendMarkRequest(id = null) {
			return $.ajax("{{ route('markNotification') }}", {
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				method: 'POST',
				data: {
					id
				}
			});
		}
		$(function() {
			$('.mark-as-read').click(function() {
				let request = sendMarkRequest($(this).data('id'));
				request.done(() => {
					$("#notify_count").text( Math.max(0, Number($("#notify_count").text()) - 1) )
					$(this).remove();
				});
			});
			$('#mark-all').click(function() {
				let request = sendMarkRequest();
				request.done(() => {
					//$('div.alert').remove();
				})
			});
		});
	
	</script>
	
    @yield('scripts')
  </body>
</html>