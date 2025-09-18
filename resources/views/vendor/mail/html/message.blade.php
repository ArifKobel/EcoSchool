<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoSchool</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">

    {{-- Header --}}
    <div style="text-align: center; margin-bottom: 30px; padding: 20px; background-color: #f8f9fa; border-radius: 8px;">
        <h1 style="color: #2c3e50; margin: 0; font-size: 24px;">EcoSchool</h1>
    </div>

    {{-- Greeting --}}
    @if (! empty($greeting ?? ''))
    <h2 style="color: #2c3e50; margin: 30px 0 20px 0;">{{ $greeting }}</h2>
    @else
    <h2 style="color: #2c3e50; margin: 30px 0 20px 0;">Hallo!</h2>
    @endif

    {{-- Intro Lines --}}
    @if(isset($introLines) && is_array($introLines))
        @foreach ($introLines as $line)
        <p style="margin: 15px 0; font-size: 16px;">{{ $line }}</p>
        @endforeach
    @endif

    {{-- Action Button --}}
    @isset($actionText)
    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $actionUrl ?? '#' }}"
           style="background-color: #3498db; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            {{ $actionText }}
        </a>
    </div>
    @endisset

    {{-- Custom German Trouble Clicking Message --}}
    @isset($actionText)
    <div style="margin: 30px 0; padding: 20px; background-color: #f8f9fa; border-radius: 5px;">
        <p style="color: #6B7280; font-size: 14px; line-height: 1.5; margin: 0 0 10px 0;">
            Falls Sie Schwierigkeiten haben, auf den Button "{{ $actionText }}" zu klicken, kopieren Sie die folgende URL und fügen Sie sie in Ihren Webbrowser ein:
        </p>
        <p style="margin: 0; word-break: break-all;">
            <a href="{{ $actionUrl ?? '#' }}" style="color: #3498db; text-decoration: none;">{{ $actionUrl ?? '' }}</a>
        </p>
    </div>
    @endisset

    {{-- Outro Lines --}}
    @if(isset($outroLines) && is_array($outroLines))
        @foreach ($outroLines as $line)
        <p style="margin: 15px 0; font-size: 16px;">{{ $line }}</p>
        @endforeach
    @endif

    {{-- Salutation --}}
    @if (! empty($salutation ?? ''))
    <p style="margin: 30px 0 10px 0; font-weight: bold;">{{ $salutation }}</p>
    @else
    <p style="margin: 30px 0 10px 0; font-weight: bold;">Mit freundlichen Grüßen,<br>EcoSchool Team</p>
    @endif

    {{-- Footer --}}
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #6B7280; font-size: 12px;">
        <p style="margin: 5px 0;">© {{ date('Y') }} EcoSchool. Alle Rechte vorbehalten.</p>
    </div>
</body>
</html>
