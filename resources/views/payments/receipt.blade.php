<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>វិក្កយបត្រ #REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }} — SMS</title>
    <link rel="icon" type="image/png" href="{{ asset('images/school-logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Khmer:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --success: #10b981;
        }
        body {
            font-family: 'Inter', 'Noto Sans Khmer', sans-serif;
            color: var(--text-main);
            background-color: #f8fafc;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .receipt-card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            width: 100%;
            max-width: 780px;
            padding: 45px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
        }
        /* Receipt Watermark Stamp */
        .receipt-card::after {
            content: "PAID";
            position: absolute;
            top: 25%;
            right: 10%;
            font-size: 8rem;
            font-weight: 900;
            color: rgba(16, 185, 129, 0.06);
            border: 15px double rgba(16, 185, 129, 0.06);
            padding: 10px 30px;
            transform: rotate(-15deg);
            pointer-events: none;
            border-radius: 20px;
            letter-spacing: 5px;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid var(--border);
            padding-bottom: 25px;
            margin-bottom: 30px;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .logo-img {
            height: 52px;
            width: auto;
            border-radius: 8px;
        }
        .school-name {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            color: var(--primary);
        }
        .school-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 3px 0 0 0;
            font-weight: 500;
        }
        .invoice-title-area {
            text-align: right;
        }
        .invoice-title {
            font-size: 1.45rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }
        .invoice-num {
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 600;
            margin: 6px 0 0 0;
            font-family: monospace;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 35px;
        }
        .meta-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 18px 22px;
            background-color: #f8fafc;
        }
        .meta-card-title {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin: 0 0 10px 0;
            border-bottom: 1px dashed var(--border);
            padding-bottom: 6px;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            margin-bottom: 6px;
        }
        .meta-row:last-child {
            margin-bottom: 0;
        }
        .meta-label {
            color: var(--text-muted);
        }
        .meta-val {
            font-weight: 600;
            color: var(--text-main);
        }
        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 35px;
        }
        .item-table th {
            text-transform: uppercase;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 2px solid var(--border);
            padding: 10px 15px;
            text-align: left;
        }
        .item-table td {
            padding: 15px;
            border-bottom: 1px solid var(--border);
            font-size: 0.9rem;
        }
        .item-table tr:last-child td {
            border-bottom: 2px solid var(--border);
        }
        .item-desc {
            font-weight: 600;
        }
        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 45px;
        }
        .total-box {
            width: 280px;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 15px 20px;
            background-color: #f8fafc;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .total-row:last-child {
            margin-bottom: 0;
            border-top: 1px dashed var(--border);
            padding-top: 8px;
            margin-top: 8px;
        }
        .total-label {
            color: var(--text-muted);
        }
        .total-val {
            font-weight: 700;
            color: var(--text-main);
        }
        .grand-total {
            font-size: 1.25rem;
            color: var(--success);
        }
        .signatures {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
            text-align: center;
            margin-top: 40px;
        }
        .sig-block {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sig-space {
            height: 70px;
            border-bottom: 1px solid var(--text-muted);
            width: 180px;
            margin-bottom: 10px;
            opacity: 0.5;
        }
        .sig-title {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            margin: 0;
        }
        .sig-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
            margin: 2px 0 0 0;
            opacity: 0.7;
        }
        .print-btn-bar {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }
        .print-btn {
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .print-btn:hover {
            background-color: #4f46e5;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
        }
        .printed-time {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 40px;
            opacity: 0.6;
        }
        
        /* PRINT SPECIFIC STYLES */
        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
                color: #000000;
            }
            .receipt-card {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .receipt-card::after {
                color: rgba(16, 185, 129, 0.05) !important;
                border-color: rgba(16, 185, 129, 0.05) !important;
            }
            .print-btn-bar {
                display: none;
            }
            .meta-card {
                background-color: #ffffff !important;
            }
            .total-box {
                background-color: #ffffff !important;
            }
        }
    </style>
