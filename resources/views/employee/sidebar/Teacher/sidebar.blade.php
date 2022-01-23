<nav id="sidebar" class="">
    <div class="sidebar-header">
        <h3>Hertronic</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ (request()->is('employee/dashboard')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="employee/dashboard" href="{{url('/employee/dashboard')}}">
               <img src="{{ url('public/images/ic_dashoard_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_dashoard.png') }}" class="selected">
                {{$translations['sidebar_nav_dasbhoard'] ?? 'Dashboard'}}
            </a>
        </li>
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_attendant-list_color.png')}}" class="color">
               <img src="{{url('public/images/ic_attendant-list.png')}}" class="selected">
                {{$translations['sidebar_nav_sa_sa'] ?? 'Student Attendance & Syllabus Accomplishment'}}
            </a>
        </li>         
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_exam_color.png')}}" class="color">
               <img src="{{url('public/images/ic_exam.png')}}" class="selected">
                {{$translations['sidebar_nav_exam'] ?? 'Exam'}}
            </a>
        </li>
        <li class="{{ (request()->is('employee/subAdmins')) || (request()->is('employee/addSubAdmin')) ||  (request()->is('employee/viewSubAdmin*')) || (request()->is('employee/editSubAdmin*')) || (request()->is('employee/teachers')) ||  (request()->is('employee/viewTeacher*')) || (request()->is('employee/editTeacher*')) ? 'active' : '' }}">
            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{url('public/images/ic_users_color.png')}}" class="color">
                <img src="{{url('public/images/ic_users.png')}}" class="selected">
                {{$translations['sidebar_nav_students'] ?? 'Students'}}
                <i class="fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('employee/students')) || (request()->is('employee/addStudent')) || (request()->is('employee/editStudents*')) ? 'show' : '' }}" id="pageSubmenu1">
                <li>
                    <a href="#">{{$translations['sidebar_nav_behaviour'] ?? 'Behaviour'}}</a>
                </li>
                <li>
                    <a href="#">{{$translations['sidebar_nav_extracurricular_activity'] ?? 'Extracurricular Activity'}}</a>
                </li>
                <li>
                    <a href="#">{{$translations['sidebar_nav_discipline_measure'] ?? 'Discipline Measure'}}</a>
                </li> 
            </ul>                   
        </li>
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_business_color.png')}}" class="color">
               <img src="{{url('public/images/ic_business.png')}}" class="selected">
                PTM
            </a>
        </li>
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_attendant-list_color.png')}}" class="color">
               <img src="{{url('public/images/ic_attendant-list.png')}}" class="selected">
                {{$translations['sidebar_nav_allocated_class'] ?? 'Allocated Class'}}
            </a>
        </li>
    </ul>
    <div class="bottom-link">
      <a href="#x" class="help-link"><img src="{{ url('public/images/ic_comment.png')}}" >{{$translations['gn_help'] ?? 'Help'}}?</a>
      <a href="#x" class="logout"><img src="{{ url('public/images/ic_logout.png')}}" ></a>
    </div>

   
</nav>