<nav id="sidebar" class="">
    <div class="sidebar-header">
        <h3>Hertronic</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ (request()->is('student/dashboard')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="student/dashboard" href="{{url('/student/dashboard')}}">
               <img src="{{ url('public/images/ic_dashoard_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_dashoard.png') }}" class="selected">
                {{$translations['sidebar_nav_dasbhoard'] ?? 'Dashboard'}}
            </a>
        </li>            
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_test-results_color.png')}}" class="color">
               <img src="{{url('public/images/ic_test-results.png')}}" class="selected">
                {{$translations['sidebar_nav_exam_result'] ?? 'Exam Result'}}
            </a>
        </li>
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_attendant-list_color.png')}}" class="color">
               <img src="{{url('public/images/ic_attendant-list.png')}}" class="selected">
                {{$translations['sidebar_nav_attendance'] ?? 'Attendance'}}
            </a>
        </li>
    </ul>
    <div class="bottom-link">
      <a href="#x" class="help-link"><img src="{{ url('public/images/ic_comment.png')}}" >{{$translations['gn_help'] ?? 'Help'}}?</a>
      <a href="#x" class="logout"><img src="{{ url('public/images/ic_logout.png')}}" ></a>
    </div>

   
</nav>