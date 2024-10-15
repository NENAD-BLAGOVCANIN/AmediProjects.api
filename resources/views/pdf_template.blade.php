<!DOCTYPE html>
<html lang="he">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            display: flex;
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: right;
        }
        .container {
            text-align: right;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        .header {
            margin-bottom: 20px;
        }
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Information -->
        <div class="header">
            <p>ניר אמידי פרוייקטים בע"מ – ח.פ : 516136405</p>
            <p>טלפון : 08-6696908 .  פקס : 08-6723535 .  נייד : 053-2265765</p>
            <p>אבימלך 27 אשקלון 7855709 . דואר אלקטרוני : niramidi@gmail.com</p>
        </div>

        <img src="{{ public_path('images/amedi-logo.jpg') }}" alt="Logo" class="logo">
        <p>לכבוד: {{ $data['clientName'] }}</p>
      <p>מצורף הצעת מחיר עבודת מסגרות לפרוייקט</p>

        
        <h1>הצעת מחיר</h1>
        <p>שם הלקוח: {{ $data['clientName'] }}</p>
        <p>שם הפרויקט: {{ $data['projectName'] }}</p>
        <p>חברה: {{ $data['company'] }}</p>
        <p>עיר: {{ $data['city'] }}</p>
        <p>טלפון: {{ $data['phone'] }}</p>
        <p>אימייל: {{ $data['email'] }}</p>
        <p>נכתב על ידי: {{ $data['writtenBy'] }}</p>
        
        <h2>מוצרים</h2>
        <table>
            <thead>
                <tr>
                    <th>תיאור</th>
                    <th>מחיר</th>
                    <th>יחידת מידה</th>
                    <th>כמות</th>
                    <th>סה"כ</th>
                    <th>הערות</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalWithoutVat = 0;
                @endphp
                @foreach($data['products'] as $product)
                    @php
                        $totalProductPrice = $product['price'] * $product['quantity'];
                        $totalWithoutVat += $totalProductPrice;
                    @endphp
                    <tr>
                        <td>{{ $product['description'] }}</td>
                        <td>{{ $product['price'] }}</td>
                        <td>{{ $product['unitOfMeasure'] }}</td>
                        <td>{{ $product['quantity'] }}</td>
                        <td>{{ $totalProductPrice }}</td> <!-- Total calculation -->
                        <td>{{ $product['remarks'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Display Total and VAT -->
        @php
            $vat = 0.17;
            $totalWithVat = $totalWithoutVat * (1 + $vat);
        @endphp
        <h3>סה"כ לפני מע"מ: {{ $totalWithoutVat }}</h3>
        <h3>סה"כ כולל מע"מ (17%): {{ $totalWithVat }}</h3>

        <!-- Important Notice Section -->
        <div class="important-notice">
            <h3>הערה:</h3>
            <p>
                המזמין מתחייב שהשטח יהיה מוכן לקריאת מודד ואחרי טיח וצבע סופי, במידה והשטח לא יהיה מוכן יחוייב בעלות מודד של 1000 ₪.<br>
                כל העבודות מיוצרות מחומר מגולוון למעט קשתות ריתוך וצבוע בתנור.<br>
                על כל העבודות, כל מוצר שהוא פחות ממטר הוא נספר כמטר.<br>
                במידה וישנם פריטים המותקנים בגג (כגון: סולמות,רפפות ומעקות ) המזמין אחראי לספק מנוף/אמצעי הרמה לגג.<br>
                במידה וההתקנה לא סטנדרטית (גובה, וכ'ו) תתווסף עלות להתקנה.<br>
            </p>
            <h3>כמות מינימום לפעימת הזמנת עבודה:</h3>
            <p>
                1. מחלקת ארונות, גדרות, ורפפות נא לרכז כמות מעל 50 מטר.<br>
                2. מחלקת שאר המסגרות נא לרכז עבודה מעל 10,000 ₪.<br>
                במידה וההזמנה תפחת מהכמות הנ"ל תהיה תוספת הובלה והתקנה של 2,500 ₪ עבור כל מחלקה בנפרד.<br>
                זמני אספקה עד 21 ימי עסקים מרגע שהחומר נמדד ואושר סופית כולל כל הפרטים והאישורים על הפרטים. ולא מרגע המדידה בלבד.<br>
            </p>
            <h3>תנאי תשלום:</h3>
            <p>
                1. שוטף + 30.<br>
                2. המחיר אינו כולל מע"מ כחוק.<br>
                3. המחירים צמודים למדד עליות המחירים במשק.<br>
                4. הצעה זו במחירים אלו תקפה ל-30 יום בלבד.<br>
            </p>
        </div>

        <!-- Add signature section here -->
        <div class="signature">
            <p>נאשר את ביצוע העבודה בהתאם לתנאים המצורפים:</p>
            <div style="height: 100px; border-bottom: 1px solid #000; width: 50%;"></div>
            <p>חתימה וחותמת:</p>
            <p>תאריך חתימה:</p>
        </div>

    </div>
</body>
</html>
