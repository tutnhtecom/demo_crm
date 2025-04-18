@if(auth()->user()->email != 'admin@htecom.vn' && (!auth()->user()->employees || auth()->user()->employees->roles->id != 1))
@php
$configPermissions = [
'crm.system.email', 'crm.system.status', 'crm.custom.field', 'crm.system.sources', 'crm.major.subject', 'crm.filters.index', 'crm.voip24h.list'];
$configHasPermission = array_intersect($configPermissions, $userPermissions);
@endphp

@if(in_array('crm.system.email', $userPermissions) ||
in_array('crm.system.status', $userPermissions) ||
in_array('crm.custom.field', $userPermissions) ||
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
                <span class="menu-title">Bộ lọc thời gian</span>
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
                <span class="menu-title">Bộ lọc thời gian</span>
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