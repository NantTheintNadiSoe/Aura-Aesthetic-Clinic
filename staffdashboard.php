<?php
session_start();
if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];
$staffName = $_SESSION['sname'] ?? 'Staff';
include('connect.php');

if (!isset($connect) || !$connect) {
    die('<div style="color:red; font-weight:bold; padding:2em;">Database connection failed. Please check your connect.php file.</div>');
}


$patientCount = $appointmentCount = $consultationCount = $orderCount = $skinAssessmentCount = 0;

// Total patients
$sql1 = "SELECT COUNT(*) AS cnt FROM patientregister";
$res1 = mysqli_query($connect, $sql1);
if ($res1) $patientCount = mysqli_fetch_assoc($res1)['cnt'];

// Daily appointments
$sql2 = "SELECT COUNT(*) AS cnt FROM appointment WHERE DATE(AppointmentDate) = CURDATE()";
$res2 = mysqli_query($connect, $sql2);
if ($res2) $appointmentCount = mysqli_fetch_assoc($res2)['cnt'];

// Daily consultations
$sql3 = "SELECT COUNT(*) AS cnt FROM consultation WHERE DATE(ConsultationDate) = CURDATE()";
$res3 = mysqli_query($connect, $sql3);
if ($res3) $consultationCount = mysqli_fetch_assoc($res3)['cnt'];

// Daily orders
$sql4 = "SELECT COUNT(*) AS cnt FROM orders WHERE DATE(OrderDate) = CURDATE()";
$res4 = mysqli_query($connect, $sql4);
if ($res4) $orderCount = mysqli_fetch_assoc($res4)['cnt'];

// Daily skin assessments
$sql5 = "SELECT COUNT(*) AS cnt FROM skinassessment WHERE DATE(AssessmentDate) = CURDATE()";
$res5 = mysqli_query($connect, $sql5);
if ($res5) $skinAssessmentCount = mysqli_fetch_assoc($res5)['cnt'];




$unreadNotifications = [];
$totalUnreadCount = 0;

$todayCondition = "AND DATE(t.CreatedAt) = CURDATE() AND t.IsNotified = 0";


if ($role === 'Admin' || $role === 'Receptionist') {
    // Receptionist/Admin cares about new Appointments and Orders
    $q_app = "SELECT 'Appointment' as Type, AppointmentCode as ID, AppointmentDate as Date, 'New Appointment Scheduled' as Message FROM appointment WHERE IsNotified = 0 ORDER BY AppointmentDate DESC LIMIT 5";
    $q_order = "SELECT 'Order' as Type, OrderCode as ID, OrderDate as Date, 'New Order Placed' as Message FROM orders WHERE IsNotified = 0 ORDER BY OrderDate DESC LIMIT 5";

    $res_app = mysqli_query($connect, $q_app);
    if ($res_app) {
        while ($row = mysqli_fetch_assoc($res_app)) $unreadNotifications[] = $row;
    }

    $res_order = mysqli_query($connect, $q_order);
    if ($res_order) {
        while ($row = mysqli_fetch_assoc($res_order)) $unreadNotifications[] = $row;
    }
}

if ($role === 'Aesthetic Doctor') {
    // Doctor cares about new Consultations and Skin Assessments
    $q_cons = "SELECT 'Consultation' as Type, ConsultationCode as ID, ConsultationDate as Date, 'New Consultation Request' as Message FROM consultation WHERE IsNotified = 0 ORDER BY ConsultationDate DESC LIMIT 5";
    $q_skin = "SELECT 'SkinAssessment' as Type, AssessmentCode as ID, AssessmentDate as Date, 'New Skin Assessment Available' as Message FROM skinassessment WHERE IsNotified = 0 ORDER BY AssessmentDate DESC LIMIT 5";

    $res_cons = mysqli_query($connect, $q_cons);
    if ($res_cons) {
        while ($row = mysqli_fetch_assoc($res_cons)) $unreadNotifications[] = $row;
    }

    $res_skin = mysqli_query($connect, $q_skin);
    if ($res_skin) {
        while ($row = mysqli_fetch_assoc($res_skin)) $unreadNotifications[] = $row;
    }
}

if ($role === 'Nurse') {
    // Nurse cares about new Treatments and Skin Assessments
    $q_treat = "SELECT 'Treatment' as Type, TreatmentCode as ID, CreatedDate as Date, 'New Treatment Form Submitted' as Message FROM treatment WHERE IsNotified = 0 ORDER BY Date DESC LIMIT 5";
    $q_skin = "SELECT 'SkinAssessment' as Type, AssessmentCode as ID, AssessmentDate as Date, 'New Skin Assessment Available' as Message FROM skinassessment WHERE IsNotified = 0 ORDER BY AssessmentDate DESC LIMIT 5";

    $res_treat = mysqli_query($connect, $q_treat);
    if ($res_treat) {
        while ($row = mysqli_fetch_assoc($res_treat)) $unreadNotifications[] = $row;
    }

    $res_skin = mysqli_query($connect, $q_skin);
    if ($res_skin) {
        while ($row = mysqli_fetch_assoc($res_skin)) $unreadNotifications[] = $row;
    }
}

