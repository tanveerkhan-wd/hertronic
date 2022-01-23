@section('title','Education Programs')
@section('script', url('public/js/dashboard/education_programs.js')) 
@section('content')
 <!-- Page Content  -->
<div class="section">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-12 mb-3">
                <h2 class="title"><a class="ajax_request no_sidebar_active" data-slug="admin/educationProgram" href="{{url('/admin/educationProgram')}}"><span>{{$translations['sidebar_nav_education_programs'] ?? 'Education Programs'}} > </span></a> {{$translations['gn_edit'] ?? ' Edit'}}</h2>
            </div>   
            <div class="col-md-4 mb-3">
                
            </div>  
            <div class="col-md-4 text-md-right mb-3">
                
            </div> 
            <div class="col-md-2 col-6 mb-3">
               
            </div>
            <div class="col-md-2 col-6 mb-3">
                
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="white_box pt-5 pb-5">
                    <div class="container-fliid">
                        <form name="add-educationProgram-form">
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <div class="">
                                        <input type="hidden" name="pkEdp" id="aid" value="{{$data->pkEdp}}">
                                        @foreach($languages as $k => $v)
                                            <div class="form-group">
                                                @php
                                                    $edpName = 'edp_Name_'.$v->language_key;
                                                @endphp
                                                <label>{{$translations['gn_name'] ?? 'Name'}} {{$v->language_name}} *</label>
                                                <input type="text" name="edp_Name_{{$v->language_key}}" value="{{$data->$edpName}}" id="edp_Name_{{$v->language_key}}" class="form-control force_require icon_control" required="">
                                            </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label>{{$translations['gn_stream'] ?? 'Stream'}} *</label>
                                            <select name="edp_ParentId" id="edp_ParentId" class="form-control icon_control dropdown_control">
                                                <option value="@if($data->edp_ParentId==0) 0 @else {{$data->edp_ParentId}} @endif" selected>@if($data->edp_ParentId==0)Self @else {{$data->parent->edp_Name}} @endif</option>
                                                <option value="0">{{$translations['gn_self'] ?? 'Self'}}</option>
                                                {{-- Parent --}}
                                                @foreach($educationProgram as $tkey => $tvalue)
                                                    <option value="{{$tvalue['pkEdp']}}">{{$translations['gn_'] ?? $tvalue['edp_Name']}}</option>
                                                    {{-- Sub Parent --}}
                                                    @foreach($tvalue['children'] as $ckey=> $cValue)
                                                        @if($cValue['edp_ParentId']==$tvalue['pkEdp'])
                                                            <option value="{{$cValue['pkEdp']}}">&emsp;&emsp;{{$translations['gn_'] ?? $cValue['edp_Name']}}</option>
                                                            {{-- Sub Sub Parent --}}
                                                            @foreach($cValue['children'] as $cckey=> $ccValue)
                                                                @if($ccValue['edp_ParentId']==$cValue['pkEdp'])
                                                                    <option value="{{$ccValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ccValue['edp_Name']}}</option>
                                                                    {{-- Sub Sub Sub Parent --}}
                                                                    @foreach($ccValue['children'] as $skey=> $sValue)
                                                                        @if($sValue['edp_ParentId']==$ccValue['pkEdp'])
                                                                            <option value="{{$sValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $sValue['edp_Name']}}</option>
                                                                            {{-- Sub Sub Sub Sub Parent --}}
                                                                            @foreach($sValue['children'] as $sskey=> $ssValue)
                                                                                @if($ssValue['edp_ParentId']==$sValue['pkEdp'])
                                                                                    <option value="{{$ssValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $ssValue['edp_Name']}}</option>
                                                                                    {{-- Sub sub Sub Sub Sub Parent --}}
                                                                                    @foreach($ssValue['children'] as $sskey=> $sssValue)
                                                                                        @if($sssValue['edp_ParentId']==$ssValue['pkEdp'])
                                                                                            <option value="{{$sssValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $sssValue['edp_Name']}}</option>
                                                                                            {{--sub sub Sub Sub Sub Sub Parent --}}
                                                                                            @foreach($sssValue['children'] as $spValue)
                                                                                                @if($spValue['edp_ParentId']==$sssValue['pkEdp'])
                                                                                                    <option value="{{$spValue['pkEdp']}}">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;{{$translations['gn_'] ?? $spValue['edp_Name']}}</option>
                                                                                                @endif
                                                                                            @endforeach

                                                                                        @endif
                                                                                    @endforeach

                                                                                @endif
                                                                            @endforeach

                                                                        @endif
                                                                    @endforeach

                                                                @endif
                                                            @endforeach

                                                        @endif
                                                    @endforeach 
                                                     
                                                    
                                                @endforeach
                                                
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Note</label>
                                            <input type="text" name="edp_Notes" value="{{$data->edp_Notes}}" id="edp_Notes" class="form-control icon_control">
                                        </div>

                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="theme_btn">{{$translations['gn_submit'] ?? 'Submit'}}</button>
                                        <a class="theme_btn red_btn ajax_request no_sidebar_active" data-slug="admin/educationProgram" href="{{url('/admin/educationProgram')}}">{{$translations['gn_cancel'] ?? 'Cancel'}}</a>
                                    </div>
                                </div>
                                <div class="col-lg-3"></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
      showLoader(false);
    });
</script>
@endsection

@push('datatable-scripts')
<!-- Include datatable Page JS -->
<script type="text/javascript" src="{{ url('public/js/dashboard/education_programs.js') }}"></script>
@endpush
@extends('layout.app_with_login')
