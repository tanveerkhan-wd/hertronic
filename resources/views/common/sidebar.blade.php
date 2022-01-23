@if($logged_user->utype=='admin')
	@if($logged_user->type=='HertronicAdmin')
	  @include('admin.sidebar.HSA.sidebar')
	@endif
	@if($logged_user->type=='MinistryAdmin')
	  @include('admin.sidebar.MA.sidebar')
	@endif
@elseif($logged_user->utype=='employee')
	@if($logged_user->type=='SchoolCoordinator' || $logged_user->type=='SchoolSubAdmin')
	  @include('employee.sidebar.SC.sidebar')
	@endif
	@if($logged_user->type=='Teacher' || $logged_user->type=='Principal')
	  @include('employee.sidebar.Teacher.sidebar')
	@endif
@elseif($logged_user->utype=='student')
	@include('student.sidebar.sidebar')
@endif