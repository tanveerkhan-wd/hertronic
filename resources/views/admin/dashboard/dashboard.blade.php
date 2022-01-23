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
			<div class="col-lg-4 col-md-6">
				<a href="#x">
    				<div class="card-dashboard">
        				<p>{{$translations['sidebar_nav_students'] ?? 'Students'}}</p>
        				<h3>2,560</h3>
        				<img src="{{ url('public/images/ic_shape2.png') }}">
        			</div>
        		</a>
			</div>
			<div class="col-lg-4 col-md-6">
				<a href="#x">
    				<div class="card-dashboard">
        				<p>{{$translations['gn_super_admin'] ?? 'Super Admin'}}</p>
        				<h3>{{$SuperAdminCount}}</h3>
        				<img src="{{ url('public/images/ic_shape3.png') }}">
        			</div>
        		</a>
			</div>
			<div class="col-lg-4 col-md-6">
				<a href="#x">
    				<div class="card-dashboard">
        				<p>{{$translations['gn_parents'] ?? 'Parents'}}</p>
        				<h3>3560</h3>
        				<img src="{{ url('public/images/ic_shape4.png') }}">
        			</div>
        		</a>
			</div>
		</div>
	</div>
</div>

<div class="section">
	<div class="container-fluid">
		<div class="row">
    		<div class="col-lg-4 col-md-12">
    			<p class="caps-head">{{$translations['sidebar_nav_teachers'] ?? 'Teachers'}}</p>
    			<div class="teachers">
        			<div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-cover ">
			        	<img src="{{ url('public/images/img7.png') }}">
			        </div>
			        <div class="profile-link">
			        	<a href="#x">+12 more</a>
			        </div>
			    </div>
			    <div class="graph mt-4">
    				<img src="{{ url('public/images/graph1.png') }}">
    			</div>
    		</div>
    		<div class="col-lg-8 col-md-12">
    			<div class="graph">
    				<img src="{{ url('public/images/graph.png') }}">
    			</div>
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