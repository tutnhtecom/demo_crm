<div class="tab-pane fade" id="draft" role="tabpanel" aria-labelledby="latest-tab">
    <div class="table-responsive position-relative border rounded-3 my-3">
        <!--begin::Table-->
        <table id="notification_table_draft" class="table table-sm table-striped table-crm table-row-devider-300 bordered rounded-3 m-0 w-100">
            <!--begin::Table head-->
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
                @php $countDraft = 1; @endphp
                @foreach ($data['notificationsDraft'] as $notificationDraft)
                <tr>
                    <td class="align-middle px-2 px-md-4 py-4">{{$countDraft++}}</td>
                    <td class="align-middle px-2 px-md-4 py-4">{{ \Carbon\Carbon::parse($notificationDraft["created_at"])->setTimezone("+7")->format('H:i') }} • {{ \Carbon\Carbon::parse($notificationDraft["created_at"])->setTimezone("+7")->format('d/m/Y') }}</td>
                    <td class="align-middle px-2 px-md-4 py-4">{!! $notificationDraft["title"] !!}</td>
                    <td class="align-middle px-2 px-md-4 py-4">
                        <span>{{ $notificationDraft["sender"] ?? null }}</span>
                        <br>
                        <span style="font-style:italic;">{{($notificationDraft["create_by"]['email']) ?? null}}</span>
                    </td>
                    <td class="align-middle px-2 px-md-4 py-4">
                        <span>{{$notificationDraft["noti_receiver"] ?? ''}}</span>
                        <br>
                        <span style="font-style:italic;">{{($notificationDraft["email"]) ?? ''}}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>