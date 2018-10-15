@php
    $elemAttributes[] = 'datepicker';

    if(empty($elemAttributes['data-date-min-view-mode'])) $elemAttributes['data-date-min-view-mode'] = 'years';
    if(empty($elemAttributes['data-date-format'])) $elemAttributes['data-date-format'] = 'yyyy';
@endphp
{!! Form::text($elemAttributes['name'], old("options.$option->slug"), $elemAttributes) !!}