</head>
<body>

    <div class="receipt-card">
        
        {{-- Header Section --}}
        <div class="header-section">
            <div class="logo-area">
                <img src="{{ asset('images/school-logo.png') }}" onerror="this.src='https://ui-avatars.com/api/?name=SMS&background=6366f1&color=fff&size=128'" alt="School Logo" class="logo-img">
                <div>
                    <h1 class="school-name">SMS System</h1>
                    <p class="school-sub">ប្រព័ន្ធគ្រប់គ្រងសាលារៀនកម្រិតខ្ពស់</p>
                </div>
            </div>
            <div class="invoice-title-area">
                <h2 class="invoice-title">វិក្កយបត្របង់ប្រាក់</h2>
                <div class="invoice-num">#REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>

        {{-- Meta Grid Information --}}
        <div class="meta-grid">
            {{-- Payer Information --}}
            <div class="meta-card">
                <h3 class="meta-card-title">ព័ត៌មានសិស្ស (Student Info)</h3>
                <div class="meta-row">
                    <span class="meta-label">ឈ្មោះសិស្ស៖</span>
                    <span class="meta-val">{{ $payment->student->full_name }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">អត្តលេខសិស្ស៖</span>
                    <span class="meta-val">{{ $payment->student->student_id }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">ថ្នាក់រៀន៖</span>
                    <span class="meta-val">{{ $payment->student->schoolClass?->class_name ?? '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">លេខទូរស័ព្ទ៖</span>
                    <span class="meta-val">{{ $payment->student->phone ?? '—' }}</span>
                </div>
            </div>

            {{-- Payment Details --}}
            <div class="meta-card">
                <h3 class="meta-card-title">ព័ត៌មានការទូទាត់ (Payment Details)</h3>
                <div class="meta-row">
                    <span class="meta-label">កាលបរិច្ឆេទ៖</span>
                    <span class="meta-val">{{ $payment->payment_date ? $payment->payment_date->format('d-M-Y') : '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">វិធីសាស្ត្រទូទាត់៖</span>
                    <span class="meta-val">{{ $payment->payment_method }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">ឆ្នាំសិក្សា៖</span>
                    <span class="meta-val">{{ $payment->academic_year }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">ឆមាស៖</span>
                    <span class="meta-val">{{ $payment->semester }}</span>
                </div>
            </div>
        </div>

        {{-- Item Table --}}
        <table class="item-table">
            <thead>
                <tr>
                    <th style="width: 55%;">ការពិពណ៌នា (Description)</th>
                    <th style="width: 15%; text-align: center;">បរិមាណ (Qty)</th>
                    <th style="width: 15%; text-align: right;">តម្លៃរាយ (Unit Price)</th>
                    <th style="width: 15%; text-align: right;">សរុប (Amount)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="item-desc">
                        ថ្លៃសិក្សាឆមាសទី១ ({{ $payment->semester }} Tuition Fee)
                        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal; margin-top: 3px;">
                            {{ $payment->student->full_name }} ({{ $payment->student->student_id }})
                        </div>
                    </td>
                    <td style="text-align: center;">1</td>
                    <td style="text-align: right;">${{ number_format($payment->amount, 2) }}</td>
                    <td style="text-align: right; font-weight: 600;">${{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Total calculations --}}
        <div class="total-section">
            <div class="total-box">
                <div class="total-row">
                    <span class="total-label">តម្លៃសរុប (Subtotal):</span>
                    <span class="total-val">${{ number_format($payment->amount, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">បញ្ចុះតម្លៃ (Discount):</span>
                    <span class="total-val">$0.00</span>
                </div>
                <div class="total-row">
                    <span class="total-label text-success">ស្ថានភាព (Status):</span>
                    <span class="total-val text-success" style="font-weight: 700;">បង់រួច (PAID)</span>
                </div>
                <div class="total-row">
                    <span class="total-label">ទឹកប្រាក់សរុប (Grand Total):</span>
                    <span class="total-val grand-total">${{ number_format($payment->amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Signatures block --}}
        <div class="signatures">
            <div class="sig-block">
                <div class="sig-space"></div>
                <h4 class="sig-title">ហត្ថលេខាអ្នកទទួលប្រាក់ (Cashier)</h4>
                <p class="sig-sub">គិតគូរជាកិច្ចចុងក្រោយ</p>
            </div>
            <div class="sig-block">
                <div class="sig-space"></div>
                <h4 class="sig-title">ហត្ថលេខាសិស្ស/អាណាព្យាបាល (Student/Payer)</h4>
                <p class="sig-sub">អ្នកទូទាត់ប្រាក់</p>
            </div>
        </div>

        {{-- Timestamp --}}
        <div class="printed-time">
            វិក្កយបត្រនេះត្រូវបានបង្កើតឡើងដោយប្រព័ន្ធស្វ័យប្រវត្តិនៅថ្ងៃទី {{ date('d-M-Y H:i:s') }}
        </div>

    </div>

    {{-- Sticky Floating Print Button Bar --}}
    <div class="print-btn-bar">
        <button onclick="window.print()" class="print-btn">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6 14" width="12" height="8"></rect></svg>
            បោះពុម្ពវិក្កយបត្រ (Print Receipt)
        </button>
    </div>

    <script>
        // Trigger browser's print interface automatically on load
        window.addEventListener('load', () => {
            // Slight delay to ensure standard fonts are fully loaded
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
