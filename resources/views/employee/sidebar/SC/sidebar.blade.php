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
        <li class="{{ (request()->is('employee/mySchool')) || (request()->is('employee/villageSchools')) || (request()->is('employee/mainBooks')) || (request()->is('employee/viewMainBook*')) ? 'active' : '' }}">
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{url('public/images/ic_high-school_color.png')}}" class="color">
               <img src="{{url('public/images/ic_high-school.png')}}" class="selected">
                {{$translations['sidebar_nav_school'] ?? 'School'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('employee/mySchool')) || (request()->is('employee/villageSchools')) || (request()->is('employee/mainBooks')) || (request()->is('employee/viewMainBook*')) ? 'show' : '' }}" id="pageSubmenu">
                <li class="{{ (request()->is('employee/mySchool')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/mySchool" href="{{url('/employee/mySchool')}}">{{$translations['sidebar_nav_my_school'] ?? 'My School'}}</a>
                </li>
                <li class="{{ (request()->is('employee/villageSchools')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/villageSchools" href="{{url('/employee/villageSchools')}}">{{$translations['sidebar_nav_village_schools'] ?? 'Village Schools'}}</a>
                </li>
                <li class="{{ (request()->is('employee/mainBooks')) || (request()->is('employee/viewMainBook*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/mainBooks" href="{{url('/employee/mainBooks')}}">{{$translations['sidebar_nav_main_books'] ?? 'Main Books'}}</a>
                </li>                        
            </ul>                   
        </li>             
        <li class="{{ (request()->is('employee/subAdmins')) || (request()->is('employee/addSubAdmin')) ||  (request()->is('employee/viewSubAdmin*')) || (request()->is('employee/editSubAdmin*')) || (request()->is('employee/employees')) ||  (request()->is('employee/viewEmployee*')) || (request()->is('employee/editEmployee*')) || (request()->is('employee/addEmployee')) || (request()->is('employee/engageEmployee')) || (request()->is('employee/students')) || (request()->is('employee/addStudent')) || (request()->is('employee/student*')) || (request()->is('employee/viewStudent*')) || (request()->is('employee/editStudent*')) || (request()->is('employee/enrollStudents')) ? 'active' : '' }}">
            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{url('public/images/ic_menu_color.png')}}" class="color">
                <img src="{{url('public/images/ic_menu.png')}}" class="selected">
                {{$translations['sidebar_nav_user_management'] ?? 'User Management'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('employee/subAdmins')) || (request()->is('employee/addSubAdmin')) || (request()->is('employee/viewSubAdmin*')) || (request()->is('employee/editSubAdmin*')) || (request()->is('employee/employees')) ||  (request()->is('employee/viewEmployee*')) || (request()->is('employee/editEmployee*')) || (request()->is('employee/addEmployee')) || (request()->is('employee/engageEmployee')) || (request()->is('employee/students')) || (request()->is('employee/addStudent')) || (request()->is('employee/students*')) || (request()->is('employee/viewStudent*')) || (request()->is('employee/editStudent*')) || (request()->is('employee/enrollStudents')) ? 'show' : '' }}" id="pageSubmenu1">
                <li class="{{ (request()->is('employee/subAdmins')) || (request()->is('employee/addSubAdmin')) || (request()->is('employee/viewSubAdmin*')) || (request()->is('employee/editSubAdmin*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/subAdmins" href="{{url('/employee/subAdmins')}}">{{$translations['sidebar_nav_admin_staff'] ?? 'Admin Staff'}}</a>
                </li>
                <li class="{{ (request()->is('employee/employees')) || (request()->is('employee/addEmployee')) ||  (request()->is('employee/viewEmployee*')) || (request()->is('employee/editEmployee*')) || (request()->is('employee/engageEmployee')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/employees" href="{{url('/employee/employees')}}">{{$translations['sidebar_nav_employees'] ?? 'Employees'}}</a>
                </li>
                <li class="{{ (request()->is('employee/students')) || (request()->is('employee/addStudent')) || (request()->is('employee/students*')) || (request()->is('employee/viewStudent*')) || (request()->is('employee/editStudent*')) || (request()->is('employee/enrollStudents')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/students" href="{{url('/employee/students')}}">{{$translations['sidebar_nav_students'] ?? 'Students'}}</a>
                </li>
            </ul>                   
        </li>
        <li class="{{ (request()->is('employee/classCreation')) || (request()->is('employee/classCreations'))  || (request()->is('employee/classCreation*')) ? 'active' : '' }}">
            <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <img src="{{url('public/images/ic_collaboration_color.png')}}" class="color">
               <img src="{{url('public/images/ic_collaboration.png')}}" class="selected">
                {{$translations['sidebar_nav_organization'] ?? 'Organization'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('employee/classCreation')) || (request()->is('employee/classCreations')) || (request()->is('employee/classCreation*')) ? 'show' : '' }}" id="pageSubmenu2">
                <li class="{{ (request()->is('employee/classCreations')) || (request()->is('employee/classCreation')) || (request()->is('employee/classCreation*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="employee/classCreations" href="{{url('/employee/classCreations')}}">{{$translations['sidebar_nav_class_creation'] ?? 'Class Creation'}}</a>
                </li>
                <li>
                    <a href="#">{{$translations['sidebar_nav_course_groups'] ?? 'Course Groups'}}</a>
                </li>
                <li>
                    <a href="#">{{$translations['sidebar_nav_course_orders'] ?? 'Course Orders'}}</a>
                </li>
                <li>
                    <a href="#">{{$translations['sidebar_nav_certification'] ?? 'Certification'}}</a>
                </li>                       
            </ul>                   
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
        <li>
            <a href="#">
               <img src="{{url('public/images/ic_reports_color.png')}}" class="color">
               <img src="{{url('public/images/ic_reports.png')}}" class="selected">
                {{$translations['sidebar_nav_report'] ?? 'Report'}}
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{url('public/images/ic_logs_color.png')}}" class="color">
                <img src="{{url('public/images/ic_logs.png')}}" class="selected">
                {{$translations['sidebar_nav_logs'] ?? 'Logs'}}
            </a>
        </li>
    </ul>
    <div class="bottom-link">
      <a href="#x" class="help-link"><img src="{{ url('public/images/ic_comment.png')}}" >{{$translations['gn_help'] ?? 'Help'}}?</a>
      <a href="#x" class="logout"><img src="{{ url('public/images/ic_logout.png')}}" ></a>
    </div>

   
</nav>