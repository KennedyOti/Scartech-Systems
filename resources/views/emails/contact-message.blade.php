<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>Website enquiry</title></head>
<body style="margin:0;padding:24px;background:#F4F6F8;font-family:Arial,Helvetica,sans-serif;color:#363F4E;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px;margin:0 auto;background:#FFFFFF;border:1px solid #D8DEE7;border-radius:8px;">
        <tr><td style="padding:24px 28px;border-bottom:3px solid #3560BC;">
            <p style="margin:0;font-size:13px;color:#66738A;">New message from the website contact form</p>
            <h1 style="margin:6px 0 0;font-size:20px;color:#141A23;">{{ $contactMessage->subject ?? 'General enquiry' }}</h1>
        </td></tr>
        <tr><td style="padding:20px 28px;">
            <table role="presentation" width="100%" cellpadding="6" cellspacing="0" style="font-size:15px;">
                <tr><td style="color:#66738A;width:110px;">Name</td><td style="color:#141A23;">{{ $contactMessage->name }}</td></tr>
                <tr><td style="color:#66738A;">Company</td><td style="color:#141A23;">{{ $contactMessage->company ?: '—' }}</td></tr>
                <tr><td style="color:#66738A;">Email</td><td><a href="mailto:{{ $contactMessage->email }}" style="color:#3560BC;">{{ $contactMessage->email }}</a></td></tr>
                <tr><td style="color:#66738A;">Phone</td><td><a href="{{ Str::telHref($contactMessage->phone) }}" style="color:#3560BC;">{{ $contactMessage->phone }}</a></td></tr>
            </table>
            <p style="margin:20px 0 6px;font-size:13px;color:#66738A;">Message</p>
            <div style="font-size:15px;line-height:1.6;color:#141A23;white-space:pre-line;">{{ $contactMessage->message }}</div>
        </td></tr>
        <tr><td style="padding:14px 28px;border-top:1px solid #D8DEE7;font-size:12px;color:#8894A6;">
            Received {{ $contactMessage->created_at?->timezone('Africa/Nairobi')->format('j M Y, H:i') }} EAT. Reply to this email to respond directly. Record #{{ $contactMessage->id }}.
        </td></tr>
    </table>
</body>
</html>
