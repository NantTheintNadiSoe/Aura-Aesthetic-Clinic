<?php
session_start();
include('connect.php');

if (isset($_POST['btnlogin'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ---- Staff ----
    $select_staff = "SELECT * FROM staffregister WHERE Email='$email'";
    $query_staff = mysqli_query($connect, $select_staff);

    if (mysqli_num_rows($query_staff) > 0) {
        $data = mysqli_fetch_assoc($query_staff);

        if (password_verify($password, $data['Password'])) {

            $_SESSION['sid'] = $data['StaffID'];
            $_SESSION['sname'] = $data['Name'];
            $_SESSION['username'] = $data['UserName'];
            $_SESSION['semail'] = $data['Email'];
            $_SESSION['sphone'] = $data['PhoneNumber'];
            $_SESSION['position'] = $data['Position'];
            $_SESSION['role'] = "staff";

            echo "<script>alert('Staff Login Success'); window.location='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid Staff Password'); window.location='login.php';</script>";
            exit();
        }
    }

    // ---- Patient ----
    $select_patient = "SELECT * FROM patientregister WHERE Email='$email'";
    $query_patient = mysqli_query($connect, $select_patient);

    if (mysqli_num_rows($query_patient) > 0) {
        $data = mysqli_fetch_assoc($query_patient);

        if (password_verify($password, $data['Password'])) {
            $_SESSION['pid'] = $data['PatientID'];
            $_SESSION['pname'] = $data['Name'];
            $_SESSION['pemail'] = $data['Email'];
            $_SESSION['pphone'] = $data['PhoneNumber'];
            $_SESSION['role'] = "patient";

            echo "<script>alert('Patient Login Success'); window.location='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid Password'); window.location='login.php';</script>";
            exit();
        }
    }


    echo "<script>alert('Email not found in Staff or Patient records'); window.location='login.php';</script>";
    exit();
}
?>
<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] font-sans text-[#4A2C35]">
    <?php include 'navbar.php'; ?>


    <div class="text-center py-10">
        <h1 class="text-3xl font-bold text-[#916D7A]">Login to Your Account</h1>
    </div>


    <main class="max-w-md mx-auto bg-white p-8 rounded shadow-md border border-[#EBD5DC] mb-20">
        <form action="login.php" method="POST" class="space-y-5">
            <div>
                <label class="block font-medium mb-1">Email</label>
                <input type="email" name="email" placeholder="Enter Your Email"
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Password</label>
                <input type="password" name="password" placeholder="Enter Your Password"
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" required>
            </div>

            <div class="text-center pt-4">
                <button type="submit" name="btnlogin"
                    class="w-full px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Login
                </button>
            </div>
        </form>

        <div class="flex justify-between text-sm mt-4 text-gray-600">
            <a href="#" class="hover:text-[#916D7A]">Forgot Password?</a>
            <a href="patientregister.php" class="hover:text-[#916D7A]">Sign Up</a>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>