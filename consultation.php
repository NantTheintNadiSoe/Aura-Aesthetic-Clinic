<?php
session_start();
include('connect.php');
include('AutoIDFunction.php');

// Only allow access if patient is logged in
if (!isset($_SESSION['pid'])) {
    echo "<script>alert('Access denied! Please login first.');</script>";
    echo "<script>window.location='login.php';</script>";
    exit();
}

// Fetch already booked appointments
$bookedAppointments = array();
$bookedQuery = "SELECT ConsultationDate, ConsultationTime FROM consultation WHERE Status = 'Active'";
$bookedResult = mysqli_query($connect, $bookedQuery);
if ($bookedResult) {
    while ($row = mysqli_fetch_assoc($bookedResult)) {
        $date = $row['ConsultationDate'];
        $time = $row['ConsultationTime'];
        if (!isset($bookedAppointments[$date])) {
            $bookedAppointments[$date] = array();
        }
        $bookedAppointments[$date][] = $time;
    }
}

// Convert the booked appointments to JSON for JavaScript
$bookedAppointmentsJson = json_encode($bookedAppointments);

$consultationCode = AutoID("consultation", "ConsultationCode", "C_", 6);
if (isset($_POST['btnsubmit'])) {
    $pid = $_SESSION['pid'];
    $name = $_POST['name'];
    $consultation_type = $_POST['consultation_type'];
    $consultation_date = $_POST['consultation_date'];
    $consultation_time = $_POST['consultation_time'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);
    $status = "Active";

    // Check if the selected time slot is still available
    $checkAvailability = "SELECT * FROM consultation 
                         WHERE ConsultationDate = '$consultation_date' 
                         AND ConsultationTime = '$consultation_time' 
                         AND Status = 'Active'";
    $availabilityResult = mysqli_query($connect, $checkAvailability);

    if (mysqli_num_rows($availabilityResult) > 0) {
        echo "<script>alert('Sorry, the selected time slot is no longer available. Please choose another time.');</script>";
    } else {
        $insert = "INSERT INTO consultation 
        (ConsultationCode, PatientID, ConsultationType, ConsultationDate, ConsultationTime, Name, Email, PhoneNumber, Message, Status)
        VALUES
        ('$consultationCode', '$pid', '$consultation_type', '$consultation_date', '$consultation_time', '$name', '$email', '$phone', '$message', '$status')";

        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('Consultation submitted successfully!');</script>";
            // Refresh the page to update the available time slots
            echo "<script>window.location.href = 'consultation.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error occurred while submitting.');</script>";
        }
    }
}
?>

<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<!-- Header Section -->
<header class="relative py-24 bg-gradient-to-br from-[#BA9EA8] to-[#7A4E5E] text-white overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: url('https://placehold.co/2000x500/BA9EA8/FFFFFF?text=Aura+Aesthetic'); background-size: cover;"></div>
    <div class="container mx-auto px-6 text-center relative z-10">
        <h1 class="text-5xl md:text-6xl font-bold mb-6">Book a Consultation</h1>
        <p class="text-xl max-w-3xl mx-auto">
            Schedule a consultation and receive personalized skincare advice.
        </p>
    </div>
</header>

