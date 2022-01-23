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
        <li class="{{ (request()->is('admin/ministries')) || (request()->is('admin/addMinistry')) ||  (request()->is('admin/viewMinistry*')) || (request()->is('admin/editMinistry*')) || (request()->is('admin/loginAs*')) ? 'active' : '' }}">                  
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{ url('public/images/ic_menu_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_menu.png') }}" class="selected">
                {{$translations['sidebar_nav_user_management'] ?? 'User Management'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/ministries')) || (request()->is('admin/addMinistry')) ||  (request()->is('admin/viewMinistry*')) || (request()->is('admin/editMinistry*')) || (request()->is('admin/loginAs*')) ? 'show' : '' }}" id="pageSubmenu">
                <li class="{{ (request()->is('admin/ministries*')) || (request()->is('admin/addMinistry*')) || (request()->is('admin/editMinistry*')) || (request()->is('admin/viewMinistry*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/ministries" href="{{url('/admin/ministries')}}">{{$translations['sidebar_nav_ministry_super_admin'] ?? 'Ministry Super Admin'}}</a>
                </li>
                <li class="{{ (request()->is('admin/loginAs*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/loginAs" href="{{url('/admin/loginAs')}}">{{$translations['sidebar_nav_login_as'] ?? 'Login as'}}</a>
                </li>
            </ul>   
        </li>
        <li class="{{ (request()->is('admin/countries*')) || (request()->is('admin/states*')) || (request()->is('admin/cantons*')) || (request()->is('admin/academicDegrees*')) || (request()->is('admin/jobAndWorks*')) || (request()->is('admin/ownershipTypes*')) || (request()->is('admin/universities*')) || (request()->is('admin/colleges*')) || (request()->is('admin/nationalEducationPlans*')) || (request()->is('admin/educationProfiles*')) || (request()->is('admin/qualificationDegrees*')) || (request()->is('admin/municipalities*')) || (request()->is('admin/postalCodes*')) ? 'active' : '' }}">
          <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{ url('public/images/ic_cart_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_cart.png') }}" class="selected">
                {{$translations['sidebar_nav_masters'] ?? 'Masters'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/countries*')) || (request()->is('admin/states*')) || (request()->is('admin/cantons*')) || (request()->is('admin/academicDegrees*')) || (request()->is('admin/jobAndWorks*')) || (request()->is('admin/ownershipTypes*')) || (request()->is('admin/universities*')) || (request()->is('admin/colleges*')) || (request()->is('admin/nationalEducationPlans*')) || (request()->is('admin/educationProfiles*')) || (request()->is('admin/qualificationDegrees*')) || (request()->is('admin/municipalities*')) || (request()->is('admin/postalCodes*')) ? 'show' : '' }}" id="pageSubmenu1">
                <li class="{{ (request()->is('admin/academicDegrees*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/academicDegrees" href="{{ url('admin/academicDegrees') }}">{{$translations['sidebar_nav_academic_degree'] ?? 'Education & Academic Degree'}}</a>
                </li>
                <li class="{{ (request()->is('admin/jobAndWorks*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/jobAndWorks" href="{{ url('admin/jobAndWorks') }}">{{$translations['sidebar_nav_job_work'] ?? 'Job & Work'}}</a>
                </li>
                <li class="{{ (request()->is('admin/countries*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/countries" href="{{ url('admin/countries') }}">{{$translations['sidebar_nav_countries'] ?? 'Countries'}}</a>
                </li>
                <li class="{{ (request()->is('admin/states*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/states" href="{{ url('admin/states') }}">{{$translations['sidebar_nav_states'] ?? 'States'}}</a>
                </li>
                <li class="{{ (request()->is('admin/cantons*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/cantons" href="{{ url('admin/cantons') }}">{{$translations['sidebar_nav_cantons'] ?? 'Cantons'}}</a>
                </li>
                <li class="{{ (request()->is('admin/municipalities*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/municipalities" href="{{ url('admin/municipalities') }}">{{$translations['sidebar_nav_municipalities'] ?? 'Municipalities'}}</a>
                </li>
                <li class="{{ (request()->is('admin/postalCodes*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/postalCodes" href="{{ url('admin/postalCodes') }}">{{$translations['sidebar_nav_postal_code'] ?? 'Postal Code'}}</a>
                </li>
                <li class="{{ (request()->is('admin/ownershipTypes*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/ownershipTypes" href="{{ url('admin/ownershipTypes') }}">{{$translations['sidebar_nav_ownership_types'] ?? 'Ownership Types'}}</a>
                </li>
                <li class="{{ (request()->is('admin/universities*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/universities" href="{{ url('admin/universities') }}">{{$translations['sidebar_nav_universities'] ?? 'Universities'}}</a>
                </li>
                <li class="{{ (request()->is('admin/colleges*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/colleges" href="{{ url('admin/colleges') }}">{{$translations['sidebar_nav_colleges'] ?? 'Colleges'}}</a>
                </li>
                <li class="{{ (request()->is('admin/nationalEducationPlans*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/nationalEducationPlans" href="{{ url('admin/nationalEducationPlans') }}">{{$translations['sidebar_nav_national_education_plan'] ?? 'National Education Plan'}}</a>
                </li>
                <li class="{{ (request()->is('admin/educationProfiles*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/educationProfiles" href="{{ url('admin/educationProfiles') }}">{{$translations['sidebar_nav_education_profile'] ?? 'Education Profile'}}</a>
                </li>
                <li class="{{ (request()->is('admin/qualificationDegrees*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/qualificationDegrees" href="{{ url('admin/qualificationDegrees') }}">{{$translations['sidebar_nav_qualification_degree'] ?? 'Qualification Degree'}}</a>
                </li>
            </ul>                   
        </li>
        <li class="{{ (request()->is('admin/grades')) || (request()->is('admin/classes')) || (request()->is('admin/schools')) || (request()->is('admin/viewSchool*')) || (request()->is('admin/editSchool*')) || (request()->is('admin/employees')) || (request()->is('admin/students*')) || (request()->is('admin/viewEducationPlan*')) || (request()->is('admin/editEducationPlan*')) || (request()->is('admin/educationPlans*')) || (request()->is('admin/courses*')) || (request()->is('admin/villageSchools*')) || (request()->is('admin/viewEmployee*')) || (request()->is('admin/editEmployee*')) ? 'active' : '' }}">
          <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{ url('public/images/ic_lock_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_lock.png') }}" class="selected">
                {{$translations['sidebar_nav_ministry_masters'] ?? 'Ministry Masters'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/grades')) || (request()->is('admin/classes')) || (request()->is('admin/schools')) ||  (request()->is('admin/viewSchool*')) || (request()->is('admin/editSchool*')) || (request()->is('admin/employees')) || (request()->is('admin/students*')) || (request()->is('admin/viewEducationPlan*')) || (request()->is('admin/editEducationPlan*')) || (request()->is('admin/educationPlans*')) || (request()->is('admin/courses*')) || (request()->is('admin/villageSchools*')) || (request()->is('admin/viewEducationPlan*')) || (request()->is('admin/editEducationPlan*')) || (request()->is('admin/employees')) ||  (request()->is('admin/viewEmployee*')) || (request()->is('admin/editEmployee*')) ? 'show' : '' }}" id="pageSubmenu2">
                <li class="{{ (request()->is('admin/schools')) ||  (request()->is('admin/viewSchool*')) || (request()->is('admin/editSchool*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/schools" href="{{url('/admin/schools')}}">{{$translations['sidebar_nav_schools'] ?? 'Schools'}}</a>
                </li>
                <li class="{{ (request()->is('admin/employees')) || (request()->is('admin/viewEmployee*')) || (request()->is('admin/editEmployee*')) || (request()->is('admin/engageEmployee')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/employees" href="{{url('/admin/employees')}}">{{$translations['sidebar_nav_employees'] ?? 'Employees'}}</a>
                </li>
                <li class="{{ (request()->is('admin/student')) || (request()->is('admin/addStudent')) || (request()->is('admin/student*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/students" href="{{url('/admin/students')}}">{{$translations['sidebar_nav_students'] ?? 'Students'}}</a>
                </li>
                <li class="{{ (request()->is('admin/educationPlans')) || (request()->is('admin/viewEducationPlan*')) || (request()->is('admin/editEducationPlan*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/educationPlans" href="{{url('/admin/educationPlans')}}">{{$translations['sidebar_nav_education_plan'] ?? 'Education Plan'}}</a>
                </li>
                <li class="{{ (request()->is('admin/courses')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/courses" href="{{url('/admin/courses')}}">{{$translations['sidebar_nav_courses'] ?? 'Courses'}}</a>
                </li>
                <li class="{{ (request()->is('admin/grades')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/grades" href="{{url('/admin/grades')}}">{{$translations['sidebar_nav_grades'] ?? 'Grades'}}</a>
                </li>
                <li class="{{ (request()->is('admin/classes')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/classes" href="{{url('/admin/classes')}}">{{$translations['sidebar_nav_classes'] ?? 'Classes'}}</a>
                </li>
                <li class="{{ (request()->is('admin/villageSchools')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/villageSchools" href="{{url('/admin/villageSchools')}}">{{$translations['sidebar_nav_village_schools'] ?? 'Village Schools'}}</a>
                </li>
            </ul>                   
        </li>
        <li class="{{ (request()->is('admin/languages')) || (request()->is('admin/translations')) ? 'active' : '' }}">
          <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
               <img src="{{ url('public/images/ic_reports_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_reports.png') }}" class="selected">
                {{$translations['sidebar_nav_translations'] ?? 'Translations'}}
                <i class="cfa fas fa-chevron-down right-arrow"></i>
            </a>
            <ul class="collapse list-unstyled {{ (request()->is('admin/languages')) || (request()->is('admin/translations')) ? 'show' : '' }}" id="pageSubmenu3">
                <li class="{{ (request()->is('admin/languages*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/languages" href="{{ url('admin/languages') }}">
                        {{$translations['sidebar_nav_languages'] ?? 'Languages'}}
                    </a>
                </li>
                <li class="{{ (request()->is('admin/translations*')) ? 'active' : '' }}">
                    <a class="ajax_request" data-slug="admin/translations" href="{{ url('admin/translations') }}">
                        {{$translations['sidebar_nav_keywords'] ?? 'Keywords'}}
                    </a>
                </li>
            </ul>                   
        </li>
        <li>
            <a href="#">
               <img src="{{ url('public/images/ic_reports_color.png') }}" class="color">
               <img src="{{ url('public/images/ic_reports.png') }}" class="selected">
                {{$translations['sidebar_nav_ministry_report'] ?? 'Report'}}
            </a>
        </li>
        <li>
            <a href="#">
                <img src="{{ url('public/images/ic_logs_color.png') }}" class="color">
                <img src="{{ url('public/images/ic_logs.png') }}" class="selected">
                {{$translations['sidebar_nav_logs'] ?? 'Logs'}}
            </a>
        </li>
    </ul>
    <div class="bottom-link">
      <a href="#x" class="help-link"><img src="{{ url('public/images/ic_comment.png') }}" >{{$translations['gn_help'] ?? 'Help'}}?</a>
      <a href="#x" class="logout"><img src="{{ url('public/images/ic_logout.png') }}" ></a>
    </div>

   
</nav>