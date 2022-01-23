<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <button type="button" id="sidebarCollapse" class="btn btn-info">
              <i class="fas fa-align-left"></i>
              <span>Toggle Sidebar</span>
          </button>
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item ">
                <div class="custom-drop-down" id="custom-flag-drop-down">
                  <select onchange='langSwitch(this.value)' style="width:130px;">
                      @foreach($languages as $k => $v)
                        <option @if($current_language==$v->language_key) selected @endif value='{{$v->language_key}}' class="custom_flag {{$v->language_key}}" style="background-image:url({{url('public/images/languages')}}/{{$v->flag}});" data-title="{{$v->language_name}}">{{$v->language_name}}</option>
                      @endforeach
                  </select>
                </div>
              </li>

              <li class="nav-item active">
                  <a class="nav-link" href="#"> <img src="{{ url('public/images/ic_search.png') }}"></a>
              </li>
               
              <li class="nav-item dropdown notification_dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ url('public/images/ic_bell.png') }}">
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <ul>
                      <li>
                        <p class="noti_pere">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        <div class="close_noti">
                          <img src="{{ url('public/images/ic_close_circle.png') }}">
                        </div>
                      </li>
                      <li>
                        <p class="noti_pere">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        <div class="close_noti">
                          <img src="{{ url('public/images/ic_close_circle.png') }}">
                        </div>
                      </li>
                      <li>
                        <p class="noti_pere">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                        <div class="close_noti">
                          <img src="{{ url('public/images/ic_close_circle.png') }}">
                        </div>
                      </li>
                    </ul>
                  </div>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="profile-cover">
                      <img src="@if(!empty($logged_user->stu_PicturePath)) {{url('public/images/students/')}}/{{$logged_user->stu_PicturePath}} @else {{ url('public/images/user.png') }}@endif">
                    </div>
                    <i class="fas fa-chevron-down right-arrow"></i>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                     <!-- <a class="dropdown-item ajax_request" data-slug="employee/profile" href="{{ url('employee/profile') }}">{{$translations['gn_profile'] ?? 'Profile'}}</a> -->
                    <a class="dropdown-item" href="javascript:void(0)">{{$translations['gn_profile'] ?? 'Profile'}}</a>
                    <a class="dropdown-item" href="#">{{$translations['gn_setting'] ?? 'Setting'}}</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('logout') }}">{{$translations['gn_logout'] ?? 'Logout'}}</a>
                  </div>
              </li>
            </ul>
            
        </div>
    </div>
</nav>