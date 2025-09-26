<?php
include('connect.php');
if (isset($_POST['btnsubmit'])) {
    $typename = $_POST['txttypename'];
    $description = $_POST['txtdescription'];
    $status = $_POST['txtstatus'];

    if (isset($_FILES['fileimage'])) {
        $img1 = $_FILES['fileimage']['name'];
        $folder = "UploadedImage/";
        $type = $folder . "_" . $img1;

        /* MenuType Image Upload */
        $copy = copy($_FILES['fileimage']['tmp_name'], $type);

        if (!$copy) {
            echo "<p>Cannot upload Treatment Type Image</p>";
            exit();
        }
    }
    $select = "SELECT * FROM treatmenttype WHERE TreatmentTypeName='$typename'";
    $query1 = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query1);

    if ($count > 0) {
        echo "<script>window.alert('Treatment Type already Exist! Please Try again')</script>";
        echo "<script>window.location='treatmenttype.php'</script>";
    } else {
        $insert = "INSERT INTO treatmenttype(TreatmentTypeName, TreatmentTypeImage, Descriptions, Status) 
      VALUES ('$typename','$type',' $description','$status')";
        $query = mysqli_query($connect, $insert);
        if ($query) {
            echo "<script>alert('TreatmentType Fill Success')</script>";
        }
    }
}
?>

<?php include 'header.php'; ?>

<body class="bg-[#F7EFEF] text-[#4A2C35] font-sans">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>


    <!-- Page Title -->
    <div class="text-center py-10">
        <h1 class="text-3xl font-bold text-[#916D7A]">Treatment Types</h1>
    </div>

    <!-- Form Container -->
    <div class="max-w-xl mx-auto bg-white p-8 rounded shadow-md border border-[#EBD5DC] mb-20">

        <form action="treatmenttype.php" method="POST" class="space-y-5" enctype="multipart/form-data">

            <!-- <div>
                <label class="block font-medium mb-1">Treatment Type Code</label>
                <input type="text" name="treatment_code" value="Tt_00001" readonly
                    class="w-full px-4 py-2 border border-[#EBD5DC] bg-[#FAF2F5] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
            </div> -->

            <div>
                <label class="block font-medium mb-1">Treatment Type Name</label>
                <input type="text" name="txttypename" required
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div>
                <label class="block font-medium mb-1">Treatment Type Image</label>
                <input type="file" name="fileimage" required
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
            </div>


            <div>
                <label class="block font-medium mb-1">Description</label>
                <textarea name="txtdescription" rows="4" required
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]"></textarea>
            </div>

            <div>
                <label class="block font-medium mb-1">Status</label>
                <input type="text" name="txtstatus" required
                    class="w-full px-4 py-2 border border-[#EBD5DC] rounded focus:outline-none focus:ring-2 focus:ring-[#916D7A]" />
            </div>

            <div class="text-center pt-4">
                <button type="submit" name="btnsubmit"
                    class="px-6 py-2 bg-[#916D7A] text-white rounded hover:bg-[#6E4B57] transition font-semibold">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>