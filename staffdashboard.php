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
// Get patient and appointment counts
// Statistics queries
$patientCount = 0;
$appointmentCount = 0;
$consultationCount = 0;
$orderCount = 0;
$skinAssessmentCount = 0;

// Total patients
$sql1 = "SELECT COUNT(*) AS cnt FROM patientregister";
$res1 = mysqli_query($connect, $sql1);
if ($res1) {
    $row1 = mysqli_fetch_assoc($res1);
    $patientCount = $row1['cnt'];
}

// Daily appointments
$sql2 = "SELECT COUNT(*) AS cnt FROM appointment WHERE DATE(AppointmentDate) = CURDATE()";
$res2 = mysqli_query($connect, $sql2);
if ($res2) {
    $row2 = mysqli_fetch_assoc($res2);
    $appointmentCount = $row2['cnt'];
}

// Daily consultations
$sql3 = "SELECT COUNT(*) AS cnt FROM consultation WHERE DATE(ConsultationDate) = CURDATE()";
$res3 = mysqli_query($connect, $sql3);
if ($res3) {
    $row3 = mysqli_fetch_assoc($res3);
    $consultationCount = $row3['cnt'];
}

// Daily orders
$sql4 = "SELECT COUNT(*) AS cnt FROM orders WHERE DATE(OrderDate) = CURDATE()";
$res4 = mysqli_query($connect, $sql4);
if ($res4) {
    $row4 = mysqli_fetch_assoc($res4);
    $orderCount = $row4['cnt'];
}

