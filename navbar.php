<?php include('connect.php'); ?>
<!-- Navbar -->
<nav class="flex items-center justify-between bg-[#916D7A] px-6 py-4 shadow-md text-white relative z-50">
    <!-- Logo -->
    <div class="flex items-center space-x-3">
        <img src="./image/logo2.jpg" alt="Aura Clinic Logo" class="h-12 w-12 object-cover rounded-full border-2 border-white" />
        <div class="leading-tight text-white" style="font-family: 'Playfair Display', serif;">
            <div class="text-xl font-bold">Aura</div>
            <div class="text-sm tracking-wide">Aesthetic Clinic</div>
        </div>
    </div>

    <!-- Desktop Menu -->
    <ul class="hidden lg:flex space-x-6 font-medium">
        <li><a href="index.php" class="hover:text-[#EBD5DC] transition">Home</a></li>
        <li><a href="about.php" class="hover:text-[#EBD5DC] transition">About Us</a></li>
        <li><a href="treatment.php" class="hover:text-[#EBD5DC] transition">Treatments</a></li>
        <li><a href="skinassessment.php" class="hover:text-[#EBD5DC] transition">Skin Assessment</a></li>
        <li><a href="consultation.php" class="hover:text-[#EBD5DC] transition">Consultation</a></li>
    </ul>

    <!-- Right Side -->
    <div class="flex items-center space-x-4">
        <!-- Book Appointment -->
        <a href="appointment.php" class="hidden lg:inline px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">
            Book Appointment
        </a>

        <!-- Shopping Cart Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
            <path fill="currentColor" d="M7 22q-.825 0-1.412-.587T5 20t.588-1.412T7 18t1.413.588T9 20t-.587 1.413T7 22m10 0q-.825 0-1.412-.587T15 20t.588-1.412T17 18t1.413.588T19 20t-.587 1.413T17 22M5.2 4h14.75q.575 0 .875.513t.025 1.037l-3.55 6.4q-.275.5-.737.775T15.55 13H8.1L7 15h11q.425 0 .713.288T19 16t-.288.713T18 17H7q-1.125 0-1.7-.987t-.05-1.963L6.6 11.6L3 4H2q-.425 0-.712-.288T1 3t.288-.712T2 2h1.625q.275 0 .525.15t.375.425z" />
        </svg>

        <!-- Login/Profile -->
        <?php
        if (!isset($_SESSION['sid']) && !isset($_SESSION['pid'])) {
            // Not logged in
            echo '<a href="login.php" title="Patient Login">
                    <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </a>';
        } elseif (isset($_SESSION['pid'])) {
            $name = $_SESSION['pname']; ?>
            <div class="relative">
                <button onclick="toggleDropdown('userDropdown')" class="flex items-center space-x-2 focus:outline-none">
                    <span class="text-lg font-semibold hidden lg:inline"><?= htmlspecialchars($name) ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="userDropdown" class="absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded shadow-lg hidden">
                    <a href="patientdashboard.php" class="block px-4 py-2 hover:bg-gray-100">Profile View</a>
                    <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        <?php } elseif (isset($_SESSION['sid'])) {
            $staffName = $_SESSION['sname']; ?>
            <div class="relative">
                <button onclick="toggleDropdown('staffDropdown')" class="flex items-center space-x-2 focus:outline-none">
                    <span class="text-lg font-semibold hidden lg:inline"><?= htmlspecialchars($staffName) ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="staffDropdown" class="absolute right-0 mt-2 w-40 bg-white text-gray-700 rounded shadow-lg hidden">
                    <a href="staffdashboard.php" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                    <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        <?php } ?>

        <!-- Hamburger -->
        <button onclick="toggleMenu()" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="absolute right-6 top-16 w-48 bg-[#EBD5DC] border shadow-lg rounded-md hidden z-50 font-medium text-[#4A2C35]">
        <ul class="flex flex-col space-y-2 p-4">
            <li><a href="faq.php" class="block py-1 hover:text-[#916D7A]">FAQ</a></li>
            <li><a href="contact.php" class="block py-1 hover:text-[#916D7A]">Contact Us</a></li>
            <li><a href="productview.php" class="block py-1 hover:text-[#916D7A]">Shops</a></li>
            <li><a href="feedback.php" class="block py-1 hover:text-[#916D7A]">Feedbacks</a></li>
        </ul>
    </div>
</nav>

<!-- Scripts -->
<script>
    function toggleDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }

    function toggleMenu() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    }

    // Close dropdowns and mobile menu if clicked outside
    window.addEventListener('click', function(e) {
        const dropdowns = ['userDropdown', 'staffDropdown'];
        dropdowns.forEach(id => {
            const dropdown = document.getElementById(id);
            if (!dropdown) return;
            const button = dropdown.previousElementSibling;
            if (!dropdown.contains(e.target) && !button.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile menu
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburger = document.querySelector('button[onclick="toggleMenu()"]');
        if (!mobileMenu.contains(e.target) && !hamburger.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>