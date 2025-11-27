<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aura Aesthetic Clinic</title>

    <!-- Tailwind with custom config -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brandLight: "#FFF8F5",
                        brandDark: "#4C2A36",
                        brandPink: "#916D7A",
                    },
                    fontFamily: {
                        playfair: ["Playfair Display", "serif"],
                    },
                },
            },
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>


    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/@fontsource/playfair-display@latest/700.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="style.css" rel="stylesheet">

    <script>
        function toggleMenu() {
            document.getElementById("mobile-menu").classList.toggle("hidden");
        }

        function toggleDropdown() {
            document.getElementById("treatments-dropdown").classList.toggle("hidden");
        }
    </script>
</head>