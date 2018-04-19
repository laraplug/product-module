@php
    if(empty($elemAttributes['class'])) $elemAttributes['class'] = [];
    $elemAttributes['class'] .= ' datepicker';

    if(empty($elemAttributes['data-date-format'])) $elemAttributes['data-date-format'] = 'yyyy-mm-dd';
@endphp
{!! Form::text($elemAttributes['name'], old("options.$option->slug"), $elemAttributes) !!}
