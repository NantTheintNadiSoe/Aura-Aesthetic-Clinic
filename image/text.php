<?php
// index.php - Home Page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Skincare Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        }

        function toggleDropdown() {
            document.getElementById('treatments-dropdown').classList.toggle('hidden');
        }
    </script>
</head>

<body class="bg-white text-gray-800">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 py-4 shadow-md relative">
        <div class="text-xl font-bold">Logo</div>
        <ul class="hidden md:flex space-x-6">
            <li><a href="#" class="hover:text-pink-500">Home</a></li>
            <li><a href="#" class="hover:text-pink-500">About Us</a></li>
            <li><a href="#" class="hover:text-pink-500">Skin Assessment</a></li>
            <li><a href="#" class="hover:text-pink-500">Consultation</a></li>
        </ul>
        <div class="flex items-center space-x-4">
            <button class="hidden md:inline px-4 py-2 border rounded">Book Appointment</button>
            <!-- Shopping Cart Icon -->
            <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9h14l-2-9" />
            </svg>
            <!-- Login Icon -->
            <svg class="w-6 h-6 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.28 0 4-1.72 4-4s-1.72-4-4-4-4 1.72-4 4 1.72 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            <!-- Hamburger Icon - Always visible -->
            <button class="focus:outline-none" onclick="toggleMenu()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="absolute right-6 top-16 w-48 bg-white border shadow-lg rounded-md hidden z-50">
            <ul class="flex flex-col space-y-2 p-4">
                <li>
                    <button onclick="toggleDropdown()" class="w-full text-left flex justify-between items-center">
                        Treatments
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <ul id="treatments-dropdown" class="ml-4 mt-2 hidden">
                        <li><a href="#" class="block py-1 hover:text-pink-500">Facial Treatments</a></li>
                        <li><a href="#" class="block py-1 hover:text-pink-500">Anti-Aging</a></li>
                        <li><a href="#" class="block py-1 hover:text-pink-500">Acne Solutions</a></li>
                    </ul>
                </li>
                <li><a href="#" class="block py-1 hover:text-pink-500">FAQ</a></li>
                <li><a href="#" class="block py-1 hover:text-pink-500">Contact Us</a></li>
                <li><a href="#" class="block py-1 hover:text-pink-500">Shops</a></li>
                <li><a href="#" class="block py-1 hover:text-pink-500">Feedbacks</a></li>
            </ul>
        </div>
    </nav>

    

    <!-- Our Services -->
    <section class="px-6 py-12 text-center">
        <h2 class="text-2xl font-bold mb-8">Our Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-4 border rounded">
                <div class="w-full h-32 bg-gray-200 mb-4"></div>
                <p class="font-semibold">Virtual & In-person Consultations</p>
            </div>
            <div class="p-4 border rounded">
                <div class="w-full h-32 bg-gray-200 mb-4"></div>
                <p class="font-semibold">Skin Assessments</p>
            </div>
            <div class="p-4 border rounded">
                <div class="w-full h-32 bg-gray-200 mb-4"></div>
                <p class="font-semibold">Personalized Skincare Treatments</p>
            </div>
        </div>
    </section>

    <!-- Shop Products -->
    <section class="px-6 py-12 text-center">
        <h2 class="text-2xl font-bold mb-8">Shop Our Skincare Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="p-4 border rounded">
                    <div class="w-full h-32 bg-gray-200 mb-4"></div>
                    <p class="font-semibold">Product Name</p>
                    <p class="mb-2">Price</p>
                    <button class="px-4 py-2 bg-gray-800 text-white rounded">Add To Cart</button>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="px-6 py-12 bg-gray-50 text-center">
        <h2 class="text-2xl font-bold mb-8">What Our Clinic Says</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-4 border rounded">"Great Consultation Service"<br><strong>Anna</strong></div>
            <div class="p-4 border rounded">"My skin has improved so much"<br><strong>Lily</strong></div>
            <div class="p-4 border rounded">My skin has never looked better thanks to AURA!<br><strong>Caro</strong></div>
            <div class="p-4 border rounded">Friendly Staff and amazing treatment<br>Highly recommend!<br><strong>Ella</strong></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="px-6 py-12 bg-gray-800 text-white text-sm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="font-bold mb-2">Logo</p>
                <p>Phone</p>
                <p>Email</p>
                <p>Address</p>
            </div>
            <div>
                <p class="font-bold mb-2">Home</p>
                <p>About Us</p>
                <p>Services</p>
                <p>Skin Assessment</p>
                <p>Shop</p>
                <p>Contact</p>
                <p>Appointment</p>
            </div>
            <div>
                <p class="font-bold mb-2">Opening Hours</p>
                <p>Mon - Tue: 9:00 AM - 6:00 PM</p>
                <p>Wed - Thu: 10:00 AM - 7:00 PM</p>
                <p>Friday: Closed</p>
                <p>Sat: 9:00 AM - 6:00 PM</p>
                <p>Sun: 10:00 AM - 7:00 PM</p>
            </div>
            <div>
                <p class="font-bold mb-2">Follow Us</p>
                <p><a href="#" class="text-blue-400">Facebook</a></p>
                <p><a href="#" class="text-pink-400">Instagram</a></p>
                <p><a href="#" class="text-red-500">Youtube</a></p>
                <p><a href="#" class="text-blue-300">Twitter</a></p>
            </div>
        </div>
    </footer>
</body>

</html>