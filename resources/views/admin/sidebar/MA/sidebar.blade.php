<nav id="sidebar" class="">
    <div class="sidebar-header">
        <h3>Hertronic</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="admin/dashboard" href="{{url('/admin/dashboard')}}">
               <img src="{{ url('public/images/ic_dashoard_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_dashoard.png') }}" class="selected">
                {{$translations['sidebar_nav_dasbhoard'] ?? 'Dashboard'}}
            </a>
        </li>
        <li class="{{ (request()->is('admin/subAdmins')) || (request()->is('admin/addSubAdmin')) ||  (request()->is('admin/viewSubAdmin*')) || (request()->is('admin/editSubAdmin*')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="admin/subAdmins" href="{{url('/admin/subAdmins')}}">
                <img src="{{url('public/images/ic_menu_color.png')}}" class="color">
                <img src="{{url('public/images/ic_menu.png')}}" class="selected">
                {{$translations['sidebar_nav_user_management'] ?? 'User Management'}}
            </a>
        </li>               
        <li class="{{ (request()->is('admin/grades')) || (request()->is('admin/classes')) || (request()->is('admin/nationalities')) || (request()->is('admin/religions')) || (request()->is('admin/citizenships*')) || (request()->is('admin/vocations*')) || (request()->is('admin/courses*')) || (request()->is('admin/schoolYear*')) || (request()->is('admin/educationPeriod*')) ? 'active' : '' }}">
            <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{url('public/images/ic_cart_color.png')}}" class="color">
               <img src="{{url('public/images/ic_cart.png')}}" class="selected">
                {{$translations['sidebar_nav_masters'] ?? 'Masters'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/grades*')) || (request()->is('admin/classes*')) || (request()->is('admin/nationalities')) || (request()->is('admin/religions*')) || (request()->is('admin/citizenships*')) || (request()->is('admin/vocations*')) || (request()->is('admin/courses*')) || (request()->is('admin/schoolYear*')) || (request()->is('admin/educationPeriod*')) ? 'show' : '' }}" id="pageSubmenu1">
                <li class="{{ (request()->is('admin/grades')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/grades" href="{{url('/admin/grades')}}">{{$translations['sidebar_nav_grades'] ?? 'Grades'}}</a>
                </li>
                <li class="{{ (request()->is('admin/classes')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/classes" href="{{url('/admin/classes')}}">{{$translations['sidebar_nav_classes'] ?? 'Classes'}}</a>
                </li>
                <li class="{{ (request()->is('admin/nationalities')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/nationalities" href="{{url('/admin/nationalities')}}">{{$translations['sidebar_nav_nationalities'] ?? 'Nationalities'}}</a>
                </li>
                <li class="{{ (request()->is('admin/religions')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/religions" href="{{url('/admin/religions')}}">{{$translations['sidebar_nav_religions'] ?? 'Religions'}}</a>
                </li>
                <li class="{{ (request()->is('admin/citizenships')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/citizenships" href="{{url('/admin/citizenships')}}">{{$translations['sidebar_nav_country_citizenship'] ?? 'Country Name & Citizenship'}}</a>
                </li>
                <li class="{{ (request()->is('admin/vocations')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/vocations" href="{{url('/admin/vocations')}}">{{$translations['sidebar_nav_vocations'] ?? 'Vocations'}}</a>
                </li>
                <li class="{{ (request()->is('admin/schoolYear*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/schoolYear" href="{{ url('admin/schoolYear') }}">{{$translations['sidebar_nav_school_year'] ?? 'School Year'}}</a>
                </li>
                <li class="{{ (request()->is('admin/educationPeriod*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/educationPeriod" href="{{ url('admin/educationPeriod') }}">{{$translations['sidebar_nav_education_periods'] ?? 'Education Periods'}}</a>
                </li>
                <li class="{{ (request()->is('admin/courses')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/courses" href="{{url('/admin/courses')}}">{{$translations['sidebar_nav_courses'] ?? 'Courses'}}</a>
                </li>
            </ul>                   
        </li>
        <li class="{{ (request()->is('admin/studentBehaviour')) || (request()->is('admin/extracurricuralActivityType')) || (request()->is('admin/disciplineMeasureType')) ? 'active' : '' }}">
            <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <img src="{{url('public/images/ic_cart_color.png')}}" class="color">
               <img src="{{url('public/images/ic_cart.png')}}" class="selected">
                {{$translations['sidebar_nav_student_masters'] ?? 'Student Masters'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/studentBehaviour')) || (request()->is('admin/extracurricuralActivityType')) || (request()->is('admin/disciplineMeasureType')) ? 'show' : '' }}" id="pageSubmenu2">
                <li class="{{ (request()->is('admin/studentBehaviour')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/studentBehaviour" href="{{url('/admin/studentBehaviour')}}">{{$translations['sidebar_nav_behaviour'] ?? 'Behaviour'}}</a>
                </li>
                <li class="{{ (request()->is('admin/extracurricuralActivityType')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/extracurricuralActivityType" href="{{url('/admin/extracurricuralActivityType')}}">{{$translations['sidebar_nav_ecat'] ?? 'Extracurricular Activity Type'}}</a>
                </li>
                <li class="{{ (request()->is('admin/disciplineMeasureType')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/disciplineMeasureType" href="{{url('/admin/disciplineMeasureType')}}">{{$translations['sidebar_nav_dmt'] ?? 'Discipline Measures Types'}}</a>
                </li>            
            </ul>                   
        </li>
        <li class="{{ (request()->is('admin/foreignLanguageGroup')) || (request()->is('admin/optionalCoursesGroup')) || (request()->is('admin/facultativeCoursesGroup')) || (request()->is('admin/generalPurposeGroup')) ? 'active' : '' }}">
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{url('public/images/ic_ebook_color.png')}}" class="color">
               <img src="{{url('public/images/ic_ebook.png')}}" class="selected">
                {{$translations['sidebar_nav_course_groups'] ?? 'Course Groups'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/foreignLanguageGroup')) || (request()->is('admin/optionalCoursesGroup')) || (request()->is('admin/facultativeCoursesGroup')) || (request()->is('admin/generalPurposeGroup')) ? 'show' : '' }}" id="pageSubmenu">
                <li class="{{ (request()->is('admin/foreignLanguageGroup')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/foreignLanguageGroup" href="{{url('/admin/foreignLanguageGroup')}}">{{$translations['sidebar_nav_flg'] ?? 'Foreign Language Groups'}}</a>
                </li>
                <li class="{{ (request()->is('admin/optionalCoursesGroup')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/optionalCoursesGroup" href="{{url('/admin/optionalCoursesGroup')}}">{{$translations['sidebar_nav_ocg'] ?? 'Optional Courses Groups'}}</a>
                </li>
                <li class="{{ (request()->is('admin/facultativeCoursesGroup')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/facultativeCoursesGroup" href="{{url('/admin/facultativeCoursesGroup')}}">{{$translations['sidebar_nav_fcg'] ?? 'Facultative Courses Groups'}}</a>
                </li>
                <li class="{{ (request()->is('admin/generalPurposeGroup')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/generalPurposeGroup" href="{{url('/admin/generalPurposeGroup')}}">{{$translations['sidebar_nav_gpg'] ?? 'General Purpose Groups'}}</a>
                </li>
            </ul>
        </li>
         <li class="{{ (request()->is('admin/educationProgram') || request()->is('admin/addEducationProgram') || request()->is('admin/editEducationProgram/*') ) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="admin/educationProgram" href="{{url('/admin/educationProgram')}}">
               <img src="{{url('public/images/ic_educational-programs_color.png')}}" class="color">
               <img src="{{url('public/images/ic_educational-programs.png')}}" class="selected">
                {{$translations['sidebar_nav_education_program'] ?? 'Education Program'}}
            </a>
        </li>
        <li class="{{ (request()->is('admin/educationPlans')) || (request()->is('admin/addEducationPlan')) ||  (request()->is('admin/viewEducationPlan*')) || (request()->is('admin/editEducationPlan*')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="admin/educationPlans" href="{{url('/admin/educationPlans')}}">
               <img src="{{url('public/images/ic_monitor_color.png')}}" class="color">
               <img src="{{url('public/images/ic_monitor.png')}}" class="selected">
                {{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}}
            </a>
        </li>
        <li class="{{ (request()->is('admin/schools')) || (request()->is('admin/addSchool')) ||  (request()->is('admin/viewSchool*')) || (request()->is('admin/editSchool*')) ? 'active' : '' }}">
            <a class="ajax_request" data-slug="admin/schools" href="{{url('/admin/schools')}}">
               <img src="{{url('public/images/ic_modules_color.png')}}" class="color">
               <img src="{{url('public/images/ic_modules.png')}}" class="selected">
                {{$translations['sidebar_nav_school_management'] ?? 'School Management'}}
            </a>
        </li>
        <li class="{{ (request()->is('admin/students')) || (request()->is('admin/viewStudent/*')) || (request()->is('admin/editStudent/*')) ? 'active' : '' }}">
            <a  class="ajax_request" data-slug="admin/students" href="{{url('/admin/students')}}">
               <img src="{{url('public/images/ic_users_color.png')}}" class="color">
               <img src="{{url('public/images/ic_users.png')}}" class="selected">
                {{$translations['sidebar_nav_students'] ?? 'Students'}}
            </a>
        </li>
        <li class="{{ (request()->is('admin/employees')) || (request()->is('admin/viewEmployee/*')) || (request()->is('admin/editEmployee/*')) ? 'active' : '' }}">
            <a  class="ajax_request" data-slug="admin/employees" href="{{url('/admin/employees')}}">
               <img src="{{url('public/images/ic_team_color.png')}}" class="color">
               <img src="{{url('public/images/ic_team.png')}}" class="selected">
                {{$translations['sidebar_nav_teachers'] ?? 'Teachers'}}
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