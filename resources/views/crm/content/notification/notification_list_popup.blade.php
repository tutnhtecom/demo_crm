@if (empty($data))
    <div class="d-flex flex-nowrap gap-2 border border-gray-200 bg-white shadow-sm rounded-3 p-2">
        <p class="p-5">Không có thông báo nào</p>
    </div>
@else
    @foreach ($data as $notification)
        <div class="menu-link px-5">
            <h3 class="mb-2">{{ $notification->title }}</h3>
            <p class="text-base">
                {!! \Illuminate\Support\Str::limit(strip_tags($notification->content), 400) !!}
            </p>
            <span class="d-flex align-items-center gap-1 text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path
                        d="M6.99984 3.5V7L9.33317 8.16666M12.8332 7C12.8332 10.2217 10.2215 12.8333 6.99984 12.8333C3.77818 12.8333 1.1665 10.2217 1.1665 7C1.1665 3.77834 3.77818 1.16666 6.99984 1.16666C10.2215 1.16666 12.8332 3.77834 12.8332 7Z"
                        stroke="#7E7E7E" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                {{ \Carbon\Carbon::parse($notification->created_at)->format('H:i') }} • {{ \Carbon\Carbon::parse($notification->created_at)->format('d/m/Y') }}
            </span>
        </div>

    @endforeach
@endif
