@extends('layouts.app')
@section('title', '預約課程 — 社團法人臺灣科技與社會工作協會')

@section('content')

{{-- FullCalendar v6 --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">

<style>
/* ═══════════════════════════════════════════
   PAGE LAYOUT
═══════════════════════════════════════════ */
.booking-page {
    min-height: 100svh;
    background: var(--color-bg);
    padding: 0;
}
.booking-hero {
    padding: clamp(6rem,12vh,10rem) clamp(1.5rem,6vw,5rem) clamp(2.5rem,5vh,4rem);
    background: var(--color-dark);
    position: relative;
    overflow: hidden;
}
.booking-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 50% 70% at 20% 50%, rgba(232,168,56,0.12), transparent 65%),
        radial-gradient(ellipse 40% 60% at 80% 30%, rgba(59,122,107,0.14), transparent 60%);
    pointer-events: none;
}
/* Ruled lines on hero (notebook) */
.booking-hero::after {
    content: '';
    position: absolute;
    inset: 0;
    background-image: repeating-linear-gradient(
        transparent, transparent 39px, rgba(255,255,255,0.04) 40px
    );
    pointer-events: none;
}
.hero-content { position: relative; z-index: 1; }
.hero-sticker {
    display: inline-block;
    padding: 0.28rem 0.85rem;
    border-radius: 3px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    background: var(--color-amber);
    color: white;
    transform: rotate(-1.5deg);
    box-shadow: 2px 2px 0 rgba(0,0,0,0.2);
    margin-bottom: 1.5rem;
    display: block;
    width: fit-content;
}
.booking-hero h1 {
    font-family: var(--font-serif);
    font-size: clamp(2.5rem, 6vw, 5rem);
    font-weight: 900;
    color: white;
    line-height: 1.1;
    margin-bottom: 1rem;
}
.booking-hero p {
    font-size: 14px;
    color: rgba(255,255,255,0.55);
    line-height: 1.8;
    max-width: 50ch;
}

/* ═══════════════════════════════════════════
   MAIN CONTENT GRID
═══════════════════════════════════════════ */
.booking-body {
    padding: clamp(3rem,6vw,5rem) clamp(1.5rem,6vw,5rem);
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2.5rem;
    align-items: start;
}
@media (max-width: 960px) {
    .booking-body { grid-template-columns: 1fr; }
}

/* ═══════════════════════════════════════════
   CALENDAR
═══════════════════════════════════════════ */
.calendar-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 2px 4px 0 rgba(0,0,0,0.05), 0 2px 16px rgba(0,0,0,0.04);
    position: relative;
}
/* Washi tape on calendar card */
.calendar-card::before {
    content: '';
    position: absolute;
    top: -8px; left: 2rem;
    width: 70px; height: 18px;
    background: rgba(232,168,56,0.55);
    border-radius: 2px;
    transform: rotate(-2deg);
}
.calendar-label {
    font-size: 11px;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--color-muted);
    margin-bottom: 0.35rem;
}
.calendar-title {
    font-family: var(--font-serif);
    font-size: 1.4rem;
    font-weight: 700;
    color: var(--color-dark);
    margin-bottom: 1.5rem;
}

