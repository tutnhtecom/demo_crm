<div id="ti_app_header" class="app-header d-flex flex-column flex-stack mb-3 px-3 rounded-bottom">
    <!--begin::Header main-->
    <div class="d-flex align-items-center flex-stack flex-grow-1">
        <!--begin::Sidebar mobile toggle-->
        <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
            id="ti_app_sidebar_mobile_toggle">
            <i class="ki-duotone ki-abstract-14 fs-2">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
        <!--end::Sidebar mobile toggle-->
        <!--begin::Navbar-->
        <div class="app-navbar flex-grow-1 justify-content-end" id="ti_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1 me-2 me-lg-0">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-row-fluid">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex flex-column justify-content-center text-dark fw-bolder fs-1 lh-0">
                        @yield('header')</h1>
                    <!--end::Title-->
                </div>

                <div id="" class="header-search d-flex align-items-center w-lg-350px"
                    data-ti-menu-attach="parent" data-ti-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-ti-menu-placement="bottom-end">
                    <!--begin::Tablet and mobile search toggle-->
                    {{-- <div data-ti-search-element="toggle"
                        class="search-toggle-mobile d-flex d-lg-none align-items-center">
                        <div class="d-flex">
                            <img src="/assets/crm/media/svg/crm/search-lg.svg" width="24" height="24" />
                        </div>
                    </div> --}}
                    <!--end::Tablet and mobile search toggle-->
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <form class="w-100 position-relative">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        <!--begin::Icon-->
                        <i
                            class="ki-duotone ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input id="searchInputLeadOrStudent" type="text"
                            class="search-input form-control form-control border border-gray-200 rounded h-lg-40px ps-13"
                            name="" value="" placeholder="Tìm kiếm..." />
                        <!--end::Input-->
                        <!--begin::Spinner-->
                        <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                            <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                        </span>
                        <!--end::Spinner-->
                        <!--begin::Reset-->
                        <span
                            class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                            <i class="ki-duotone ki-cross fs-2 fs-lg-1 me-0">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </span>
                        <!--end::Reset-->
                    </form>
                    <!--end::Form-->
                </div>
                <div id="searchResultsData"
                    class="menu search-lead-student menu-sub menu-sub-dropdown text-start menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6"
                    data-ti-menu="true">
                    <!--end::Menu item-->
                </div>

            </div>
            <!--begin::Notifications-->
            <div class="app-navbar-item me-lg-1">
                <!--begin::Menu- wrapper-->
                <div
                    class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
                    <div class="cursor-pointer " data-ti-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-ti-menu-attach="parent" data-ti-menu-placement="bottom-end">
                        <div class="d-flex flex-stack gap-2">
                            <div class="symbol rounded-full overflow-hidden symbol-30px symbol-lg-20px">
                                <img src="/assets/crm/media/svg/crm/notification.svg" width="20" height="20" />
                            </div>
                        </div>
                    </div>
                    <!--begin::User account menu-->
                    <div class="menu header-notification menu-sub menu-sub-dropdown text-start menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6"
                        data-ti-menu="true">
                        {{-- @include('crm.content.notification.notification_list_popup') --}}
                        <!--begin::Menu item-->
                        {{-- <div class="menu-item px-5">
                            <a href="{{ route('crm.profile.detail') }}" class="menu-link px-5">
                                <span class="menu-title d-flex align-items-center gap-2">
                                    <img src="/assets/crm/media/svg/crm/lock.svg" width="22" height="22" />
                                    Đổi mật khẩu
                                </span>
                            </a>
                        </div> --}}
                        <!--end::Menu item-->
                        <!--begin::Menu separator-->
                        {{-- <div class="separator my-2"></div> --}}
                        <!--end::Menu separator-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="{{ route('crm.notification.listToMe') }}" class="menu-link px-5">
                                Xem tất cả
                            </a>
                        </div>

                        <!--end::Menu item-->
                    </div>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Notifications-->
            <!--begin::Quick links-->
            {{-- <div class="app-navbar-item">
                <!--begin::Menu- wrapper-->
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
                    <img src="/assets/crm/media/svg/crm/cog.svg" width="20" height="20" />
                </div>
                <!--end::Menu wrapper-->
            </div> --}}
            <!--end::Quick links-->
            <!--begin::User menu-->
            <div class="app-navbar-item ms-3 ms-lg-4 me-lg-2" id="ti_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer " data-ti-menu-trigger="{default: 'click', lg: 'hover'}"
                    data-ti-menu-attach="parent" data-ti-menu-placement="bottom-end">
                    <div class="d-flex flex-stack gap-2">
                        <div class="symbol rounded-full overflow-hidden symbol-30px symbol-lg-40px">
                            @if(auth()->user()->id != 1)
                                @foreach (auth()->user()->employees->files as $file)
                                    @if ($file->types == 0 && $file->deleted_at == null)
                                        <img src="{{$file->image_url}}" alt="user">
                                    @endif
                                    @break
                                @endforeach
                            @else
                                <img src="/assets/crm/media/svg/avatars/blank.svg" alt="user" />
                            @endif    
                        </div>
                        <div class="d-flex flex-column flex-stack align-items-start">
                            @if (auth()->user()->email != 'admin@gmail.com')
                                <div
                                    class="rounded role_employee {{ auth()->user()->employees->roles->id == 1 ? 'border-danger bg-danger text-danger bg_admin' : 'badge-light-primary' }} px-2"
                                    data-employee-id="{{ auth()->user()->employees->roles->id == 1 ? '' : auth()->user()->employees->id }}">
                                    {{ auth()->user()->employees->roles ? auth()->user()->employees->roles->name : '' }}
                                </div>
                            @else
                                Administrator
                            @endif
                            
                            <p class="fw-bold p-0 m-0">
                                @if (auth()->check())
                                    {{ auth()->user()->employees ? auth()->user()->employees->name : 'Admin' }}
                                @else
                                    Bạn chưa đăng nhập.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                    data-ti-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-5 link_info_account">
                        <a href="{{ route('crm.profile.detail') }}" class="menu-link px-5">
                            <span class="menu-title d-flex align-items-center gap-2">
                                <img src="/assets/crm/media/svg/crm/account-sm.svg" width="22" height="22" />
                                Thông tin tài khoản
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5 link_change_password_account">
                        <a href="{{ route('crm.profile.detail') }}" class="menu-link px-5">
                            <span class="menu-title d-flex align-items-center gap-2">
                                <img src="/assets/crm/media/svg/crm/lock.svg" width="22" height="22" />
                                Đổi mật khẩu
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    {{-- <div class="separator my-2"></div> --}}
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="{{route('crm.login')}}" class="menu-link px-5 btn_logout_crm">
                            <span class="menu-title d-flex align-items-center gap-2">
                                <img src="/assets/crm/media/svg/crm/logout.svg" width="22" height="22" />
                                Đăng xuất
                            </span>
                        </a>
                    </div>

                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User menu-->


        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header main-->
