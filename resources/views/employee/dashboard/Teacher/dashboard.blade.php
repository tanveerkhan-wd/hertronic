@extends('layout.app_with_login')
@section('title', $translations['sidebar_nav_dasbhoard'] ?? 'Dashboard')
@section('content')	
<!-- Page Content  -->
<div class="section">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h2 class="title">{{$translations['sidebar_nav_dasbhoard'] ?? 'Dashboard'}}</h2>
			</div>
		</div>
	</div>
</div>

@endsection

@push('custom-scripts')
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endpush