<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Teacher Profile Mailer</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9;padding:40px 0;">
<tr>
<td align="center">

<table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;">

    <!-- Header -->
    <!--<tr>-->
    <!--    <td style="background:#0d6efd;padding:30px;text-align:center;">-->
    <!--        <h1 style="margin:0;color:#ffffff;font-size:28px;">A Teacher Is Interested in Your Job</h1>-->
    <!--        <p style="margin:10px 0 0;color:#dbe8ff;font-size:16px;">-->
    <!--            Teachinghood Candidate Recommendation-->
    <!--        </p>-->
    <!--    </td>-->
    <!--</tr>-->

    <!-- Intro -->
    <tr>
        <td style="padding:35px;">

            <p style="font-size:16px;line-height:28px;margin-top:0;">
                Hello Hiring Team,
            </p>

            <p style="font-size:16px;line-height:28px;">
                A teacher has recently shown interest in your open position: {{ $job->position }}.
            </p>

            <p style="font-size:16px;line-height:28px;">
                We understand this job may have been posted some time ago. If you're still reviewing applications or haven't finalized your hiring decision, we'd like to introduce a candidate who could be a great fit.
            </p>

            <p style="font-size:16px;line-height:28px;margin-bottom:30px;">
                Below is a quick profile summary to help you evaluate the candidate at a glance.
            </p>

        </td>
    </tr>

    <!-- Candidate Card -->
    <tr>
        <td style="padding:0 35px 35px;">

            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e6e6e6;border-radius:12px;background:#ffffff;">

                <tr>
                    <td style="padding:25px;">

                        <table width="100%">
                            <tr>

                                <td width="90" valign="top">
                                    @if($job->applied->user->avatar_url)
                                    <img src="https://teaching-hood-backend.netcraftglobal.com/storage/{{ $job->applied->user->avatar_url }}"
                                         width="80"
                                         height="80"
                                         style="border-radius:50%;border:3px solid #0d6efd;">
                                    @else
                                    <img src="https://teaching-hood-backend.netcraftglobal.com/default-avatar.png"
                                         width="80"
                                         height="80"
                                         style="border-radius:50%;border:3px solid #0d6efd;">
                                    @endif
                                </td>

                                <td valign="top">

                                    <div style="font-size:24px;font-weight:bold;color:#0d6efd;">
                                        {{ $job->applied->user->first_name }}
                                        {{ $job->applied->user->last_name }}
                                    </div>

                                    <div style="margin-top:5px;font-size:16px;color:#666;">
                                        {{ $job->applied->user->position }}
                                    </div>
                                    
                                    @if($job->applied->user->addresses)
                                        <div style="margin-top:15px;font-size:14px;color:#555;">
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                                                <tr>
                                                    <td style="vertical-align:middle;padding:0 5px 0 0;">
                                                        <img
                                                            src="https://teaching-hood-backend.netcraftglobal.com/location.svg"
                                                            width="18"
                                                            height="18"
                                                            style="display:block;border:0;"
                                                            alt="Location"
                                                        >
                                                    </td>
                                    
                                                    <td style="vertical-align:middle;padding:0;font-size:14px;line-height:18px;color:#555;">
                                                        {{ $job->applied->user->addresses->city ?? '' }}@if($job->applied->user->addresses->city && $job->applied->user->addresses->state), @endif{{ $job->applied->user->addresses->state ?? '' }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if($job->applied->user->total_experience)
                                        <div style="margin-top:8px;font-size:14px;color:#555;">
                                            <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                                                <tr>
                                                    <td style="vertical-align:middle;padding:0 5px 0 0;">
                                                        <img
                                                            src="https://teaching-hood-backend.netcraftglobal.com/clock.svg"
                                                            width="18"
                                                            height="18"
                                                            style="display:block;border:0;"
                                                            alt="Experience"
                                                        >
                                                    </td>
                                                    <td style="vertical-align:middle;padding:0;">
                                                        <span style="font-size:14px;line-height:18px;color:#555;">
                                                            {{ $job->applied->user->total_experience }} Years Experience
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif

                                    @if($job->applied->user->additional_info)
                                        @if($job->applied->user->additional_info->notice_period)
                                            <div style="margin-top:8px;font-size:14px;color:#555;">
                                                <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                                                    <tr>
                                                        <td style="vertical-align:middle;padding:0 5px 0 0;">
                                                            <img
                                                                src="https://teaching-hood-backend.netcraftglobal.com/calendar.svg"
                                                                width="18"
                                                                height="18"
                                                                style="display:block;border:0;"
                                                                alt="Notice Period"
                                                            >
                                                        </td>
                                    
                                                        <td style="vertical-align:middle;padding:0;font-size:14px;line-height:18px;color:#555;">
                                                            Notice Period:
                                                            {{ $job->applied->user->additional_info->notice_period }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        @endif
                                    @endif

                                </td>

                            </tr>
                        </table>

                        <!-- About -->

                        @if($job->applied->user->additional_info)

                        <div style="margin-top:30px;border-top:1px solid #eeeeee;padding-top:20px;">

                            <h3 style="margin:0 0 10px;font-size:20px;color:#222;">
                                About the Candidate
                            </h3>

                            <p style="margin:0;font-size:15px;line-height:26px;color:#555;">
                                {{ $job->applied->user->additional_info->about_us }}
                            </p>

                        </div>

                        @endif

                        <!-- Subjects -->

                        @php
                        $subjects = $job->applied->user->additional_info->subjects ??[];
                        @endphp

                        @if(count($subjects))

                        <div style="margin-top:25px;">

                            <h3 style="margin:0 0 10px;font-size:20px;color:#222;">
                                Other Subjects
                            </h3>

                            <ul style="margin:0;padding-left:20px;line-height:28px;color:#555;">

                                @foreach($subjects as $subject)

                                <li>{{ $subject->name }}</li>

                                @endforeach

                            </ul>

                        </div>

                        @endif

                        <!-- Grade Levels -->

                        @php
                        $grades = $job->applied->user->additional_info->grade_levels??[];
                        @endphp

                        @if(count($grades))

                        <div style="margin-top:25px;">

                            <h3 style="margin:0 0 10px;font-size:20px;color:#222;">
                                Other Grade Levels
                            </h3>

                            <ul style="margin:0;padding-left:20px;line-height:28px;color:#555;">

                                @foreach($grades as $grade)

                                <li>{{ $grade->name }}</li>

                                @endforeach

                            </ul>

                        </div>

                        @endif

                        <!-- Achievements -->

                        @php
                        $achievements = array_filter(array_map('trim', explode(',', $job->applied->user->additional_info->achievement ?? '')));
                        @endphp

                        @if(count($achievements))

                        <div style="margin-top:25px;">

                            <h3 style="margin:0 0 10px;font-size:20px;color:#222;">
                                Achievements
                            </h3>

                            <ul style="margin:0;padding-left:20px;line-height:28px;color:#555;">

                                @foreach($achievements as $item)

                                <li>{{ $item }}</li>

                                @endforeach

                            </ul>

                        </div>

                        @endif

                        <!-- Certifications -->

                        @php
                        $certifications = array_filter(array_map('trim', explode(',', $job->applied->user->additional_info->certification ?? '')));
                        @endphp

                        @if(count($certifications))

                        <div style="margin-top:25px;">

                            <h3 style="margin:0 0 10px;font-size:20px;color:#222;">
                                Certifications
                            </h3>

                            <ul style="margin:0;padding-left:20px;line-height:28px;color:#555;">

                                @foreach($certifications as $item)

                                <li>{{ $item }}</li>

                                @endforeach

                            </ul>

                        </div>

                        @endif

                        <!-- CTA -->

                        <div style="text-align:center;margin-top:35px;">

                            <a href="https://teachinghood.com/view-profile/{{ $job->applied->user->id }}"
                               style="display:inline-block;background:#0d6efd;color:#ffffff;text-decoration:none;padding:15px 35px;border-radius:40px;font-size:16px;font-weight:bold;">

                                View Full Profile

                            </a>

                        </div>

                    </td>
                </tr>

            </table>

        </td>
    </tr>

    <!-- Benefits -->

    <tr>

        <td style="padding:0 35px 35px;">

            <h2 style="font-size:22px;color:#222;">
                Why Hire Through Teachinghood?
            </h2>

            <table width="100%" cellpadding="0" cellspacing="0">

                <tr>
                    <td style="padding:8px 0;font-size:15px;color:#555;">
                        ✔ Review detailed teacher profiles
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px 0;font-size:15px;color:#555;">
                        ✔ Evaluate experience, achievements and certifications
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px 0;font-size:15px;color:#555;">
                        ✔ Match candidates by subject expertise and grade levels
                    </td>
                </tr>

                <tr>
                    <td style="padding:8px 0;font-size:15px;color:#555;">
                        ✔ Manage your hiring process in one place
                    </td>
                </tr>

            </table>

        </td>

    </tr>

    <!-- CTA -->

    <tr>

        <td align="center" style="padding:10px 35px 40px;">

            <p style="font-size:16px;color:#555;line-height:28px;">
                <strong>Post teaching jobs FREE until 31st December.</strong>
                Start receiving qualified teacher applications in just a few minutes.
            </p>

            <a href="https://teachinghood.com/post-job"
               style="display:inline-block;background:#198754;color:#ffffff;text-decoration:none;padding:15px 40px;border-radius:40px;font-size:16px;font-weight:bold;">

                Post a New Job

            </a>

        </td>

    </tr>

    <!-- Footer -->

    <tr>

        <td style="background:#f8f9fa;padding:30px;text-align:center;font-size:14px;color:#777;line-height:24px;">

            We’re committed to helping schools connect with exceptional educators.
            <br><br>

            <strong>Warm Regards,</strong><br>
            Team Teachinghood

        </td>

    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>