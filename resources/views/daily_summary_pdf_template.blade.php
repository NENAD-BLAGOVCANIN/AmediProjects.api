<?php $statuses = [
    'in_progress' => 'בעבודה',
    'todo' => 'תחילת עבודה',
    'done' => 'הושלם',
];
?>
<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>דוח סיכום יומי</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .logo {
            display: block;
            margin: 0 auto;
        }
        .header p {
            margin: 0;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        h1, h2 {
            margin: 20px 0;
        }
    </style>
</head>
<body>
  <div class="container">
    <!-- Header Information -->
    <img src="{{ public_path('images/amedi-logo.jpg') }}" alt="Logo" class="logo">
    <div class="header">
        <p>ניר אמידי פרוייקטים בע"מ – ח.פ : 516136405</p>
        <p>טלפון : 08-6696908 . פקס : 08-6723535 . נייד : 053-2265765</p>
        <p>אבימלך 27 אשקלון 7855709 . דואר אלקטרוני : niramidi@gmail.com</p>
    </div>

    <h1>דוח סיכום שבועי</h1>

    <!-- Monthly Collections Section -->
    <h2>גבייה</h2>
    <table>
        <thead>
            <tr>
                <th>פרויקט</th>
                <th>סכום שנגבה</th>
                <th>חודש</th>
                <th>שנה</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['monthlyCollections'] as $collection)
                <tr>
                    <td>{{ $collection->project->name }}</td>
                    <td>{{ $collection->amount_collected }}</td>
                    <td>{{ $collection->month }}</td>
                    <td>{{ $collection->year }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Daily Summary Collections Section -->
    <h2>סיכום יומי גבייה</h2>
    <table>
        <thead>
            <tr>
                <th>תוכן</th>
                <th>גבייה היום</th>
                <th>גבייה עתידית</th>
                <th>תאריך</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['summaryDays'] as $summaryDay)
                <tr>
                    <td>{{ $summaryDay->body }}</td>
                    <td>{{ $summaryDay->collected_today }}</td>
                    <td>{{ $summaryDay->future_collection }}</td>
                    <td>{{ $summaryDay->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Daily Summary Installations Section -->
    <h2>סיכום יומי מדידה והתקנה</h2>
    <table>
        <thead>
            <tr>
                <th>שם פרוייקט</th>
                <th>שם מתקין</th>
                {{-- <th>בונוסים</th> --}}
                <th>תיאור</th>
                <th>עיר</th>
                <th>הערות עובד</th>
                <th>תאריך</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['summaryInstallations'] as $summaryInstallation)
                <tr>
                    <td>{{ $summaryInstallation->project_name }}</td>
                    <td>{{ $summaryInstallation->worker_name }}</td>
                    {{-- <td>{{ $summaryInstallation->bonuses }}</td> --}}
                    <td>{{ $summaryInstallation->notes }}</td>
                    <td>{{ $summaryInstallation->city }}</td>
                    <td>{{ $summaryInstallation->employee_comments }}</td>
                    <td>{{ $summaryInstallation->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Daily Summary Planners Section -->
    <h2>סיכום יומי תכנון</h2>
    <table>
        <thead>
            <tr>
                <th>שם פרוייקט</th>
                <th>שם עובד</th>
                <th>בונוסים</th>
                <th>תיאור</th>
                <th>תאריך</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['summaryPlanners'] as $summaryPlanner)
                <tr>
                    <td>{{ $summaryPlanner->project_name }}</td>
                    <td>{{ $summaryPlanner->worker_name }}</td>
                    <td>{{ $summaryPlanner->bonuses }}</td>
                    <td>{{ $summaryPlanner->description }}</td>
                    <td>{{ $summaryPlanner->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- User Tasks Section -->
    <h2>משימות יומיות למשתמשים</h2>
    <table>
        <thead>
            <tr>
                <th>שם משתמש</th>
                <th>משימה</th>
                <th>תאריך יעד</th>
                <th>סטטוס</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['userTasks'] as $userName => $tasks)
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $userName }}</td>
                        <td>{{ $task->subject }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $statuses[$task->status] ?? $task->status }}</td> <!-- Convert status to Hebrew -->
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
  </div>
</body>
</html>