/* FullCalendar overrides — notebook style */
.fc {
    font-family: var(--font-sans) !important;
    font-size: 13px;
}
.fc .fc-toolbar-title {
    font-family: var(--font-serif) !important;
    font-size: 1.1rem !important;
    font-weight: 700 !important;
    color: var(--color-dark) !important;
}
.fc .fc-button {
    background: white !important;
    border: 1.5px solid var(--color-border) !important;
    color: var(--color-dark) !important;
    border-radius: 8px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    padding: 0.3rem 0.75rem !important;
    box-shadow: 1px 2px 0 rgba(0,0,0,0.05) !important;
    transition: all 0.2s !important;
}
.fc .fc-button:hover {
    border-color: var(--color-teal) !important;
    color: var(--color-teal) !important;
    box-shadow: 2px 3px 0 rgba(59,122,107,0.15) !important;
}
.fc .fc-button:focus { box-shadow: none !important; outline: none !important; }
.fc .fc-button-primary:not(:disabled).fc-button-active {
    background: var(--color-teal) !important;
    border-color: var(--color-teal) !important;
    color: white !important;
}
.fc .fc-col-header-cell-cushion {
    font-size: 11px !important;
    font-weight: 600 !important;
    letter-spacing: 0.08em !important;
    color: var(--color-muted) !important;
    padding: 0.5rem 0 !important;
    text-decoration: none !important;
}
.fc .fc-daygrid-day-number {
    font-size: 12px !important;
    color: var(--color-dark) !important;
    text-decoration: none !important;
    padding: 0.35rem 0.5rem !important;
}
.fc .fc-daygrid-day.fc-day-today {
    background: rgba(59,122,107,0.06) !important;
}
.fc .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
    background: var(--color-teal) !important;
    color: white !important;
    border-radius: 50% !important;
    width: 26px; height: 26px;
    display: flex !important; align-items: center !important; justify-content: center !important;
    font-weight: 700 !important;
}
.fc .fc-daygrid-day:hover {
    background: var(--color-teal-light) !important;
    cursor: pointer;
}
.fc .fc-daygrid-day.selected-day {
    background: rgba(59,122,107,0.12) !important;
    outline: 2px solid var(--color-teal);
    outline-offset: -2px;
    border-radius: 4px;
}
.fc th { border-color: var(--color-border) !important; }
.fc td { border-color: var(--color-border) !important; }
.fc .fc-scrollgrid { border-color: var(--color-border) !important; }
.fc .fc-daygrid-day.fc-day-sun .fc-daygrid-day-number { color: #e07070 !important; }
.fc .fc-daygrid-day.fc-day-sat .fc-daygrid-day-number { color: var(--color-teal) !important; }
/* Available event dots */
.fc-event {
    border-radius: 4px !important;
    border: none !important;
    font-size: 11px !important;
    font-weight: 600 !important;
    padding: 2px 6px !important;
}

/* Selected date display */
.selected-date-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
    padding: 0.6rem 1rem;
    background: var(--color-teal-light);
    border-radius: 8px;
    font-size: 13px;
    color: var(--color-teal);
    font-weight: 600;
    min-height: 40px;
}
.selected-date-display.empty { background: #f5f5f3; color: var(--color-muted); font-weight: 400; }

/* ═══════════════════════════════════════════
   BOOKING FORM
═══════════════════════════════════════════ */
.form-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 2px 4px 0 rgba(0,0,0,0.05), 0 2px 16px rgba(0,0,0,0.04);
    position: relative;
    /* Sticky so it scrolls with user on desktop */
    position: sticky;
    top: 88px;
}
.form-card::before {
    content: '';
    position: absolute;
    top: -8px; right: 2rem;
    width: 60px; height: 18px;
    background: rgba(155,142,196,0.5);
    border-radius: 2px;
    transform: rotate(2deg);
}
.form-title {
    font-family: var(--font-serif);
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--color-dark);
    margin-bottom: 0.25rem;
}
.form-subtitle {
    font-size: 12px;
    color: var(--color-muted);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}