$totalUnreadCount = count($unreadNotifications);

usort($unreadNotifications, function ($a, $b) {
    return strtotime($b['Date']) - strtotime($a['Date']);
});

?>

<?php include 'header.php'; ?>
<?php
?>
<?php include('navbar.php'); ?>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">

<!-- Mobile Menu Button -->
<div class="lg:hidden bg-white shadow-md p-4">
    <button id="mobileMenuToggle" class="flex items-center space-x-2 text-[#916D7A] font-semibold">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <span>Menu</span>
    </button>
</div>

<div class="min-h-screen bg-gradient-to-br from-[#EBD5DC] to-[#F7F3F5] flex flex-col lg:flex-row">

    <aside id="sidebar" class="w-full lg:w-64 bg-white shadow-lg flex-col py-8 px-4 border-r border-[#EBD5DC] min-h-screen hidden lg:flex lg:static absolute z-40">
        <!-- Close button for mobile -->
        <button id="closeSidebar" class="lg:hidden absolute top-4 right-4 text-[#916D7A]">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col items-center mb-10">
            <img src="./image/doctor.jpg" alt="Staff" class="h-16 w-16 lg:h-20 lg:w-20 rounded-full border-4 border-[#916D7A] shadow mb-3 object-cover" />
            <div class="text-lg lg:text-xl font-bold text-[#916D7A] text-center" style="font-family: 'Playfair Display', serif;">Hello, <?= htmlspecialchars($staffName) ?></div>
            <div class="text-xs lg:text-sm text-gray-500">Role: <?= htmlspecialchars($role) ?></div>
        </div>

        <nav class="flex-1">
            <ul class="space-y-2">
                <li><a href="staffdashboard.php" class="flex items-center px-4 py-3 rounded text-[#916D7A] font-semibold bg-[#EBD5DC]">Dashboard</a></li>

                <?php if ($role === 'Admin'): ?>
                    <li><a href="staffregister.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Add Staff</a></li>
                    <li><a href="product.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Add Product</a></li>
                    <li><a href="CreateInvoice.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Create Invoice</a></li>
                    <!-- <li><a href="productlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Product List</a></li>
                    <li><a href="treatmentlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Treatment List</a></li>
                    <li><a href="appointmentlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Appointment List</a></li>
                    <li><a href="consultationlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Consultation List</a></li>
                    <li><a href="skinassessmentlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Skinassessment List</a></li>
                    <li><a href="stafflist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Staff List</a></li>
                    <li><a href="patientlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Patient List</a></li>
                    <li><a href="orderlist.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Order List</a></li> -->
                <?php elseif ($role === 'Receptionist'): ?>
                    <li><a href="CreateInvoice.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Create Invoice</a></li>
                    <li><a href="appointmentlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Appointment List</a></li>
                    <li><a href="consultationlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Consultation List</a></li>
                    <li><a href="patientlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Patient List</a></li>
                    <li><a href="orderlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Order List</a></li>
                <?php elseif ($role === 'Aesthetic Doctor'): ?>
                    <li><a href="recommendation.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Add Recommendation</a></li>
                    <li><a href="treatmentform.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Add Treatment</a></li>
                    <li><a href="recommendationlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Recommendation List</a></li>

                <?php elseif ($role === 'Nurse'): ?>
                    <li><a href="treatmentform.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Add Treatment</a></li>
                    <li><a href="treatmentlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Treatment List</a></li>
                    <li><a href="skinassessmentlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Skinassessment List</a></li>
                    <li><a href="patientlist.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Patient List</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <div class="mt-auto mb-20 text-center">
            <a href="logout.php"
                class="inline-flex items-center justify-center gap-2 px-5 py-3 w-[85%] bg-gradient-to-r from-[#916D7A] to-[#B7929F] text-white font-semibold rounded-full shadow-md hover:shadow-lg hover:scale-105 hover:from-[#7e5a68] hover:to-[#a37785] transition-all duration-300">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 p-4 lg:p-8 xl:p-10 bg-gradient-to-br from-[#F7EFEF] to-[#EBD5DC] relative overflow-x-hidden">
        <!-- Welcome Banner -->
        <div class="w-full bg-gradient-to-r from-[#916D7A] to-[#EBD5DC] rounded-2xl shadow-lg flex items-center justify-between px-4 lg:px-8 py-3 lg:py-4 mb-6 lg:mb-8">
            <div class="flex-1">
                <div class="text-xl lg:text-2xl font-extrabold text-white mb-1" style="font-family: 'Playfair Display', serif;">Welcome!</div>
                <div class="text-sm lg:text-base text-[#F7EFEF] font-medium">Wishing you a productive day at Aura Aesthetic Clinic.</div>
            </div>
            <div class="hidden md:block">
                <svg width="50" height="30" class="lg:w-60 lg:h-12" viewBox="0 0 120 80" fill="none">
                    <ellipse cx="60" cy="40" rx="60" ry="40" fill="#fff" fill-opacity="0.08" />
                </svg>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 lg:gap-6 xl:gap-8 mb-8 lg:mb-10 xl:mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-6 xl:p-7 flex flex-col items-center border-b-4 border-[#916D7A]">
                <span class="text-[#916D7A] text-2xl lg:text-3xl xl:text-4xl mb-2"><i class="fas fa-users"></i></span>
                <div class="text-2xl lg:text-3xl xl:text-4xl font-bold text-[#916D7A] mb-1"><?= $patientCount ?></div>
                <div class="text-xs lg:text-sm xl:text-base font-semibold text-gray-700 text-center">Total Patients</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-6 xl:p-7 flex flex-col items-center border-b-4 border-[#916D7A]">
                <span class="text-[#916D7A] text-2xl lg:text-3xl xl:text-4xl mb-2"><i class="fas fa-calendar-check"></i></span>
                <div class="text-2xl lg:text-3xl xl:text-4xl font-bold text-[#916D7A] mb-1"><?= $appointmentCount ?></div>
                <div class="text-xs lg:text-sm xl:text-base font-semibold text-gray-700 text-center">Daily Appointments</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-6 xl:p-7 flex flex-col items-center border-b-4 border-[#916D7A]">
                <span class="text-[#916D7A] text-2xl lg:text-3xl xl:text-4xl mb-2"><i class="fas fa-user-md"></i></span>
                <div class="text-2xl lg:text-3xl xl:text-4xl font-bold text-[#916D7A] mb-1"><?= $consultationCount ?></div>
                <div class="text-xs lg:text-sm xl:text-base font-semibold text-gray-700 text-center">Daily Consultations</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-6 xl:p-7 flex flex-col items-center border-b-4 border-[#916D7A]">
                <span class="text-[#916D7A] text-2xl lg:text-3xl xl:text-4xl mb-2"><i class="fas fa-shopping-bag"></i></span>
                <div class="text-2xl lg:text-3xl xl:text-4xl font-bold text-[#916D7A] mb-1"><?= $orderCount ?></div>
                <div class="text-xs lg:text-sm xl:text-base font-semibold text-gray-700 text-center">Daily Orders</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-6 xl:p-7 flex flex-col items-center border-b-4 border-[#916D7A]">
                <span class="text-[#916D7A] text-2xl lg:text-3xl xl:text-4xl mb-2"><i class="fas fa-spa"></i></span>
                <div class="text-2xl lg:text-3xl xl:text-4xl font-bold text-[#916D7A] mb-1"><?= $skinAssessmentCount ?></div>
                <div class="text-xs lg:text-sm xl:text-base font-semibold text-gray-700 text-center">Daily Skin Assessments</div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6 xl:gap-8 mb-8 lg:mb-12 xl:mb-16">
            <a href="productlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-box"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Product List</span>
            </a>
            <a href="treatmentlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-syringe"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Treatment List</span>
            </a>
            <a href="appointmentlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-calendar-alt"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Appointment List</span>
            </a>
            <a href="consultationlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-nurse"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Consultation List</span>
            </a>
            <a href="skinassessmentlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-spa"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Skinassessment List</span>
            </a>
            <a href="stafflist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-tie"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Staff List</span>
            </a>
            <a href="patientlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-friends"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Patient List</span>
            </a>
            <a href="orderlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-4 lg:p-6 xl:p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-xl lg:text-2xl xl:text-3xl mb-2 lg:mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-receipt"></i></span>
                <span class="font-semibold text-sm lg:text-base xl:text-lg text-center">Order List</span>
            </a>
        </div>

        <div class="mt-8 lg:mt-10 xl:mt-12 text-center text-gray-500 text-xs lg:text-sm">
            &copy; <?= date('Y') ?> Aura Aesthetic Clinic. All rights reserved.
        </div>
    </main>
</div>

<script>
    // Mobile sidebar functionality
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebar = document.getElementById('sidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    if (mobileMenuToggle && sidebar) {
        mobileMenuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });
    }

    if (closeSidebar && sidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('hidden');
        });
    }


    document.querySelectorAll('#sidebar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) {
                sidebar.classList.add('hidden');
            }
        });
    });


    document.addEventListener('click', (e) => {
        if (window.innerWidth < 1024 && sidebar && mobileMenuToggle) {
            if (!sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        }
    });

    function toggleDropdown(id) {
        var el = document.getElementById(id);
        if (el) el.classList.toggle('hidden');
    }
</script>