@extends('admin.layout.app_with_login')
@section('title','Notification List')
@section('content')	
<section class="content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h3>Notification List</h3>				
				@foreach($notifications as $key=>$value)
				 @php
                	$string = $value->message;        
	                $string = str_replace(['Hello','Admin','From','Thank you','Team Cashguru',','],'',$string);               
              	 @endphp  		
				<div class="notification_pera noti_text" >
			    	<div class="row">
						<div class="col-md-11">
							<div class="abc"><span>{!! str_replace('&nbsp;','',$string) !!}</span></div>	
						</div>
						<div class="col-md-1">
							<a href="{{ url('admin/deleteNotification/'.$value->id) }}"><img src="{{ url('public/front_end/assets/images/delete.png') }}"></a>	
						</div>
					</div>				    
				</div>
				@endforeach

				{{ $notifications->links() }}

			</div>
		</div>
	</div>
</section>
@endsection
@push('custom-styles')
<!-- Include this Page CSS -->
<style type="text/css">
	.abc br,.abc table {
	    display: none;
	}
	.abc p {
	    display: inline-block;
	}
	.notification_pera.noti_text {
    margin-top: 15px;
}
</style>
@endpush
@push('custom-scripts')
<!-- Include this Page JS -->
<script type="text/javascript">
	$(document).on('click','.pageClick',function(){
		location.href = $(this).attr('data-url');
	});
</script>
@endpush