</div>
<script>
    const baseUrlWeb = window.location.origin;
    $('#searchInputLeadOrStudent').on('keyup', function() {
        let query = $(this).val();

        if (query.length > 2) {
            $.ajax({
                url: '{{ route('search') }}',
                method: 'POST',
                data: {
                    query: query,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    let resultsHtml = '<div>';

                    // Hiển thị danh sách Leads
                    if (response.leads && response.leads.length > 0) {
                        resultsHtml += `<h4 style="color:#034EA2;padding:5px;margin:0;">Danh sách thí sinh tiềm năng</h4><ul>`;
                        response.leads.forEach(item => {
                            resultsHtml += `
                                <li class="item_search_all">
                                    <a class="link_item_search" href="${baseUrlWeb}/crm/leads/detail_lead/${item.id}" style="color: #000;">
                                        ${item.full_name}
                                    </a>
                                </li>`;
                        });
                        resultsHtml += `</ul>`;
                    }

                    // Hiển thị danh sách Students
                    if (response.students && response.students.length > 0) {
                        resultsHtml += `<h4 style="color:#034EA2;padding:5px;margin:0;">Danh sách sinh viên</h4><ul>`;
                        response.students.forEach(item => {
                            resultsHtml += `
                                <li class="item_search_all">
                                    <a class="link_item_search" href="${baseUrlWeb}/crm/students/detail_student/${item.id}" style="color: #000;">
                                        ${item.full_name}
                                    </a>
                                </li>`;
                        });
                        resultsHtml += `</ul>`;
                    }

                    if(response.leads == '' && response.students == ''){
                        resultsHtml += '<p>Không có kết quả tìm kiếm</p>';
                    }

                    resultsHtml += '</div>';
                    $('#searchResultsData').html(resultsHtml);
                },
                error: function() {
                    $('#searchResultsData').html('<p>Lỗi khi tìm kiếm.</p>');
                }
            });
        } else {
            $('#searchResultsData').html('Không có kết quả tìm kiếm');
        }
    });
    $(document).on('click', '.link_item_search', function(){
        $('#searchInputLeadOrStudent').val('');
    })

    var employeeLoginId = "{{ auth()->user()->employees ? auth()->user()->employees->id : '' }}";
    var employeeLoginRoleId = "{{ auth()->user()->employees ? auth()->user()->employees->roles_id : '' }}";
    
</script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/header.js') }}"></script>
<script type="module" src="{{ asset('assets/crm/js/htecomJs/tasksForEmployee.js') }}"></script>
