<div class="tab-pane fade" id="transactions" role="tabpanel"
    aria-labelledby="transactions-tab">
    <div class="table-responsive position-relative border rounded-3 my-3">
        <!--begin::Table-->
        <table
            class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0">
            <!--begin::Table head-->
            <thead>
                <tr class="bg-primary text-white">
                    <th class="w-40px"></th>
                    <th class="text-nowrap fs-5 text-center min-w-50px">ID</th>
                    <th class="text-nowrap fs-5 text-center min-w-50px">Mã học phí</th>
                    <th class="text-nowrap fs-5 text-start min-w-200px">Nội dung</th>
                    <th class="text-nowrap fs-5 text-start">Số tiền (VND)</th>
                    <th class="text-nowrap fs-5 text-start">Ngày giao dịch</th>
                    <th class="text-nowrap fs-5 text-start">Tình trạng thanh toán</th>
                </tr>
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody>
                @foreach ($dataId->transactions as $transaction)
                <tr>
                    <td class="align-middle text-center ps-4">
                        <div class="form-check form-check-sm">
                            <input class="form-check-input inrow-checkbox"
                                type="checkbox" value="" id="flexCheckDefault">
                        </div>
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        #{{ $transaction->code ?? '' }}
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        #{{ $transaction->price_lists->code ?? '' }}
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        {{ $transaction->name ?? '' }}
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        {{ number_format($transaction->price, 0, ',', '.') }}
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        <div class="d-flex justify-content-start flex-column">
                            <span class="d-flex gap-1 align-items-center d-block fs-7">
                                <i class="text-primary">
                                    <svg width="14" height="14"
                                        viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4.52085 1.45837C4.52085 1.21675 4.32498 1.02087 4.08335 1.02087C3.84173 1.02087 3.64585 1.21675 3.64585 1.45837V2.37961C2.80624 2.44684 2.25505 2.61184 1.8501 3.01679C1.44516 3.42174 1.28015 3.97293 1.21292 4.81254H12.7871C12.7199 3.97293 12.5549 3.42174 12.1499 3.01679C11.745 2.61184 11.1938 2.44684 10.3542 2.37961V1.45837C10.3542 1.21675 10.1583 1.02087 9.91669 1.02087C9.67506 1.02087 9.47919 1.21675 9.47919 1.45837V2.3409C9.09112 2.33337 8.65612 2.33337 8.16669 2.33337H5.83335C5.34392 2.33337 4.90893 2.33337 4.52085 2.3409V1.45837Z"
                                            fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.16669 7.00004C1.16669 6.5106 1.16669 6.07561 1.17421 5.68754H12.8258C12.8334 6.07561 12.8334 6.5106 12.8334 7.00004V8.16671C12.8334 10.3666 12.8334 11.4665 12.1499 12.15C11.4665 12.8334 10.3666 12.8334 8.16669 12.8334H5.83335C3.63347 12.8334 2.53352 12.8334 1.8501 12.15C1.16669 11.4665 1.16669 10.3666 1.16669 8.16671V7.00004ZM9.91669 8.16671C10.2389 8.16671 10.5 7.90554 10.5 7.58337C10.5 7.26121 10.2389 7.00004 9.91669 7.00004C9.59452 7.00004 9.33335 7.26121 9.33335 7.58337C9.33335 7.90554 9.59452 8.16671 9.91669 8.16671ZM9.91669 10.5C10.2389 10.5 10.5 10.2389 10.5 9.91671C10.5 9.59454 10.2389 9.33337 9.91669 9.33337C9.59452 9.33337 9.33335 9.59454 9.33335 9.91671C9.33335 10.2389 9.59452 10.5 9.91669 10.5ZM7.58335 7.58337C7.58335 7.90554 7.32219 8.16671 7.00002 8.16671C6.67785 8.16671 6.41669 7.90554 6.41669 7.58337C6.41669 7.26121 6.67785 7.00004 7.00002 7.00004C7.32219 7.00004 7.58335 7.26121 7.58335 7.58337ZM7.58335 9.91671C7.58335 10.2389 7.32219 10.5 7.00002 10.5C6.67785 10.5 6.41669 10.2389 6.41669 9.91671C6.41669 9.59454 6.67785 9.33337 7.00002 9.33337C7.32219 9.33337 7.58335 9.59454 7.58335 9.91671ZM4.08335 8.16671C4.40552 8.16671 4.66669 7.90554 4.66669 7.58337C4.66669 7.26121 4.40552 7.00004 4.08335 7.00004C3.76119 7.00004 3.50002 7.26121 3.50002 7.58337C3.50002 7.90554 3.76119 8.16671 4.08335 8.16671ZM4.08335 10.5C4.40552 10.5 4.66669 10.2389 4.66669 9.91671C4.66669 9.59454 4.40552 9.33337 4.08335 9.33337C3.76119 9.33337 3.50002 9.59454 3.50002 9.91671C3.50002 10.2389 3.76119 10.5 4.08335 10.5Z"
                                            fill="#034EA2" />
                                    </svg>
                                </i>

                                {{ \Carbon\Carbon::parse($transaction->tran_date)->format('d/m/Y') }}
                            </span>
                            {{-- <span class="d-flex gap-1 align-items-center d-block fs-7">
                                <i class="text-primary">
                                    <svg width="14" height="14"
                                        viewBox="0 0 14 14" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12.8334 6.99996C12.8334 10.2216 10.2217 12.8333 7.00002 12.8333C3.77836 12.8333 1.16669 10.2216 1.16669 6.99996C1.16669 3.7783 3.77836 1.16663 7.00002 1.16663C10.2217 1.16663 12.8334 3.7783 12.8334 6.99996Z"
                                            fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M7.00002 4.22913C7.24165 4.22913 7.43752 4.425 7.43752 4.66663V6.81874L8.76771 8.14893C8.93857 8.31979 8.93857 8.5968 8.76771 8.76765C8.59686 8.93851 8.31985 8.93851 8.14899 8.76765L6.69066 7.30932C6.60861 7.22727 6.56252 7.11599 6.56252 6.99996V4.66663C6.56252 4.425 6.7584 4.22913 7.00002 4.22913Z"
                                            fill="white" />
                                    </svg>

                                </i>
                                {{ \Carbon\Carbon::parse($transaction->tran_time)->format('H:i') }}
                            </span> --}}
                        </div>
                    </td>
                    <td class="align-middle text-start px-2 px-md-4 py-4">
                        <span class="text-primary">
                            {{ $transaction->status->name }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- <div class="d-flex align-items-center justify-content-end">
        <a href="{{ route('crm.lead.transaction', ['id' => $dataId->id]) }}"
            class="btn btn-primary d-flex align-items-center gap-2">
            <img src="assets/crm/media/svg/crm/add-circle.svg" alt="Thêm báo giá"
                width="18" height="18" />
            <span>Thêm giao dịch</span>
        </a>
    </div> --}}
</div>