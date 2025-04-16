<!--begin::Học phí-->
<div class="tab-pane fade" id="learning-fee" role="tabpanel"
    aria-labelledby="learning-fee-tab">
    <div class="table-responsive position-relative border rounded-3 my-3">
        <!--begin::Table-->
        <table
            class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
            <!--begin::Table head-->
            <thead>
                <tr class="bg-primary text-white">
                    <th class="text-nowrap fs-5 text-center min-w-200px">Học kỳ</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Mã hóa đơn</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Hạn nộp</th>                    
                    <th class="text-nowrap fs-5 text-start">Số tiền (VND)</th>
                    <th class="text-nowrap fs-5 text-start">Trạng thái thanh toán</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Ghi chú</th>
                    <th class="text-nowrap fs-5 text-start">Tệp đính kèm</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @foreach ($dataId->price_lists as $price)
                <tr>                    
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        {{ $price->title ?? null }}
                    </td>
                    <td class="align-middle">
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

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="d-flex align-items-center justify-content-end">
        <a href="#" data-bs-toggle="modal" data-bs-target="#ti_modal_add_quota"
            class="btn btn-primary d-flex align-items-center gap-2">
            <img src="assets/crm/media/svg/crm/add-circle.svg" alt="Thêm báo giá"
                width="18" height="18" />
            <span>Thêm thông báo học phí</span>
        </a>
    </div> --}}
</div>
<!--end::Học phí-->

<script type="module" src="/assets/crm/js/htecomJs/updateNotePriceList.js"></script>
