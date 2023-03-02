@component('mail::message')
{{ __('This is an automated message indicating that a comment has been posted on your ticket. Please login to the support portal to view the comment.') }}

@component('mail::button', ['url' => $url])
{{ __('View Comment') }}
@endcomponent

{{ __('Thanks,') }}<br>
{{ $generalSettings->site_name ?? config('app.name') }}
@endcomponent
