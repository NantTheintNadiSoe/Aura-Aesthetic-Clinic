<?php

if (session_status() === PHP_SESSION_NONE) session_start();
include('connect.php');


$patientNotiCount = 0;
$patientNotiItems = [];
$staffNotiCount = 0;
$staffNotiItems = [];


if (isset($_SESSION['pid'])) {
    $pid = mysqli_real_escape_string($connect, $_SESSION['pid']);

    // Recommendations
    $q = mysqli_query($connect, "
        SELECT r.RecommendationDate
        FROM recommendation r
        JOIN skinassessment sa ON r.AssessmentCode = sa.AssessmentCode
        WHERE sa.PatientID = '$pid' AND r.IsNotified = 1
        ORDER BY r.RecommendationDate DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $patientNotiCount++;
        $patientNotiItems[] = "<div class='px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            New recommendation on <b>" . htmlspecialchars($r['RecommendationDate']) . "</b>
        </div>";
    }

    // Confirmed Appointments
    $q = mysqli_query($connect, "
        SELECT AppointmentDate, AppointmentTime
        FROM appointment
        WHERE PatientID='$pid' AND Status='Confirmed' AND IsNotified=1
        ORDER BY AppointmentDate DESC, AppointmentTime DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $patientNotiCount++;
        $patientNotiItems[] = "<div class='px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            Appointment confirmed for <b>" . htmlspecialchars($r['AppointmentDate']) . "</b> at <b>" . htmlspecialchars($r['AppointmentTime']) . "</b>
        </div>";
    }

    // Confirmed Orders
    $q = mysqli_query($connect, "
        SELECT OrderCode, OrderDate, TotalAmount
        FROM orders
        WHERE PatientID='$pid' AND Status='Confirmed' AND IsNotified=1
        ORDER BY OrderDate DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $patientNotiCount++;
        $patientNotiItems[] = "<div class='px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            Order <b>" . htmlspecialchars($r['OrderCode']) . "</b> confirmed on <b>" . htmlspecialchars($r['OrderDate']) . "</b> (MMK " . number_format($r['TotalAmount'], 2) . ")
        </div>";
    }

    // Confirmed Skin Assessments
    $q = mysqli_query($connect, "
        SELECT AssessmentDate, SkinConcern
        FROM skinassessment
        WHERE PatientID='$pid' AND Status='Confirmed' AND IsNotified=1
        ORDER BY AssessmentDate DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $patientNotiCount++;
        $patientNotiItems[] = "<div class='px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            Consultation confirmed on <b>" . htmlspecialchars($r['AssessmentDate']) . "</b> (Concern: <b>" . htmlspecialchars($r['SkinConcern']) . "</b>)
        </div>";
    }
}


