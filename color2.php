<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aura Skincare Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }

        function toggleDropdown() {
            document.getElementById("treatments-dropdown").classList.toggle("hidden");
        }
    </script>
</head>

<body class="font-sans bg-[#FFF8F5] text-[#4C2A36]">
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 py-4 shadow-md bg-[#BA9EA8] text-white relative">
        <div class="text-xl font-bold">Aura Clinic</div>

        <!-- Desktop Menu (lg and up) -->
        <ul class="hidden lg:flex space-x-6 font-medium">
            <li><a href="#" class="hover:text-[#EBD5DC] transition">Home</a></li>
            <li><a href="#" class="hover:text-[#EBD5DC] transition">About Us</a></li>
            <li><a href="#" class="hover:text-[#EBD5DC] transition">Skin Assessment</a></li>
            <li><a href="#" class="hover:text-[#EBD5DC] transition">Consultation</a></li>
        </ul>

        <div class="flex items-center space-x-4">
            <button class="hidden lg:inline px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">
                Book Appointment
            </button>

            <!-- Shopping Cart Icon -->
            <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <!-- Login Icon -->
            <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <!-- Hamburger Icon -->
            <button onclick="toggleMenu()" class="focus:outline-none lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Hamburger Menu -->
        <div id="mobile-menu" class="absolute right-6 top-16 w-48 bg-[#EBD5DC] border shadow-lg rounded-md hidden z-50 font-medium lg:hidden text-[#4A2C35]">
            <ul class="flex flex-col space-y-2 p-4">
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Home</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">About Us</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Skin Assessment</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Consultation</a></li>
                <li>
                    <button onclick="toggleDropdown()" class="w-full text-left flex justify-between items-center font-semibold">
                        Treatments
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="treatments-dropdown" class="ml-4 mt-2 hidden">
                        <li><a href="#" class="block py-1 hover:text-[#916D7A]">Facial Treatments</a></li>
                        <li><a href="#" class="block py-1 hover:text-[#916D7A]">Anti-Aging</a></li>
                        <li><a href="#" class="block py-1 hover:text-[#916D7A]">Acne Solutions</a></li>
                    </ul>
                </li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">FAQ</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Contact Us</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Shops</a></li>
                <li><a href="#" class="block py-1 hover:text-[#916D7A]">Feedbacks</a></li>
            </ul>
        </div>
    </nav>


    <!-- Hero Section -->
    <section class="relative w-full h-[500px] md:h-[600px]">
        <img src="./image/model2.jpg" alt="Model" class="absolute inset-0 w-full h-full object-cover object-center" />
        <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        <div class="relative z-10 h-full flex items-center">
            <div class="max-w-7xl mx-auto px-6 w-full">
                <div class="max-w-xl text-left text-white">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4 text-[#FFD1DC]">Reveal Your Natural Glow</h1>
                    <p class="mb-6">Personalized skincare & expert consultations from certified aestheticians</p>
                    <div class="space-x-4">
                        <button class="px-4 py-2 bg-[#5B3F4E] text-white rounded hover:bg-[#4A2C35] transition">Take Skin Assessment</button>
                        <button class="px-4 py-2 border border-white text-white rounded hover:bg-white hover:text-[#916D7A] transition">Book Appointment</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Services -->
    <section class="py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-8 text-[#BA9EA8]">Our Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">
                    <div class="w-full h-32 bg-[#D6A6B8] opacity-20 mb-4 rounded"></div>
                    <p class="font-semibold">Virtual & In-person Consultations</p>
                </div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">
                    <div class="w-full h-32 bg-[#D6A6B8] opacity-20 mb-4 rounded"></div>
                    <p class="font-semibold">Skin Assessments</p>
                </div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">
                    <div class="w-full h-32 bg-[#D6A6B8] opacity-20 mb-4 rounded"></div>
                    <p class="font-semibold">Personalized Skincare Treatments</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop Section -->
    <section class="py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-8 text-[#BA9EA8]">Shop Our Skincare Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div class="p-6 border rounded bg-white shadow-sm">
                        <div class="w-full h-32 bg-[#D6A6B8] opacity-20 mb-4 rounded"></div>
                        <p class="font-semibold text-[#4C2A36]">Product Name</p>
                        <p class="mb-2 text-[#6B7280]">Price</p>
                        <button class="px-4 py-2 bg-[#BA9EA8] text-white rounded hover:bg-[#8C4E2C] transition">Add To Cart</button>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-12 bg-[#FFF8F5]">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold mb-8 text-[#BA9EA8]">What Our Clients Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">"Great Consultation Service"<br /><strong>Anna</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">"My skin has improved so much"<br /><strong>Lily</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">"Aura changed my skin!"<br /><strong>Caro</strong></div>
                <div class="p-6 border rounded bg-[#FFF8F5] shadow-sm">"Friendly staff!"<br /><strong>Ella</strong></div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-[#2F2F2F] text-white text-sm">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="font-bold mb-2 text-[#BA9EA8]">Aura Clinic</p>
                <p>Phone: +123 456 7890</p>
                <p>Email: info@auraclinic.com</p>
                <p>Address: 123 Skin St, Wellness City</p>
            </div>
            <div>
                <p class="font-bold mb-2 text-[#BA9EA8]">Navigation</p>
                <p>About Us</p>
                <p>Services</p>
                <p>Skin Assessment</p>
                <p>Shop</p>
                <p>Contact</p>
                <p>Appointment</p>
            </div>
            <div>
                <p class="font-bold mb-2 text-[#BA9EA8]">Opening Hours</p>
                <p>Mon–Tue: 9AM–6PM</p>
                <p>Wed–Thu: 10AM–7PM</p>
                <p>Fri: Closed</p>
                <p>Sat: 9AM–6PM</p>
                <p>Sun: 10AM–7PM</p>
            </div>
            <div>
                <p class="font-bold mb-2 text-[#BA9EA8]">Follow Us</p>
                <p><a href="#" class="hover:text-[#D6A6B8]">Facebook</a></p>
                <p><a href="#" class="hover:text-[#D6A6B8]">Instagram</a></p>
                <p><a href="#" class="hover:text-[#D6A6B8]">YouTube</a></p>
                <p><a href="#" class="hover:text-[#D6A6B8]">Twitter</a></p>
            </div>
        </div>
    </footer>

</body>

</html>