<!DOCTYPE html>
<html lang="en">
<!--Head-->
<head>
	<base href="/" />
	<title>{{ config('app.name') }}</title>
	@include('includes.crm.style')
    <script src="/assets/js/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="/assets/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
    <script src="/assets/crm/plugins/global/plugins.bundle.js"></script>
	@yield('meta')
	@include('includes.crm.script')
</head>

<!--Body-->
@if(auth()->user()->email != 'admin@htecom.vn' && (!auth()->user()->employees || auth()->user()->employees->roles->id != 1))
	@php
		$userPermissions = auth()->user()->employees->roles->role_permissions->pluck('permissions.router_web_name')->toArray();
		$bodyClasses = 'is_not_admin';
		foreach ($userPermissions as $permission) {
            $bodyClasses.= ' ' . str_replace(".", "_", $permission);
        }
	@endphp
@else
	@php
		$bodyClasses = 'is_super_admin';
	@endphp
@endif
@if(isset($_GET['token']))
    @php $bodyClasses .= ' is_mobile'; @endphp
    <script>
        localStorage.setItem('is_mobile', true);
    </script>
@endif
<body id="ti_app_body" class="{{$bodyClasses}} crm_leads_statistical" data-ti-app-header-fixed="false" data-ti-app-header-fixed-mobile="true" data-ti-app-sidebar-enabled="true" data-ti-app-sidebar-fixed="true" data-ti-app-sidebar-hoverable="false" data-ti-app-sidebar-submenu-hoverable="true" data-ti-app-sidebar-push-toolbar="true" data-ti-app-sidebar-push-footer="true" data-ti-app-toolbar-enabled="true" data-ti-app-aside-enabled="false" data-ti-app-aside-fixed="false" data-ti-app-aside-push-toolbar="true" data-ti-app-aside-push-footer="true" class="app-default">
	@include('includes.loading')
	@include('includes.crm.theme')
	<div class="d-flex flex-column flex-root app-root" id="ti_app_root">
		<!--Page-->
		<div class="app-page" id="ti_app_page">
			<!--Wrapper-->
			<div class="app-wrapper flex-column flex-row-fluid" id="ti_app_wrapper">
				<!--Sidebar-->
				@include('crm.layouts.sidebar')
				<!--Main-->
				@include('crm.layouts.main')
			</div>
		</div>
	</div>
</body>
<!--end::Body-->

@php
    $voipConfig = DB::table('config_voip')->orderBy('id')->first();
@endphp
@if ($voipConfig)
<script>
    window.API_KEY    = @json($voipConfig->api_key);
    window.API_SECRET = @json($voipConfig->api_secret);
    window.VOIP_IP    = @json($voipConfig->voip_ip);
</script>
@else
<script>
    window.API_KEY    = '';
    window.API_SECRET = '';
    window.VOIP_IP    = '';
</script>
@endif 
</html>
