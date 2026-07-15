<div class="card border-0 shadow-sm rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h6 class="fw-bold mb-0">Schedule Calendar</h6>
            <small class="text-muted" id="month-year"></small>
        </div>
        <div class="d-flex gap-1">
            <button id="prev-month" class="btn-cal-nav">&lt;</button>
            <button id="next-month" class="btn-cal-nav">&gt;</button>
        </div>
    </div>
    
    <div class="calendar-weekdays-grid">
        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
    </div>
    
    <div class="calendar-days-grid" id="calendar-days">
        </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const monthYearText = document.getElementById("month-year");
    const calendarDaysContainer = document.getElementById("calendar-days");
    const prevBtn = document.getElementById("prev-month");
    const nextBtn = document.getElementById("next-month");

    let currentDate = new Date();
    let today = new Date();

    const months = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    function renderCalendar() {
        if (!calendarDaysContainer || !monthYearText) return;
        
        calendarDaysContainer.innerHTML = "";
        let year = currentDate.getFullYear();
        let month = currentDate.getMonth();

        monthYearText.innerText = `${months[month]} ${year}`;

        let firstDayIndex = new Date(year, month, 1).getDay();
        let totalDays = new Date(year, month + 1, 0).getDate();

        // Elemen kosong (offset hari pertama bulan)
        for (let i = 0; i < firstDayIndex; i++) {
            const emptyDiv = document.createElement("div");
            emptyDiv.classList.add("cal-day", "empty");
            calendarDaysContainer.appendChild(emptyDiv);
        }

        // Generate tanggal
        for (let day = 1; day <= totalDays; day++) {
            const dayDiv = document.createElement("div");
            dayDiv.classList.add("cal-day");
            dayDiv.innerText = day;

            // Tandai hari ini
            if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                dayDiv.classList.add("active");
            }
            calendarDaysContainer.appendChild(dayDiv);
        }
    }

    if (prevBtn && nextBtn) {
        prevBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();
        });

        nextBtn.addEventListener("click", () => {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();
        });
    }

    renderCalendar();
});
</script>