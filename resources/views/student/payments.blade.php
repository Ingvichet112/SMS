@extends('layouts.app')
@section('title', 'ការបង់ប្រាក់ និងវិក្កយបត្ររបស់ខ្ញុំ')
@section('page-title', 'ថ្លៃសិក្សា និងការបង់ប្រាក់')

@push('styles')
<style>
.payment-card {
    border: 1px solid var(--bs-border-color, #e2e8f0);
    border-radius: 20px;
    background: var(--bs-card-bg, #fff);
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.02);
    overflow: hidden;
}
.status-pill {
    font-size: 0.78rem;
    font-weight: 700;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.status-pill.paid {
    background-color: rgba(16, 185, 129, 0.12);
    color: #10b981;
    border: 1px solid rgba(16, 185, 129, 0.2);
}
.status-pill.unpaid {
    background-color: rgba(239, 68, 68, 0.12);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.2);
}
.qr-container {
    background: #0d2e5c;
    border-radius: 16px;
    padding: 1.5rem;
    color: #fff;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.qr-container::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 150px;
    height: 150px;
    background: rgba(255, 255, 255, 0.03);
    border-radius: 50%;
}
.qr-code-box {
    background: #fff;
    padding: 1rem;
    border-radius: 12px;
    display: inline-block;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.payment-method-btn {
    border: 1px solid var(--bs-border-color, #e2e8f0);
    background: var(--bs-card-bg, #fff);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    text-align: left;
}
.payment-method-btn:hover {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.02);
}
.payment-method-btn.active {
    border-color: #6366f1;
    background: rgba(99, 102, 241, 0.05);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
.invoice-breakdown-box {
    background-color: rgba(0, 0, 0, 0.02);
}
[data-bs-theme="dark"] .invoice-breakdown-box {
    background-color: rgba(255, 255, 255, 0.03);
}
[data-bs-theme="dark"] .invoice-breakdown-box .text-muted {
    color: rgba(255, 255, 255, 0.6) !important;
}
[data-bs-theme="dark"] .invoice-breakdown-box .fw-semibold {
    color: #fff !important;
}
[data-bs-theme="dark"] .invoice-breakdown-box .fw-bold {
    color: #fff !important;
}
[data-bs-theme="dark"] .invoice-breakdown-box .text-primary {
    color: #6366f1 !important;
}
[data-bs-theme="dark"] .bg-success-subtle {
    background-color: rgba(16, 185, 129, 0.08) !important;
}
[data-bs-theme="dark"] .text-success {
    color: #34d399 !important;
}
[data-bs-theme="dark"] .bg-success-subtle .text-muted {
    color: rgba(255, 255, 255, 0.7) !important;
}
</style>
@endpush

@section('content')
<div class="row g-4">
    {{-- Main Section: Active Semester Invoice --}}
    <div class="col-lg-8">
        <div class="payment-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">ថ្លៃសិក្សាឆមាសបច្ចុប្បន្ន</h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">ឆមាសសិក្សា៖ <strong>ឆមាសទី ១, ២០២៣-២០២៤</strong></p>
                </div>
                <div>
                    @if($isPaid)
                        <span class="status-pill paid">
                            <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i> បង់រួច
                        </span>
                    @else
                        <span class="status-pill unpaid">
                            <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i> មិនទាន់បង់
                        </span>
                    @endif
                </div>
            </div>

            <div class="row align-items-center g-4">
                {{-- Left: Invoice Breakdown --}}
                <div class="col-md-6">
                    @if(!$isPaid)
                    <div class="mb-3">
                            <label class="small text-muted fw-bold mb-1.5 d-block">ជ្រើសរើសរយៈពេលបង់ប្រាក់</label>
                            <select id="durationSelect" class="form-select rounded-3 fw-semibold text-body" onchange="updateDuration()">
                                <option value="1">១ ខែ ($30.00)</option>
                                <option value="2">២ ខែ ($60.00)</option>
                                <option value="3">៣ ខែ ($90.00)</option>
                                <option value="5" selected>៥ ខែ / ឆមាស ($150.00)</option>
                                <option value="10">១០ ខែ / ឆ្នាំសិក្សា ($300.00)</option>
                            </select>
                        </div>
                    @endif

                    <div class="p-3.5 rounded-4 invoice-breakdown-box border mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ថ្លៃសិក្សា (<span id="breakdownMonths">5</span> ខែ)</span>
                            <span class="fw-semibold">$<span id="breakdownTuition">150.00</span></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">ថ្លៃចុះឈ្មោះ</span>
                            <span class="fw-semibold" style="color: #10b981;">ឥតគិតថ្លៃ</span>
                        </div>
                        <hr class="my-2.5">
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">ចំនួនទឹកប្រាក់ត្រូវបង់សរុប</span>
                            <span class="fw-bold text-primary" style="font-size: 1.15rem;">$<span id="breakdownTotal">150.00</span></span>
                        </div>
                    </div>

                    @if($isPaid && $latestPayment)
                        <div class="p-3.5 rounded-4 bg-success-subtle bg-opacity-25 border border-success border-opacity-10 mb-3">
                            <div class="fw-bold text-success mb-1" style="font-size: 0.85rem;">ការបង់ប្រាក់ត្រូវបានបញ្ជាក់!</div>
                            <div class="text-muted" style="font-size: 0.78rem; line-height: 1.4;">
                                បានបង់ប្រាក់តាមរយៈ <strong>{{ $latestPayment->payment_method }}</strong> នៅថ្ងៃទី {{ $latestPayment->payment_date->format('d-M-Y') }}.
                                <br>
                                កំណត់សម្គាល់៖ {{ $latestPayment->remarks }}
                            </div>
                        </div>
                        <a href="{{ route('student.payments.receipt', $latestPayment) }}" target="_blank" class="btn btn-primary w-100 py-2.5 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="printer" style="width: 16px; height: 16px;"></i> បោះពុម្ពវិក្កយបត្រផ្លូវការ
                        </a>
                    @else
                        <div class="p-3.5 rounded-4 bg-warning-subtle bg-opacity-25 border border-warning border-opacity-10 mb-3">
                            <div class="fw-bold text-warning mb-1" style="font-size: 0.85rem;">តម្រូវឱ្យធ្វើការបង់ប្រាក់</div>
                            <div class="text-muted mb-0" style="font-size: 0.78rem; line-height: 1.4;">
                                សូមជ្រើសរើសរយៈពេលខែដែលចង់បង់ប្រាក់ និងទូទាត់ការបង់ប្រាក់ ដើម្បីបន្តចូលទៅកាន់កាលវិភាគសិក្សារបស់អ្នក។
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Right: Checkout / QR Section --}}
                <div class="col-md-6">
                    @if($isPaid)
                        <div class="text-center py-5">
                            <div class="badge bg-success-subtle text-success p-4 rounded-circle mb-3">
                                <i data-lucide="check" style="width: 44px; height: 44px; stroke-width: 3;"></i>
                            </div>
                            <h6 class="fw-bold text-success">បានទូទាត់ដោយជោគជ័យ</h6>
                            <p class="text-muted mb-0" style="font-size: 0.8rem; max-width: 200px; margin: 4px auto 0;">ទិន្នន័យបង់ថ្លៃសិក្សារបស់អ្នក ត្រូវបានកត់ត្រាក្នុងប្រព័ន្ធដោយជោគជ័យ។</p>
                        </div>
                    @else
                        {{-- QR Payment Mockup --}}
                        <div class="qr-container">
                            <div class="fw-bold mb-1" style="font-size: 0.95rem;">ABA PAY តាមទូរស័ព្ទ</div>
                            <div class="small opacity-75 mb-3">ស្កែន QR ដើម្បីផ្ទេរប្រាក់ភ្លាមៗ</div>
                            
                            <div class="qr-code-box mb-3">
                                {{-- SVG QR Mockup --}}
                                <svg viewBox="0 0 100 100" style="width: 120px; height: 120px;">
                                    {{-- Outer borders --}}
                                    <rect x="0" y="0" width="30" height="30" fill="#0d2e5c"/>
                                    <rect x="5" y="5" width="20" height="20" fill="#fff"/>
                                    <rect x="10" y="10" width="10" height="10" fill="#0d2e5c"/>

                                    <rect x="70" y="0" width="30" height="30" fill="#0d2e5c"/>
                                    <rect x="75" y="5" width="20" height="20" fill="#fff"/>
                                    <rect x="80" y="10" width="10" height="10" fill="#0d2e5c"/>

                                    <rect x="0" y="70" width="30" height="30" fill="#0d2e5c"/>
                                    <rect x="5" y="75" width="20" height="20" fill="#fff"/>
                                    <rect x="10" y="80" width="10" height="10" fill="#0d2e5c"/>

                                    {{-- Random blocks --}}
                                    <rect x="40" y="10" width="10" height="10" fill="#0d2e5c"/>
                                    <rect x="50" y="20" width="10" height="10" fill="#0d2e5c"/>
                                    <rect x="40" y="40" width="20" height="20" fill="#0d2e5c"/>
                                    <rect x="10" y="40" width="10" height="20" fill="#0d2e5c"/>
                                    <rect x="80" y="40" width="10" height="20" fill="#0d2e5c"/>
                                    <rect x="70" y="80" width="20" height="10" fill="#0d2e5c"/>
                                    <rect x="40" y="80" width="20" height="10" fill="#0d2e5c"/>
                                </svg>
                            </div>
                            
                            <div class="fw-bold" style="font-size: 1.1rem;">$<span id="qrTotal">150.00</span></div>
                            <div class="small opacity-75 mt-0.5" style="font-size: 0.72rem;">អត្តលេខសិស្ស៖ {{ $student->student_id }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Right Section: Select Payment Method & Pay --}}
    <div class="col-lg-4">
        <div class="payment-card p-4 h-100">
            <h5 class="fw-bold mb-3">ការទូទាត់ប្រាក់</h5>
            
            @if($isPaid)
                <div class="text-center py-5 text-muted">
                    <i data-lucide="shield-check" class="mb-3" style="width: 48px; height: 48px; opacity: 0.4;"></i>
                    <h6 class="fw-bold mb-1">សុវត្ថិភាពខ្ពស់</h6>
                    <p class="mb-0 small" style="max-width: 220px; margin: 0 auto;">ព័ត៌មានលម្អិតនៃការបង់ប្រាក់របស់អ្នក ត្រូវបានភ្ជាប់ជាមួយអ្នកគ្រប់គ្រង និងផ្ទៀងផ្ទាត់ដោយក្រុមប្រឹក្សាភិបាលសាលា។</p>
                </div>
            @else
                <form method="POST" action="{{ route('student.payments.pay') }}">
                    @csrf
                    
                    <label class="small text-muted fw-bold mb-2">ជ្រើសរើសវិធីសាស្ត្រទូទាត់</label>
                    <div class="d-flex flex-column gap-2 mb-3">
                        <div class="payment-method-btn active" id="methodABA" onclick="selectMethod('ABA Mobile')">
                            <i data-lucide="smartphone" style="stroke: #0284c7; width: 22px; height: 22px; flex-shrink: 0;"></i>
                            <div>
                                <div class="fw-bold text-body" style="font-size: 0.85rem; line-height: 1.2;">ផ្ទេរប្រាក់តាម ABA PAY</div>
                                <span class="text-muted small" style="font-size: 0.7rem;">ធ្វើបច្ចុប្បន្នភាពទិន្នន័យភ្លាមៗ</span>
                            </div>
                        </div>

                        <div class="payment-method-btn" id="methodCard" onclick="selectMethod('Credit Card')">
                            <i data-lucide="credit-card" style="stroke: #8b5cf6; width: 22px; height: 22px; flex-shrink: 0;"></i>
                            <div>
                                <div class="fw-bold text-body" style="font-size: 0.85rem; line-height: 1.2;">កាតឥណទាន / ឥណពន្ធ</div>
                                <span class="text-muted small" style="font-size: 0.7rem;">Visa, Mastercard, UnionPay</span>
                            </div>
                        </div>

                        <div class="payment-method-btn" id="methodCash" onclick="selectMethod('Cash')">
                            <i data-lucide="banknote" style="stroke: #10b981; width: 22px; height: 22px; flex-shrink: 0;"></i>
                            <div>
                                <div class="fw-bold text-body" style="font-size: 0.85rem; line-height: 1.2;">បង់ប្រាក់ផ្ទាល់នៅការិយាល័យសាលា</div>
                                <span class="text-muted small" style="font-size: 0.7rem;">បង់ប្រាក់ដោយផ្ទាល់នៅការិយាល័យ</span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="payment_method" id="selectedMethodInput" value="ABA Mobile">
                    <input type="hidden" name="months" id="formMonthsInput" value="5">

                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1.5" for="remarksInput">កំណត់សម្គាល់ប្រតិបត្តិការ</label>
                        <textarea class="form-control rounded-3" name="remarks" id="remarksInput" rows="2" placeholder="ឧ. លេខកូដប្រតិបត្តិការ ABA ឬព័ត៌មានផ្សេងៗ..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-accent w-100 py-2.5 rounded-3 fw-bold d-flex align-items-center justify-content-center gap-2">
                        <i data-lucide="credit-card" style="width: 18px; height: 18px;"></i> បញ្ជាក់ការបង់ប្រាក់
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Full-width Section: Historical Payment Logs --}}
    <div class="col-12">
        <div class="payment-card">
            <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i data-lucide="history" class="lucide-sm me-2 text-primary"></i>ប្រវត្តិបង់ប្រាក់ និងវិក្កយបត្រ</h6>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill" style="font-size: 0.75rem;">
                    {{ $payments->count() }} ប្រតិបត្តិការដែលបានកត់ត្រា
                </span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: var(--bs-tertiary-bg);">
                        <tr>
                            <th class="ps-4">អត្តលេខវិក្កយបត្រ</th>
                            <th>កាលបរិច្ឆេទបង់ប្រាក់</th>
                            <th>ចំនួនទឹកប្រាក់</th>
                            <th>វិធីសាស្ត្រ</th>
                            <th>ឆមាស</th>
                            <th>កំណត់សម្គាល់</th>
                            <th class="pe-4 text-end">សកម្មភាព</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td class="ps-4"><code class="text-success fw-bold">#INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</code></td>
                            <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : '—' }}</td>
                            <td><strong class="text-body">${{ number_format($payment->amount, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill" style="font-size: 0.72rem;">
                                    {{ $payment->payment_method }}
                                </span>
                            </td>
                            <td>{{ $payment->semester }}</td>
                            <td class="text-muted small text-truncate" style="max-width: 200px;">{{ $payment->remarks }}</td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('student.payments.receipt', $payment) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3 px-3 d-inline-flex align-items-center gap-1.5">
                                    <i data-lucide="eye" style="width: 13px; height: 13px;"></i> មើលវិក្កយបត្រ
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i data-lucide="inbox" class="d-block mx-auto mb-2 text-muted" style="width: 38px; height: 38px; opacity: 0.4;"></i>
                                <span class="small">មិនទាន់មានប្រវត្តិប្រតិបត្តិការបង់ប្រាក់សម្រាប់គណនីនេះនៅឡើយទេ។</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectMethod(methodName) {
    // Set hidden input
    document.getElementById('selectedMethodInput').value = methodName;

    // Reset styles
    document.getElementById('methodABA').classList.remove('active');
    document.getElementById('methodCard').classList.remove('active');
    document.getElementById('methodCash').classList.remove('active');

    // Set active style
    if (methodName === 'ABA Mobile') {
        document.getElementById('methodABA').classList.add('active');
    } else if (methodName === 'Credit Card') {
        document.getElementById('methodCard').classList.add('active');
    } else if (methodName === 'Cash') {
        document.getElementById('methodCash').classList.add('active');
    }
}

function updateDuration() {
    const select = document.getElementById('durationSelect');
    if (!select) return;
    const months = parseInt(select.value) || 5;
    const rate = 30.00;
    const total = months * rate;

    // Update Breakdown
    document.getElementById('breakdownMonths').innerText = months;
    document.getElementById('breakdownTuition').innerText = total.toFixed(2);
    document.getElementById('breakdownTotal').innerText = total.toFixed(2);

    // Update QR Code Amount
    const qrTotal = document.getElementById('qrTotal');
    if (qrTotal) {
        qrTotal.innerText = total.toFixed(2);
    }

    // Update hidden form inputs
    const formMonths = document.getElementById('formMonthsInput');
    if (formMonths) {
        formMonths.value = months;
    }
}
</script>
@endpush
