<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: right;
        }
        h1, h2, h3 {
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>פירוט חשבון</h1>
        <p>לקוח: {{ $data['clientName'] }}</p>
        <p>פרויקט: {{ $data['projectName'] }}</p>
        <p>חברה: {{ $data['companyName'] }}</p>
        <p>עיר: {{ $data['city'] }}</p>
        <p>נוצר על ידי: {{ $data['documentProducer'] }}</p>
        <p>אימייל: {{ $data['emailSent'] }}</p>
    </div>

    <div class="logo">
        <img src="{{ public_path('images/amedi-logo.jpg') }}" alt="Logo" class="logo">
    </div>

    <h2>מוצרים</h2>
    <table>
        <thead>
            <tr>
                <th>שם מוצר</th>
                <th>יחידות מידה</th>
                <th>כמות</th>
                <th>מחיר ליחידה</th>
                <th>סה"כ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['billingData'] as $product)
                <tr>
                    <td>{{ $product['description'] }}</td>
                    <td>{{ $product['unit'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['unitPrice'] }}</td>
                    <td>{{ $product['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>עבודות</h2>
    <table>
        <thead>
            <tr>
                <th>חודש</th>
                <th>מוצר</th>
                <th>מקום התקנה</th>
                <th>יחידות מידה</th>
                <th>כמות</th>
                <th>סכום</th>
                <th>סכום כולל מע"מ</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalBeforeVat = 0;
                $totalVat = 0;
                $totalWithVat = 0;
            @endphp
            @foreach($data['billingData'] as $work)
                @php
                    $amountWithVat = $work['total'] * 1.17;
                    $totalBeforeVat += $work['total'];
                    $totalVat += $work['total'] * 0.17;
                    $totalWithVat += $amountWithVat;
                @endphp
                <tr>
                    <td>{{ $work['month'] }}</td>
                    <td>{{ $work['description'] }}</td>
                    <td>{{ $work['location'] }}</td>
                    <td>{{ $work['unit'] }}</td>
                    <td>{{ $work['quantity'] }}</td>
                    <td>{{ number_format($work['total'], 2) }}</td>
                    <td>{{ number_format($amountWithVat, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>סיכום</h2>
    <table>
        <tbody>
            <tr>
                <td>סה"כ לפני מע"מ</td>
                <td>₪ {{ number_format($totalBeforeVat, 2) }}</td>
            </tr>
            <tr>
                <td>מע"מ 17%</td>
                <td>₪ {{ number_format($totalVat, 2) }}</td>
            </tr>
            <tr>
                <td>סה"כ כולל מע"מ</td>
                <td>₪ {{ number_format($totalWithVat, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>מאזן</h2>
    <table>
        <thead>
            <tr>
                <th>מס' חשבונית</th>
                <th>מס' קבלה</th>
                <th>מאזן</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $data['invoiceNumber'] ?? '' }}</td>
                <td>{{ $data['receiptNumber'] ?? '' }}</td>
                <td>{{ number_format($totalWithVat, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr>
                <td>סה"כ חשבוניות שהופקו ושולמו</td>
                <td>₪ {{ number_format($totalWithVat, 2) }}</td>
            </tr>
            <tr>
                <td>יתרה להפקת חשבונית ותשלום</td>
                <td>₪ {{ number_format(0, 2) }}</td>
            </tr>
        </tbody>
    </table>
    <div class="important-notice">
      <h3>הערה:</h3>
      <p>נא רשום המחאה לפקודת ניר אמידי פרוייקטים בע"מ</p>
      <p>תשלום לפי חוזה/הסכם</p>
      <p>בברכה,</p>
      <p>ארז אמידי, מנכ"ל</p>
      <p>050-6336059</p>
    </div>
</body>
</html>