// Daily skin assessments
$sql5 = "SELECT COUNT(*) AS cnt FROM skinassessment WHERE DATE(AssessmentDate) = CURDATE()";
$res5 = mysqli_query($connect, $sql5);
if ($res5) {
    $row5 = mysqli_fetch_assoc($res5);
    $skinAssessmentCount = $row5['cnt'];
}
?>
<?php include 'header.php'; ?>
<?php include('navbar.php'); ?>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<div class="min-h-screen bg-gradient-to-br from-[#EBD5DC] to-[#F7F3F5] flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col py-8 px-4 border-r border-[#EBD5DC] min-h-screen">
        <div class="flex flex-col items-center mb-10">
            <img src="./image/doctor.jpg" alt="Staff" class="h-20 w-20 rounded-full border-4 border-[#916D7A] shadow mb-3 object-cover" />
            <div class="text-xl font-bold text-[#916D7A]" style="font-family: 'Playfair Display', serif;">Hello, <?= htmlspecialchars($staffName) ?></div>
            <div class="text-sm text-gray-500">Role: <?= htmlspecialchars($role) ?></div>
        </div>
        <nav class="flex-1">
            <ul class="space-y-2">
                <li><a href="staffdashboard.php" class="flex items-center px-4 py-2 rounded text-[#916D7A] font-semibold bg-[#EBD5DC]">Dashboard</a></li>
                <li><a href="staffregister.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Add Staff</a></li>
                <li><a href="product.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Add Product</a></li>
                <?php if (in_array($role, ['Admin', 'Receptionist', 'Aesthetic Doctor'])): ?>
                    <li><a href="CreateInvoice.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Create Invoice</a></li>
                <?php endif; ?>
                <?php if (in_array($role, ['Admin', 'Aesthetic Doctor', 'Dermatologist'])): ?>
                    <li><a href="recommendation.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Add Recommendation</a></li>
                <?php endif; ?>
                <li><a href="treatmentform.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Add Treatment</a></li>
                <li><a href="appointment.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Appointments</a></li>
                <li><a href="patientdashboard.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Patients</a></li>
                <?php if ($role === 'Admin'): ?>
                    <li><a href="staffregister.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Staff Management</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="mt-10 text-center">
            <a href="logout.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">Logout</a>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-10 bg-gradient-to-br from-[#F7EFEF] to-[#EBD5DC] relative overflow-x-hidden">
        <!-- Welcome Banner -->
        <div class="w-full bg-gradient-to-r from-[#916D7A] to-[#EBD5DC] rounded-2xl shadow-lg flex items-center justify-between px-8 py-8 mb-12 animate-fade-in">
            <div>
                <div class="text-2xl md:text-3xl font-extrabold text-white mb-1" style="font-family: 'Playfair Display', serif;">Welcome!</div>
                <div class="text-lg text-[#F7EFEF] font-medium">Wishing you a productive day at Aura Aesthetic Clinic.</div>
            </div>
            <div class="hidden md:block">
                <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                    <ellipse cx="60" cy="40" rx="60" ry="40" fill="#fff" fill-opacity="0.08" />
                </svg>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-8 mb-12">
            <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                <span class="text-[#916D7A] text-4xl mb-2"><i class="fas fa-users"></i></span>
                <div class="text-4xl font-bold text-[#916D7A] mb-1"><?= $patientCount ?></div>
                <div class="text-base font-semibold text-gray-700">Total Patients</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                <span class="text-[#916D7A] text-4xl mb-2"><i class="fas fa-calendar-check"></i></span>
                <div class="text-4xl font-bold text-[#916D7A] mb-1"><?= $appointmentCount ?></div>
                <div class="text-base font-semibold text-gray-700">Daily Appointments</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                <span class="text-[#916D7A] text-4xl mb-2"><i class="fas fa-user-md"></i></span>
                <div class="text-4xl font-bold text-[#916D7A] mb-1"><?= $consultationCount ?></div>
                <div class="text-base font-semibold text-gray-700">Daily Consultations</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                <span class="text-[#916D7A] text-4xl mb-2"><i class="fas fa-shopping-bag"></i></span>
                <div class="text-4xl font-bold text-[#916D7A] mb-1"><?= $orderCount ?></div>
                <div class="text-base font-semibold text-gray-700">Daily Orders</div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                <span class="text-[#916D7A] text-4xl mb-2"><i class="fas fa-spa"></i></span>
                <div class="text-4xl font-bold text-[#916D7A] mb-1"><?= $skinAssessmentCount ?></div>
                <div class="text-base font-semibold text-gray-700">Daily Skin Assessments</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
            <a href="productlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-box"></i></span>
                <span class="font-semibold text-lg">Product List</span>
            </a>
            <a href="treatmentlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-syringe"></i></span>
                <span class="font-semibold text-lg">Treatment List</span>
            </a>
            <a href="appointmentlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-calendar-alt"></i></span>
                <span class="font-semibold text-lg">Appointment List</span>
            </a>
            <a href="consultationlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-nurse"></i></span>
                <span class="font-semibold text-lg">Consultation List</span>
            </a>
            <a href="consultationlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-spa"></i></span>
                <span class="font-semibold text-lg">Skinassessment List</span>
            </a>
            <a href="stafflist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-tie"></i></span>
                <span class="font-semibold text-lg">Staff List</span>
            </a>
            <a href="patientlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-user-friends"></i></span>
                <span class="font-semibold text-lg">Patient List</span>
            </a>
            <a href="orderlist.php" class="bg-gradient-to-br from-[#EBD5DC] to-[#F7EFEF] hover:from-[#916D7A] hover:to-[#EBD5DC] hover:text-white transition rounded-2xl p-8 flex flex-col items-center shadow-xl group border border-[#EBD5DC]">
                <span class="text-3xl mb-3 text-[#916D7A] group-hover:text-white"><i class="fas fa-receipt"></i></span>
                <span class="font-semibold text-lg">Order List</span>
            </a>
        </div>

        <div class="mt-12 text-center text-gray-500 text-sm">
            &copy; <?= date('Y') ?> Aura Aesthetic Clinic. All rights reserved.
        </div>
    </main>
</div>
<script>
    // Dropdown toggles (from navbar)
    function toggleDropdown(id) {
        var el = document.getElementById(id);
        if (el) el.classList.toggle('hidden');
    }
</script>