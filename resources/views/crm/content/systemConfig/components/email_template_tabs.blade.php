<style>
    .responsive-tabs {
        padding: 2rem;
    }

    .responsive-tabs .nav-tabs {
        display: none;
    }

    @media (min-width: 768px) {
        .responsive-tabs .nav-tabs {
            display: flex;
        }

        .responsive-tabs .card {
            border: none;
        }

        .responsive-tabs .card .card-header {
            display: none;
        }

        .responsive-tabs .card .collapse {
            display: block;
        }
    }

    @media (max-width: 767px) {
        .responsive-tabs .tab-pane {
            display: block !important;
            opacity: 1;
        }
    }
</style>
<div id="content" class="tab-content" role="tablist"  style="border-radius: 0;">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a id="email-template-tab" href="#email-template" class="nav-link active" data-bs-toggle="tab" role="tab">
                <span style="font-size:14px;">
                   Danh sách mẫu Email
                </span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a id="email-template-tab" href="#key-email-template" class="nav-link" data-bs-toggle="tab" role="tab" >
                <span style="font-size:14px;">
                    Danh sách mẫu key
                </span>
            </a>
        </li> -->
    </ul>
    <div id="email-template" class="card tab-pane fade show active div-content" role="tabpanel" aria-labelledby="tab-A">
        @include('crm.content.systemConfig.components.email_template_list')
    </div>
    <div id="key-email-template" class="card tab-pane fade div-content" role="tabpanel" aria-labelledby="tab-B">            
        @include('crm.content.systemConfig.components.email_template_key_tabs')
    </div>
</div>
</div>
<style>
    .div-content {
        border-radius: 0;
    }
</style>