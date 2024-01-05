@foreach($data as $day => $value)
<b>{{$day}}</b> <b>{{collect($value->first())->first()['full_date']}}</b>

@foreach($value as $key => $pars)
{{ $key }} {{ $pars->first()['study_time_begin'] }} - {{ $pars->first()['study_time_end'] }}
@foreach($pars as $para)
@if(count($pars) < 2 and $pars->first()['study_subgroup'] === null)
    [{{$para['study_type']}}] {{$para['discipline']}}
        {{$para['cabinet']}}, {{$para['employee']}}
@elseif(count($pars) == 2)
    {{$para['study_subgroup']}} гр.:[{{$para['study_type']}}] {{$para['discipline']}}
        {{$para['cabinet']}}, {{$para['employee']}}
@elseif(count($pars) < 2 && $pars->first()['study_subgroup'] == 1)
    {{$para['study_subgroup']}} гр.:[{{$para['study_type']}}] {{$para['discipline']}}
        {{$para['cabinet']}}, {{$para['employee']}}
    2 гр.: —
@elseif(count($pars) < 2 && $pars->first()['study_subgroup'] == 2)
    1 гр.: —
    {{$para['study_subgroup']}} гр.:[{{$para['study_type']}}] {{$para['discipline']}}
        {{$para['cabinet']}}, {{$para['employee']}}
@else
    {{$para['study_subgroup']}} гр.:[{{$para['study_type']}}] {{$para['discipline']}}
        {{$para['cabinet']}}, {{$para['employee']}}
@endif
@endforeach

@endforeach
@endforeach
