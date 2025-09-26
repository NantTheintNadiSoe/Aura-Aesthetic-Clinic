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
                <li><a href="product.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Product List</a></li>
                <li><a href="productdetails.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Product Details</a></li>
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
    <main class="flex-1 p-10">
        <!-- Stat Cards -->
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 mb-10">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border-t-4 border-[#916D7A]">
                <div class="text-3xl font-bold text-[#916D7A] mb-2"><?= $patientCount ?></div>
                <div class="text-lg font-semibold text-gray-700">Total Patients</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border-t-4 border-[#916D7A]">
                <div class="text-3xl font-bold text-[#916D7A] mb-2"><?= $appointmentCount ?></div>
                <div class="text-lg font-semibold text-gray-700">Daily Appointments</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border-t-4 border-[#916D7A]">
                <div class="text-3xl font-bold text-[#916D7A] mb-2"><?= $consultationCount ?></div>
                <div class="text-lg font-semibold text-gray-700">Daily Consultations</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border-t-4 border-[#916D7A]">
                <div class="text-3xl font-bold text-[#916D7A] mb-2"><?= $orderCount ?></div>
                <div class="text-lg font-semibold text-gray-700">Daily Orders</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center border-t-4 border-[#916D7A]">
                <div class="text-3xl font-bold text-[#916D7A] mb-2"><?= $skinAssessmentCount ?></div>
                <div class="text-lg font-semibold text-gray-700">Daily Skin Assessments</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="product.php" class="bg-[#EBD5DC] hover:bg-[#916D7A] hover:text-white transition rounded-xl p-6 flex flex-col items-center shadow group">
                <svg class="w-10 h-10 mb-2 text-[#916D7A] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                <span class="font-semibold">Product List</span>
            </a>
            <a href="productdetails.php" class="bg-[#EBD5DC] hover:bg-[#916D7A] hover:text-white transition rounded-xl p-6 flex flex-col items-center shadow group">
                <svg class="w-10 h-10 mb-2 text-[#916D7A] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">Add Product</span>
            </a>
            <a href="CreateInvoice.php" class="bg-[#EBD5DC] hover:bg-[#916D7A] hover:text-white transition rounded-xl p-6 flex flex-col items-center shadow group">
                <svg class="w-10 h-10 mb-2 text-[#916D7A] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2v6m6 2a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2h10z" />
                </svg>
                <span class="font-semibold">Create Invoice</span>
            </a>
            <a href="treatmentform.php" class="bg-[#EBD5DC] hover:bg-[#916D7A] hover:text-white transition rounded-xl p-6 flex flex-col items-center shadow group">
                <svg class="w-10 h-10 mb-2 text-[#916D7A] group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">Add Treatment</span>
            </a>
        </div>

        <!-- Clinic Section: Product List -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-[#916D7A] mb-4">Clinic</h2>
            <div class="mb-6 flex flex-wrap gap-4">
                <a href="productlist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Product List</a>
                <a href="stafflist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Staff List</a>
                <a href="patientlist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Patient List</a>
                <a href="appointmentlist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Appointment List</a>
                <a href="skinassessmentlist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Skin Assessment List</a>
                <a href="consultationlist.php" class="inline-block px-6 py-3 bg-[#EBD5DC] text-[#916D7A] font-semibold rounded shadow hover:bg-[#916D7A] hover:text-white transition">View Consultation List</a>
            </div>
        </section>

        <!-- Main Dashboard Cards (reuse previous logic for role-based cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    </main>
    <?php
    // Handle product deletion
    if (isset($_GET['delete_product'])) {
        $delCode = mysqli_real_escape_string($connect, $_GET['delete_product']);
        $delQuery = mysqli_query($connect, "DELETE FROM product WHERE ProductCode='$delCode'");
        if ($delQuery) {
            echo "<script>alert('Product deleted successfully!'); window.location='staffdashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to delete product.');</script>";
        }
    }
    ?>
    <!-- <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition border-t-4 border-[#916D7A]">
        <div class="flex items-center mb-4">
            <svg class="w-8 h-8 text-[#916D7A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-semibold text-[#916D7A]">Appointments</h2>
        </div>
        <p class="text-gray-600 mb-4">View and manage patient appointments.</p>
        <a href="appointment.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">Go to Appointments</a>
    </div> -->
    <!-- <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition border-t-4 border-[#916D7A]">
        <div class="flex items-center mb-4">
            <svg class="w-8 h-8 text-[#916D7A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <h2 class="text-xl font-semibold text-[#916D7A]">Patients</h2>
        </div>
        <p class="text-gray-600 mb-4">Access patient records and history.</p>
        <a href="patientdashboard.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">View Patients</a>
    </div> -->
    <?php if (in_array($role, ['Admin', 'Receptionist'])): ?>
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition border-t-4 border-[#916D7A]">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-[#916D7A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2m0 0l2-2m-2 2v6m6 2a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2h10z" />
                </svg>
                <h2 class="text-xl font-semibold text-[#916D7A]">Billing & Invoices</h2>
            </div>
            <p class="text-gray-600 mb-4">Create and manage invoices, process payments.</p>
            <a href="CreateInvoice.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">Manage Billing</a>
        </div>
    <?php endif; ?>
    <?php if (in_array($role, ['Aesthetic Doctor', 'Dermatologist', 'Admin'])): ?>
        <!-- <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition border-t-4 border-[#916D7A]">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-[#916D7A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                <h2 class="text-xl font-semibold text-[#916D7A]">Recommendations</h2>
            </div>
            <p class="text-gray-600 mb-4">Write and view patient recommendations.</p>
            <a href="recommendationview.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">View Recommendations</a>
        </div> -->
    <?php endif; ?>
    <?php if ($role === 'Admin'): ?>
        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-2xl transition border-t-4 border-[#916D7A]">
            <div class="flex items-center mb-4">
                <svg class="w-8 h-8 text-[#916D7A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h2 class="text-xl font-semibold text-[#916D7A]">Staff Management</h2>
            </div>
            <p class="text-gray-600 mb-4">Add, edit, or remove staff accounts.</p>
            <a href="staffregister.php" class="inline-block px-4 py-2 bg-[#916D7A] text-white rounded hover:bg-[#7e5a68] transition">Manage Staff</a>
        </div>
    <?php endif; ?>
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