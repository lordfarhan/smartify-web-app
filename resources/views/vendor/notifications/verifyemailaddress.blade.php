@component('mail::message')
{{-- Greeting --}}
@if (! empty($data['greeting']))
# {{ $data['greeting'] }}
@else
@if ($data['level'] === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($data['introLines'] as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($data['actionText'])
<?php
    switch ($data['level']) {
        case 'success':
        case 'error':
            $color = $data['level'];
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $data['actionUrl'], 'color' => $color])
{{ $data['actionText'] }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($data['outroLines'] as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($data['salutation']))
{{ $data['salutation'] }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($data['actionText'])
@slot('subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => $data['actionText'],
    ]
) <span class="break-all">{{ $data['actionUrl'] }}</span>
@endslot
@endisset
@endcomponent
