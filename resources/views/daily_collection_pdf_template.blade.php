<!DOCTYPE html>
<html lang="he" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>דוח גבייה יומי</title>
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

    <h1>לקוחות הדורשים טיפול מיוחד</h1>

    <!-- Project Collections Section -->
    <h2>פרטי גבייה</h2>
    <table>
        <thead>
            <tr>
                <th>שם חברה</th>
                <th>שם פרויקט</th>
                <th>איש קשר</th>
                <th>חוב</th>
                <th>תאריך הוצאת חשבונית אחרונה</th>
                <th>שיעור עיכבון</th>
                <th>סטטוס תשלום</th>
                <th>טלפון מנהל פרויקט</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['projectCollections'] as $collection)
                <tr>
                    <td>{{ $collection->company_name }}</td>
                    <td>{{ $collection->project_name }}</td>
                    <td>{{ $collection->contact_person }}</td>
                    <td>{{ $collection->debt }}</td>
                    <td>{{ $collection->last_invoice_issuance_date }}</td>
                    <td>{{ $collection->retention_5 }}</td>
                    <td>{{ $collection->payment_status }}</td>
                    <td>{{ $collection->project_manager_mobile }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </div>
</body>
</html>
