<?php
session_start();
include('connect.php');
include 'header.php';

if (!isset($_SESSION['pid'])) {
    echo "<script>alert('Please log in to access the dashboard.'); window.location='login.php';</script>";
    exit();
}

$patientID = $_SESSION['pid'];
$patientName = $_SESSION['pname'] ?? 'Patient';


$query = "SELECT r.RecommendationCode, r.RecommendationDate, r.IsNotified, r.FollowUpDate
          FROM recommendation r
          JOIN skinassessment sa ON r.AssessmentCode = sa.AssessmentCode
          WHERE sa.PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "'
          ORDER BY r.RecommendationDate DESC";
$result = mysqli_query($connect, $query);
$recommendationCount = $result ? mysqli_num_rows($result) : 0;
$newRecommendationCount = 0;
if ($result) {
    foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
        if ($row['IsNotified']) $newRecommendationCount++;
    }
    mysqli_data_seek($result, 0);
}


$query_invoices = "SELECT InvoiceCode, InvoiceDate, Payment FROM invoice
                   WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "'
                   ORDER BY InvoiceDate DESC";
$invoices = mysqli_query($connect, $query_invoices);
$invoiceCount = $invoices ? mysqli_num_rows($invoices) : 0;
$unpaidCount = 0;
if ($invoices) {
    foreach (mysqli_fetch_all($invoices, MYSQLI_ASSOC) as $inv) {
        if (strtolower($inv['Payment']) == 'unpaid') $unpaidCount++;
    }
    mysqli_data_seek($invoices, 0);
}

// Fetch new confirmed appointment
$pendingAppointmentsQuery = "SELECT AppointmentCode, AppointmentDate, AppointmentTime, Status FROM appointment WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' AND Status != 'Confirmed' ORDER BY AppointmentDate DESC, AppointmentTime DESC";
$pendingAppointmentsResult = mysqli_query($connect, $pendingAppointmentsQuery);
$apptNotifyQuery = "SELECT AppointmentCode, AppointmentDate, AppointmentTime
                    FROM appointment
                    WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "'
                    AND Status = 'Confirmed' AND IsNotified = 1
                    ORDER BY AppointmentDate DESC, AppointmentTime DESC LIMIT 1";
$apptNotifyResult = mysqli_query($connect, $apptNotifyQuery);
$newConfirmedAppointment = $apptNotifyResult && mysqli_num_rows($apptNotifyResult) > 0
    ? mysqli_fetch_assoc($apptNotifyResult) : null;
