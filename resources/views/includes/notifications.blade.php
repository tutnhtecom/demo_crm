<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
</head>
<body>        
    <h3><strong>{{$title}}</strong></h3>        
     @if (isset($content) && is_array($content) && count($content) > 0)        
        @foreach ($content as $c)
            <p style="text-align: justify;">{!! $c !!}</p>
        @endforeach
     @else
            <span style="text-align: justify;">{!! $content !!}</span>
     @endif
    <h3>Trân trọng!</h3>    
</body>
</html>