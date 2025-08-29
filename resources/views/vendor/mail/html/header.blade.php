@props(['url'])

<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }} Logo"
                style="max-width: 150px; height: auto; margin-bottom: 10px;">
            <h1 style="color: #3d4852; font-size: 19px; font-weight: bold; margin: 0;">{{ config('app.name') }}</h1>
        </a>
    </td>
</tr>