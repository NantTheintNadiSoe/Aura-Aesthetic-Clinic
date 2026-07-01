<?php
session_start();
include('connect.php');

if (!isset($_SESSION['sid']) || !isset($_SESSION['position'])) {
    echo "<script>alert('Access denied! Please log in as staff.'); window.location='login.php';</script>";
    exit();
}

$role = $_SESSION['position'];



if (isset($_GET['delete_consultation'])) {
    if ($role !== 'Admin') {
        echo "<script>alert('Access denied! Only Admin can delete consultations.'); 
              window.location='consultationlist.php';</script>";
        exit();
    }

    $delID = mysqli_real_escape_string($connect, $_GET['delete_consultation']);
    $delQuery = mysqli_query($connect, "DELETE FROM consultation WHERE ConsultationCode='$delID'");

    if ($delQuery) {
        echo "<script>alert('Consultation deleted successfully!'); 
              window.location='consultationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete consultation.');</script>";
    }
}


if (isset($_GET['confirm_consultation'])) {
    if (!in_array($role, ['Admin', 'Aesthetic Doctor'])) {
        echo "<script>alert('Access denied! You cannot confirm consultations.'); 
              window.location='consultationlist.php';</script>";
        exit();
    }

    $confID = mysqli_real_escape_string($connect, $_GET['confirm_consultation']);
    $confQuery = mysqli_query(
        $connect,
        "UPDATE consultation SET Status='Confirmed', IsNotified=1 
         WHERE ConsultationCode='$confID'"
    );

    if ($confQuery) {
        echo "<script>alert('Consultation confirmed successfully!'); 
              window.location='consultationlist.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to confirm consultation.');</script>";
    }
}

include('header.php');
include('navbar.php');
?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <div class="max-w-7xl mx-auto mt-6 lg:mt-10 px-3 sm:px-4 mb-8 lg:mb-16">
        <h1 class="text-2xl lg:text-3xl font-bold text-[#916D7A] mb-4 lg:mb-6">Consultation List</h1>

        <div class="overflow-x-auto">
            <table class="w-full bg-white border border-[#EBD5DC] rounded shadow-md text-sm lg:text-base">
                <thead>
                    <tr class="bg-[#FAF2F5] text-[#916D7A]">
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Patient Name</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Type</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Date</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Time</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Status</th>
                        <th class="py-2 px-2 sm:px-4 border-b text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $consultQuery = mysqli_query(
                        $connect,
                        "SELECT c.*, p.Name AS PatientName 
                         FROM consultation c 
                         LEFT JOIN patientregister p 
                         ON c.PatientID = p.PatientID 
                         ORDER BY ConsultationDate DESC, ConsultationTime DESC"
                    );

                    if ($consultQuery && mysqli_num_rows($consultQuery) > 0):
                        while ($c = mysqli_fetch_assoc($consultQuery)):
                    ?>

                            <tr class="hover:bg-[#F7EFEF]">
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($c['PatientName']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($c['ConsultationType']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($c['ConsultationDate']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b"><?= htmlspecialchars($c['ConsultationTime']) ?></td>
                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold 
                                        <?= $c['Status'] === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                        <?= htmlspecialchars($c['Status']) ?>
                                    </span>
                                </td>

                                <td class="py-2 px-2 sm:px-4 border-b">
                                    <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">

                                        <!-- Confirm Button -->
                                        <?php if ($c['Status'] !== 'Confirmed'): ?>

                                            <?php if (in_array($role, ['Admin', 'Aesthetic Doctor'])): ?>
                                                <a href="consultationlist.php?confirm_consultation=<?= urlencode($c['ConsultationCode']) ?>"
                                                    class="bg-green-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-green-700 text-xs sm:text-sm text-center"
                                                    onclick="return confirm('Confirm this consultation?');">
                                                    Confirm
                                                </a>
                                            <?php else: ?>
                                                <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded cursor-not-allowed text-xs sm:text-sm w-full sm:w-auto"
                                                    onclick="alert('Access denied! Only Admin and Aesthetic Doctor can confirm consultations.');">
                                                    Confirm
                                                </button>
                                            <?php endif; ?>

                                        <?php endif; ?>

                                        <!-- Delete Button -->
                                        <?php if ($role === 'Admin'): ?>
                                            <a href="consultationlist.php?delete_consultation=<?= urlencode($c['ConsultationCode']) ?>"
                                                class="bg-red-500 text-white px-2 sm:px-4 py-1 sm:py-2 rounded hover:bg-red-700 text-xs sm:text-sm text-center"
                                                onclick="return confirm('Delete this consultation?');">
                                                Delete
                                            </a>
                                        <?php else: ?>
                                            <button class="bg-gray-400 text-white px-2 sm:px-4 py-1 sm:py-2 rounded cursor-not-allowed text-xs sm:text-sm w-full sm:w-auto"
                                                onclick="alert('Access denied! Only Admin can delete consultations.');">
                                                Delete
                                            </button>
                                        <?php endif; ?>

                                    </div>
                                </td>
                            </tr>

                        <?php endwhile;
                    else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-gray-500 py-4">
                                No consultations found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

<?php include('footer.php'); ?>