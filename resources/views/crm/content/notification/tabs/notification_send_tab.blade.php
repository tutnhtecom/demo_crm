<div class="tab-pane fade" id="send" role="tabpanel" aria-labelledby="latest-tab">
    <div class="table-responsive position-relative border rounded-3 my-3">
        <table id="notification_table_send" class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100">
            <thead>
            <tr class="bg-primary text-white">
                    <th class="w-40px text-center">STT</th>
                    <th class="text-nowrap align-middle fs-5 text-start">Thời gian</th>
                    <th class="text-nowrap align-middle fs-5 text-start w-300px">Tiêu đề</th>
                    <th class="text-nowrap align-middle fs-5 text-start">Người tạo</th>
                    <th class="text-nowrap align-middle fs-5 text-start">Người nhận</th>
                </tr>
            </thead>
            <tbody>
                @php $countSend = 1; @endphp
                @foreach ($data['notificationsSend'] as $notificationSend)                
                <tr>
                    <td class="align-middle px-2 px-md-4 py-4">{{$countSend++}}</td>
                    <td class="align-middle px-2 px-md-4 py-4">{{ \Carbon\Carbon::parse($notificationSend["created_at"])->setTimezone("+7")->format('H:i') }} • {{ \Carbon\Carbon::parse($notificationSend["created_at"])->setTimezone("+7")->format('d/m/Y') }}</td>
                    <td class="align-middle px-2 px-md-4 py-4">{!! $notificationSend["title"] !!}</td>
                    <td class="align-middle px-2 px-md-4 py-4">
                        <span>{{ $notificationSend["sender"] ?? null }}</span>
                        <br>
                        <span style="font-style:italic;">{{($notificationSend["create_by"]['email']) ?? null}}</span>
                    </td>
                    <td class="align-middle px-2 px-md-4 py-4">
                        <span>{{$notificationSend["noti_receiver"] ?? ''}}</span>
                        <br>
                        <span style="font-style:italic;">{{($notificationSend["email"]) ?? ''}}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>