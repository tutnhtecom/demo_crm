<!--begin::Học phí-->
<div class="tab-pane fade" id="learning-fee" role="tabpanel" aria-labelledby="learning-fee-tab">
    <div class="d-flex align-items-center justify-content-end btn_create_pricelist_wrapper">
        @php
            $currentEmployeeId = auth()->user()->employees ? auth()->user()->employees->id : null;
        @endphp
        @if(auth()->user()->id == 1 || $currentEmployeeId == $dataId->employees->id)
            <a href="#" data-bs-toggle="modal" data-bs-target="#ti_modal_add_quota" id="crm_notification_pricelist"
                data-email-tmp="TYPE_PRICE_LISTS" data-email-tmp-id="3"
                class="btn btn-primary d-flex align-items-center gap-2 crm_notification_pricelist"> 
                <img src="assets/crm/media/svg/crm/add-circle.svg" alt="Thêm báo giá" width="18" height="18" />
                <span>Thêm mới học phí </span>
            </a>
        @endif
        <!-- class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1 crm_lead_create_lead mx-2"  -->
        <!-- <button id="btn_import_leads" type="button"  class="btn btn-primary d-flex align-items-center gap-2 crm_notification_pricelist mx-2"
            data-bs-toggle="modal" data-bs-target="#modal_import_price_list">
            <img src="assets/crm/media/svg/crm/upload.svg" width="22" height="22" />
            <span class="d-none d-md-block">Nhập dữ liệu</span>
        </button> -->
    </div>
    <div class="table-responsive position-relative border rounded-3 my-3">
        <!--begin::Table-->
        <table
            class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
            <!--begin::Table head-->
            <thead>
                <tr class="bg-primary text-white">
                    <th class="w-40px"></th>
                    <th class="text-nowrap fs-5 text-center min-w-200px">Học kỳ</th>
                    <th class="text-nowrap fs-5 text-center min-w-200px">Mã học phí</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Hạn nộp</th>
                    <th class="text-nowrap fs-5 text-start">Số tiền (VND)</th>
                    <th class="text-nowrap fs-5 text-start">Trạng thái thanh toán</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Ghi chú</th>
                    <th class="text-nowrap fs-5 text-start">Tệp đính kèm</th>
                    <th class="text-nowrap fs-5 text-center min-w-125px">Chức năng</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @if(isset($dataId->price_lists) && count($dataId->price_lists) > 0)
                    @foreach ($dataId->price_lists as $price)
                    <tr>
                        <td class="align-middle text-center ps-4">
                            <div class="form-check form-check-sm">
                                <input class="form-check-input inrow-checkbox"
                                    type="checkbox" value="" id="flexCheckDefault">
                            </div>
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            {{ $price->title ?? null }}
                        </td>
                        <td class="align-middle text-center"  style="max-width:1% !important;">
                            {{$price->code}}
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            {{ \Carbon\Carbon::parse($price->from_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($price->to_date)->format('d/m/Y') }}
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            {{ number_format($price->price, 0, ',', '.') }}
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            <select data-id="{{$price->id}}" class="status_select w-auto form-select form-select-sm change_status_price_list"
                                style="background-color:{{$price['data_color'][$price->status]['bg_color']}}; color:{{$price['data_color'][$price->status]['color']}};border-color:{{$price['data_color'][$price->status]['border_color']}}" disabled>
                                <option data-color="success" value="1" {{ $price->status == 1 ? 'selected' : '' }}
                                    style="background-color:{{$price['data_color'][$price->status]['bg_color']}}; color:{{$price['data_color'][$price->status]['color']}};border-color:{{$price['data_color'][$price->status]['border_color']}}">
                                    Đã thanh toán
                                </option>
                                <option data-bg-color="{{$price['data_color'][0]['bg_color']}}" data-border-color="{{$price['data_color'][0]['color']}}" data-text-color="{{$price['data_color'][0]['border_color']}}"
                                    data-color="gray-500" value="0" {{ $price->status == 0 ? 'selected' : '' }}>
                                    Chưa thanh toán
                                </option>
                            </select>
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            {{$price->note ?? '-'}}
                        </td>
                        <td class="align-middle text-start px-2 px-md-4 py-4">
                            @if(isset($price->files) && isset($price->files->image_url))
                            <a href="{{$price->files->image_url}}"> Tải file</a>
                            @else
                            -
                            @endif
                        </td>
                        <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                            <button type="button" class="btn btn-ghost p-1"
                                data-ti-menu-trigger="click"
                                data-ti-menu-placement="bottom-end">
                                <img src="assets/crm/media/svg/crm/edit.svg" alt="Sửa"
                                    width="18" height="18" />
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px"
                                data-ti-menu="true"
                                id="ti-toolbar-candidate-note-editor-887" style="">
                                <!--begin::Content-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="text-start mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-bold fs-6 mb-1 w-100">Ghi chú
                                            <!--begin::Input-->
                                            <textarea id="note_input_edit_{{$price->id}}" class="form-control"></textarea>
                                            <!--end::Input-->
                                        </label>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end gap-2">
                                        <button id="btn_update_note_price" data-id="{{$price->id}}" type="submit" class="btn btn-primary btn_update_note_price">
                                            Lưu
                                        </button>
                                        <button type="reset"
                                            class="btn btn-light btn-active-light-primary me-2"
                                            data-ti-menu-dismiss="true"
                                            data-ti-candidate-table-action="reset">Hủy</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Content-->
                            </div>
                            <button type="button" class="btn btn-ghost p-1 crm_notification_pricelist"
                                data-ti-row-confirm-message="Xóa hồ sơ này?"
                                data-ti-button-action="row-remove"
                                data-ti-row-confirm="true" data-bs-toggle="modal" data-bs-target="#deletePriceModal{{$price->id}}">
                                <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa"
                                    width="18" height="18" />
                            </button>

                            <!-- Modal Delete Role-->
                            <div class="modal fade modal_delete" id="deletePriceModal{{$price->id}}" tabindex="-1" aria-labelledby="deletePriceModal{{$price->id}}Label" aria-hidden="true">
                                <div class="modal-dialog" style="margin-top:160px;">
                                    <div class="modal-content" style="max-width: 444px">
                                        <div class="">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <img src="assets/crm/media/svg/crm/danger-triange.svg" alt="">
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center" style="font-size:24px;font-weight:600;margin-bottom:15px;"> Xóa mục này? </div>
                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                <button id="" type="button" class="btn btn-primary btn_delete_price_list" data-id="{{$price->id}}">Xác nhận</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Modal Delete Role-->
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            if ($("body").hasClass("crm_notification_pricelist") || $("body").hasClass("is_super_admin")) {
                $(".change_status_price_list").prop("disabled", false);
            }
        });
    </script>
</div>
<!--end::Học phí-->
<!-- <script type="module" src="/assets/crm/js/htecomJs/import_price_list.js"></script>
@include('crm.content.leads.modal.modal_import_price_list_for_leads') -->