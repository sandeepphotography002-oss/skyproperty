@php
    $s = config('site');
    $e = $enquiry;

    /* Log number kaise bhi likhte hain. wa.me sirf saaf digits leta hai. */
    $digits = ltrim(preg_replace('/\D/', '', (string) $e->phone), '0');
    $wa     = str_starts_with($digits, '91') ? $digits : '91' . $digits;
@endphp
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>New enquiry — {{ $e->name }}</title>
</head>
{{-- Email clients apni CSS file nahi padhte, isliye style seedha tag par
     hai. Table isliye ki Outlook aaj bhi grid theek se nahi dikhata. --}}
<body style="margin:0;padding:24px;background:#f4f6f2;font:15px/1.6 Arial,Helvetica,sans-serif;color:#1c2419">

<div style="max-width:560px;margin:0 auto;background:#fff;border:1px solid #e0e4da;border-radius:12px;overflow:hidden">

  <div style="background:#51873f;color:#fff;padding:18px 22px">
    <div style="font-size:12px;letter-spacing:.08em;text-transform:uppercase;opacity:.85">
      {{ $s['name'] }}
    </div>
    <div style="font-size:19px;font-weight:bold;margin-top:3px">New enquiry</div>
  </div>

  <div style="padding:22px">

    <table cellpadding="0" cellspacing="0" style="width:100%;font-size:15px">
      <tr>
        <td style="padding:7px 0;color:#616b5c;width:110px">Name</td>
        <td style="padding:7px 0;font-weight:bold">{{ $e->name }}</td>
      </tr>
      <tr>
        <td style="padding:7px 0;color:#616b5c">Phone</td>
        <td style="padding:7px 0">
          <a href="tel:{{ $e->phone }}" style="color:#51873f;font-weight:bold;text-decoration:none">{{ $e->phone }}</a>
        </td>
      </tr>
      @if($e->email)
      <tr>
        <td style="padding:7px 0;color:#616b5c">Email</td>
        <td style="padding:7px 0"><a href="mailto:{{ $e->email }}" style="color:#51873f">{{ $e->email }}</a></td>
      </tr>
      @endif
      @if($e->budget)
      <tr>
        <td style="padding:7px 0;color:#616b5c">Budget</td>
        <td style="padding:7px 0">{{ $e->budget }}</td>
      </tr>
      @endif
      @if($e->property_title)
      <tr>
        <td style="padding:7px 0;color:#616b5c">Property</td>
        <td style="padding:7px 0">{{ $e->property_title }}</td>
      </tr>
      @endif
      <tr>
        <td style="padding:7px 0;color:#616b5c">When</td>
        <td style="padding:7px 0">{{ $e->created_at?->format('d M Y, g:i A') }}</td>
      </tr>
    </table>

    @if($e->message)
      <div style="margin-top:16px;background:#f4f6f2;border-left:3px solid #51873f;padding:13px 15px;border-radius:0 8px 8px 0">
        {!! nl2br(e($e->message)) !!}
      </div>
    @endif

    <div style="margin-top:22px">
      <a href="tel:{{ $e->phone }}"
         style="display:inline-block;background:#51873f;color:#fff;text-decoration:none;
                padding:11px 20px;border-radius:8px;font-weight:bold;margin-right:8px">
        Call {{ $e->name }}
      </a>
      <a href="https://wa.me/{{ $wa }}"
         style="display:inline-block;background:#25d366;color:#fff;text-decoration:none;
                padding:11px 20px;border-radius:8px;font-weight:bold">
        WhatsApp
      </a>
    </div>

    @if($e->source_page)
      <div style="margin-top:18px;font-size:13px;color:#616b5c">
        Came from <a href="{{ $e->source_page }}" style="color:#616b5c">{{ $e->source_page }}</a>
      </div>
    @endif

  </div>

  <div style="border-top:1px solid #e0e4da;padding:14px 22px;font-size:13px;color:#616b5c">
    Also saved in the dashboard &mdash;
    <a href="{{ route('admin.enquiries.index') }}" style="color:#51873f">open enquiries</a>
  </div>

</div>
</body>
</html>
