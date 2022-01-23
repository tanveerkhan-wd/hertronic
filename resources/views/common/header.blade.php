@if($logged_user->utype=='admin')
    @include('admin.header.header')
@elseif($logged_user->utype=='employee')
    @include('employee.header.header')
@elseif($logged_user->utype=='student')
    @include('student.header.header')
@endif