.form-group { margin-bottom: 1.1rem; }
.form-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--color-dark);
    letter-spacing: 0.04em;
    margin-bottom: 0.4rem;
}
.form-label .req { color: var(--color-rose); margin-left: 2px; }
.form-input, .form-textarea, .form-select {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--color-border);
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 13px;
    color: var(--color-dark);
    background: var(--color-bg);
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-input:focus, .form-textarea:focus, .form-select:focus {
    border-color: var(--color-teal);
    box-shadow: 0 0 0 3px rgba(59,122,107,0.1);
    background: white;
}
.form-textarea { resize: vertical; min-height: 90px; line-height: 1.6; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.form-date-preview {
    padding: 0.65rem 0.9rem;
    border: 1.5px solid var(--color-teal);
    border-radius: 10px;
    background: var(--color-teal-light);
    font-size: 13px;
    color: var(--color-teal);
    font-weight: 600;
    min-height: 42px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.form-date-preview.empty {
    border-color: var(--color-border);
    background: var(--color-bg);
    color: var(--color-muted);
    font-weight: 400;
}
.form-submit {
    width: 100%;
    padding: 0.85rem 1.5rem;
    border-radius: 12px;
    border: none;
    background: var(--color-teal);
    color: white;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 700;
    letter-spacing: 0.06em;
    cursor: pointer;
    box-shadow: 2px 4px 0 rgba(59,122,107,0.35);
    transition: transform 0.2s, box-shadow 0.2s;
    margin-top: 0.5rem;
}
.form-submit:hover {
    transform: translate(-1px,-2px);
    box-shadow: 3px 6px 0 rgba(59,122,107,0.35);
}
.form-submit:active { transform: translate(0,0); box-shadow: 1px 2px 0 rgba(59,122,107,0.35); }

/* Validation errors */
.field-error { font-size: 11px; color: var(--color-rose); margin-top: 0.3rem; }
.form-input.error, .form-textarea.error { border-color: var(--color-rose); }

/* Tips strip */
.booking-tips {
    margin-top: 2.5rem;
    padding: clamp(2rem,4vw,3rem) clamp(1.5rem,6vw,5rem);
    background: #f3ede4;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 1.5rem;
}
.tip-card {
    display: flex;
    gap: 1rem;
    align-items: flex-start;
}
.tip-icon {
    font-size: 1.75rem;
    flex-shrink: 0;
    line-height: 1;
    margin-top: 2px;
}
.tip-title { font-size: 13px; font-weight: 600; color: var(--color-dark); margin-bottom: 0.25rem; }
.tip-body  { font-size: 12px; color: var(--color-muted); line-height: 1.7; }
</style>

{{-- Hero --}}
<section class="booking-hero">
    <div class="hero-content">
        <span class="hero-sticker fade-in">Course Booking</span>
        <h1 class="fade-up">預約課程</h1>
        <p class="fade-up">選擇您希望的授課日期，填寫申請資料後送出，協會將盡快與您確認。</p>
    </div>
</section>

{{-- Body --}}
<div class="booking-body">

    {{-- Calendar --}}
    <div>
        <div class="calendar-card fade-up">
            <p class="calendar-label">Step 1</p>
            <h2 class="calendar-title">選擇預約日期 📅</h2>
            <div id="booking-calendar"></div>
            <div class="selected-date-display empty" id="date-display">
                📆 請在日曆上點選希望預約的日期
            </div>
        </div>

        {{-- Tips --}}
        <div style="margin-top:1.5rem; display:grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap:1rem;">
            <div class="calendar-card" style="padding:1.25rem;">
                <div class="tip-card">
                    <span class="tip-icon">📋</span>
                    <div>
                        <div class="tip-title">申請流程</div>
                        <div class="tip-body">送出申請後，協會秘書將於 3 個工作天內與您聯繫確認。</div>
                    </div>
                </div>
            </div>
            <div class="calendar-card" style="padding:1.25rem;">
                <div class="tip-card">
                    <span class="tip-icon">🏫</span>
                    <div>
                        <div class="tip-title">適合對象</div>
                        <div class="tip-body">社福機構、社工系所、政府單位皆可申請到府講授或線上培訓。</div>
                    </div>
                </div>
            </div>
            <div class="calendar-card" style="padding:1.25rem;">
                <div class="tip-card">
                    <span class="tip-icon">⏱️</span>
                    <div>
                        <div class="tip-title">課程時數</div>
                        <div class="tip-body">可申請半天（3小時）或全天（6小時），請在備註欄說明需求。</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="form-card fade-up">
        <p style="font-size:11px;letter-spacing:.15em;text-transform:uppercase;color:var(--color-muted);margin-bottom:.35rem;">Step 2</p>
        <h2 class="form-title">填寫申請資料 ✏️</h2>
        <p class="form-subtitle">請填寫以下資訊，我們將盡快與您聯絡。</p>

        <form method="POST" action="{{ route('booking.store') }}" id="booking-form" novalidate>
            @csrf

            {{-- Hidden date field --}}
            <input type="hidden" name="requested_date" id="requested_date" value="{{ old('requested_date') }}">

            {{-- Date preview --}}
            <div class="form-group">
                <label class="form-label">預約日期 <span class="req">*</span></label>
                <div class="form-date-preview {{ old('requested_date') ? '' : 'empty' }}" id="date-preview">
                    {{ old('requested_date') ? '📅 ' . old('requested_date') : '請先在左方日曆點選日期' }}
                </div>
                @error('requested_date')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="institution_name">機構名稱 <span class="req">*</span></label>
                <input class="form-input @error('institution_name') error @enderror"
                       type="text" id="institution_name" name="institution_name"
                       value="{{ old('institution_name') }}" placeholder="例：臺北市家庭服務中心" required>
                @error('institution_name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="contact_email">聯絡 Email <span class="req">*</span></label>
                    <input class="form-input @error('contact_email') error @enderror"
                           type="email" id="contact_email" name="contact_email"
                           value="{{ old('contact_email') }}" placeholder="contact@org.tw" required>
                    @error('contact_email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label" for="contact_phone">聯絡電話</label>
                    <input class="form-input"
                           type="tel" id="contact_phone" name="contact_phone"
                           value="{{ old('contact_phone') }}" placeholder="02-1234-5678">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="location">上課地點</label>
                <input class="form-input"
                       type="text" id="location" name="location"
                       value="{{ old('location') }}" placeholder="例：臺北市中正區（或線上）">
            </div>

            <div class="form-group">
                <label class="form-label" for="teaching_hours">授課時數／形式</label>
                <input class="form-input"
                       type="text" id="teaching_hours" name="teaching_hours"
                       value="{{ old('teaching_hours') }}" placeholder="例：半天 3 小時、線上 2 小時">
            </div>

            <div class="form-group">
                <label class="form-label" for="expectations">課程需求說明</label>
                <textarea class="form-textarea"
                          id="expectations" name="expectations"
                          placeholder="請描述貴機構對課程的期待、學員背景、特殊需求等…">{{ old('expectations') }}</textarea>
            </div>

            <button type="submit" class="form-submit" id="submit-btn">
                送出預約申請 →
            </button>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl     = document.getElementById('booking-calendar');
    const hiddenDate     = document.getElementById('requested_date');
    const dateDisplay    = document.getElementById('date-display');
    const datePreview    = document.getElementById('date-preview');
    let   selectedDate   = '{{ old('requested_date') }}';

    function formatDisplay(dateStr) {
        if (!dateStr) return null;
        const d = new Date(dateStr + 'T00:00:00');
        return `${d.getFullYear()} 年 ${d.getMonth()+1} 月 ${d.getDate()} 日（${['日','一','二','三','四','五','六'][d.getDay()]}）`;
    }

    // Restore previously selected date label
    if (selectedDate) {
        const label = formatDisplay(selectedDate);
        dateDisplay.classList.remove('empty');
        dateDisplay.textContent = '📅 已選：' + label;
        datePreview.classList.remove('empty');
        datePreview.textContent = '📅 ' + label;
    }

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'zh-tw',
        headerToolbar: {
            left:   'prev',
            center: 'title',
            right:  'next'
        },
        height: 'auto',
        selectable: false,
        validRange: { start: new Date().toISOString().split('T')[0] },
        dayCellDidMount: function(info) {
            info.el.addEventListener('click', function () {
                const dateStr = info.date.toISOString().split('T')[0];
                // Don't allow past dates
                const today = new Date(); today.setHours(0,0,0,0);
                if (info.date < today) return;

                // Remove previous selection highlight
                document.querySelectorAll('.fc-daygrid-day.selected-day')
                    .forEach(el => el.classList.remove('selected-day'));

                info.el.classList.add('selected-day');
                selectedDate = dateStr;
                hiddenDate.value = dateStr;

                const label = formatDisplay(dateStr);
                dateDisplay.classList.remove('empty');
                dateDisplay.textContent = '📅 已選：' + label;
                datePreview.classList.remove('empty');
                datePreview.textContent = '📅 ' + label;

                // Smooth scroll to form on mobile
                if (window.innerWidth < 960) {
                    document.querySelector('.form-card').scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        },
        // Example available slots (visual only)
        events: [
            { title: '可預約', start: getNextWeekday(1), color: '#3b7a6b', textColor: 'white' },
            { title: '可預約', start: getNextWeekday(3), color: '#3b7a6b', textColor: 'white' },
            { title: '可預約', start: getNextWeekday(5), color: '#e8a838', textColor: 'white' },
        ],
    });

    calendar.render();

    // Restore highlight after render if old value
    if (selectedDate) {
        setTimeout(() => {
            document.querySelectorAll('.fc-daygrid-day').forEach(el => {
                if (el.dataset.date === selectedDate) el.classList.add('selected-day');
            });
        }, 100);
    }

    // Form validation
    document.getElementById('booking-form').addEventListener('submit', function (e) {
        if (!hiddenDate.value) {
            e.preventDefault();
            dateDisplay.style.background = 'rgba(224,112,112,0.1)';
            dateDisplay.style.color = 'var(--color-rose)';
            dateDisplay.textContent = '⚠️ 請先在日曆點選預約日期';
            dateDisplay.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});

function getNextWeekday(daysFromNow) {
    const d = new Date();
    d.setDate(d.getDate() + daysFromNow + Math.floor(daysFromNow / 5) * 2);
    return d.toISOString().split('T')[0];
}
</script>

{{-- Hero animation --}}
<script>
gsap.timeline({ delay: 0.15 })
    .to('.booking-hero .fade-in', { opacity:1, duration:0.6 })
    .to('.booking-hero .fade-up', { opacity:1, y:0, duration:0.8, ease:'power3.out', stagger:0.15 }, '-=0.3');
</script>
@endsection
