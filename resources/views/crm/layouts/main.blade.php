<div class="app-main flex-column flex-row-fluid" id="ti_app_main">
    <!--  Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">
        <!--  Header -->
        @include('crm.layouts.header')
        <div class="noti_micro_wrapper">
            <p class="noti_micro_check_device" style="display:none;color:red;font-weight:bold">
                <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
            </p>
            <p class="noti_micro_turn_on" style="display:none;color:red;font-weight:bold">
                <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
            </p>
            <p class="noti_err_voip" style="display:none;color:red;font-weight:bold">
                <i class="fa-solid fa-circle-exclamation" style="color:red;"></i>
            </p>
        </div>
        <!--end::Header-->
        @yield('content')
    </div>
    <!--end::Content wrapper-->

    @include('crm.content.modalVoip.modal_answer_voip_24h')
</div>