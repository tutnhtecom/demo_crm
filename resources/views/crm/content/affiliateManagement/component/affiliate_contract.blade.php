<div class="tab-pane fade show active" id="activities-history" role="tabpanel" aria-labelledby="activities-history-tab">
    <div style="width: max-content;">
        <a class="btn btn-sm btn-primary lh-0 d-flex align-items-center gap-1" data-bs-toggle="modal"
            data-bs-target="#contractCreateModal{{ $data['id'] }}">
            <img src="assets/crm/media/svg/crm/add-circle.svg" width="22" height="22" />
            <span class="d-none d-md-block">Thêm Hợp đồng mới</span>
        </a>
        @include('crm.content.affiliateManagement.affiliate_modal_create_contract')
    </div>
    <div class="table-responsive position-relative border rounded-3 my-3">
        <table class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0" id="table_expense">
            <thead>
                <tr class="bg-primary text-white">
                    <th class="text-nowrap fs-5 text-center ">STT</th>
                    <th class="text-nowrap fs-5 text-center pe-7">Mã hợp đồng</th>
                    <th class="text-nowrap fs-5 text-center pe-7">Văn bản ký kết</th>
                    <th class="text-nowrap fs-5 text-center pe-7">Nội dung hợp tác</th>
                    <th class="text-nowrap fs-5 text-center pe-7">Ngày bắt đầu</th>
                    <th class="text-nowrap fs-5 text-center pe-7">Ngày kết thúc</th>
                    <th class="text-nowrap fs-5 text-center pe-3">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['sources_documents'] as $k => $document)
                <!-- Hiển thị data của hợp đồng -->
                <!-- ----------------------------------------------------------------------  -->
                <tr>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        <!-- #{{ $document['id'] }} -->
                         {{$k+1}}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        {{ $document['code'] }}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        {{ $document['signed_document'] }}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        {{ $document['signed_content'] }}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        {{ \Carbon\Carbon::parse($document['signed_from_date'])->format('d/m/Y') }}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        {{ \Carbon\Carbon::parse($document['signed_to_date'])->format('d/m/Y') }}
                    </td>
                    <td class="align-middle text-center fs-5 px-2 px-md-4 py-4">
                        <button class="btn btn-ghost p-1 contract_edit_modal" data-bs-toggle="modal"
                            data-bs-target="#contractEditModal"
                            data-signed-document="{{ $document['signed_document'] }}"
                            data-signed-content="{{ $document['signed_content'] }}"
                            data-signed-from-date="{{ $document['signed_from_date'] }}"
                            data-signed-to-date="{{ $document['signed_to_date'] }}"
                            data-id="{{ $document['id'] }}">
                            <img src="/assets/crm/media/svg/crm/edit.svg" alt="Sửa" width="18"
                                height="18" />
                        </button>

                        <button type="button" class="btn btn-ghost p-1" data-document-id="{{ $document['id'] }}"
                            data-ti-row-confirm-message="Xóa hợp đồng này?" data-ti-button-action="row-remove"
                            data-ti-row-confirm="true" data-bs-toggle="modal"
                            data-bs-target="#documentModalDelete{{ $document['id'] }}">
                            <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18"
                                height="18">
                        </button>
                        @include('crm.content.affiliateManagement.affiliate_modal_delete_document')

                    </td>
                </tr>
                <!-- ----------------------------------------------------------------------  -->
                <!-- Phần hiển thị data của khoản chi -->
                @include('crm.content.affiliateManagement.component.affiliate_sources_rate_table')                
                <!-- ----------------------------------------------------------------------  -->
                @endforeach
            </tbody>
        </table>
    </div>
</div>