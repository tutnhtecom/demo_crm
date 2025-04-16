@php 
    $title    = config("data.email_template.title");
    $table_1  = config("data.email_template.table_1");
    $table_2  = config("data.email_template.table_2");
    $table_3  = config("data.email_template.table_3");
@endphp
<div class="modal key_email_template" id="key_email_template" tabindex="-1" aria-labelledby="createExampleEmailModalLabel" style="left:150px; top:80px;display:none;">
    <div class="modal-dialog modal_wrapper modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Danh sách key của mẫu Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Bảng 1 -->
                    <div class="col-lg-4 col-md-4">
                        <table style="border-bottom: 1px solid;" class="table table-striped table-bordered table-hover table-secondary">
                            <thead>
                                <tr>
                                    <td class="text-center"> {{ $title["note"]}}</td>
                                    <td class="text-center"> {{ $title["key"]}}</td>
                                </tr>        
                            </thead>
                            <tbody>
                                @if(isset($table_1) && is_array($table_1) && count($table_1) > 0)
                                    @foreach ($table_1 as $value)
                                        <tr>
                                            <td>{{$value["note"]}} </td>
                                            <td>{{$value["key"]}}</td>
                                        </tr>        
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Bảng 2 -->
                    <div class="col-lg-4 col-md-4">
                        <table style="border-bottom: 1px solid;" class="table table-striped table-bordered table-hover table-secondary">
                            <thead>
                                <tr>
                                    <td class="text-center"> {{ $title["note"]}}</td>
                                    <td class="text-center"> {{ $title["key"]}}</td>
                                </tr>        
                            </thead>
                            <tbody>
                                @if(isset($table_2) && is_array($table_2) && count($table_2) > 0)
                                    @foreach ($table_2 as $value)
                                        <tr>
                                            <td>{{$value["note"]}} </td>
                                            <td>{{$value["key"]}}</td>
                                        </tr>        
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <table style="border-bottom: 1px solid;" class="table table-striped table-bordered table-hover table-secondary">
                            <thead>
                                <tr>
                                    <td class="text-center"> {{ $title["note"]}}</td>
                                    <td class="text-center"> {{ $title["key"]}}</td>
                                </tr>        
                            </thead>
                            <tbody>
                                @if(isset($table_3) && is_array($table_3) && count($table_3) > 0)
                                    @foreach ($table_3 as $value)
                                        <tr>
                                            <td>{{$value["note"]}} </td>
                                            <td>{{$value["key"]}}</td>
                                        </tr>        
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- @include('crm.content.systemConfig.table_key_for_email_template') -->
            </div>           
        </div>
    </div>
</div>
