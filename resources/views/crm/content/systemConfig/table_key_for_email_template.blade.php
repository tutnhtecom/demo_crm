@php 
    $title    = config("data.email_template.title");
    $table_1  = config("data.email_template.table_1");
    $table_2  = config("data.email_template.table_2");
    $table_3  = config("data.email_template.table_3");
@endphp

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