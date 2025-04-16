<tr class="text-end" >    
    <th></th>    
    <td colspan="5">
        <a class="btn_add_sources_rate btn btn-md btn-primary lh-1 align-items-center gap-1"
            data-bs-toggle="modal" data-bs-target="#sourceRateCreateModal"
            data-id="{{ $document['id'] }}">
            <span>Thêm Khoản chi</span>
        </a>
    </td>
</tr>
@if (isset($sources_rate) && count($sources_rate[$document['id']]) > 0)
<tr>
    <th></th>    
    <td colspan="5">
        <div>
        <!-- table-striped -->
            <table class="table table-sm  table-crm table-row-devider-300 bordered rounded-3 m-0" id="table_expense" cellspacing="0" cellpadding="5">            
                <thead>
                    <tr class="bg-primary text-white">
                        <th class="text-nowrap fs-6 text-center text-white">Khoản chi</th>
                        <th class="text-nowrap fs-6 text-center text-white">Điều kiện thanh toán</th>
                        <th class="text-nowrap fs-6 text-center text-white">Định mức thanh toán</th>                        
                        <th class="text-nowrap fs-6 text-center text-white">Học kỳ</th>
                        <th class="text-nowrap fs-6 text-center text-white">Thời gian thực hiện thanh toán</th>
                        <th class="text-nowrap fs-6 text-center text-white" style="padding-right:5px!important;">Chức năng</th>
                    </tr>                 
                </thead>
                <tbody>
                    {{-- {{dd($sources_rate[$document['id']])}} --}}
                    @foreach ($sources_rate[$document['id']] as $key => $item)
                        <tr style="border-bottom:1px solid #ccc!important;" >
                            <td class="align-middle text-center px-md-2">{{ $item['expense_name'] }}</td>
                            <td class="align-middle text-center px-md-2">
                                {{ $item['math_sign'] }}{{ $item['payment_condition'] }} 
                                {{ isset($item['payment_terms_note']) ? $item['payment_terms_note'] : '' }}
                            </td>                            
                            <td class="align-middle text-center px-2 px-md-2 ">
                                <div style="border-bottom:1px dotted #ccc!important;" class="pb-2">
                                       {{ $item['payment_rate']  ? $item['payment_rate'] . '%' : 'vnđ' }}
                                    <br>{{ $item['payment_manager_price'] ? '(' . number_format($item['payment_manager_price'], 0, ',', '.') . 'vnđ)' : '' }}
                                </div>
                                <div class="py-2">
                                    {{ $item['payment_manager_rate'] . '%' }}   
                                </div>
                            </td>                            
                            <td class="align-middle text-center px-md-2" >{{ $item['semesters']['note'] ?? '' }}</td>
                            <td class="align-middle text-center px-md-2" >{{ $item['payment_note'] ?? '' }}</td>
                            <td class="align-middle text-center px-md-2" >
                                <button class="btn btn-ghost p-1 icon_edit_sources_rate" id="btn-edit-sources-rate"
                                    data-id="{{ $item['id'] }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sourceRateEditModal"
                                    data-expense-name="{{ $item['expense_name'] }}"
                                    data-payment-condition="{{ $item['payment_condition']}}"
                                    data-math-sign="{{ $item['math_sign'] }}"
                                    data-payment-rate="{{ $item['payment_rate'] }}"                                    
                                    data-payment-note="{{ $item['payment_note'] }}"                                    
                                    data-payment-terms-note="{{ $item['payment_terms_note'] }}"                                    
                                    data-payment-manager-rate="{{ $item['payment_manager_rate'] }}"
                                    data-payment-manager-price="{{ $item['payment_manager_price'] }}"                                    
                                    data-sources-id="{{$item['sources_id']}}" 
                                    data-sources-documents-id="{{$item['sources_documents_id']}}"
                                    data-academic-terms-id="{{$item['academic_terms_id'] ?? ''}}"
                                    data-semesters-id="{{ $item['semesters_id'] ?? '' }}">
                                     <img src="/assets/crm/media/svg/crm/edit.svg"
                                     alt="Sửa" width="18" height="18" />
                                </button>
                                <button type="button"
                                    class="btn_delete_sources_rate btn btn-ghost p-1"
                                    data-id="{{ $item['id'] }}"
                                    data-ti-row-confirm-message="Xóa hợp đồng này?"
                                    data-ti-button-action="row-remove"
                                    data-ti-row-confirm="true" data-bs-toggle="modal"
                                    data-bs-target="#sourcesRateModalDelete">
                                    <img src="assets/crm/media/svg/crm/delete.svg" alt="Xóa" width="18" height="18">
                                </button>
                            </td>
                        </tr>       
                        <!-- style="border-top:1px solid #ccc!important;" -->
                                   
                    @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>
@endif