<body class="bg-[#FFF8F5] text-[#4C2A36] font-sans">
    <div class="max-w-3xl mx-auto px-6 py-10 bg-white rounded shadow mt-10 mb-10">
        <form id="consultationForm" action="consultation.php" method="POST" class="space-y-8">
            <input type="hidden" name="ConsultationCode" value="<?php echo $consultationCode; ?>">
            <!-- HIDDEN INPUTS to store selected date and time -->
            <input type="hidden" name="consultation_date" id="consultation_date" required>
            <input type="hidden" name="consultation_time" id="consultation_time" required>

            <!-- Step 1 -->
            <div id="step1">
                <h2 class="text-xl font-semibold mb-4 text-[#4C2A36]">Step 1 of 3: Choose Consultation Type</h2>
                <p class="text-[#6B7280] mb-6">Select how you'd like to meet with our skincare specialist.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Virtual Option -->
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-[#FFF0F5] block">
                        <input type="radio" name="consultation_type" value="virtual" class="hidden peer" checked>
                        <div class="flex items-start gap-3 peer-checked:bg-[#FFF0F5]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#916D7A] mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <p class="font-medium text-[#4C2A36]">Virtual Consultation</p>
                                <p class="text-sm text-[#6B7280]">Connect with us online via video call from anywhere at your convenience.</p>
                            </div>
                        </div>
                    </label>

                    <!-- In-Person Option -->
                    <label class="border p-4 rounded-lg cursor-pointer hover:bg-[#FFF0F5] block">
                        <input type="radio" name="consultation_type" value="in-person" class="hidden peer">
                        <div class="flex items-start gap-3 peer-checked:bg-[#FFF0F5]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#916D7A] mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <p class="font-medium text-[#4C2A36]">In-Person Consultation</p>
                                <p class="text-sm text-[#6B7280]">Visit our clinic and meet with our consultant face-to-face for a full experience.</p>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" onclick="nextStep(1)" class="bg-[#916D7A] text-white px-6 py-2 rounded hover:bg-[#7b5864]">Next</button>
                </div>
            </div>

            <!-- Step 2 -->
            <div id="step2" class="hidden">
                <h2 class="text-xl font-semibold mb-4">Step 2 of 3: Choose Date & Time</h2>

                <!-- Selected Date Display -->
                <div id="selectedDateDisplay" class="bg-[#FFF0F5] p-3 rounded mb-4 hidden">
                    <p class="font-medium">Selected: <span id="displayDate"></span> at <span id="displayTime"></span></p>
                </div>

                <!-- Calendar -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <button type="button" id="prevMonth" class="hover:text-[#916D7A] text-xl font-bold">&lt;</button>
                        <span id="currentMonth" class="text-lg font-medium"></span>
                        <button type="button" id="nextMonth" class="hover:text-[#916D7A] text-xl font-bold">&gt;</button>
                    </div>
                    <div class="grid grid-cols-7 text-center text-sm text-[#6B7280] font-medium">
                        <div class="py-2 text-red-500">Sun</div>
                        <div class="py-2">Mon</div>
                        <div class="py-2">Tue</div>
                        <div class="py-2">Wed</div>
                        <div class="py-2">Thu</div>
                        <div class="py-2">Fri</div>
                        <div class="py-2 text-blue-500">Sat</div>
                    </div>
                    <div id="calendarDays" class="grid grid-cols-7 text-center mt-2 gap-1"></div>
                </div>

                <!-- Time Slots -->
                <div class="mt-4">
                    <h3 class="font-medium mb-2">Available Time Slots</h3>
                    <div id="timeSlots" class="grid grid-cols-2 md:grid-cols-3 gap-2"></div>
                </div>

                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(2)" class="border px-6 py-2 rounded hover:bg-gray-100">Back</button>
                    <button type="button" onclick="nextStep(2)" class="bg-[#916D7A] text-white px-6 py-2 rounded">Next</button>
                </div>
            </div>

            <!-- Step 3 -->
            <div id="step3" class="hidden">
                <h2 class="text-xl font-semibold mb-4">Step 3 of 3: Your Information</h2>
                <div class="space-y-4">
                    <input type="text" name="name" placeholder="Name" class="w-full px-4 py-2 border rounded" required>
                    <input type="email" name="email" placeholder="Email" class="w-full px-4 py-2 border rounded" required>
                    <input type="tel" name="phone" placeholder="Phone Number" class="w-full px-4 py-2 border rounded" required>
                    <textarea name="message" placeholder="Message" rows="3" class="w-full px-4 py-2 border rounded"></textarea>
                </div>
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="prevStep(3)" class="border px-6 py-2 rounded hover:bg-gray-100">Back</button>
                    <button type="submit" name="btnsubmit" class="bg-[#916D7A] text-white px-6 py-2 rounded">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTime = null;

        // Use the booked appointments from PHP
        let bookedAppointments = <?php echo $bookedAppointmentsJson; ?>;

        function nextStep(step) {
            if (step === 1) {
                document.getElementById(`step${step}`).classList.add('hidden');
                document.getElementById(`step${step + 1}`).classList.remove('hidden');
            } else if (step === 2) {
                if (!selectedDate || !selectedTime) {
                    alert("Please select both date and time.");
                    return;
                }
                document.getElementById('consultation_date').value = formatDate(selectedDate);
                document.getElementById('consultation_time').value = selectedTime;

                document.getElementById(`step${step}`).classList.add('hidden');
                document.getElementById(`step${step + 1}`).classList.remove('hidden');
            }
        }

        function prevStep(step) {
            document.getElementById(`step${step}`).classList.add('hidden');
            document.getElementById(`step${step - 1}`).classList.remove('hidden');
        }

        function renderCalendar(date) {
            const monthNames = ["January", "February", "March", "April", "May", "June", "July",
                "August", "September", "October", "November", "December"
            ];
            document.getElementById('currentMonth').textContent = `${monthNames[date.getMonth()]} ${date.getFullYear()}`;

            const firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
            const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDay = firstDay.getDay();
            const today = new Date();

            let html = '';

            // Previous month days (empty cells)
            for (let i = 0; i < startingDay; i++) {
                html += `<div class="calendar-day p-2 text-gray-400"></div>`;
            }

            // Current month days
            for (let i = 1; i <= daysInMonth; i++) {
                const dayDate = new Date(date.getFullYear(), date.getMonth(), i);
                const dateString = formatDate(dayDate);
                const isToday = dayDate.toDateString() === today.toDateString();
                const isPast = dayDate < today && !isToday;
                const isFullyBooked = bookedAppointments[dateString] && bookedAppointments[dateString].length >= 6; // All slots taken

                let dayClasses = "calendar-day p-2 rounded cursor-pointer text-center";

                if (isPast) {
                    dayClasses += " text-gray-400 cursor-not-allowed";
                } else if (isToday) {
                    dayClasses += " bg-blue-100 font-bold";
                } else if (isFullyBooked) {
                    dayClasses += " bg-red-100 text-gray-500 cursor-not-allowed";
                } else {
                    dayClasses += " hover:bg-[#FFF0F5]";
                }

                // Check if this day is selected
                if (selectedDate && dayDate.getDate() === selectedDate.getDate() &&
                    dayDate.getMonth() === selectedDate.getMonth() &&
                    dayDate.getFullYear() === selectedDate.getFullYear()) {
                    dayClasses += " bg-[#916D7A] text-white";
                }

                html += `<div class="${dayClasses}" ${isPast || isFullyBooked ? '' : `onclick="selectDate(this, ${i})"`}>${i}</div>`;
            }

            document.getElementById('calendarDays').innerHTML = html;
        }

        function selectDate(element, day) {
            document.querySelectorAll('.calendar-day').forEach(el => {
                el.classList.remove('bg-[#916D7A]', 'text-white');
                el.classList.add('text-[#4C2A36]');
            });

            element.classList.remove('text-[#4C2A36]');
            element.classList.add('bg-[#916D7A]', 'text-white');

            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
            selectedTime = null;
            document.getElementById('consultation_time').value = '';

            // Hide the selected date display
            document.getElementById('selectedDateDisplay').classList.add('hidden');

            generateTimeSlots();
        }

        function generateTimeSlots() {
            if (!selectedDate) return;

            const dateString = formatDate(selectedDate);
            const timeOptions = ['9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM'];
            let html = '';

            timeOptions.forEach(time => {
                // Check if this time slot is already booked for this date
                const isBooked = bookedAppointments[dateString] && bookedAppointments[dateString].includes(time);

                if (!isBooked) {
                    let buttonClasses = "time-slot px-3 py-2 border rounded text-center transition-all duration-200";

                    if (selectedTime === time) {
                        buttonClasses += " bg-[#916D7A] text-white border-[#916D7A] scale-105 shadow-md";
                    } else {
                        buttonClasses += " bg-white text-[#4C2A36] border-gray-300 hover:bg-[#FFF0F5]";
                    }

                    html += `<button type="button" class="${buttonClasses}" onclick="selectTime(this, '${time}')">${time}</button>`;
                }
            });

            document.getElementById('timeSlots').innerHTML = html;

            // If no times available
            if (html === '') {
                document.getElementById('timeSlots').innerHTML = `<p class="text-red-500">No available times for this date.</p>`;
            }
        }

        function selectTime(button, time) {
            document.querySelectorAll('.time-slot').forEach(btn => {
                btn.classList.remove('bg-[#916D7A]', 'text-white', 'border-[#916D7A]', 'scale-105', 'shadow-md');
                btn.classList.add('bg-white', 'text-[#4C2A36]', 'border-gray-300');
            });

            button.classList.remove('bg-white', 'text-[#4C2A36]', 'border-gray-300');
            button.classList.add('bg-[#916D7A]', 'text-white', 'border-[#916D7A]', 'scale-105', 'shadow-md');
            selectedTime = time;

            // Update the selected date display
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('displayDate').textContent = selectedDate.toLocaleDateString('en-US', options);
            document.getElementById('displayTime').textContent = selectedTime;
            document.getElementById('selectedDateDisplay').classList.remove('hidden');
        }

        function formatDate(date) {
            let y = date.getFullYear();
            let m = date.getMonth() + 1;
            let d = date.getDate();

            if (m < 10) m = '0' + m;
            if (d < 10) d = '0' + d;

            return `${y}-${m}-${d}`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCalendar(currentDate);

            document.getElementById('prevMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar(currentDate);
                selectedDate = null;
                selectedTime = null;
                document.getElementById('timeSlots').innerHTML = '';
                document.getElementById('selectedDateDisplay').classList.add('hidden');
            });

            document.getElementById('nextMonth').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar(currentDate);
                selectedDate = null;
                selectedTime = null;
                document.getElementById('timeSlots').innerHTML = '';
                document.getElementById('selectedDateDisplay').classList.add('hidden');
            });
        });
    </script>
</body>

</html>