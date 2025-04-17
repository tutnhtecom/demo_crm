<div id="ti_app_sidebar" class="app-sidebar flex-column" data-ti-drawer="true" data-ti-drawer-name="app-sidebar" data-ti-drawer-activate="{default: true, lg: false}" data-ti-drawer-overlay="true" data-ti-drawer-width="310px" data-ti-drawer-direction="start" data-ti-drawer-toggle="#ti_app_sidebar_mobile_toggle">
    <!--begin::Main-->
    <div class="d-flex flex-column justify-content-between h-100 overflow-y-scroll my-2 d-flex flex-column" id="ti_app_sidebar_main" data-ti-scroll="true" data-ti-scroll-activate="true" data-ti-scroll-height="auto" data-ti-scroll-dependencies="#ti_app_header" data-ti-scroll-wrappers="#ti_app_main" data-ti-scroll-offset="5px">
        <!--begin::Sidebar logo-->
        <div class="app-header-logo d-flex flex-column align-items-start flex-stack px-lg-3 mb-2" id="ti_app_header_logo">
            <!--begin::Sidebar toggle-->
            <div id="ti_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon btn-color-warning me-n2 d-none d-lg-flex" data-ti-toggle="true" data-ti-toggle-state="active" data-ti-toggle-target="body" data-ti-toggle-name="app-sidebar-minimize">
                <img src="/assets/crm/media/svg/custom/menu_toggle.svg" width="32" height="32" class="fs-2x rotate-180">
            </div>
            <!--end::Sidebar toggle-->

            <!--begin::Logo-->
            <a href="{{ route('crm.leads.index') }}" class="app-sidebar-logo align-self-center d-block">
                <img alt="Logo" src="/assets/crm/media/logos/logo.png" class="theme-light-show object-fit-scale w-100" />
                <img alt="Logo" src="/assets/crm/media/logos/logo.png" class="theme-dark-show object-fit-scale w-100" />
            </a>
            <!--end::Logo-->

        </div>
        <!--end::Sidebar logo-->
        <!--begin::Sidebar menu-->

        <div id="ti_app_sidebar_menu" data-ti-menu="true" data-ti-menu-expand="false" class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg bg-white mb-7 mt-3">
            <h5 class="pe-4">Tổng quan</h5>
            <!--begin:Menu item-->
            <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                <!--begin:Menu link-->
                <span class="menu-link">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path opacity="0.3" d="M5.10756 9.4285C7.49422 9.4285 9.42899 7.49373 9.42899 5.10707C9.42899 2.72042 7.49422 0.785645 5.10756 0.785645C2.72091 0.785645 0.786133 2.72042 0.786133 5.10707C0.786133 7.49373 2.72091 9.4285 5.10756 9.4285Z" fill="#034EA2" />
                            <path opacity="0.3" d="M16.8937 9.4285C19.2804 9.4285 21.2151 7.49373 21.2151 5.10707C21.2151 2.72042 19.2804 0.785645 16.8937 0.785645C14.507 0.785645 12.5723 2.72042 12.5723 5.10707C12.5723 7.49373 14.507 9.4285 16.8937 9.4285Z" fill="#034EA2" />
                            <path opacity="0.3" d="M5.10756 21.2141C7.49422 21.2141 9.42899 19.2794 9.42899 16.8927C9.42899 14.5061 7.49422 12.5713 5.10756 12.5713C2.72091 12.5713 0.786133 14.5061 0.786133 16.8927C0.786133 19.2794 2.72091 21.2141 5.10756 21.2141Z" fill="#034EA2" />
                            <path opacity="0.3" d="M16.8937 21.2141C19.2804 21.2141 21.2151 19.2794 21.2151 16.8927C21.2151 14.5061 19.2804 12.5713 16.8937 12.5713C14.507 12.5713 12.5723 14.5061 12.5723 16.8927C12.5723 19.2794 14.507 21.2141 16.8937 21.2141Z" fill="#034EA2" />
                            <path d="M5.10756 9.4285C7.49422 9.4285 9.42899 7.49373 9.42899 5.10707C9.42899 2.72042 7.49422 0.785645 5.10756 0.785645C2.72091 0.785645 0.786133 2.72042 0.786133 5.10707C0.786133 7.49373 2.72091 9.4285 5.10756 9.4285Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16.8937 9.4285C19.2804 9.4285 21.2151 7.49373 21.2151 5.10707C21.2151 2.72042 19.2804 0.785645 16.8937 0.785645C14.507 0.785645 12.5723 2.72042 12.5723 5.10707C12.5723 7.49373 14.507 9.4285 16.8937 9.4285Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5.10756 21.2141C7.49422 21.2141 9.42899 19.2794 9.42899 16.8927C9.42899 14.5061 7.49422 12.5713 5.10756 12.5713C2.72091 12.5713 0.786133 14.5061 0.786133 16.8927C0.786133 19.2794 2.72091 21.2141 5.10756 21.2141Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M16.8937 21.2141C19.2804 21.2141 21.2151 19.2794 21.2151 16.8927C21.2151 14.5061 19.2804 12.5713 16.8937 12.5713C14.507 12.5713 12.5723 14.5061 12.5723 16.8927C12.5723 19.2794 14.507 21.2141 16.8937 21.2141Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="menu-title lh-0">Dashboards</span>
                    <span class="menu-arrow"></span>
                </span>
                <!--end:Menu link-->
                {{-- @if(auth()->check() && auth()->user()->uRolePermission->isNotEmpty())
                    @foreach(auth()->user()->uRolePermission as $permission)
                        <div class="rounded {{$permission->roles->id == 1 ? 'border-danger bg-danger text-danger bg_admin' : 'badge-light-primary'}} px-2">
                            {{ $permission->permissions->router_name }}
                        </div>
                    @endforeach
                @endif --}}
                <!--begin:Menu sub-->
                <div class="menu-sub menu-sub-accordion">
                    <!--begin:Menu item-->
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link crm_leads_statistical" href="{{ route('crm.leads.statistical') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Thống kê</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                    <!--begin:Menu item-->
                    {{-- <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link" href="{{ route('crm.leads.statistical_kpi') }}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Thống kê KPI</span>
                        </a>
                        <!--end:Menu link-->
                    </div> --}}
                    <!--end:Menu item-->
                </div>
                <!--end:Menu sub-->
            </div>
            <!--end:Menu item-->
            <!--begin:Menu item-->
            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $userPermissions = auth()->user()->employees->roles->role_permissions->pluck('permissions.router_web_name')->toArray();
                @endphp
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $leadsPermissions = ['crm.leads.index', 'crm.affiliate.sources', 'crm.academic.terms'];
                    $leadsHasPermission = array_intersect($leadsPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.leads.index', $userPermissions) || in_array('crm.affiliate.sources', $userPermissions) || in_array('crm.academic.terms', $userPermissions))
                    <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path opacity="0.3" d="M7.92031 8.45977C10.0466 8.45977 11.7703 6.73607 11.7703 4.60977C11.7703 2.48347 10.0466 0.759766 7.92031 0.759766C5.79401 0.759766 4.07031 2.48347 4.07031 4.60977C4.07031 6.73607 5.79401 8.45977 7.92031 8.45977Z" fill="#034EA2" />
                                    <path opacity="0.3" d="M0.990234 19.2399H14.8502V18.405C14.838 17.2312 14.5284 16.0796 13.9504 15.0579C13.3725 14.0363 12.5449 13.1777 11.5454 12.5625C10.5456 11.9472 9.40618 11.5954 8.23373 11.5399C8.12908 11.5351 8.02458 11.5324 7.92023 11.5322C7.81589 11.5324 7.71139 11.5351 7.60689 11.5399C6.43429 11.5954 5.29501 11.9472 4.29526 12.5625C3.29552 13.1777 2.46801 14.0363 1.89003 15.0579C1.31206 16.0796 1.00249 17.2312 0.990234 18.405V19.2399Z" fill="#034EA2" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.92008C11.4835 6.27658 11.77 5.47672 11.77 4.60977C11.77 3.74281 11.4835 2.94295 11 2.29945C11.7024 1.36445 12.8207 0.759766 14.08 0.759766C16.2063 0.759766 17.93 2.48347 17.93 4.60977C17.93 6.73606 16.2063 8.45977 14.08 8.45977C12.8207 8.45977 11.7024 7.85508 11 6.92008ZM14.85 19.2398H21.01V18.4049C20.9977 17.231 20.6882 16.0795 20.1102 15.0577C19.5322 14.0361 18.7047 13.1775 17.705 12.5623C16.7052 11.9471 15.5659 11.5952 14.3935 11.5398C14.2888 11.5349 14.1843 11.5322 14.08 11.5321C13.9757 11.5322 13.8712 11.5349 13.7667 11.5398C12.8023 11.5855 11.8604 11.8316 11 12.2598C11.1857 12.3522 11.3676 12.4531 11.5451 12.5623C12.5449 13.1775 13.3722 14.0361 13.9502 15.0577C14.5282 16.0795 14.8377 17.231 14.85 18.4049V19.2398Z" fill="white" />
                                    <path d="M7.92031 8.45977C10.0466 8.45977 11.7703 6.73607 11.7703 4.60977C11.7703 2.48347 10.0466 0.759766 7.92031 0.759766C5.79401 0.759766 4.07031 2.48347 4.07031 4.60977C4.07031 6.73607 5.79401 8.45977 7.92031 8.45977Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M0.990234 19.2399H14.8502V18.405C14.838 17.2312 14.5284 16.0796 13.9504 15.0579C13.3725 14.0363 12.5449 13.1777 11.5454 12.5625C10.5456 11.9472 9.40618 11.5954 8.23373 11.5399C8.12908 11.5351 8.02458 11.5324 7.92023 11.5322C7.81589 11.5324 7.71139 11.5351 7.60689 11.5399C6.43429 11.5954 5.29501 11.9472 4.29526 12.5625C3.29552 13.1777 2.46801 14.0363 1.89003 15.0579C1.31206 16.0796 1.00249 17.2312 0.990234 18.405V19.2399Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.0801 8.45977C16.2064 8.45977 17.9301 6.73607 17.9301 4.60977C17.9301 2.48347 16.2064 0.759766 14.0801 0.759766" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M17.9301 19.2399H21.0101V18.405C20.9979 17.2313 20.6883 16.0796 20.1103 15.0578C19.5323 14.0363 18.7048 13.1776 17.7051 12.5624C17.0589 12.1647 16.3543 11.8771 15.6201 11.7085" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="menu-title lh-0">Quản lý thí sinh mới</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.leads.index', $userPermissions))
                                <a class="menu-link crm_leads_index" href="{{ route('crm.leads.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Sinh viên tiềm năng</span>
                                </a>
                                @endif
                            </div>
                            
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.academic.terms', $userPermissions))
                                <a class="menu-link crm_academic_terms" href="{{ route('crm.academic.terms') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Khóa tuyển sinh</span>
                                </a>
                                @endif
                            </div>
                            {{-- <div class="menu-item menu-accordion">
                                <a class="menu-link" href="{{ route('crm.interaction.history') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Lịch sử tương tác</span>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                @endif
            @else
                <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                <path opacity="0.3" d="M7.92031 8.45977C10.0466 8.45977 11.7703 6.73607 11.7703 4.60977C11.7703 2.48347 10.0466 0.759766 7.92031 0.759766C5.79401 0.759766 4.07031 2.48347 4.07031 4.60977C4.07031 6.73607 5.79401 8.45977 7.92031 8.45977Z" fill="#034EA2" />
                                <path opacity="0.3" d="M0.990234 19.2399H14.8502V18.405C14.838 17.2312 14.5284 16.0796 13.9504 15.0579C13.3725 14.0363 12.5449 13.1777 11.5454 12.5625C10.5456 11.9472 9.40618 11.5954 8.23373 11.5399C8.12908 11.5351 8.02458 11.5324 7.92023 11.5322C7.81589 11.5324 7.71139 11.5351 7.60689 11.5399C6.43429 11.5954 5.29501 11.9472 4.29526 12.5625C3.29552 13.1777 2.46801 14.0363 1.89003 15.0579C1.31206 16.0796 1.00249 17.2312 0.990234 18.405V19.2399Z" fill="#034EA2" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 6.92008C11.4835 6.27658 11.77 5.47672 11.77 4.60977C11.77 3.74281 11.4835 2.94295 11 2.29945C11.7024 1.36445 12.8207 0.759766 14.08 0.759766C16.2063 0.759766 17.93 2.48347 17.93 4.60977C17.93 6.73606 16.2063 8.45977 14.08 8.45977C12.8207 8.45977 11.7024 7.85508 11 6.92008ZM14.85 19.2398H21.01V18.4049C20.9977 17.231 20.6882 16.0795 20.1102 15.0577C19.5322 14.0361 18.7047 13.1775 17.705 12.5623C16.7052 11.9471 15.5659 11.5952 14.3935 11.5398C14.2888 11.5349 14.1843 11.5322 14.08 11.5321C13.9757 11.5322 13.8712 11.5349 13.7667 11.5398C12.8023 11.5855 11.8604 11.8316 11 12.2598C11.1857 12.3522 11.3676 12.4531 11.5451 12.5623C12.5449 13.1775 13.3722 14.0361 13.9502 15.0577C14.5282 16.0795 14.8377 17.231 14.85 18.4049V19.2398Z" fill="white" />
                                <path d="M7.92031 8.45977C10.0466 8.45977 11.7703 6.73607 11.7703 4.60977C11.7703 2.48347 10.0466 0.759766 7.92031 0.759766C5.79401 0.759766 4.07031 2.48347 4.07031 4.60977C4.07031 6.73607 5.79401 8.45977 7.92031 8.45977Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M0.990234 19.2399H14.8502V18.405C14.838 17.2312 14.5284 16.0796 13.9504 15.0579C13.3725 14.0363 12.5449 13.1777 11.5454 12.5625C10.5456 11.9472 9.40618 11.5954 8.23373 11.5399C8.12908 11.5351 8.02458 11.5324 7.92023 11.5322C7.81589 11.5324 7.71139 11.5351 7.60689 11.5399C6.43429 11.5954 5.29501 11.9472 4.29526 12.5625C3.29552 13.1777 2.46801 14.0363 1.89003 15.0579C1.31206 16.0796 1.00249 17.2312 0.990234 18.405V19.2399Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.0801 8.45977C16.2064 8.45977 17.9301 6.73607 17.9301 4.60977C17.9301 2.48347 16.2064 0.759766 14.0801 0.759766" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17.9301 19.2399H21.0101V18.405C20.9979 17.2313 20.6883 16.0796 20.1103 15.0578C19.5323 14.0363 18.7048 13.1776 17.7051 12.5624C17.0589 12.1647 16.3543 11.8771 15.6201 11.7085" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-title lh-0">Quản lý thí sinh mới</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_leads_index" href="{{ route('crm.leads.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Sinh viên tiềm năng</span>
                            </a>
                        </div>

                        <!-- <div class="menu-item menu-accordion">
                            <a class="menu-link crm_affiliate_sources" href="{{ route('crm.affiliate.sources') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Quản lý đơn vị liên kết</span>
                            </a>
                        </div> -->

                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_academic_terms" href="{{ route('crm.academic.terms') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Khóa tuyển sinh</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $studentsPermissions = ['crm.official.student'];
                    $studentsHasPermission = array_intersect($studentsPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.official.student', $userPermissions))
                    <div class="menu-item">
                        <a class="menu-link crm_official_student" href="{{ route('crm.official.student') }}">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path d="M1.73751 20.0001C2.69713 20.0001 3.47503 19.1669 3.47503 18.1392C3.47503 17.1115 2.69713 16.2783 1.73751 16.2783C0.777917 16.2783 0 17.1115 0 18.1392C0 19.1669 0.777917 20.0001 1.73751 20.0001Z" fill="white" />
                                    <path d="M2.97503 18.1392C2.97503 18.9237 2.38922 19.5001 1.73751 19.5001C1.08582 19.5001 0.5 18.9237 0.5 18.1392C0.5 17.3548 1.08583 16.7783 1.73751 16.7783C2.38922 16.7783 2.97503 17.3548 2.97503 18.1392Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M1.73828 16.2784V7.1123" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.8598 9.6167C16.8761 9.97261 16.8854 10.331 16.8854 10.6915C16.8854 11.5909 16.8272 12.4765 16.749 13.3447C16.5844 15.1697 15.2338 16.6445 13.5749 16.827C12.733 16.9196 11.8733 16.9904 10.9998 16.9904C10.1263 16.9904 9.26669 16.9196 8.42478 16.827C6.76588 16.6445 5.41524 15.1697 5.25069 13.3447C5.17243 12.4765 5.11426 11.5909 5.11426 10.6915C5.11426 10.331 5.12361 9.97261 5.13986 9.6167" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.654725 6.90425C-0.218553 6.31299 -0.219069 5.4678 0.658143 4.87823C1.86671 4.06598 3.12014 3.22471 4.56591 2.4492C6.01168 1.67367 7.58003 1.00131 9.09426 0.353025C10.1934 -0.117508 11.769 -0.117231 12.8713 0.351194L12.9523 0.385626C14.4532 1.02344 16.0075 1.68392 17.4341 2.4492C18.8606 3.2144 20.0918 4.04805 21.2808 4.8531L21.3453 4.89678C22.2185 5.48801 22.2191 6.33322 21.3419 6.92277C20.1334 7.73504 18.8799 8.57629 17.4341 9.35183C17.2451 9.45321 17.054 9.55283 16.8612 9.65086C16.8766 9.99561 16.8853 10.3426 16.8853 10.6918C16.8853 11.6195 16.8235 12.5325 16.7414 13.4268C16.5784 15.204 15.234 16.6446 13.5755 16.8271C12.7333 16.9197 11.8735 16.9907 10.9998 16.9907C10.126 16.9907 9.2662 16.9197 8.42406 16.8271C6.76553 16.6446 5.42105 15.204 5.25809 13.4268C5.17608 12.5325 5.1142 11.6195 5.1142 10.6918C5.1142 10.3424 5.12298 9.99515 5.1383 9.65018C4.94555 9.55243 4.75462 9.45305 4.56591 9.35183C3.13912 8.58647 1.90771 7.75267 0.71857 6.94748L0.654725 6.90425Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M0.935048 6.49022L0.935045 6.49022C0.582785 6.25172 0.499861 6.02865 0.5 5.89111C0.500139 5.75385 0.583216 5.53103 0.937051 5.29321C2.14735 4.47981 3.38141 3.65196 4.80226 2.88981L4.80226 2.88981C6.22538 2.12643 7.77324 1.46249 9.29103 0.812674C10.2642 0.396056 11.6982 0.395932 12.6757 0.811363L12.7471 0.841726C14.2549 1.48247 15.7913 2.13536 17.1978 2.88981L17.4341 2.4492L17.1978 2.88981C18.6014 3.64273 19.8143 4.46397 21.0075 5.27189L21.065 5.3108C21.4172 5.54929 21.5001 5.77235 21.5 5.90989C21.4999 6.04717 21.4168 6.26999 21.063 6.50779L21.0629 6.5078C19.8528 7.3212 18.6186 8.14905 17.1978 8.91121C15.7747 9.67458 14.2268 10.3385 12.709 10.9883C11.7358 11.405 10.3019 11.4051 9.32438 10.9897L9.25255 10.9591C7.74485 10.3184 6.20861 9.66558 4.80226 8.91121C3.39836 8.15814 2.18526 7.33674 0.991838 6.52867L0.935048 6.49022Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="menu-title">Quản lý sinh viên chính thức</span>
                        </a>
                    </div>
                @endif
                
            @else
                <div class="menu-item">
                    <a class="menu-link crm_official_student" href="{{ route('crm.official.student') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                <path d="M1.73751 20.0001C2.69713 20.0001 3.47503 19.1669 3.47503 18.1392C3.47503 17.1115 2.69713 16.2783 1.73751 16.2783C0.777917 16.2783 0 17.1115 0 18.1392C0 19.1669 0.777917 20.0001 1.73751 20.0001Z" fill="white" />
                                <path d="M2.97503 18.1392C2.97503 18.9237 2.38922 19.5001 1.73751 19.5001C1.08582 19.5001 0.5 18.9237 0.5 18.1392C0.5 17.3548 1.08583 16.7783 1.73751 16.7783C2.38922 16.7783 2.97503 17.3548 2.97503 18.1392Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.73828 16.2784V7.1123" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.8598 9.6167C16.8761 9.97261 16.8854 10.331 16.8854 10.6915C16.8854 11.5909 16.8272 12.4765 16.749 13.3447C16.5844 15.1697 15.2338 16.6445 13.5749 16.827C12.733 16.9196 11.8733 16.9904 10.9998 16.9904C10.1263 16.9904 9.26669 16.9196 8.42478 16.827C6.76588 16.6445 5.41524 15.1697 5.25069 13.3447C5.17243 12.4765 5.11426 11.5909 5.11426 10.6915C5.11426 10.331 5.12361 9.97261 5.13986 9.6167" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.654725 6.90425C-0.218553 6.31299 -0.219069 5.4678 0.658143 4.87823C1.86671 4.06598 3.12014 3.22471 4.56591 2.4492C6.01168 1.67367 7.58003 1.00131 9.09426 0.353025C10.1934 -0.117508 11.769 -0.117231 12.8713 0.351194L12.9523 0.385626C14.4532 1.02344 16.0075 1.68392 17.4341 2.4492C18.8606 3.2144 20.0918 4.04805 21.2808 4.8531L21.3453 4.89678C22.2185 5.48801 22.2191 6.33322 21.3419 6.92277C20.1334 7.73504 18.8799 8.57629 17.4341 9.35183C17.2451 9.45321 17.054 9.55283 16.8612 9.65086C16.8766 9.99561 16.8853 10.3426 16.8853 10.6918C16.8853 11.6195 16.8235 12.5325 16.7414 13.4268C16.5784 15.204 15.234 16.6446 13.5755 16.8271C12.7333 16.9197 11.8735 16.9907 10.9998 16.9907C10.126 16.9907 9.2662 16.9197 8.42406 16.8271C6.76553 16.6446 5.42105 15.204 5.25809 13.4268C5.17608 12.5325 5.1142 11.6195 5.1142 10.6918C5.1142 10.3424 5.12298 9.99515 5.1383 9.65018C4.94555 9.55243 4.75462 9.45305 4.56591 9.35183C3.13912 8.58647 1.90771 7.75267 0.71857 6.94748L0.654725 6.90425Z" fill="#034EA2" fill-opacity="0.3" />
                                <path d="M0.935048 6.49022L0.935045 6.49022C0.582785 6.25172 0.499861 6.02865 0.5 5.89111C0.500139 5.75385 0.583216 5.53103 0.937051 5.29321C2.14735 4.47981 3.38141 3.65196 4.80226 2.88981L4.80226 2.88981C6.22538 2.12643 7.77324 1.46249 9.29103 0.812674C10.2642 0.396056 11.6982 0.395932 12.6757 0.811363L12.7471 0.841726C14.2549 1.48247 15.7913 2.13536 17.1978 2.88981L17.4341 2.4492L17.1978 2.88981C18.6014 3.64273 19.8143 4.46397 21.0075 5.27189L21.065 5.3108C21.4172 5.54929 21.5001 5.77235 21.5 5.90989C21.4999 6.04717 21.4168 6.26999 21.063 6.50779L21.0629 6.5078C19.8528 7.3212 18.6186 8.14905 17.1978 8.91121C15.7747 9.67458 14.2268 10.3385 12.709 10.9883C11.7358 11.405 10.3019 11.4051 9.32438 10.9897L9.25255 10.9591C7.74485 10.3184 6.20861 9.66558 4.80226 8.91121C3.39836 8.15814 2.18526 7.33674 0.991838 6.52867L0.935048 6.49022Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-title">Quản lý sinh viên chính thức</span>
                    </a>
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $suportsPermissions = ['crm.affiliate.sources'];
                    $suportsHasPermission = array_intersect($suportsPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.affiliate.sources', $userPermissions))
                    <div class="menu-item">
                        <a class="menu-link " href="{{ route('crm.affiliate.sources') }}">
                            <span class="menu-icon">
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                    <path d="M1.73751 20.0001C2.69713 20.0001 3.47503 19.1669 3.47503 18.1392C3.47503 17.1115 2.69713 16.2783 1.73751 16.2783C0.777917 16.2783 0 17.1115 0 18.1392C0 19.1669 0.777917 20.0001 1.73751 20.0001Z" fill="white" />
                                    <path d="M2.97503 18.1392C2.97503 18.9237 2.38922 19.5001 1.73751 19.5001C1.08582 19.5001 0.5 18.9237 0.5 18.1392C0.5 17.3548 1.08583 16.7783 1.73751 16.7783C2.38922 16.7783 2.97503 17.3548 2.97503 18.1392Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M1.73828 16.2784V7.1123" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.8598 9.6167C16.8761 9.97261 16.8854 10.331 16.8854 10.6915C16.8854 11.5909 16.8272 12.4765 16.749 13.3447C16.5844 15.1697 15.2338 16.6445 13.5749 16.827C12.733 16.9196 11.8733 16.9904 10.9998 16.9904C10.1263 16.9904 9.26669 16.9196 8.42478 16.827C6.76588 16.6445 5.41524 15.1697 5.25069 13.3447C5.17243 12.4765 5.11426 11.5909 5.11426 10.6915C5.11426 10.331 5.12361 9.97261 5.13986 9.6167" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0.654725 6.90425C-0.218553 6.31299 -0.219069 5.4678 0.658143 4.87823C1.86671 4.06598 3.12014 3.22471 4.56591 2.4492C6.01168 1.67367 7.58003 1.00131 9.09426 0.353025C10.1934 -0.117508 11.769 -0.117231 12.8713 0.351194L12.9523 0.385626C14.4532 1.02344 16.0075 1.68392 17.4341 2.4492C18.8606 3.2144 20.0918 4.04805 21.2808 4.8531L21.3453 4.89678C22.2185 5.48801 22.2191 6.33322 21.3419 6.92277C20.1334 7.73504 18.8799 8.57629 17.4341 9.35183C17.2451 9.45321 17.054 9.55283 16.8612 9.65086C16.8766 9.99561 16.8853 10.3426 16.8853 10.6918C16.8853 11.6195 16.8235 12.5325 16.7414 13.4268C16.5784 15.204 15.234 16.6446 13.5755 16.8271C12.7333 16.9197 11.8735 16.9907 10.9998 16.9907C10.126 16.9907 9.2662 16.9197 8.42406 16.8271C6.76553 16.6446 5.42105 15.204 5.25809 13.4268C5.17608 12.5325 5.1142 11.6195 5.1142 10.6918C5.1142 10.3424 5.12298 9.99515 5.1383 9.65018C4.94555 9.55243 4.75462 9.45305 4.56591 9.35183C3.13912 8.58647 1.90771 7.75267 0.71857 6.94748L0.654725 6.90425Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M0.935048 6.49022L0.935045 6.49022C0.582785 6.25172 0.499861 6.02865 0.5 5.89111C0.500139 5.75385 0.583216 5.53103 0.937051 5.29321C2.14735 4.47981 3.38141 3.65196 4.80226 2.88981L4.80226 2.88981C6.22538 2.12643 7.77324 1.46249 9.29103 0.812674C10.2642 0.396056 11.6982 0.395932 12.6757 0.811363L12.7471 0.841726C14.2549 1.48247 15.7913 2.13536 17.1978 2.88981L17.4341 2.4492L17.1978 2.88981C18.6014 3.64273 19.8143 4.46397 21.0075 5.27189L21.065 5.3108C21.4172 5.54929 21.5001 5.77235 21.5 5.90989C21.4999 6.04717 21.4168 6.26999 21.063 6.50779L21.0629 6.5078C19.8528 7.3212 18.6186 8.14905 17.1978 8.91121C15.7747 9.67458 14.2268 10.3385 12.709 10.9883C11.7358 11.405 10.3019 11.4051 9.32438 10.9897L9.25255 10.9591C7.74485 10.3184 6.20861 9.66558 4.80226 8.91121C3.39836 8.15814 2.18526 7.33674 0.991838 6.52867L0.935048 6.49022Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg> -->
                                <img src="/assets/crm/media/svg/crm/chart-increase.svg" width="22" height="22" class="pr-4">
                            </span>
                            <span class="menu-title pl-4">Quản lý đơn vị liên kết</span>
                        </a>
                    </div> 
                @endif
            @else   
                <div class="menu-item">
                    <a class="menu-link " href="{{ route('crm.affiliate.sources') }}">
                        <span class="menu-icon">
                            <!-- <svg xmlns="http://www.w3.org/2000/svg" width="22" height="20" viewBox="0 0 22 20" fill="none">
                                <path d="M1.73751 20.0001C2.69713 20.0001 3.47503 19.1669 3.47503 18.1392C3.47503 17.1115 2.69713 16.2783 1.73751 16.2783C0.777917 16.2783 0 17.1115 0 18.1392C0 19.1669 0.777917 20.0001 1.73751 20.0001Z" fill="white" />
                                <path d="M2.97503 18.1392C2.97503 18.9237 2.38922 19.5001 1.73751 19.5001C1.08582 19.5001 0.5 18.9237 0.5 18.1392C0.5 17.3548 1.08583 16.7783 1.73751 16.7783C2.38922 16.7783 2.97503 17.3548 2.97503 18.1392Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M1.73828 16.2784V7.1123" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16.8598 9.6167C16.8761 9.97261 16.8854 10.331 16.8854 10.6915C16.8854 11.5909 16.8272 12.4765 16.749 13.3447C16.5844 15.1697 15.2338 16.6445 13.5749 16.827C12.733 16.9196 11.8733 16.9904 10.9998 16.9904C10.1263 16.9904 9.26669 16.9196 8.42478 16.827C6.76588 16.6445 5.41524 15.1697 5.25069 13.3447C5.17243 12.4765 5.11426 11.5909 5.11426 10.6915C5.11426 10.331 5.12361 9.97261 5.13986 9.6167" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.654725 6.90425C-0.218553 6.31299 -0.219069 5.4678 0.658143 4.87823C1.86671 4.06598 3.12014 3.22471 4.56591 2.4492C6.01168 1.67367 7.58003 1.00131 9.09426 0.353025C10.1934 -0.117508 11.769 -0.117231 12.8713 0.351194L12.9523 0.385626C14.4532 1.02344 16.0075 1.68392 17.4341 2.4492C18.8606 3.2144 20.0918 4.04805 21.2808 4.8531L21.3453 4.89678C22.2185 5.48801 22.2191 6.33322 21.3419 6.92277C20.1334 7.73504 18.8799 8.57629 17.4341 9.35183C17.2451 9.45321 17.054 9.55283 16.8612 9.65086C16.8766 9.99561 16.8853 10.3426 16.8853 10.6918C16.8853 11.6195 16.8235 12.5325 16.7414 13.4268C16.5784 15.204 15.234 16.6446 13.5755 16.8271C12.7333 16.9197 11.8735 16.9907 10.9998 16.9907C10.126 16.9907 9.2662 16.9197 8.42406 16.8271C6.76553 16.6446 5.42105 15.204 5.25809 13.4268C5.17608 12.5325 5.1142 11.6195 5.1142 10.6918C5.1142 10.3424 5.12298 9.99515 5.1383 9.65018C4.94555 9.55243 4.75462 9.45305 4.56591 9.35183C3.13912 8.58647 1.90771 7.75267 0.71857 6.94748L0.654725 6.90425Z" fill="#034EA2" fill-opacity="0.3" />
                                <path d="M0.935048 6.49022L0.935045 6.49022C0.582785 6.25172 0.499861 6.02865 0.5 5.89111C0.500139 5.75385 0.583216 5.53103 0.937051 5.29321C2.14735 4.47981 3.38141 3.65196 4.80226 2.88981L4.80226 2.88981C6.22538 2.12643 7.77324 1.46249 9.29103 0.812674C10.2642 0.396056 11.6982 0.395932 12.6757 0.811363L12.7471 0.841726C14.2549 1.48247 15.7913 2.13536 17.1978 2.88981L17.4341 2.4492L17.1978 2.88981C18.6014 3.64273 19.8143 4.46397 21.0075 5.27189L21.065 5.3108C21.4172 5.54929 21.5001 5.77235 21.5 5.90989C21.4999 6.04717 21.4168 6.26999 21.063 6.50779L21.0629 6.5078C19.8528 7.3212 18.6186 8.14905 17.1978 8.91121C15.7747 9.67458 14.2268 10.3385 12.709 10.9883C11.7358 11.405 10.3019 11.4051 9.32438 10.9897L9.25255 10.9591C7.74485 10.3184 6.20861 9.66558 4.80226 8.91121C3.39836 8.15814 2.18526 7.33674 0.991838 6.52867L0.935048 6.49022Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg> -->
                            <img src="/assets/crm/media/svg/crm/chart-increase.svg" width="22" height="22" class="pr-4">
                        </span>
                        <span class="menu-title pl-4">Quản lý đơn vị liên kết</span>
                    </a>
                </div>  
            @endif


            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $suportsPermissions = ['crm.request.support'];
                    $suportsHasPermission = array_intersect($suportsPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.request.support', $userPermissions))
                    <div class="menu-item">
                        <a href="{{ route('crm.request.support') }}" class="menu-link crm_request_support">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <g clip-path="url(#clip0_3245_5004)">
                                        <path d="M20.0916 13.3725C20.2717 13.2788 20.4265 13.1432 20.5431 12.9771C21.3532 11.8222 18.0546 9.02155 17.8201 7.33833C17.1861 2.78578 13.6115 1.17871 9.63231 1.17871C4.26963 1.17871 1.17871 3.92871 1.17871 9.42871C1.17871 13.1902 2.16107 14.4507 3.34901 16.3729C4.00027 17.4267 4.27642 18.658 4.27328 19.8968C4.27135 20.6583 4.26963 21.4769 4.26963 21.9891H13.7273V19.2497C13.8137 18.5498 14.4381 18.079 15.1433 18.079H15.9186C17.2203 18.079 18.2757 17.0236 18.2757 15.7218V13.5462L19.5088 13.5152C19.7117 13.5151 19.9117 13.4662 20.0916 13.3725Z" fill="#034EA2" fill-opacity="0.3" />
                                        <path d="M10.2178 7.86343V1.17871" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11 14.0879C12.5714 15.6593 15.7143 17.286 19.6429 17.286" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M4.26963 21.2008C4.26963 20.8222 4.27056 20.3579 4.27183 19.9019C4.27529 18.6596 3.99939 17.4248 3.34625 16.3682C2.15955 14.4485 1.17871 13.1871 1.17871 9.42854C1.17871 5.93755 2.42397 3.55446 4.70504 2.2793" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M18.2752 14.497V13.5464L19.5083 13.5154C19.7112 13.5153 19.9112 13.4664 20.0912 13.3727C20.2713 13.2791 20.426 13.1434 20.5426 12.9773C21.3527 11.8224 18.0541 9.02177 17.8197 7.33853C17.4507 4.68904 16.0856 3.03718 14.2246 2.11914" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M13.7275 19.25V21.2011" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M10.2181 14.1431C12.2295 14.1431 13.3609 13.0117 13.3609 11.0003C13.3609 8.98885 12.2295 7.85742 10.2181 7.85742C8.20662 7.85742 7.0752 8.98885 7.0752 11.0003C7.0752 13.0117 8.20662 14.1431 10.2181 14.1431Z" fill="white" />
                                        <path d="M10.2171 14.1431C12.2285 14.1431 13.3599 13.0117 13.3599 11.0003C13.3599 8.98885 12.2285 7.85742 10.2171 7.85742C8.20565 7.85742 7.07422 8.98885 7.07422 11.0003C7.07422 13.0117 8.20565 14.1431 10.2171 14.1431Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3245_5004">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            <span class="menu-title">
                                Yêu cầu hỗ trợ &nbsp;
                                {{-- <span class="text-danger">(3)</span> --}}
                            </span>
                        </a>
                    </div>
                @endif
            @else
                <div class="menu-item">
                    <a href="{{ route('crm.request.support') }}" class="menu-link crm_request_support">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g clip-path="url(#clip0_3245_5004)">
                                    <path d="M20.0916 13.3725C20.2717 13.2788 20.4265 13.1432 20.5431 12.9771C21.3532 11.8222 18.0546 9.02155 17.8201 7.33833C17.1861 2.78578 13.6115 1.17871 9.63231 1.17871C4.26963 1.17871 1.17871 3.92871 1.17871 9.42871C1.17871 13.1902 2.16107 14.4507 3.34901 16.3729C4.00027 17.4267 4.27642 18.658 4.27328 19.8968C4.27135 20.6583 4.26963 21.4769 4.26963 21.9891H13.7273V19.2497C13.8137 18.5498 14.4381 18.079 15.1433 18.079H15.9186C17.2203 18.079 18.2757 17.0236 18.2757 15.7218V13.5462L19.5088 13.5152C19.7117 13.5151 19.9117 13.4662 20.0916 13.3725Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M10.2178 7.86343V1.17871" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11 14.0879C12.5714 15.6593 15.7143 17.286 19.6429 17.286" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.26963 21.2008C4.26963 20.8222 4.27056 20.3579 4.27183 19.9019C4.27529 18.6596 3.99939 17.4248 3.34625 16.3682C2.15955 14.4485 1.17871 13.1871 1.17871 9.42854C1.17871 5.93755 2.42397 3.55446 4.70504 2.2793" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M18.2752 14.497V13.5464L19.5083 13.5154C19.7112 13.5153 19.9112 13.4664 20.0912 13.3727C20.2713 13.2791 20.426 13.1434 20.5426 12.9773C21.3527 11.8224 18.0541 9.02177 17.8197 7.33853C17.4507 4.68904 16.0856 3.03718 14.2246 2.11914" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M13.7275 19.25V21.2011" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M10.2181 14.1431C12.2295 14.1431 13.3609 13.0117 13.3609 11.0003C13.3609 8.98885 12.2295 7.85742 10.2181 7.85742C8.20662 7.85742 7.0752 8.98885 7.0752 11.0003C7.0752 13.0117 8.20662 14.1431 10.2181 14.1431Z" fill="white" />
                                    <path d="M10.2171 14.1431C12.2285 14.1431 13.3599 13.0117 13.3599 11.0003C13.3599 8.98885 12.2285 7.85742 10.2171 7.85742C8.20565 7.85742 7.07422 8.98885 7.07422 11.0003C7.07422 13.0117 8.20565 14.1431 10.2171 14.1431Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_3245_5004">
                                        <rect width="22" height="22" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <span class="menu-title">
                            Yêu cầu hỗ trợ &nbsp;
                            {{-- <span class="text-danger">(3)</span> --}}
                        </span>
                    </a>
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $notificationsPermissions = [
                        'crm.notification.list', 'crm.notification.create', 'crm.notification.pricelist', 'crm.notification.groups'];
                    $notificationsHasPermission = array_intersect($notificationsPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.notification.list', $userPermissions) ||
                    in_array('crm.notification.create', $userPermissions) ||
                    in_array('crm.notification.pricelist', $userPermissions) ||
                    in_array('crm.notification.groups', $userPermissions) )
                    <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M1.31942 12.1947C1.12449 13.435 1.99599 14.2958 3.06304 14.7249C7.1539 16.3697 12.8468 16.3697 16.9376 14.7249C18.0047 14.2958 18.8762 13.435 18.6812 12.1947C18.5614 11.4325 17.9691 10.7978 17.5302 10.178C16.9553 9.35623 16.8982 8.4599 16.8981 7.50629C16.8981 3.82101 13.8099 0.833496 10.0003 0.833496C6.19078 0.833496 3.10252 3.82101 3.10252 7.50629C3.10244 8.4599 3.04532 9.35623 2.47047 10.178C2.03159 10.7978 1.43922 11.4325 1.31942 12.1947Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M1.31942 12.1947C1.12449 13.435 1.99599 14.2958 3.06304 14.7249C7.1539 16.3697 12.8468 16.3697 16.9376 14.7249C18.0047 14.2958 18.8762 13.435 18.6812 12.1947C18.5614 11.4325 17.9691 10.7978 17.5302 10.178C16.9553 9.35623 16.8982 8.4599 16.8981 7.50629C16.8981 3.82101 13.8099 0.833496 10.0003 0.833496C6.19078 0.833496 3.10252 3.82101 3.10252 7.50629C3.10244 8.4599 3.04532 9.35623 2.47047 10.178C2.03159 10.7978 1.43922 11.4325 1.31942 12.1947Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.25 18.25C7.97979 18.82 8.94351 19.1667 10 19.1667C11.0565 19.1667 12.0202 18.82 12.75 18.25" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="menu-title lh-0">Quản lý thông báo</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.notification.list', $userPermissions))
                                <a class="menu-link crm_notification_list" href="{{auth()->user()->id != 1 ? route('crm.notification.listToMe') : route('crm.notification.list')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Thông báo</span>
                                </a>
                                @endif
                            </div>
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.notification.create', $userPermissions))
                                <a href="{{ route('crm.notification.create') }}" class="menu-link crm_notification_create">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Tạo thông báo</span>
                                </a>
                                @endif
                            </div>
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.notification.pricelist', $userPermissions))
                                <a class="menu-link crm_notification_pricelist" href="{{ route('crm.notification.pricelist') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Thông báo học phí</span>
                                </a>
                                @endif
                            </div>
                            <div class="menu-item menu-accordion">
                                @if(in_array('crm.notification.groups', $userPermissions))
                                <a class="menu-link crm_notification_groups" href="{{route('crm.notification.groups')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Quản lý Nhóm</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                    <span class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M1.31942 12.1947C1.12449 13.435 1.99599 14.2958 3.06304 14.7249C7.1539 16.3697 12.8468 16.3697 16.9376 14.7249C18.0047 14.2958 18.8762 13.435 18.6812 12.1947C18.5614 11.4325 17.9691 10.7978 17.5302 10.178C16.9553 9.35623 16.8982 8.4599 16.8981 7.50629C16.8981 3.82101 13.8099 0.833496 10.0003 0.833496C6.19078 0.833496 3.10252 3.82101 3.10252 7.50629C3.10244 8.4599 3.04532 9.35623 2.47047 10.178C2.03159 10.7978 1.43922 11.4325 1.31942 12.1947Z" fill="#034EA2" fill-opacity="0.3" />
                                <path d="M1.31942 12.1947C1.12449 13.435 1.99599 14.2958 3.06304 14.7249C7.1539 16.3697 12.8468 16.3697 16.9376 14.7249C18.0047 14.2958 18.8762 13.435 18.6812 12.1947C18.5614 11.4325 17.9691 10.7978 17.5302 10.178C16.9553 9.35623 16.8982 8.4599 16.8981 7.50629C16.8981 3.82101 13.8099 0.833496 10.0003 0.833496C6.19078 0.833496 3.10252 3.82101 3.10252 7.50629C3.10244 8.4599 3.04532 9.35623 2.47047 10.178C2.03159 10.7978 1.43922 11.4325 1.31942 12.1947Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M7.25 18.25C7.97979 18.82 8.94351 19.1667 10 19.1667C11.0565 19.1667 12.0202 18.82 12.75 18.25" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-title lh-0">Quản lý thông báo</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_notification_list" href="{{route('crm.notification.list')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Thông báo</span>
                            </a>
                        </div>
                        <div class="menu-item menu-accordion">
                            <a href="{{ route('crm.notification.create') }}" class="menu-link crm_notification_create">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Tạo thông báo</span>
                            </a>
                        </div>
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_notification_pricelist" href="{{ route('crm.notification.pricelist') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Thông báo học phí</span>
                            </a>
                        </div>
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_notification_groups" href="{{route('crm.notification.groups')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Quản lý Nhóm</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif


            <h5 class="pe-4 mt-3">Tài khoản</h5>

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $employeesPermissions = ['crm.employees.list'];
                    $employeesHasPermission = array_intersect($employeesPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.employees.list', $userPermissions))
                    <div class="menu-item">
                        <a href="{{ route('crm.employees.list') }}" class="menu-link crm_employees_list">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <g clip-path="url(#clip0_3245_7905)">
                                        <path d="M11.0008 12.5715C13.1705 12.5715 14.9294 10.8126 14.9294 8.64293C14.9294 6.47324 13.1705 4.71436 11.0008 4.71436C8.83115 4.71436 7.07227 6.47324 7.07227 8.64293C7.07227 10.8126 8.83115 12.5715 11.0008 12.5715Z" fill="white" />
                                        <path d="M17.7125 18.6995C15.9175 20.2658 13.5697 21.2144 11.0003 21.2144C8.43094 21.2144 6.08313 20.2658 4.28809 18.6995C5.66764 16.4382 8.15768 14.9287 11.0003 14.9287C13.843 14.9287 16.333 16.4382 17.7125 18.6995Z" fill="white" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.28817 18.6993C5.66773 16.438 8.15778 14.9285 11.0004 14.9285C13.8431 14.9285 16.3331 16.438 17.7126 18.6993C19.8587 16.8268 21.2147 14.0717 21.2147 10.9999C21.2147 5.35874 16.6417 0.785645 11.0004 0.785645C5.35923 0.785645 0.786133 5.35874 0.786133 10.9999C0.786133 14.0717 2.14212 16.8268 4.28817 18.6993ZM11.0004 12.5714C13.1701 12.5714 14.929 10.8125 14.929 8.64279C14.929 6.4731 13.1701 4.71422 11.0004 4.71422C8.83073 4.71422 7.07185 6.4731 7.07185 8.64279C7.07185 10.8125 8.83073 12.5714 11.0004 12.5714Z" fill="#034EA2" fill-opacity="0.3" />
                                        <path d="M11.0008 12.5715C13.1705 12.5715 14.9294 10.8126 14.9294 8.64293C14.9294 6.47324 13.1705 4.71436 11.0008 4.71436C8.83115 4.71436 7.07227 6.47324 7.07227 8.64293C7.07227 10.8126 8.83115 12.5715 11.0008 12.5715Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M4.29004 18.7C4.99127 17.5489 5.97683 16.5975 7.15194 15.9375C8.32705 15.2774 9.65221 14.9307 11 14.9307C12.3479 14.9307 13.673 15.2774 14.8481 15.9375C16.0233 16.5975 17.0087 17.5489 17.7101 18.7" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M11.0004 21.2142C16.6417 21.2142 21.2147 16.6412 21.2147 10.9999C21.2147 5.35874 16.6417 0.785645 11.0004 0.785645C5.35923 0.785645 0.786133 5.35874 0.786133 10.9999C0.786133 16.6412 5.35923 21.2142 11.0004 21.2142Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3245_7905">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            <span class="menu-title">Quản lý nhân sự</span>
                        </a>
                    </div>
                @endif
            @else
                <div class="menu-item">
                    <a href="{{ route('crm.employees.list') }}" class="menu-link crm_employees_list">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g clip-path="url(#clip0_3245_7905)">
                                    <path d="M11.0008 12.5715C13.1705 12.5715 14.9294 10.8126 14.9294 8.64293C14.9294 6.47324 13.1705 4.71436 11.0008 4.71436C8.83115 4.71436 7.07227 6.47324 7.07227 8.64293C7.07227 10.8126 8.83115 12.5715 11.0008 12.5715Z" fill="white" />
                                    <path d="M17.7125 18.6995C15.9175 20.2658 13.5697 21.2144 11.0003 21.2144C8.43094 21.2144 6.08313 20.2658 4.28809 18.6995C5.66764 16.4382 8.15768 14.9287 11.0003 14.9287C13.843 14.9287 16.333 16.4382 17.7125 18.6995Z" fill="white" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.28817 18.6993C5.66773 16.438 8.15778 14.9285 11.0004 14.9285C13.8431 14.9285 16.3331 16.438 17.7126 18.6993C19.8587 16.8268 21.2147 14.0717 21.2147 10.9999C21.2147 5.35874 16.6417 0.785645 11.0004 0.785645C5.35923 0.785645 0.786133 5.35874 0.786133 10.9999C0.786133 14.0717 2.14212 16.8268 4.28817 18.6993ZM11.0004 12.5714C13.1701 12.5714 14.929 10.8125 14.929 8.64279C14.929 6.4731 13.1701 4.71422 11.0004 4.71422C8.83073 4.71422 7.07185 6.4731 7.07185 8.64279C7.07185 10.8125 8.83073 12.5714 11.0004 12.5714Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M11.0008 12.5715C13.1705 12.5715 14.9294 10.8126 14.9294 8.64293C14.9294 6.47324 13.1705 4.71436 11.0008 4.71436C8.83115 4.71436 7.07227 6.47324 7.07227 8.64293C7.07227 10.8126 8.83115 12.5715 11.0008 12.5715Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M4.29004 18.7C4.99127 17.5489 5.97683 16.5975 7.15194 15.9375C8.32705 15.2774 9.65221 14.9307 11 14.9307C12.3479 14.9307 13.673 15.2774 14.8481 15.9375C16.0233 16.5975 17.0087 17.5489 17.7101 18.7" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.0004 21.2142C16.6417 21.2142 21.2147 16.6412 21.2147 10.9999C21.2147 5.35874 16.6417 0.785645 11.0004 0.785645C5.35923 0.785645 0.786133 5.35874 0.786133 10.9999C0.786133 16.6412 5.35923 21.2142 11.0004 21.2142Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_3245_7905">
                                        <rect width="22" height="22" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <span class="menu-title">Quản lý nhân sự</span>
                    </a>
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $kpisPermissions = ['crm.task.list', 'crm.task.target'];
                    $kpiHasPermission = array_intersect($kpisPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.task.list', $userPermissions) || in_array('crm.task.target', $userPermissions))
                    <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                        <a href="#" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <path d="M1.73022 12.2441L1.93851 9.93848H20.0613L20.2696 12.2441C20.643 16.3771 20.8296 18.4436 19.6319 19.7634C18.4342 21.0832 16.3722 21.0832 12.2481 21.0832H9.7517C5.62762 21.0832 3.56557 21.0832 2.36786 19.7634C1.17015 18.4436 1.35684 16.3771 1.73022 12.2441Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M17.9763 4.63135H4.02432C3.27013 4.63135 2.89303 4.63135 2.59264 4.70393C1.73545 4.91107 1.09224 5.5321 0.941645 6.29799C0.888874 6.56638 0.926396 6.89424 1.00144 7.54996C1.16922 9.01598 1.94044 9.8628 3.51618 10.3487L7.94344 11.7141L7.94345 11.7141C8.38223 11.8494 8.75741 11.9651 9.08815 12.0612L12.9125 12.0612C13.2432 11.9651 13.6184 11.8494 14.0572 11.7141L18.4845 10.3487C20.0602 9.8628 20.8314 9.01598 20.9992 7.54996L20.9992 7.54985C21.0743 6.8942 21.1118 6.56636 21.059 6.29799C20.9084 5.5321 20.2652 4.91107 19.408 4.70393C19.1076 4.63135 18.7305 4.63135 17.9763 4.63135Z" fill="white" />
                                    <path d="M8.87793 11.3537C8.87793 11.0247 8.87793 10.8601 8.9141 10.7252C9.01224 10.3589 9.29834 10.0728 9.66462 9.97464C9.7996 9.93848 9.96411 9.93848 10.2931 9.93848H11.7083C12.0374 9.93848 12.2019 9.93848 12.3369 9.97464C12.7031 10.0728 12.9892 10.3589 13.0874 10.7252C13.1235 10.8601 13.1235 11.0247 13.1235 11.3537V12.0613C13.1235 13.2337 12.1731 14.1841 11.0007 14.1841C9.82834 14.1841 8.87793 13.2337 8.87793 12.0613V11.3537Z" fill="white" />
                                    <path d="M8.87793 11.3537C8.87793 11.0247 8.87793 10.8601 8.9141 10.7252C9.01224 10.3589 9.29834 10.0728 9.66462 9.97464C9.7996 9.93848 9.96411 9.93848 10.2931 9.93848H11.7083C12.0374 9.93848 12.2019 9.93848 12.3369 9.97464C12.7031 10.0728 12.9892 10.3589 13.0874 10.7252C13.1235 10.8601 13.1235 11.0247 13.1235 11.3537V12.0613C13.1235 13.2337 12.1731 14.1841 11.0007 14.1841C9.82834 14.1841 8.87793 13.2337 8.87793 12.0613V11.3537Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M11.1087 0.916504H10.8914C9.59917 0.916504 8.95303 0.916504 8.46659 1.3172C7.98014 1.7179 7.77582 2.41844 7.36717 3.81954C7.32616 3.96013 7.4316 4.10071 7.57805 4.10071H14.4221C14.5685 4.10071 14.674 3.96013 14.633 3.81954C14.2243 2.41844 14.02 1.7179 13.5335 1.3172C13.0471 0.916504 12.401 0.916504 11.1087 0.916504Z" fill="white" />
                                    <path d="M12.9125 12.0612C13.2432 11.9651 13.6184 11.8494 14.0572 11.7141L18.4845 10.3487C20.0602 9.8628 20.8314 9.01598 20.9992 7.54996C21.0743 6.89424 21.1118 6.56638 21.059 6.29799C20.9084 5.5321 20.2652 4.91107 19.408 4.70393C19.1076 4.63135 18.7305 4.63135 17.9763 4.63135H4.02432C3.27013 4.63135 2.89303 4.63135 2.59264 4.70393C1.73545 4.91107 1.09224 5.5321 0.941645 6.29799C0.888874 6.56638 0.926396 6.89424 1.00144 7.54996C1.16922 9.01598 1.94044 9.8628 3.51618 10.3487L7.94344 11.7141C8.38222 11.8494 8.75741 11.9651 9.08815 12.0612" stroke="#034EA2" />
                                    <path d="M1.93851 9.93848L1.73022 12.2441C1.35684 16.3771 1.17015 18.4436 2.36786 19.7634C3.56557 21.0832 5.62762 21.0832 9.7517 21.0832H12.2481C16.3722 21.0832 18.4342 21.0832 19.6319 19.7634C20.8296 18.4436 20.643 16.3771 20.2696 12.2441L20.0613 9.93848" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.715 4.10071L14.633 3.81954C14.2243 2.41844 14.02 1.7179 13.5335 1.3172C13.0471 0.916504 12.401 0.916504 11.1087 0.916504H10.8914C9.59917 0.916504 8.95303 0.916504 8.46659 1.3172C7.98014 1.7179 7.77582 2.41844 7.36717 3.81954L7.28516 4.10071" stroke="#034EA2" />
                                </svg>
                            </span>
                            <span class="menu-title">Quản lý KPI và giao việc</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item menu-accordion">
                                @if (in_array('crm.task.list', $userPermissions))
                                <a class="menu-link crm_task_list" href="{{ route('crm.task.list') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Danh sách công việc</span>
                                </a>
                                @endif
                            </div>
                            <div class="menu-item menu-accordion">
                                @if (in_array('crm.task.target', $userPermissions))
                                <a class="menu-link crm_task_target" href="{{ route('crm.task.target') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Chỉ tiêu tuyển sinh</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <path d="M1.73022 12.2441L1.93851 9.93848H20.0613L20.2696 12.2441C20.643 16.3771 20.8296 18.4436 19.6319 19.7634C18.4342 21.0832 16.3722 21.0832 12.2481 21.0832H9.7517C5.62762 21.0832 3.56557 21.0832 2.36786 19.7634C1.17015 18.4436 1.35684 16.3771 1.73022 12.2441Z" fill="#034EA2" fill-opacity="0.3" />
                                <path d="M17.9763 4.63135H4.02432C3.27013 4.63135 2.89303 4.63135 2.59264 4.70393C1.73545 4.91107 1.09224 5.5321 0.941645 6.29799C0.888874 6.56638 0.926396 6.89424 1.00144 7.54996C1.16922 9.01598 1.94044 9.8628 3.51618 10.3487L7.94344 11.7141L7.94345 11.7141C8.38223 11.8494 8.75741 11.9651 9.08815 12.0612L12.9125 12.0612C13.2432 11.9651 13.6184 11.8494 14.0572 11.7141L18.4845 10.3487C20.0602 9.8628 20.8314 9.01598 20.9992 7.54996L20.9992 7.54985C21.0743 6.8942 21.1118 6.56636 21.059 6.29799C20.9084 5.5321 20.2652 4.91107 19.408 4.70393C19.1076 4.63135 18.7305 4.63135 17.9763 4.63135Z" fill="white" />
                                <path d="M8.87793 11.3537C8.87793 11.0247 8.87793 10.8601 8.9141 10.7252C9.01224 10.3589 9.29834 10.0728 9.66462 9.97464C9.7996 9.93848 9.96411 9.93848 10.2931 9.93848H11.7083C12.0374 9.93848 12.2019 9.93848 12.3369 9.97464C12.7031 10.0728 12.9892 10.3589 13.0874 10.7252C13.1235 10.8601 13.1235 11.0247 13.1235 11.3537V12.0613C13.1235 13.2337 12.1731 14.1841 11.0007 14.1841C9.82834 14.1841 8.87793 13.2337 8.87793 12.0613V11.3537Z" fill="white" />
                                <path d="M8.87793 11.3537C8.87793 11.0247 8.87793 10.8601 8.9141 10.7252C9.01224 10.3589 9.29834 10.0728 9.66462 9.97464C9.7996 9.93848 9.96411 9.93848 10.2931 9.93848H11.7083C12.0374 9.93848 12.2019 9.93848 12.3369 9.97464C12.7031 10.0728 12.9892 10.3589 13.0874 10.7252C13.1235 10.8601 13.1235 11.0247 13.1235 11.3537V12.0613C13.1235 13.2337 12.1731 14.1841 11.0007 14.1841C9.82834 14.1841 8.87793 13.2337 8.87793 12.0613V11.3537Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M11.1087 0.916504H10.8914C9.59917 0.916504 8.95303 0.916504 8.46659 1.3172C7.98014 1.7179 7.77582 2.41844 7.36717 3.81954C7.32616 3.96013 7.4316 4.10071 7.57805 4.10071H14.4221C14.5685 4.10071 14.674 3.96013 14.633 3.81954C14.2243 2.41844 14.02 1.7179 13.5335 1.3172C13.0471 0.916504 12.401 0.916504 11.1087 0.916504Z" fill="white" />
                                <path d="M12.9125 12.0612C13.2432 11.9651 13.6184 11.8494 14.0572 11.7141L18.4845 10.3487C20.0602 9.8628 20.8314 9.01598 20.9992 7.54996C21.0743 6.89424 21.1118 6.56638 21.059 6.29799C20.9084 5.5321 20.2652 4.91107 19.408 4.70393C19.1076 4.63135 18.7305 4.63135 17.9763 4.63135H4.02432C3.27013 4.63135 2.89303 4.63135 2.59264 4.70393C1.73545 4.91107 1.09224 5.5321 0.941645 6.29799C0.888874 6.56638 0.926396 6.89424 1.00144 7.54996C1.16922 9.01598 1.94044 9.8628 3.51618 10.3487L7.94344 11.7141C8.38222 11.8494 8.75741 11.9651 9.08815 12.0612" stroke="#034EA2" />
                                <path d="M1.93851 9.93848L1.73022 12.2441C1.35684 16.3771 1.17015 18.4436 2.36786 19.7634C3.56557 21.0832 5.62762 21.0832 9.7517 21.0832H12.2481C16.3722 21.0832 18.4342 21.0832 19.6319 19.7634C20.8296 18.4436 20.643 16.3771 20.2696 12.2441L20.0613 9.93848" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M14.715 4.10071L14.633 3.81954C14.2243 2.41844 14.02 1.7179 13.5335 1.3172C13.0471 0.916504 12.401 0.916504 11.1087 0.916504H10.8914C9.59917 0.916504 8.95303 0.916504 8.46659 1.3172C7.98014 1.7179 7.77582 2.41844 7.36717 3.81954L7.28516 4.10071" stroke="#034EA2" />
                            </svg>
                        </span>
                        <span class="menu-title">Quản lý KPI và giao việc</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_task_list" href="{{ route('crm.task.list') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Danh sách công việc</span>
                            </a>
                        </div>
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_task_target" href="{{ route('crm.task.target') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Chỉ tiêu tuyển sinh</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $rolesPermissions = ['crm.role.roleList'];
                    $rolesHasPermission = array_intersect($rolesPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.role.roleList', $userPermissions))
                    <div class="menu-item">
                        <a class="menu-link crm_role_roleList" href="{{ route('crm.role.roleList') }}">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                    <g clip-path="url(#clip0_3245_2864)">
                                        <path d="M1.30159 10.4736C1.42144 11.1973 1.78007 11.86 2.32033 12.3561C2.86059 12.8522 3.55138 13.1532 4.28259 13.2111C6.26259 13.3666 8.31488 13.5285 10.4159 13.5285C12.5169 13.5285 14.5692 13.3666 16.5492 13.2111C17.2803 13.1529 17.9709 12.8518 18.5111 12.3558C19.0513 11.8597 19.4101 11.1971 19.5302 10.4736C19.7014 9.39563 19.8444 8.28934 19.8444 7.16263C19.8444 6.03591 19.7014 4.9312 19.5302 3.8532C19.4104 3.12939 19.0518 2.46648 18.5116 1.9701C17.9713 1.47372 17.2805 1.17242 16.5492 1.1142C14.5692 0.958626 12.5169 0.79834 10.4159 0.79834C8.31488 0.79834 6.26259 0.958626 4.28259 1.11263C3.5508 1.171 2.85963 1.47276 2.31933 1.96976C1.77904 2.46676 1.42074 3.13038 1.30159 3.85477C1.1303 4.9312 0.987305 6.03748 0.987305 7.1642C0.987305 8.29091 1.1303 9.39563 1.30159 10.4736Z" fill="#034EA2" fill-opacity="0.3" />
                                        <path d="M20.3535 16.61C20.3536 16.6515 20.3674 16.6919 20.3927 16.7247L20.9427 17.4162C21.0413 17.5402 21.1003 17.6911 21.1121 17.8491C21.1239 18.0072 21.0879 18.1651 21.0087 18.3024L20.6866 18.8587C20.6074 18.9963 20.4886 19.1068 20.3456 19.1758C20.2026 19.2448 20.0421 19.269 19.8852 19.2453L19.0115 19.1133C18.9703 19.1073 18.9283 19.115 18.892 19.1353L17.858 19.7324C17.822 19.7541 17.7943 19.7874 17.7795 19.8267L17.4557 20.647C17.3985 20.7948 17.298 20.9219 17.1673 21.0116C17.0366 21.1013 16.8819 21.1495 16.7235 21.1499H16.0792C15.9207 21.1493 15.7661 21.101 15.6355 21.0113C15.5049 20.9216 15.4043 20.7947 15.3469 20.647L15.0247 19.8252C15.0096 19.7864 14.982 19.7537 14.9462 19.7324L13.909 19.1353C13.8732 19.1153 13.8318 19.1076 13.7912 19.1133L12.9175 19.2453C12.7605 19.269 12.6 19.2448 12.457 19.1758C12.3141 19.1068 12.1952 18.9963 12.116 18.8587L11.7939 18.3024C11.7146 18.1648 11.6787 18.0065 11.6908 17.8481C11.7028 17.6897 11.7623 17.5387 11.8615 17.4146L12.4115 16.7247C12.4377 16.6922 12.4521 16.6518 12.4523 16.61V15.4157C12.4526 15.3741 12.4387 15.3337 12.413 15.301L11.8615 14.6096C11.7624 14.4858 11.703 14.335 11.691 14.1769C11.6789 14.0188 11.7148 13.8607 11.7939 13.7233L12.116 13.167C12.1952 13.0294 12.3141 12.9189 12.457 12.85C12.6 12.781 12.7605 12.7568 12.9175 12.7804L13.788 12.914C13.8299 12.9199 13.8725 12.9116 13.909 12.8904L14.9462 12.2902C14.9819 12.2688 15.0095 12.2362 15.0247 12.1974L15.3485 11.3803C15.4059 11.2326 15.5065 11.1057 15.6371 11.016C15.7677 10.9263 15.9223 10.878 16.0807 10.8774H16.725C16.8837 10.8777 17.0387 10.9258 17.1696 11.0156C17.3005 11.1053 17.4013 11.2324 17.4589 11.3803L17.781 12.1974C17.7957 12.2373 17.8234 12.2711 17.8596 12.2933L18.8952 12.8904C18.9313 12.9113 18.9733 12.9196 19.0146 12.914L19.8883 12.7804C20.0453 12.7568 20.2057 12.781 20.3487 12.85C20.4917 12.9189 20.6106 13.0294 20.6897 13.167L21.0119 13.7233C21.0913 13.8609 21.1274 14.0193 21.1153 14.1777C21.1033 14.3361 21.0437 14.4872 20.9443 14.6112L20.3943 15.3026C20.3684 15.3347 20.354 15.3745 20.3535 15.4157V16.61Z" fill="white" />
                                        <path d="M20.3535 16.61C20.3536 16.6515 20.3674 16.6919 20.3927 16.7247L20.9427 17.4162C21.0413 17.5402 21.1003 17.6911 21.1121 17.8491C21.1239 18.0072 21.0879 18.1651 21.0087 18.3024L20.6866 18.8587C20.6074 18.9963 20.4886 19.1068 20.3456 19.1758C20.2026 19.2448 20.0421 19.269 19.8852 19.2453L19.0115 19.1133C18.9703 19.1073 18.9283 19.115 18.892 19.1353L17.858 19.7324C17.822 19.7541 17.7943 19.7874 17.7795 19.8267L17.4557 20.647C17.3985 20.7948 17.298 20.9219 17.1673 21.0116C17.0366 21.1013 16.8819 21.1495 16.7235 21.1499H16.0792C15.9207 21.1493 15.7661 21.101 15.6355 21.0113C15.5049 20.9216 15.4043 20.7947 15.3469 20.647L15.0247 19.8252C15.0096 19.7864 14.982 19.7537 14.9462 19.7324L13.909 19.1353C13.8732 19.1153 13.8318 19.1076 13.7912 19.1133L12.9175 19.2453C12.7605 19.269 12.6 19.2448 12.457 19.1758C12.3141 19.1068 12.1952 18.9963 12.116 18.8587L11.7939 18.3024C11.7146 18.1648 11.6787 18.0065 11.6908 17.8481C11.7028 17.6897 11.7623 17.5387 11.8615 17.4146L12.4115 16.7247C12.4377 16.6922 12.4521 16.6518 12.4523 16.61V15.4157C12.4526 15.3741 12.4387 15.3337 12.413 15.301L11.8615 14.6096C11.7624 14.4858 11.703 14.335 11.691 14.1769C11.6789 14.0188 11.7148 13.8607 11.7939 13.7233L12.116 13.167C12.1952 13.0294 12.3141 12.9189 12.457 12.85C12.6 12.781 12.7605 12.7568 12.9175 12.7804L13.788 12.914C13.8299 12.9199 13.8725 12.9116 13.909 12.8904L14.9462 12.2902C14.9819 12.2688 15.0095 12.2362 15.0247 12.1974L15.3485 11.3803C15.4059 11.2326 15.5065 11.1057 15.6371 11.016C15.7677 10.9263 15.9223 10.878 16.0807 10.8774H16.725C16.8837 10.8777 17.0387 10.9258 17.1696 11.0156C17.3005 11.1053 17.4013 11.2324 17.4589 11.3803L17.781 12.1974C17.7957 12.2373 17.8234 12.2711 17.8596 12.2933L18.8952 12.8904C18.9313 12.9113 18.9733 12.9196 19.0146 12.914L19.8883 12.7804C20.0453 12.7568 20.2057 12.781 20.3487 12.85C20.4917 12.9189 20.6106 13.0294 20.6897 13.167L21.0119 13.7233C21.0913 13.8609 21.1274 14.0193 21.1153 14.1777C21.1033 14.3361 21.0437 14.4872 20.9443 14.6112L20.3943 15.3026C20.3684 15.3347 20.354 15.3745 20.3535 15.4157V16.61Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16.4033 15.2274C16.2102 15.222 16.021 15.283 15.8675 15.4002C15.5579 15.6595 15.5375 16.2504 15.7952 16.5537C15.8734 16.6353 15.9681 16.6993 16.0729 16.7416C16.1778 16.7838 16.2904 16.8033 16.4033 16.7988" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M16.4033 15.2275C16.6013 15.2275 16.8009 15.2857 16.9392 15.402C17.2487 15.6597 17.2692 16.2505 17.0115 16.5538C16.9332 16.6354 16.8386 16.6995 16.7337 16.7417C16.6289 16.784 16.5163 16.8035 16.4033 16.799" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.7486 8.85977C19.8067 8.30034 19.8429 7.73463 19.8429 7.16263C19.8429 6.03591 19.7014 4.9312 19.5302 3.8532C19.4104 3.12939 19.0518 2.46648 18.5116 1.9701C17.9713 1.47372 17.2805 1.17242 16.5492 1.1142C14.5692 0.958626 12.5169 0.79834 10.4159 0.79834C8.31488 0.79834 6.26259 0.958626 4.28259 1.11263C3.5508 1.171 2.85963 1.47276 2.31933 1.96976C1.77904 2.46676 1.42074 3.13038 1.30159 3.85477C1.1303 4.9312 0.987305 6.03748 0.987305 7.1642C0.987305 8.29091 1.1303 9.3972 1.30159 10.4752C1.42144 11.1988 1.78007 11.8615 2.32033 12.3576C2.86059 12.8538 3.55138 13.1547 4.28259 13.2126C5.68745 13.3226 7.12688 13.4358 8.59773 13.4923" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.01367 5.15918H6.20639" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M9.82031 5.15918H11.013" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M14.627 5.15918H15.8181" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M5.29785 9.16602H13.3106" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3245_2864">
                                            <rect width="22" height="22" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </span>
                            <span class="menu-title">Quản lý phân quyền</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                @endif
            @else
                <div class="menu-item">
                    <a class="menu-link crm_role_roleList" href="{{ route('crm.role.roleList') }}">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                <g clip-path="url(#clip0_3245_2864)">
                                    <path d="M1.30159 10.4736C1.42144 11.1973 1.78007 11.86 2.32033 12.3561C2.86059 12.8522 3.55138 13.1532 4.28259 13.2111C6.26259 13.3666 8.31488 13.5285 10.4159 13.5285C12.5169 13.5285 14.5692 13.3666 16.5492 13.2111C17.2803 13.1529 17.9709 12.8518 18.5111 12.3558C19.0513 11.8597 19.4101 11.1971 19.5302 10.4736C19.7014 9.39563 19.8444 8.28934 19.8444 7.16263C19.8444 6.03591 19.7014 4.9312 19.5302 3.8532C19.4104 3.12939 19.0518 2.46648 18.5116 1.9701C17.9713 1.47372 17.2805 1.17242 16.5492 1.1142C14.5692 0.958626 12.5169 0.79834 10.4159 0.79834C8.31488 0.79834 6.26259 0.958626 4.28259 1.11263C3.5508 1.171 2.85963 1.47276 2.31933 1.96976C1.77904 2.46676 1.42074 3.13038 1.30159 3.85477C1.1303 4.9312 0.987305 6.03748 0.987305 7.1642C0.987305 8.29091 1.1303 9.39563 1.30159 10.4736Z" fill="#034EA2" fill-opacity="0.3" />
                                    <path d="M20.3535 16.61C20.3536 16.6515 20.3674 16.6919 20.3927 16.7247L20.9427 17.4162C21.0413 17.5402 21.1003 17.6911 21.1121 17.8491C21.1239 18.0072 21.0879 18.1651 21.0087 18.3024L20.6866 18.8587C20.6074 18.9963 20.4886 19.1068 20.3456 19.1758C20.2026 19.2448 20.0421 19.269 19.8852 19.2453L19.0115 19.1133C18.9703 19.1073 18.9283 19.115 18.892 19.1353L17.858 19.7324C17.822 19.7541 17.7943 19.7874 17.7795 19.8267L17.4557 20.647C17.3985 20.7948 17.298 20.9219 17.1673 21.0116C17.0366 21.1013 16.8819 21.1495 16.7235 21.1499H16.0792C15.9207 21.1493 15.7661 21.101 15.6355 21.0113C15.5049 20.9216 15.4043 20.7947 15.3469 20.647L15.0247 19.8252C15.0096 19.7864 14.982 19.7537 14.9462 19.7324L13.909 19.1353C13.8732 19.1153 13.8318 19.1076 13.7912 19.1133L12.9175 19.2453C12.7605 19.269 12.6 19.2448 12.457 19.1758C12.3141 19.1068 12.1952 18.9963 12.116 18.8587L11.7939 18.3024C11.7146 18.1648 11.6787 18.0065 11.6908 17.8481C11.7028 17.6897 11.7623 17.5387 11.8615 17.4146L12.4115 16.7247C12.4377 16.6922 12.4521 16.6518 12.4523 16.61V15.4157C12.4526 15.3741 12.4387 15.3337 12.413 15.301L11.8615 14.6096C11.7624 14.4858 11.703 14.335 11.691 14.1769C11.6789 14.0188 11.7148 13.8607 11.7939 13.7233L12.116 13.167C12.1952 13.0294 12.3141 12.9189 12.457 12.85C12.6 12.781 12.7605 12.7568 12.9175 12.7804L13.788 12.914C13.8299 12.9199 13.8725 12.9116 13.909 12.8904L14.9462 12.2902C14.9819 12.2688 15.0095 12.2362 15.0247 12.1974L15.3485 11.3803C15.4059 11.2326 15.5065 11.1057 15.6371 11.016C15.7677 10.9263 15.9223 10.878 16.0807 10.8774H16.725C16.8837 10.8777 17.0387 10.9258 17.1696 11.0156C17.3005 11.1053 17.4013 11.2324 17.4589 11.3803L17.781 12.1974C17.7957 12.2373 17.8234 12.2711 17.8596 12.2933L18.8952 12.8904C18.9313 12.9113 18.9733 12.9196 19.0146 12.914L19.8883 12.7804C20.0453 12.7568 20.2057 12.781 20.3487 12.85C20.4917 12.9189 20.6106 13.0294 20.6897 13.167L21.0119 13.7233C21.0913 13.8609 21.1274 14.0193 21.1153 14.1777C21.1033 14.3361 21.0437 14.4872 20.9443 14.6112L20.3943 15.3026C20.3684 15.3347 20.354 15.3745 20.3535 15.4157V16.61Z" fill="white" />
                                    <path d="M20.3535 16.61C20.3536 16.6515 20.3674 16.6919 20.3927 16.7247L20.9427 17.4162C21.0413 17.5402 21.1003 17.6911 21.1121 17.8491C21.1239 18.0072 21.0879 18.1651 21.0087 18.3024L20.6866 18.8587C20.6074 18.9963 20.4886 19.1068 20.3456 19.1758C20.2026 19.2448 20.0421 19.269 19.8852 19.2453L19.0115 19.1133C18.9703 19.1073 18.9283 19.115 18.892 19.1353L17.858 19.7324C17.822 19.7541 17.7943 19.7874 17.7795 19.8267L17.4557 20.647C17.3985 20.7948 17.298 20.9219 17.1673 21.0116C17.0366 21.1013 16.8819 21.1495 16.7235 21.1499H16.0792C15.9207 21.1493 15.7661 21.101 15.6355 21.0113C15.5049 20.9216 15.4043 20.7947 15.3469 20.647L15.0247 19.8252C15.0096 19.7864 14.982 19.7537 14.9462 19.7324L13.909 19.1353C13.8732 19.1153 13.8318 19.1076 13.7912 19.1133L12.9175 19.2453C12.7605 19.269 12.6 19.2448 12.457 19.1758C12.3141 19.1068 12.1952 18.9963 12.116 18.8587L11.7939 18.3024C11.7146 18.1648 11.6787 18.0065 11.6908 17.8481C11.7028 17.6897 11.7623 17.5387 11.8615 17.4146L12.4115 16.7247C12.4377 16.6922 12.4521 16.6518 12.4523 16.61V15.4157C12.4526 15.3741 12.4387 15.3337 12.413 15.301L11.8615 14.6096C11.7624 14.4858 11.703 14.335 11.691 14.1769C11.6789 14.0188 11.7148 13.8607 11.7939 13.7233L12.116 13.167C12.1952 13.0294 12.3141 12.9189 12.457 12.85C12.6 12.781 12.7605 12.7568 12.9175 12.7804L13.788 12.914C13.8299 12.9199 13.8725 12.9116 13.909 12.8904L14.9462 12.2902C14.9819 12.2688 15.0095 12.2362 15.0247 12.1974L15.3485 11.3803C15.4059 11.2326 15.5065 11.1057 15.6371 11.016C15.7677 10.9263 15.9223 10.878 16.0807 10.8774H16.725C16.8837 10.8777 17.0387 10.9258 17.1696 11.0156C17.3005 11.1053 17.4013 11.2324 17.4589 11.3803L17.781 12.1974C17.7957 12.2373 17.8234 12.2711 17.8596 12.2933L18.8952 12.8904C18.9313 12.9113 18.9733 12.9196 19.0146 12.914L19.8883 12.7804C20.0453 12.7568 20.2057 12.781 20.3487 12.85C20.4917 12.9189 20.6106 13.0294 20.6897 13.167L21.0119 13.7233C21.0913 13.8609 21.1274 14.0193 21.1153 14.1777C21.1033 14.3361 21.0437 14.4872 20.9443 14.6112L20.3943 15.3026C20.3684 15.3347 20.354 15.3745 20.3535 15.4157V16.61Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.4033 15.2274C16.2102 15.222 16.021 15.283 15.8675 15.4002C15.5579 15.6595 15.5375 16.2504 15.7952 16.5537C15.8734 16.6353 15.9681 16.6993 16.0729 16.7416C16.1778 16.7838 16.2904 16.8033 16.4033 16.7988" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.4033 15.2275C16.6013 15.2275 16.8009 15.2857 16.9392 15.402C17.2487 15.6597 17.2692 16.2505 17.0115 16.5538C16.9332 16.6354 16.8386 16.6995 16.7337 16.7417C16.6289 16.784 16.5163 16.8035 16.4033 16.799" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M19.7486 8.85977C19.8067 8.30034 19.8429 7.73463 19.8429 7.16263C19.8429 6.03591 19.7014 4.9312 19.5302 3.8532C19.4104 3.12939 19.0518 2.46648 18.5116 1.9701C17.9713 1.47372 17.2805 1.17242 16.5492 1.1142C14.5692 0.958626 12.5169 0.79834 10.4159 0.79834C8.31488 0.79834 6.26259 0.958626 4.28259 1.11263C3.5508 1.171 2.85963 1.47276 2.31933 1.96976C1.77904 2.46676 1.42074 3.13038 1.30159 3.85477C1.1303 4.9312 0.987305 6.03748 0.987305 7.1642C0.987305 8.29091 1.1303 9.3972 1.30159 10.4752C1.42144 11.1988 1.78007 11.8615 2.32033 12.3576C2.86059 12.8538 3.55138 13.1547 4.28259 13.2126C5.68745 13.3226 7.12688 13.4358 8.59773 13.4923" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.01367 5.15918H6.20639" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9.82031 5.15918H11.013" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M14.627 5.15918H15.8181" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5.29785 9.16602H13.3106" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_3245_2864">
                                        <rect width="22" height="22" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </span>
                        <span class="menu-title">Quản lý phân quyền</span>
                    </a>
                    <!--end:Menu link-->
                </div>
            @endif


            <h5 class="pe-4 mt-3">Cấu hình</h5>

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $configPermissions = [
                        'crm.system.email', 'crm.system.status', 'crm.custom.field', 'crm.system.sources', 'crm.major.subject', 'crm.filters.index', 'crm.voip24h.list'];
                    $configHasPermission = array_intersect($configPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.system.email', $userPermissions) ||
                    in_array('crm.system.status', $userPermissions) ||
                    in_array('crm.custom.field', $userPermissions)  ||
                    in_array('crm.system.sources', $userPermissions) ||
                    in_array('crm.major.subject', $userPermissions) ||
                    in_array('crm.voip24h.list', $userPermissions) || 
                    in_array('crm.filters.index', $userPermissions))
                    <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                        <a href="#" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                                    <path opacity="0.3" d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89312 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" fill="#034EA2" />
                                    <path d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89311 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="menu-title">Cấu hình hệ thống</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <a class="menu-link crm_filter" href="{{ route('crm.filters.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Bộ lọc  thời gian</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--begin:Menu item-->
                            <div class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <a class="menu-link crm_system_email" href="{{ route('crm.system.email') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Mẫu Email</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                            <!--begin:Menu item-->
                            <div class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <a class="menu-link crm_system_status" href="{{ route('crm.system.status') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Trạng thái</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            <div class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <a class="menu-link crm_custom_field" href="{{ route('crm.custom.field') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Trường tùy chỉnh</span>
                                </a>
                                <!--end:Menu link-->
                            </div>

                            <div class="menu-item menu-accordion">
                                <a class="menu-link crm_general_configuration" href="{{route('crm.general.configuration')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Cấu hình chung</span>
                                </a>
                            </div>

                            <div class="menu-item menu-accordion">
                                <a class="menu-link crm_voip24h_list" href="{{route('crm.voip24h.list')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Cấu hình Tổng đài</span>
                                </a>
                            </div>
                        </div>
                        <!--end:Menu sub-->
                    </div>
                @endif
            @else
                <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                                <path opacity="0.3" d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89312 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" fill="#034EA2" />
                                <path d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89311 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-title">Cấu hình hệ thống</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link crm_filter" href="{{ route('crm.filters.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Bộ lọc  thời gian</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link crm_system_email" href="{{ route('crm.system.email') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Mẫu Email</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link crm_system_status" href="{{ route('crm.system.status') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Trạng thái</span>
                            </a>
                            <!--end:Menu link-->
                        </div>

                        <div class="menu-item menu-accordion">
                            <!--begin:Menu link-->
                            <a class="menu-link crm_custom_field" href="{{ route('crm.custom.field') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Trường tùy chỉnh</span>
                            </a>
                            <!--end:Menu link-->
                        </div>

                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_general_configuration" href="{{route('crm.general.configuration')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Cấu hình chung</span>
                            </a>
                        </div>

                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_general_configuration" href="{{route('crm.voip24h.list')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Cấu hình Tổng đài</span>
                            </a>
                        </div>
                    </div>
                    <!--end:Menu sub-->
                </div>
            @endif

            @if(auth()->user()->email != 'admin@gmail.com')
                @php
                    $configPermissions = [
                        'crm.education.type', 'crm.system.sources', 'crm.major.subject'];
                    $configHasPermission = array_intersect($configPermissions, $userPermissions);
                @endphp

                @if(in_array('crm.education.type', $userPermissions)  ||
                    in_array('crm.system.sources', $userPermissions) ||
                    in_array('crm.major.subject', $userPermissions) )
                    <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                        <a href="#" class="menu-link">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                                    <path opacity="0.3" d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89312 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" fill="#034EA2" />
                                    <path d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89311 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </span>
                            <span class="menu-title">Cấu hình Đăng ký hồ sơ</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item menu-accordion">
                                <a class="menu-link crm_system_sources" href="{{ route('crm.system.sources') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Nguồn tiếp cận</span>
                                </a>
                            </div>
                            <div class="menu-item menu-accordion">
                                <a class="menu-link crm_major_subject" href="{{route('crm.major.subject')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Ngành và tổ hợp môn</span>
                                </a>
                            </div>

                            <div class="menu-item menu-accordion">
                                <a class="menu-link crm_education_type" href="{{route('crm.education.type')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Trình độ học vấn</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div data-ti-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="#" class="menu-link">
                        <span class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 20 22" fill="none">
                                <path opacity="0.3" d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89312 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" fill="#034EA2" />
                                <path d="M7.21883 3.53564L7.89454 1.79136C8.0085 1.49603 8.20899 1.242 8.46976 1.06255C8.73053 0.883095 9.03942 0.78658 9.35597 0.785645H10.6445C10.9611 0.78658 11.27 0.883095 11.5308 1.06255C11.7915 1.242 11.992 1.49603 12.106 1.79136L12.7817 3.53564L15.076 4.85564L16.9303 4.57279C17.239 4.53088 17.5533 4.5817 17.8331 4.71881C18.1129 4.85591 18.3456 5.07311 18.5017 5.34279L19.1303 6.44279C19.2913 6.71676 19.3655 7.03314 19.3431 7.35016C19.3206 7.66718 19.2026 7.96995 19.0045 8.2185L17.8574 9.67993V12.3199L19.036 13.7814C19.234 14.0299 19.3521 14.3327 19.3745 14.6497C19.397 14.9667 19.3228 15.2831 19.1617 15.5571L18.5331 16.6571C18.377 16.9268 18.1443 17.1439 17.8645 17.2811C17.5847 17.4182 17.2704 17.469 16.9617 17.4271L15.1074 17.1442L12.8131 18.4642L12.1374 20.2085C12.0234 20.5038 11.823 20.7579 11.5622 20.9373C11.3014 21.1168 10.9925 21.2133 10.676 21.2142H9.35597C9.03942 21.2133 8.73053 21.1168 8.46976 20.9373C8.20899 20.7579 8.0085 20.5038 7.89454 20.2085L7.21883 18.4642L4.92454 17.1442L3.07026 17.4271C2.7615 17.469 2.44725 17.4182 2.16744 17.2811C1.88764 17.1439 1.65491 16.9268 1.49883 16.6571L0.870258 15.5571C0.709189 15.2831 0.634979 14.9667 0.657423 14.6497C0.679867 14.3327 0.79791 14.0299 0.995972 13.7814L2.14311 12.3199V9.67993L0.964543 8.2185C0.766481 7.96995 0.648439 7.66718 0.625995 7.35016C0.603551 7.03314 0.67776 6.71676 0.838829 6.44279L1.4674 5.34279C1.62348 5.07311 1.85621 4.85591 2.13602 4.71881C2.41582 4.5817 2.73007 4.53088 3.03883 4.57279L4.89311 4.85564L7.21883 3.53564ZM6.8574 10.9999C6.8574 11.8335 7.18852 12.6329 7.77792 13.2223C8.36732 13.8117 9.16672 14.1428 10.0003 14.1428C10.8338 14.1428 11.6332 13.8117 12.2226 13.2223C12.812 12.6329 13.1431 11.8335 13.1431 10.9999C13.1431 10.1664 12.812 9.36699 12.2226 8.77759C11.6332 8.18819 10.8338 7.85707 10.0003 7.85707C9.16672 7.85707 8.36732 8.18819 7.77792 8.77759C7.18852 9.36699 6.8574 10.1664 6.8574 10.9999Z" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span class="menu-title">Cấu hình Đăng ký hồ sơ</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="menu-sub menu-sub-accordion">
                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_system_sources"  href="{{ route('crm.system.sources') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Nguồn tiếp cận</span>
                            </a>
                        </div>

                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_major_subject" href="{{route('crm.major.subject')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Ngành và tổ hợp môn</span>
                            </a>
                        </div>

                        <div class="menu-item menu-accordion">
                            <a class="menu-link crm_education_type" href="{{route('crm.education.type')}}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Trình độ văn hóa</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!--end:Menu item-->
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link btn_logout_crm" href="{{route('crm.login')}}">
                    <span class="menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                            <path opacity="0.3" d="M14.929 19.6428C14.929 20.0595 14.7634 20.4593 14.4687 20.7539C14.174 21.0486 13.7743 21.2142 13.3576 21.2142H2.35756C1.94079 21.2142 1.54109 21.0486 1.24639 20.7539C0.951694 20.4593 0.786133 20.0595 0.786133 19.6428V2.35707C0.786133 1.9403 0.951694 1.54061 1.24639 1.2459C1.54109 0.951206 1.94079 0.785645 2.35756 0.785645H13.3576C13.7743 0.785645 14.174 0.951206 14.4687 1.2459C14.7634 1.54061 14.929 1.9403 14.929 2.35707V19.6428Z" fill="#034EA2" />
                            <path d="M10.2148 11H21.2148" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M18.0723 7.85693L21.2151 10.9998L18.0723 14.1426" stroke="#034EA2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="menu-title">Đăng xuất</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        </div>
        <!--end::Sidebar menu-->
    </div>
    <!--end::Main-->
</div>
