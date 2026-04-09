<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; }
        .header { background-color: #1b4332; color: #fff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; color: #ba985d; }
        .content { padding: 30px; }
        .footer { background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #6c757d; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border-bottom: 1px solid #edf2f7; text-align: left; }
        th { color: #4a5568; width: 40%; font-weight: 600; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 14px; display: inline-block; }
        .status-present { background-color: #d1e7dd; color: #0f5132; }
        .status-absent { background-color: #f8d7da; color: #842029; }
        .status-late { background-color: #fff3cd; color: #664d03; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Madrasa Dar-ul-Falah</h1>
            <p style="margin: 5px 0 0 0; color: #e9ecef;">Daily Progress Update</p>
        </div>
        <div class="content">
            <p>As-salamu Alaykum,</p>
            <p>Here is the daily madrasa update for <strong>{{ $student->user->name ?? 'Student' }}</strong> on <strong>{{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}</strong>.</p>
            
            <table>
                <tr>
                    <th>Assigned Program</th>
                    <td>{{ ucfirst($student->program) }}</td>
                </tr>
                <tr>
                    <th>Teacher</th>
                    <td>{{ $student->teacher->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Attendance Status</th>
                    <td>
                        @php
                            $status = $attendance ? $attendance->status : 'absent';
                            $statusClass = 'status-' . $status;
                        @endphp
                        <span class="status-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
                    </td>
                </tr>
                @if($progressLog)
                <tr>
                    <th>Lesson Type</th>
                    <td>{{ ucfirst($progressLog->lesson_type ?? 'N/A') }}</td>
                </tr>
                @if($progressLog->para)
                <tr>
                    <th>Para</th>
                    <td>{{ $progressLog->para }}</td>
                </tr>
                @endif
                @if($progressLog->surah)
                <tr>
                    <th>Surah</th>
                    <td>{{ $progressLog->surah }}</td>
                </tr>
                @endif
                @if($progressLog->ayah_from)
                <tr>
                    <th>Ayah (From - To)</th>
                    <td>{{ $progressLog->ayah_from }} - {{ $progressLog->ayah_to }}</td>
                </tr>
                @endif
                @if($progressLog->remarks)
                <tr>
                    <th>Teacher's Remarks</th>
                    <td style="font-style: italic;">"{{ $progressLog->remarks }}"</td>
                </tr>
                @endif
                @endif
            </table>

            <p style="margin-top: 30px;">For more details, <a href="{{ config('app.url') }}/login" style="color: #ba985d; text-decoration: none; font-weight: 600;">login to the student portal</a>.</p>
            <p>JazakAllah Khair,<br>Madrasa Dar-ul-Falah Administration</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Madrasa Dar-ul-Falah. All rights reserved.
        </div>
    </div>
</body>
</html>
