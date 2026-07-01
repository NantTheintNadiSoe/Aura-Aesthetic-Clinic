<?php
session_start();
include('connect.php');
include 'header.php';

if (isset($_POST['btnsubmit'])) {


    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);


    $insert = "INSERT INTO contact
    ( Name, Email, PhoneNumber, Subject, Message)
    VALUES
    ('$name','$email','$phone','$subject','$message')";

    $query = mysqli_query($connect, $insert);
    if ($query) {
        echo "<script>alert('Form submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred while submitting.');</script>";
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
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Contact Us</h1>
            <p class="text-xl max-w-3xl mx-auto">
                We're here to help with any questions. Reach out and we'll get back to you as soon as possible.
            </p>

        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 pb-24">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Contact Information -->
            <div class="lg:w-1/2">
                <div class="bg-white p-8 md:p-10 contact-card h-full">
                    <h2 class="text-3xl font-bold text-[#BA9EA8] mb-8">Our Information</h2>

                    <div class="space-y-8">
                        <!-- Phone -->
                        <div class="flex items-start gap-6">
                            <div class="contact-icon p-4 rounded-xl flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#BA9EA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-xl mb-1">Phone</h3>
                                <p class="text-[#7A4E5E] text-lg">09984747574</p>
                                <p class="text-gray-500 text-sm mt-1">Monday - Saturday, 8:00 AM - 7:00 PM</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start gap-6">
                            <div class="contact-icon p-4 rounded-xl flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#BA9EA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-xl mb-1">Email</h3>
                                <a href="mailto:auraclinic@gmail.com" class="text-[#7A4E5E] text-lg hover:text-[#BA9EA8] transition">auraclinic@gmail.com</a>
                                <p class="text-gray-500 text-sm mt-1">We respond within 24 hours</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-6">
                            <div class="contact-icon p-4 rounded-xl flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#BA9EA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-xl mb-1">Location</h3>
                                <p class="text-[#7A4E5E] text-lg">Lanmadaw Township, Yangon</p>
                                <p class="text-[#7A4E5E]">Corner of Pansodan Road and Mahabandoola Road</p>
                                <!-- <a href="#" class="inline-block mt-2 text-[#BA9EA8] font-medium hover:underline">Get directions →</a> -->
                            </div>
                        </div>
                    </div>

                    <!-- Map Placeholder -->
                    <div class="mt-12 map-container bg-gray-100 relative overflow-hidden">
                        <img src="https://placehold.co/1200x600" alt="Map showing location of Aura Clinic at the corner of Pansodan Road and Mahabandoola Road in Yangon" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-[#BA9EA8] bg-opacity-5"></div>
                        <div class="absolute bottom-4 right-4 bg-white p-2 rounded-lg shadow-md">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.967825402364!2d96.13977397574472!3d16.77827628400879!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1eb94a5cee141%3A0x608c1dc7173558c0!2sDrZ%20Lanmadaw!5e0!3m2!1sen!2smm!4v1752503868000!5m2!1sen!2smm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#BA9EA8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-8">
                        <h3 class="font-semibold text-lg mb-4 text-[#BA9EA8]">Follow Us</h3>
                        <div class="flex gap-4">

                            <a href="#" class="social-icon bg-[#FAE8E0] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Unicons by Iconscout - https://github.com/Iconscout/unicons/blob/master/LICENSE -->
                                    <path fill="currentColor" d="M15.12 5.32H17V2.14A26 26 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73" />
                                </svg>
                            </a>
                            <a href="#" class="social-icon bg-[#FAE8E0] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Design Icons by Pictogrammers - https://github.com/Templarian/MaterialDesign/blob/master/LICENSE -->
                                    <path fill="currentColor" d="M22.46 6c-.77.35-1.6.58-2.46.69c.88-.53 1.56-1.37 1.88-2.38c-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29c0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15c0 1.49.75 2.81 1.91 3.56c-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.2 4.2 0 0 1-1.93.07a4.28 4.28 0 0 0 4 2.98a8.52 8.52 0 0 1-5.33 1.84q-.51 0-1.02-.06C3.44 20.29 5.7 21 8.12 21C16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56c.84-.6 1.56-1.36 2.14-2.23" />
                                </svg>
                            </a>
                            <a href="#" class="social-icon bg-[#FAE8E0] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Design Icons by Pictogrammers - https://github.com/Templarian/MaterialDesign/blob/master/LICENSE -->
                                    <path fill="currentColor" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4zm9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3" />
                                </svg>
                            </a>
                            <a href="#" class="social-icon bg-[#FAE8E0] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><!-- Icon from Material Design Icons by Pictogrammers - https://github.com/Templarian/MaterialDesign/blob/master/LICENSE -->
                                    <path fill="currentColor" d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93zM6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:w-1/2">
                <div class="bg-white p-8 md:p-10 contact-card">
                    <h2 class="text-3xl font-bold text-[#BA9EA8] mb-8">Send a Message</h2>

                    <form class="space-y-8" action="contact.php" method="POST">
                        <div>
                            <label class="block font-semibold text-lg mb-2">Full Name</label>
                            <input type="text" name="name" class="w-full px-5 py-4 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Your name" required>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-2">Email Address</label>
                            <input type="email" name="email" class="w-full px-5 py-4 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Your email" required>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-2">Phone Number</label>
                            <input type="tel" name="phone" class="w-full px-5 py-4 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Your phone number" required>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-2">Subject</label>
                            <select name="subject" class="w-full px-5 py-4 border border-gray-200 rounded-xl form-input focus:outline-none" required>
                                <option disabled selected>Select a subject</option>
                                <option>Appointment Booking</option>
                                <option>General Inquiry</option>
                                <option>Feedback</option>
                                <option>Emergency</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold text-lg mb-2">Your Message</label>
                            <textarea name="message" rows="6" class="w-full px-5 py-4 border border-gray-200 rounded-xl form-input focus:outline-none" placeholder="Write your message here..." required></textarea>
                        </div>

                        <div class="flex items-center gap-4">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-[#BA9EA8] rounded focus:ring-[#BA9EA8]" required>
                            <label class="text-[#7A4E5E]">I agree to the terms and privacy policy</label>
                        </div>

                        <button type="submit" name="btnsubmit" class="submit-btn w-full py-4 px-6 text-white font-semibold text-lg rounded-xl">
                            Send Message
                        </button>

                        <p class="text-center text-[#7A4E5E] mt-6">
                            We typically respond within 2 business days
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>