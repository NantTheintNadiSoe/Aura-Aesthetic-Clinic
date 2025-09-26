<?php
session_start();
include('connect.php');
include 'header.php'; ?>

<body class="bg-[#FFF8F5] text-[#4A2C35] font-sans">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="relative w-full h-[600px]">
        <img src="./image/beautyclinic2.webp" alt="Model" class="absolute inset-0 w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h1 class="text-5xl md:text-6xl font-extrabold mb-6 animate-fade-in text-white">Your Journey to Radiance Starts Here</h1>
                <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto text-white">Where beauty meets wellness in our premium aesthetic clinic</p>
                <button class="bg-[#BA9EA8] hover:bg-[#D6A6B8] text-white font-medium py-3 px-8 rounded-full transition">Get Started</button>
            </div>
        </div>
    </section>
    <!-- About Sections -->
    <section class="py-16">
        <div class="max-w-5xl mx-auto px-6">
            <!-- Our Story -->
            <div class="mb-16">
                <div class="flex flex-col md:flex-row items-center gap-8">

                    <div class="md:w-1/2">
                        <img src="image/about.jpg" alt="About Us" class="w-full max-w-sm rounded-2xl shadow-lg object-cover border-4 border-[#EAD4DC]">
                        <!-- <img src="/image/about.jpg" alt="Founders shaking hands in front of their first office" class="rounded-lg shadow-lg" /> -->
                    </div>
                    <div class="md:w-1/2">
                        <h2 class="text-3xl font-bold mb-4 text-[#BA9EA8]">Our Journey in Beauty</h2>
                        <p class="mb-4">Established in 2016, AURA Aesthetic Clinic was founded by the talented Ms. Olivia Johnson with a mission to help people feel confident and beautiful in their own skin.</p>
                        <p class="mb-4">Located in Lanmadaw Township, Yangon, our clinic has grown into a trusted name in modern aesthetic care by using only high-quality, FDA-approved equipment and the latest technologies. Backed by a passionate team of dermatologists and cosmetic experts, we are dedicated to delivering safe, effective, and personalized treatments that highlight each client's natural beauty.</p>

                        <div class="flex items-center mt-8">
                            <div class="bg-[#D6A6B8] bg-opacity-20 p-4 rounded-full mr-4">
                                <i class="fas fa-check-circle text-[#BA9EA8] text-xl"></i>
                            </div>
                            <span>Over 200 satisfied clients</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="bg-[#D6A6B8] bg-opacity-20 p-4 rounded-full mr-4">
                                <i class="fas fa-trophy text-[#BA9EA8] text-xl"></i>
                            </div>
                            <span>5 industry awards</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Meet Dr. Olivia Johnson Section -->
            <section class="bg-[#FFF8F5] py-16 px-4 md:px-20">
                <div class="flex flex-col md:flex-row items-center gap-10 md:gap-16">

                    <!-- Text Content -->
                    <div class="md:w-1/2">
                        <h2 class="text-4xl font-bold mb-6 text-[#BA9EA8]">Meet Dr. Olivia Johnson</h2>
                        <p class="mb-4 text-gray-700 leading-relaxed text-justify">
                            Dr. Olivia Johnson is the founder and lead practitioner of AURA Aesthetic Clinic. With over 10 years of experience in dermatology and aesthetic medicine, she is known for her dedication to enhancing natural beauty through safe and personalized treatments.
                        </p>
                        <p class="mb-4 text-gray-700 leading-relaxed text-justify">
                            After earning her medical degree and completing her dermatology residency, Dr. Johnson has continued to stay at the forefront of modern aesthetic care by attending global workshops and training programs.
                        </p>
                        <p class="mb-4 text-gray-700 leading-relaxed text-justify">
                            Her warm, client-focused approach ensures every visitor feels comfortable and confident. Under her leadership, AURA Clinic has become a trusted name in Yangon for safe, FDA-approved cosmetic solutions.
                        </p>
                        <p class="text-gray-700 leading-relaxed text-justify">
                            Outside of work, she enjoys time with her family, exploring beauty trends, and supporting local community causes.
                        </p>
                    </div>

                    <!-- Image -->
                    <div class="md:w-1/2 flex justify-center">
                        <img src="image/doctor.jpg"
                            alt="Dr. Olivia Johnson"
                            class="w-full max-w-sm rounded-2xl shadow-lg object-cover border-4 border-[#EAD4DC]" />
                    </div>

                </div>
            </section>




            <!-- Mission & Values -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold mb-8 text-center text-[#BA9EA8]">Our Mission & Values</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-[#D6A6B8] hover:shadow-lg transition">
                        <div class="text-[#BA9EA8] text-4xl mb-4">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Our Philosophy</h3>
                        <p>We believe that true beauty starts with confidence. Our mission is to help clients look and feel their best through modern, non-invasive aesthetic treatments tailored to individual needs.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-[#D6A6B8] hover:shadow-lg transition">
                        <div class="text-[#BA9EA8] text-4xl mb-4">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Our Approach</h3>
                        <p>Led by experienced dermatologists and specialists, we use FDA-approved technology and a patient-focused approach to deliver safe, effective, and natural-looking results.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-[#D6A6B8] hover:shadow-lg transition">
                        <div class="text-[#BA9EA8] text-4xl mb-4">
                            <i class="fas fa-star"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Our Commitment</h3>
                        <p>Safety, Quality, and Care — We are committed to innovation, personalized service, and achieving excellence in every treatment we provide.</p>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div>
                <h2 class="text-3xl font-bold mb-8 text-center text-[#BA9EA8]">Our Teams</h2>
                <p class="text-center max-w-2xl mx-auto mb-12">Board-certified specialists dedicated to helping you look and feel your absolute best.</p>
                <div>
                    <?php
                    $query = "SELECT * FROM staffregister 
                      WHERE Position IN ('Aesthetic Doctor', 'Dermatologist', 'Aesthetician')";
                    $result = mysqli_query($connect, $query);
                    $count = mysqli_num_rows($result);

                    if ($count == 0) {
                        echo "<p>No staff found for the selected positions.</p>";
                    } else {
                        echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-6'>";
                        while ($data = mysqli_fetch_assoc($result)) {
                            $name = $data['Name'];
                            $position = $data['Position'];
                            $email = $data['Email'];
                            $qualification = $data['Qualification'];
                            $imagePath = $data['ProfileImage'];

                            echo "
                    <div class='border border-[#EBD5DC] bg-white rounded shadow hover:shadow-md transition'>
                        <div class='w-full aspect-[3/2] mb-3 overflow-hidden rounded-t bg-[#FAF2F5]'>
                            <img src='{$imagePath}' alt='{$name}' class='w-full h-full object-cover object-top' onerror=\"this.src='default.jpg'\">
                        </div>
                        <div class='p-3'>
                            <h3 class='font-semibold text-lg text-[#916D7A]'>$name</h3>
                            <p class='text-sm text-gray-600 mb-2'>$position</p>
                            <p class='text-sm text-gray-600 mb-2'>$email</p>
                            <p class='text-sm text-gray-600 mb-2'>$qualification</p>
                        </div>
                    </div>
                    ";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Us Section -->
    <!-- <section class="py-16 bg-[#FFF0EB]">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-6 text-[#BA9EA8]">Join Our Team</h2>
            <p class="mb-8 max-w-2xl mx-auto">We're always looking for talented individuals to join our growing team. Check out our current openings.</p>
            <button class="bg-[#BA9EA8] hover:bg-[#D6A6B8] text-white font-medium py-3 px-8 rounded-full transition">View Open Positions</button>
        </div>
    </section> -->
    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>


<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        console.log('Mobile menu clicked');
        // Add mobile menu functionality here
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Simple animation for team cards on scroll
    const teamCards = document.querySelectorAll('.team-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    teamCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
</script>
</body>

</html>