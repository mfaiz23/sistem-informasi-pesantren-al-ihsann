<x-mail::message>
{{-- Greeting (Salam Pembuka) --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Assalamualaikum,
@endif

{{-- Intro Lines (Isi Email) --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button (Tombol Aksi) --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines (Baris Penutup) --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation (Salam Penutup) --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Hormat kami,<br>
Panitia PSB Pesantren Al-Ihsan
@endif

{{-- Subcopy (Teks Bantuan) --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Jika Anda kesulitan menekan tombol \":actionText\", salin dan tempel URL di bawah ini\n".
    'ke dalam browser web Anda:',
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
```