if (isset($_SESSION['sid'])) {
    $sid = mysqli_real_escape_string($connect, $_SESSION['sid']);

    $staffNotiCount = 0;
    $staffNotiItems = [];

    // Pending Appointments
    $q = mysqli_query($connect, "
        SELECT a.AppointmentCode, a.AppointmentDate, a.AppointmentTime, p.Name
        FROM appointment a
        JOIN patientregister p ON a.PatientID = p.PatientID
        WHERE a.Status != 'Active' 
        ORDER BY a.AppointmentDate DESC, a.AppointmentTime DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $staffNotiCount++;
        $staffNotiItems[] = "<a href='appointmentlist.php#" . htmlspecialchars($r['AppointmentCode']) . "' class='block px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            New appointment: <b>" . htmlspecialchars($r['Name']) . "</b> on <b>" . htmlspecialchars($r['AppointmentDate']) . "</b> at <b>" . htmlspecialchars($r['AppointmentTime']) . "</b>
        </a>";
    }

    // Pending Orders
    $q = mysqli_query($connect, "
        SELECT o.OrderCode, o.OrderDate, p.Name
        FROM orders o
        JOIN patientregister p ON o.PatientID = p.PatientID
        WHERE o.Status != 'Active' 
        ORDER BY o.OrderDate DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $staffNotiCount++;
        $staffNotiItems[] = "<a href='orderlist.php#" . htmlspecialchars($r['OrderCode']) . "' class='block px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            New order: <b>" . htmlspecialchars($r['Name']) . "</b> on <b>" . htmlspecialchars($r['OrderDate']) . "</b>
        </a>";
    }

    // Consultations
    $q = mysqli_query($connect, "
        SELECT c.ConsultationCode, c.ConsultationDate, c.ConsultationTime, p.Name
        FROM consultation c
        JOIN patientregister p ON c.PatientID = p.PatientID
        WHERE c.Status != 'Active' 
        ORDER BY c.ConsultationDate DESC, c.ConsultationTime DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $staffNotiCount++;
        $staffNotiItems[] = "<a href='consultationlist.php#" . htmlspecialchars($r['ConsultationCode']) . "' class='block px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            New consultation: <b>" . htmlspecialchars($r['Name']) . "</b> on <b>" . htmlspecialchars($r['ConsultationDate']) . "</b> at <b>" . htmlspecialchars($r['ConsultationTime']) . "</b>
        </a>";
    }

    // Pending Skin Assessments
    $q = mysqli_query($connect, "
        SELECT sa.AssessmentCode, sa.AssessmentDate, p.Name
        FROM skinassessment sa
        JOIN patientregister p ON sa.PatientID = p.PatientID
        WHERE sa.Status != 'Active' 
        ORDER BY sa.AssessmentDate DESC
    ");
    while ($r = mysqli_fetch_assoc($q)) {
        $staffNotiCount++;
        $staffNotiItems[] = "<a href='skinassessmentlist.php#" . htmlspecialchars($r['AssessmentCode']) . "' class='block px-4 py-2 border-b text-sm hover:bg-[#F7EFEF]'>
            New skin assessment: <b>" . htmlspecialchars($r['Name']) . "</b> on <b>" . htmlspecialchars($r['AssessmentDate']) . "</b>
        </a>";
    }
}
?>
<!-- NAVBAR -->
<nav class="flex items-center justify-between bg-[#916D7A] px-4 sm:px-6 py-3 shadow-md text-white relative z-50">
    <!-- Logo and Mobile Menu Button -->
    <div class="flex items-center justify-between w-full lg:w-auto">
        <!-- Logo -->
        <div class="flex items-center space-x-3">
            <img src="./image/logo2.jpg" alt="Aura Clinic Logo" class="h-10 w-10 sm:h-12 sm:w-12 object-cover rounded-full border-2 border-white" />
            <div class="leading-tight text-white" style="font-family: 'Playfair Display', serif;">
                <div class="text-lg sm:text-xl font-bold">Aura</div>
                <div class="text-xs sm:text-sm tracking-wide">Aesthetic Clinic</div>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button onclick="toggleMenu()" class="lg:hidden focus:outline-none ml-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex flex-1 items-center justify-between ml-8">
        <ul class="flex space-x-6 font-medium">
            <li><a href="index.php" class="hover:text-[#EBD5DC] transition">Home</a></li>
            <li><a href="about.php" class="hover:text-[#EBD5DC] transition">About Us</a></li>
            <li><a href="treatment.php" class="hover:text-[#EBD5DC] transition">Treatments</a></li>
            <li><a href="skinassessment.php" class="hover:text-[#EBD5DC] transition">Skin Assessment</a></li>
            <li><a href="consultation.php" class="hover:text-[#EBD5DC] transition">Consultation</a></li>

            <!-- More Menu Dropdown for Laptop -->
            <li class="relative">
                <button onclick="toggleDropdown('moreDropdown')" class="flex items-center space-x-1 hover:text-[#EBD5DC] transition focus:outline-none">
                    <span>More</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="moreDropdown" class="absolute left-0 mt-2 w-48 bg-white text-gray-700 rounded shadow-lg hidden z-50">
                    <a href="faq.php" class="block px-4 py-2 hover:bg-[#F7EFEF] border-b">FAQ</a>
                    <a href="contact.php" class="block px-4 py-2 hover:bg-[#F7EFEF] border-b">Contact Us</a>
                    <a href="productview.php" class="block px-4 py-2 hover:bg-[#F7EFEF] border-b">Shops</a>
                    <a href="feedback.php" class="block px-4 py-2 hover:bg-[#F7EFEF]">Feedbacks</a>
                </div>
            </li>
        </ul>

        <!-- Right Side - Desktop -->
        <div class="flex items-center space-x-4 ml-6">
            <!-- Book Appointment -->
            <a href="appointment.php" class="px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">
                Book Appointment
            </a>

            <!-- Notifications & Cart -->
            <?php if (isset($_SESSION['pid'])): ?>
                <!-- Patient Notifications -->
                <div class="relative">
                    <button onclick="toggleDropdown('patientNotiDropdown'); markPatientNotificationsRead();" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.29 1.29A1 1 0 0 0 6 19h12a1 1 0 0 0 .71-1.71z" />
                        </svg>
                        <?php if ($patientNotiCount > 0): ?>
                            <span id="patientNotiBadge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5"><?= $patientNotiCount ?></span>
                        <?php endif; ?>
                    </button>
                    <div id="patientNotiDropdown" class="absolute right-0 mt-2 w-80 sm:w-96 bg-white text-gray-700 rounded shadow-lg hidden z-50">
                        <div class="p-4 border-b font-semibold text-[#916D7A]">Your Notifications</div>
                        <div class="max-h-96 overflow-y-auto">
                            <?php
                            if (!empty($patientNotiItems)) {
                                foreach ($patientNotiItems as $item) echo $item;
                            } else {
                                echo '<div class="px-4 py-6 text-center text-gray-400">No new notifications.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_SESSION['sid'])): ?>
                <!-- Staff Notifications -->
                <div class="relative">
                    <button onclick="toggleDropdown('staffNotiDropdown'); markStaffNotificationsRead();" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 22a2 2 0 0 0 2-2h-4a2 2 0 0 0 2 2zm6-6V11c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.29 1.29A1 1 0 0 0 6 19h12a1 1 0 0 0 .71-1.71z" />
                        </svg>
                        <?php if ($staffNotiCount > 0): ?>
                            <span id="staffNotiBadge" class="absolute -top-2 -right-2 bg-blue-500 text-white text-xs font-bold rounded-full px-2 py-0.5"><?= $staffNotiCount ?></span>
                        <?php endif; ?>
                    </button>
                    <div id="staffNotiDropdown" class="absolute right-0 mt-2 w-80 sm:w-96 bg-white text-gray-700 rounded shadow-lg hidden z-50">
                        <div class="p-4 border-b font-semibold text-[#916D7A]">Staff Notifications</div>
                        <div class="max-h-96 overflow-y-auto">
                            <?php
                            if (!empty($staffNotiItems)) {
                                foreach ($staffNotiItems as $item) echo $item;
                            } else {
                                echo '<div class="px-4 py-6 text-center text-gray-400">No new notifications.</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Shopping Cart -->
            <div class="relative">
                <a href="ShoppingCart.php" title="View Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7 22q-.825 0-1.412-.587T5 20t.588-1.412T7 18t1.413.588T9 20t-.587 1.413T7 22m10 0q-.825 0-1.412-.587T15 20t.588-1.412T17 18t1.413.588T19 20t-.587 1.413T17 22M5.2 4h14.75q.575 0 .875.513t.025 1.037l-3.55 6.4q-.275 0-.737.775T15.55 13H8.1L7 15h11q.425 0 .713.288T19 16t-.288.713T18 17H7q-1.125 0-1.7-.987t-.05-1.963L6.6 11.6L3 4H2q-.425 0-.712-.288T1 3t.288-.712T2 2h1.625q.275 0 .525.15t.375.425z" />
                    </svg>
                    <?php
                    $cartCount = 0;
                    if (isset($_SESSION['pid']) && isset($_SESSION['ShoppingCart'])) {
                        foreach ($_SESSION['ShoppingCart'] as $item) $cartCount += $item['Quantity'] ?? 1;
                    } elseif (isset($_SESSION['sid']) && isset($_SESSION['StaffCart'])) {
                        foreach ($_SESSION['StaffCart'] as $item) $cartCount += $item['Quantity'] ?? 1;
                    }
                    if ($cartCount > 0) echo '<span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full px-2 py-0.5">' . $cartCount . '</span>';
                    ?>
                </a>
            </div>

            <!-- Profile / Login -->
            <?php
            if (!isset($_SESSION['pid']) && !isset($_SESSION['sid'])) {
                echo '<a href="login.php" title="Patient Login" class="hidden lg:block">
                        <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                      </a>';
            } elseif (isset($_SESSION['pid'])) {
                $name = $_SESSION['pname'] ?? 'Patient'; ?>
                <div class="relative">
                    <button onclick="toggleDropdown('userDropdown')" class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-lg font-semibold"><?= htmlspecialchars($name) ?></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="userDropdown" class="absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded shadow-lg hidden">
                        <a href="patientdashboard.php" class="block px-4 py-2 hover:bg-gray-100">Profile View</a>
                        <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            <?php } elseif (isset($_SESSION['sid'])) {
                $staffName = $_SESSION['sname'] ?? 'Staff'; ?>
                <div class="relative">
                    <button onclick="toggleDropdown('staffDropdown')" class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-lg font-semibold"><?= htmlspecialchars($staffName) ?></span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="staffDropdown" class="absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded shadow-lg hidden">
                        <a href="staffdashboard.php" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                        <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="absolute inset-x-0 top-full bg-[#916D7A] border-t shadow-lg lg:hidden hidden z-50">
        <div class="px-4 py-6 space-y-6">
            <!-- Main Navigation Links -->
            <ul class="space-y-4 font-medium">
                <li><a href="index.php" class="block py-2 hover:text-[#EBD5DC] transition">Home</a></li>
                <li><a href="about.php" class="block py-2 hover:text-[#EBD5DC] transition">About Us</a></li>
                <li><a href="treatment.php" class="block py-2 hover:text-[#EBD5DC] transition">Treatments</a></li>
                <li><a href="skinassessment.php" class="block py-2 hover:text-[#EBD5DC] transition">Skin Assessment</a></li>
                <li><a href="consultation.php" class="block py-2 hover:text-[#EBD5DC] transition">Consultation</a></li>
            </ul>

            <!-- Additional Links -->
            <ul class="space-y-4 font-medium border-t border-[#EBD5DC] pt-4">
                <li><a href="faq.php" class="block py-2 hover:text-[#EBD5DC]">FAQ</a></li>
                <li><a href="contact.php" class="block py-2 hover:text-[#EBD5DC]">Contact Us</a></li>
                <li><a href="productview.php" class="block py-2 hover:text-[#EBD5DC]">Shops</a></li>
                <li><a href="feedback.php" class="block py-2 hover:text-[#EBD5DC]">Feedbacks</a></li>
            </ul>

            <!-- Mobile Actions -->
            <div class="border-t border-[#EBD5DC] pt-4 space-y-4">
                <?php if (!isset($_SESSION['pid']) && !isset($_SESSION['sid'])): ?>
                    <a href="login.php" class="block w-full text-center px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">
                        Login
                    </a>
                <?php endif; ?>

                <a href="appointment.php" class="block w-full text-center px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">
                    Book Appointment
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('hidden');

        // Close other dropdowns when opening a new one
        if (!el.classList.contains('hidden')) {
            const allDropdowns = ['userDropdown', 'staffDropdown', 'patientNotiDropdown', 'staffNotiDropdown', 'moreDropdown'];
            allDropdowns.forEach(dropdownId => {
                if (dropdownId !== id) {
                    const otherEl = document.getElementById(dropdownId);
                    if (otherEl) otherEl.classList.add('hidden');
                }
            });
        }
    }

    function toggleMenu() {
        const m = document.getElementById('mobile-menu');
        if (!m) return;
        m.classList.toggle('hidden');
    }

    function markPatientNotificationsRead() {
        var badge = document.getElementById('patientNotiBadge');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'mark_notifications_read.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.success && badge) badge.remove();
                } catch (e) {}
            }
        };
        xhr.send('mark=1');
    }

    function markStaffNotificationsRead() {
        var badge = document.getElementById('staffNotiBadge');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'mark_staff_notifications_read.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                try {
                    var res = JSON.parse(xhr.responseText);
                    if (res.success && badge) badge.remove();
                } catch (e) {}
            }
        };
        xhr.send('mark=1');
    }

    window.addEventListener('click', function(e) {
        const ids = ['userDropdown', 'staffDropdown', 'patientNotiDropdown', 'staffNotiDropdown', 'moreDropdown'];
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            const button = el.previousElementSibling;
            if (!el.contains(e.target) && (!button || !button.contains(e.target))) el.classList.add('hidden');
        });
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburger = document.querySelector('button[onclick="toggleMenu()"]');
        if (mobileMenu && hamburger && !mobileMenu.contains(e.target) && !hamburger.contains(e.target)) mobileMenu.classList.add('hidden');
    });


    document.querySelectorAll('#mobile-menu a').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.add('hidden');
        });
    });
</script>