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

// Fetch recommendations
$query = "SELECT r.RecommendationCode, r.RecommendationDate, r.IsNotified, r.FollowUpDate FROM recommendation r JOIN skinassessment sa ON r.AssessmentCode = sa.AssessmentCode WHERE sa.PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' ORDER BY r.RecommendationDate DESC";
$result = mysqli_query($connect, $query);
$recommendationCount = $result ? mysqli_num_rows($result) : 0;
$newRecommendationCount = 0;
if ($result) {
    foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $row) {
        if ($row['IsNotified']) $newRecommendationCount++;
    }
    mysqli_data_seek($result, 0); // Reset pointer for table
}

// Fetch invoices
$query_invoices = "SELECT InvoiceCode, InvoiceDate, Payment FROM invoice WHERE PatientID = '" . mysqli_real_escape_string($connect, $patientID) . "' ORDER BY InvoiceDate DESC";
$invoices = mysqli_query($connect, $query_invoices);
$invoiceCount = $invoices ? mysqli_num_rows($invoices) : 0;
$unpaidCount = 0;
if ($invoices) {
    foreach (mysqli_fetch_all($invoices, MYSQLI_ASSOC) as $inv) {
        if (strtolower($inv['Payment']) == 'unpaid') $unpaidCount++;
    }
    mysqli_data_seek($invoices, 0);
}
?>
<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="min-h-screen flex bg-gradient-to-br from-[#EBD5DC] to-[#F7F3F5]">
        <!-- Sidebar -->
        <aside class="w-60 bg-white shadow-lg flex flex-col py-8 px-4 border-r border-[#EBD5DC] min-h-screen">
            <div class="flex flex-col items-center mb-10">
                <img src="./image/model1.jpg" alt="Patient" class="h-20 w-20 rounded-full border-4 border-[#916D7A] shadow mb-3 object-cover" />
                <div class="text-xl font-bold text-[#916D7A]" style="font-family: 'Playfair Display', serif;">Hi, <?= htmlspecialchars($patientName) ?></div>
            </div>
            <nav class="flex-1">
                <ul class="space-y-2">
                    <li><a href="patientdashboard.php" class="flex items-center px-4 py-2 rounded text-[#916D7A] font-semibold bg-[#EBD5DC]">Dashboard</a></li>
                    <li><a href="#recommendations" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Recommendations</a></li>
                    <li><a href="#invoices" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Invoices</a></li>
                    <li><a href="profile.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Profile</a></li>
                    <li><a href="logout.php" class="flex items-center px-4 py-2 rounded hover:bg-[#F7F3F5] transition">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 p-8 bg-gradient-to-br from-[#F7EFEF] to-[#EBD5DC] relative overflow-x-hidden">
            <!-- Welcome Banner -->
            <div class="w-full bg-gradient-to-r from-[#916D7A] to-[#EBD5DC] rounded-2xl shadow-lg flex items-center justify-between px-8 py-8 mb-10 animate-fade-in">
                <div>
                    <div class="text-2xl md:text-3xl font-extrabold text-white mb-1" style="font-family: 'Playfair Display', serif;">Welcome!</div>
                    <div class="text-lg text-[#F7EFEF] font-medium">Your personal health and beauty dashboard.</div>
                </div>
                <div class="hidden md:block">
                    <svg width="120" height="80" viewBox="0 0 120 80" fill="none">
                        <ellipse cx="60" cy="40" rx="60" ry="40" fill="#fff" fill-opacity="0.08" />
                    </svg>
                </div>
            </div>
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-3xl mb-2"><i class="fas fa-file-medical-alt"></i></span>
                    <div class="text-3xl font-bold text-[#916D7A] mb-1"><?= $recommendationCount ?></div>
                    <div class="text-base font-semibold text-gray-700">Total Recommendations</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-3xl mb-2"><i class="fas fa-bell"></i></span>
                    <div class="text-3xl font-bold text-[#916D7A] mb-1"><?= $newRecommendationCount ?></div>
                    <div class="text-base font-semibold text-gray-700">New Recommendations</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-3xl mb-2"><i class="fas fa-file-invoice"></i></span>
                    <div class="text-3xl font-bold text-[#916D7A] mb-1"><?= $invoiceCount ?></div>
                    <div class="text-base font-semibold text-gray-700">Total Invoices</div>
                </div>
                <div class="bg-white rounded-2xl shadow-xl p-7 flex flex-col items-center border-b-4 border-[#916D7A] hover:scale-105 transition-transform duration-200">
                    <span class="text-[#916D7A] text-3xl mb-2"><i class="fas fa-exclamation-circle"></i></span>
                    <div class="text-3xl font-bold text-[#916D7A] mb-1"><?= $unpaidCount ?></div>
                    <div class="text-base font-semibold text-gray-700">Unpaid Invoices</div>
                </div>
            </div>

            <!-- Upcoming Appointments (Placeholder) -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-[#916D7A] mb-4">Upcoming Appointments</h2>
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">No upcoming appointments found.</div>
            </section>

            <!-- Recent Treatments (Placeholder) -->
            <section class="mb-12">
                <h2 class="text-2xl font-bold text-[#916D7A] mb-4">Recent Treatments</h2>
                <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">No recent treatments found.</div>
            </section>

            <!-- Recommendations Table -->
            <section id="recommendations">
                <h2 class="text-2xl font-bold text-[#916D7A] mb-4">Your Recommendations</h2>
                <?php if ($recommendationCount > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-[#916D7A] text-white">
                                    <th class="border border-gray-300 px-4 py-2">Code</th>
                                    <th class="border border-gray-300 px-4 py-2">Date</th>
                                    <th class="border border-gray-300 px-4 py-2">Follow-up</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr class="<?= $row['IsNotified'] ? 'bg-yellow-100' : '' ?>">
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['RecommendationCode']) ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['RecommendationDate']) ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($row['FollowUpDate'] ?: '-') ?></td>
                                        <td class="border border-gray-300 px-4 py-2 font-semibold <?= $row['IsNotified'] ? 'text-red-600' : 'text-green-600' ?>">
                                            <?= $row['IsNotified'] ? 'New' : 'Viewed' ?>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="view_recommendation.php?code=<?= urlencode($row['RecommendationCode']) ?>" class="text-[#916D7A] hover:underline font-semibold">View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="mt-2 text-sm text-gray-600"><em>Yellow highlight means new/unread recommendations.</em></p>
                <?php else: ?>
                    <p class="text-center text-gray-600">You have no recommendations yet.</p>
                <?php endif; ?>
            </section>

            <!-- Invoices Table -->
            <section id="invoices" class="mt-12">
                <h2 class="text-2xl font-bold text-[#916D7A] mb-4">Your Invoices</h2>
                <?php if ($invoiceCount > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border-collapse border border-gray-300 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-[#916D7A] text-white">
                                    <th class="border border-gray-300 px-4 py-2">Code</th>
                                    <th class="border border-gray-300 px-4 py-2">Date</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($inv = mysqli_fetch_assoc($invoices)): ?>
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($inv['InvoiceCode']) ?></td>
                                        <td class="border border-gray-300 px-4 py-2"><?= htmlspecialchars($inv['InvoiceDate']) ?></td>
                                        <td class="border border-gray-300 px-4 py-2 font-semibold">
                                            <?php if (strtolower($inv['Payment']) == 'unpaid'): ?>
                                                <a href="paybills.php?invoice=<?= urlencode($inv['InvoiceCode']) ?>" class="text-red-600 hover:underline">Unpaid – Pay Now</a>
                                            <?php else: ?>
                                                <span class="text-green-600">Paid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center">
                                            <a href="ViewInvoice.php?code=<?= urlencode($inv['InvoiceCode']) ?>" class="text-[#916D7A] hover:underline font-semibold">View</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-600">You have no invoices yet.</p>
                <?php endif; ?>
            </section>
            <div class="mt-12 text-center text-gray-500 text-sm">
                &copy; <?= date('Y') ?> Aura Aesthetic Clinic. All rights reserved.
            </div>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>