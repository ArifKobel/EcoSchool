EcoSchool
{{ str_repeat('=', 50) }}

{{-- Greeting --}}
@if (! empty($greeting ?? ''))
{{ $greeting }}
@else
Hallo!
@endif

{{ str_repeat('-', 30) }}

{{-- Intro Lines --}}
@if(isset($introLines) && is_array($introLines))
@foreach ($introLines as $line)
{{ $line }}

@endforeach
@endif

{{-- Action Button --}}
@isset($actionText)
{{ $actionText }}: {{ $actionUrl ?? '' }}

{{-- Custom German Trouble Clicking Message --}}
Falls Sie Schwierigkeiten haben, auf den Button "{{ $actionText }}" zu klicken,
kopieren Sie die folgende URL und fügen Sie sie in Ihren Webbrowser ein:
{{ $actionUrl ?? '' }}

{{ str_repeat('-', 30) }}
@endisset

{{-- Outro Lines --}}
@if(isset($outroLines) && is_array($outroLines))
@foreach ($outroLines as $line)
{{ $line }}

@endforeach
@endif

{{-- Salutation --}}
@if (! empty($salutation ?? ''))
{{ $salutation }}
@else
Mit freundlichen Grüßen,
EcoSchool Team
@endif

{{ str_repeat('=', 50) }}
© {{ date('Y') }} EcoSchool. Alle Rechte vorbehalten.
