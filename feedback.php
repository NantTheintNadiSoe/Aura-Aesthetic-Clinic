<?php
session_start();
include('connect.php');
include 'header.php';

if (isset($_POST['btnsubmit'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $feedback = trim($_POST['feedback']);

    $insert = "INSERT INTO feedback
    (Name, Email, Feedback)
    VALUES
    ('$name','$email','$feedback')";

    $query = mysqli_query($connect, $insert);
    if ($query) {
        echo "<script>alert('Feedback submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred while submitting feedback.');</script>";
    }
}
?>

<body class="body text-[#4C2A36]">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Header Section -->
    <header class="relative py-24 bg-gradient-to-br from-[#BA9EA8] to-[#7A4E5E] text-white overflow-hidden mb-20">
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://placehold.co/2000x500/BA9EA8/FFFFFF?text=Aura+Aesthetic'); background-size: cover;"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Feedback</h1>
            <p class="text-xl max-w-3xl mx-auto">
                We value your feedback. Please share your thoughts with us.
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pb-24">
        <div class="flex flex-col lg:flex-row gap-12 justify-center items-stretch">
            <!-- Feedback Form -->
            <div class="lg:w-1/2 flex justify-center">
                <div class="bg-white p-6 md:p-8 contact-card w-full max-w-lg flex flex-col justify-between"> <!-- Reduced padding -->
                    <h2 class="text-3xl font-bold text-[#BA9EA8] mb-6">Share Your Feedback</h2>

                    <form class="space-y-6" action="feedback.php" method="POST"> <!-- Reduced space between form elements -->
                        <div>
                            <label class="block font-semibold text-lg mb-1">Full Name</label>
                            <input type="text" name="name" class="w-full px-4 py-3 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Your name" required>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-1">Email Address</label>
                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Your email" required>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-1">Your Feedback</label>
                            <textarea name="feedback" rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Write your feedback here..." required></textarea>
                        </div>

                        <button type="submit" name="btnsubmit" class="submit-btn w-full py-3 px-6 text-white font-semibold text-lg rounded-xl">
                            Submit Feedback
                        </button>

                        <p class="text-center text-[#7A4E5E] mt-4">
                            Thank you for your feedback!
                        </p>
                    </form>
                </div>
            </div>

            <!-- Image Section -->
            <div class="lg:w-1/2 flex justify-center">
                <img src="https://www.luxxu.net/blog/wp-content/uploads/2025/01/estee-1.jpg" alt="Feedback Image" class="rounded-lg shadow-lg w-full max-w-lg h-auto object-cover"> <!-- Set h-auto for responsive height -->
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>