if ($newConfirmedAppointment) {
    mysqli_query($connect, "UPDATE appointment SET IsNotified = 0
                            WHERE AppointmentCode = '" . mysqli_real_escape_string($connect, $newConfirmedAppointment['AppointmentCode']) . "'");
}

// Fetch new confirmed order
$pendingOrdersQuery = "SELECT OrderCode, OrderDate, TotalAmount, Status FROM orders WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' AND Status != 'Confirmed' ORDER BY OrderDate DESC";
$pendingOrdersResult = mysqli_query($connect, $pendingOrdersQuery);
$orderNotifyQuery = "SELECT OrderCode, OrderDate, TotalAmount
                     FROM orders
                     WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "'
                     AND Status = 'Confirmed' AND IsNotified = 1
                     ORDER BY OrderDate DESC LIMIT 1";
$orderNotifyResult = mysqli_query($connect, $orderNotifyQuery);
$newConfirmedOrder = $orderNotifyResult && mysqli_num_rows($orderNotifyResult) > 0
    ? mysqli_fetch_assoc($orderNotifyResult) : null;
if ($newConfirmedOrder) {
    mysqli_query($connect, "UPDATE orders SET IsNotified = 0
                            WHERE OrderCode = '" . mysqli_real_escape_string($connect, $newConfirmedOrder['OrderCode']) . "'");
}

// Fetch new confirmed skin assessment
$pendingConsultsQuery = "SELECT AssessmentCode, AssessmentDate, SkinConcern, Status FROM skinassessment WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' AND Status != 'Confirmed' ORDER BY AssessmentDate DESC";
$pendingConsultsResult = mysqli_query($connect, $pendingConsultsQuery);
$skinNotifyQuery = "SELECT AssessmentCode, AssessmentDate, SkinConcern
                    FROM skinassessment
                    WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "'
                    AND Status = 'Confirmed' AND IsNotified = 1
                    ORDER BY AssessmentDate DESC LIMIT 1";
$skinNotifyResult = mysqli_query($connect, $skinNotifyQuery);
$newConfirmedSkin = $skinNotifyResult && mysqli_num_rows($skinNotifyResult) > 0
    ? mysqli_fetch_assoc($skinNotifyResult) : null;
if ($newConfirmedSkin) {
    mysqli_query($connect, "UPDATE skinassessment SET IsNotified = 0
                            WHERE AssessmentCode = '" . mysqli_real_escape_string($connect, $newConfirmedSkin['AssessmentCode']) . "'");
}
?>


<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <!-- Mobile Menu Button -->
    <div class="lg:hidden bg-white shadow-md p-4">
        <button id="mobileMenuToggle" class="flex items-center space-x-2 text-[#916D7A] font-semibold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span>Menu</span>
        </button>
    </div>

    <div class="min-h-screen flex flex-col lg:flex-row bg-gradient-to-br from-[#EBD5DC] to-[#F7F3F5]">
        <!-- Sidebar - Hidden on mobile by default -->
        <aside id="sidebar" class="w-full lg:w-60 bg-white shadow-lg flex-col py-8 px-4 border-r border-[#EBD5DC] min-h-screen hidden lg:flex lg:static absolute z-40">
            <!-- Close button for mobile -->
            <button id="closeSidebar" class="lg:hidden absolute top-4 right-4 text-[#916D7A]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex flex-col items-center mb-10">
                <img src="./image/model1.jpg" alt="Patient" class="h-16 w-16 lg:h-20 lg:w-20 rounded-full border-4 border-[#916D7A] shadow mb-3 object-cover" />
                <div class="text-lg lg:text-xl font-bold text-[#916D7A] text-center" style="font-family: 'Playfair Display', serif;">Hi, <?= htmlspecialchars($patientName) ?></div>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="patientdashboard.php" class="flex items-center px-4 py-3 rounded text-[#916D7A] font-semibold bg-[#EBD5DC]">Dashboard</a></li>
                    <li><a href="#recommendations" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Recommendations</a></li>
                    <li><a href="#invoices" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Invoices</a></li>
                    <li><a href="profile.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Profile</a></li>
                    <li><a href="logout.php" class="flex items-center px-4 py-3 rounded hover:bg-[#F7F3F5] transition">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 lg:p-8 bg-gradient-to-br from-[#F7EFEF] to-[#EBD5DC] relative overflow-x-hidden">
            <!-- Welcome Banner -->
            <div class="w-full bg-gradient-to-r from-[#916D7A] to-[#EBD5DC] rounded-2xl shadow-lg flex items-center justify-between px-4 lg:px-8 py-4 lg:py-6 mb-6 lg:mb-8">
                <div class="flex-1">
                    <div class="text-xl lg:text-2xl xl:text-2xl font-extrabold text-white mb-1" style="font-family: 'Playfair Display', serif;">Welcome!</div>
                    <div class="text-sm lg:text-base text-[#F7EFEF] font-medium">Your personal health and beauty dashboard.</div>
                </div>
                <div class="hidden md:block">
                    <svg width="60" height="40" class="lg:w-80 lg:h-20" viewBox="0 0 120 80" fill="none">
                        <ellipse cx="60" cy="40" rx="60" ry="40" fill="#fff" fill-opacity="0.08" />
                    </svg>
                </div>
            </div>

            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-8 mb-8 lg:mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-2xl lg:text-3xl mb-2"><i class="fas fa-file-medical-alt"></i></span>
                    <div class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-1"><?= $recommendationCount ?></div>
                    <div class="text-sm lg:text-base font-semibold text-gray-700 text-center">Total Recommendations</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-2xl lg:text-3xl mb-2"><i class="fas fa-bell"></i></span>
                    <div class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-1"><?= $newRecommendationCount ?></div>
                    <div class="text-sm lg:text-base font-semibold text-gray-700 text-center">New Recommendations</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-2xl lg:text-3xl mb-2"><i class="fas fa-file-invoice"></i></span>
                    <div class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-1"><?= $invoiceCount ?></div>
                    <div class="text-sm lg:text-base font-semibold text-gray-700 text-center">Total Invoices</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-4 lg:p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-2xl lg:text-3xl mb-2"><i class="fas fa-exclamation-circle"></i></span>
                    <div class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-1"><?= $unpaidCount ?></div>
                    <div class="text-sm lg:text-base font-semibold text-gray-700 text-center">Unpaid Invoices</div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="space-y-4 lg:space-y-6 mb-8 lg:mb-12">
                <!-- Appointment Notification -->
                <?php if ($newConfirmedAppointment): ?>
                    <div class="bg-green-100 border border-green-300 text-green-800 rounded-xl shadow p-4 lg:p-6 text-center font-semibold text-sm lg:text-base">
                        Your appointment on <span class="font-bold"><?= htmlspecialchars($newConfirmedAppointment['AppointmentDate']) ?></span> at <span class="font-bold"><?= htmlspecialchars($newConfirmedAppointment['AppointmentTime']) ?></span> has been <span class="text-green-700">confirmed</span>!
                    </div>
                <?php endif; ?>

                <!-- Order Notification -->
                <?php if ($newConfirmedOrder): ?>
                    <div class="bg-blue-100 border border-blue-300 text-blue-800 rounded-xl shadow p-4 lg:p-6 text-center font-semibold text-sm lg:text-base">
                        Your order <span class="font-bold"><?= htmlspecialchars($newConfirmedOrder['OrderCode']) ?></span> placed on <span class="font-bold"><?= htmlspecialchars($newConfirmedOrder['OrderDate']) ?></span> (MMK <?= number_format($newConfirmedOrder['TotalAmount'], 2) ?>) has been <span class="text-blue-700">confirmed</span>!
                    </div>
                <?php endif; ?>

                <!-- Skin Assessment Notification -->
                <?php if ($newConfirmedSkin): ?>
                    <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 rounded-xl shadow p-4 lg:p-6 text-center font-semibold text-sm lg:text-base">
                        Your skin assessment on <span class="font-bold"><?= htmlspecialchars($newConfirmedSkin['AssessmentDate']) ?></span> (Concern: <span class="font-bold"><?= htmlspecialchars($newConfirmedSkin['SkinConcern']) ?></span>) has been <span class="text-yellow-700">confirmed</span>!
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pending Sections -->
            <div class="space-y-8 lg:space-y-12">
                <!-- Pending Appointments -->
                <section class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#916D7A] mb-4">Pending Appointments</h2>
                    <?php if ($pendingAppointmentsResult && mysqli_num_rows($pendingAppointmentsResult) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm lg:text-base">
                                <thead>
                                    <tr class="bg-[#916D7A] text-white">
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Code</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Date</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Time</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($pendingAppointmentsResult)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['AppointmentCode']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['AppointmentDate']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['AppointmentTime']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 font-semibold text-yellow-600"><?= htmlspecialchars($row['Status']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl shadow p-6 text-center text-gray-500">No pending appointments found.</div>
                    <?php endif; ?>
                </section>

                <!-- Pending Orders -->
                <section class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#916D7A] mb-4">Pending Orders</h2>
                    <?php if ($pendingOrdersResult && mysqli_num_rows($pendingOrdersResult) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm lg:text-base">
                                <thead>
                                    <tr class="bg-[#916D7A] text-white">
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Code</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Date</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Amount</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($pendingOrdersResult)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['OrderCode']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['OrderDate']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2">MMK <?= number_format($row['TotalAmount'], 2) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 font-semibold text-yellow-600"><?= htmlspecialchars($row['Status']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl shadow p-6 text-center text-gray-500">No pending orders found.</div>
                    <?php endif; ?>
                </section>

                <!-- Pending Consultations -->
                <section class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#916D7A] mb-4">Pending Consultations</h2>
                    <?php if ($pendingConsultsResult && mysqli_num_rows($pendingConsultsResult) > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm lg:text-base">
                                <thead>
                                    <tr class="bg-[#916D7A] text-white">
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Code</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Date</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Concern</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($pendingConsultsResult)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['AssessmentCode']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['AssessmentDate']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 truncate max-w-xs"><?= htmlspecialchars($row['SkinConcern']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 font-semibold text-yellow-600"><?= htmlspecialchars($row['Status']) ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl shadow p-6 text-center text-gray-500">No pending consultations found.</div>
                    <?php endif; ?>
                </section>

                <!-- Recommendations Table -->
                <section id="recommendations" class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#916D7A] mb-4">Your Recommendations</h2>
                    <?php if ($recommendationCount > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm lg:text-base">
                                <thead>
                                    <tr class="bg-[#916D7A] text-white">
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Code</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Date</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Follow-up</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr class="<?= $row['IsNotified'] ? 'bg-yellow-100' : '' ?> hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['RecommendationCode']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['RecommendationDate']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($row['FollowUpDate'] ?: '-') ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 font-semibold <?= $row['IsNotified'] ? 'text-red-600' : 'text-green-600' ?>">
                                                <?= $row['IsNotified'] ? 'New' : 'Viewed' ?>
                                            </td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 text-center">
                                                <a href="view_recommendation.php?code=<?= urlencode($row['RecommendationCode']) ?>" class="text-[#916D7A] hover:underline font-semibold text-sm lg:text-base">View</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <p class="mt-2 text-xs lg:text-sm text-gray-600"><em>Yellow highlight means new/unread recommendations.</em></p>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl shadow p-6 text-center text-gray-500">You have no recommendations yet.</div>
                    <?php endif; ?>
                </section>

                <!-- Invoices Table -->
                <section id="invoices" class="bg-white rounded-xl shadow-lg p-4 lg:p-6">
                    <h2 class="text-xl lg:text-2xl font-bold text-[#916D7A] mb-4">Your Invoices</h2>
                    <?php if ($invoiceCount > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden text-sm lg:text-base">
                                <thead>
                                    <tr class="bg-[#916D7A] text-white">
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Code</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Date</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Status</th>
                                        <th class="border border-gray-300 px-2 lg:px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($inv = mysqli_fetch_assoc($invoices)): ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($inv['InvoiceCode']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2"><?= htmlspecialchars($inv['InvoiceDate']) ?></td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 font-semibold">
                                                <?php if (strtolower($inv['Payment']) == 'unpaid'): ?>
                                                    <a href="paybills.php?invoice=<?= urlencode($inv['InvoiceCode']) ?>" class="text-red-600 hover:underline text-sm lg:text-base">Unpaid – Pay Now</a>
                                                <?php else: ?>
                                                    <span class="text-green-600">Paid</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="border border-gray-300 px-2 lg:px-4 py-2 text-center">
                                                <a href="ViewInvoice.php?code=<?= urlencode($inv['InvoiceCode']) ?>" class="text-[#916D7A] hover:underline font-semibold text-sm lg:text-base">View</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="bg-gray-50 rounded-xl shadow p-6 text-center text-gray-500">You have no invoices yet.</div>
                    <?php endif; ?>
                </section>
            </div>

            <!-- Footer -->
            <div class="mt-8 lg:mt-12 text-center text-gray-500 text-xs lg:text-sm">
                &copy; <?= date('Y') ?> Aura Aesthetic Clinic. All rights reserved.
            </div>
        </main>
    </div>
    <?php include 'footer.php'; ?>

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
    </script>
</body>

</html>