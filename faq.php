<?php
session_start();
include('connect.php');
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FAQs | Aura Aesthetic Clinic</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .accordion {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        }

        .accordion-item {
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
        }

        .accordion-header {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9f0f3;
            transition: all 0.3s ease;
            border-left: 4px solid #BA9EA8;
        }

        .accordion-header:hover {
            background: #f1e1e7;
        }

        .accordion-header.active {
            background: #e8d1da;
        }

        .accordion-content {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.show {
            padding: 20px;
            max-height: 500px;
        }

        .doctor-image {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        .badge {
            background: #BA9EA8;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 14px;
            margin-left: 10px;
        }
    </style>
</head>

<body class="body text-[#4C2A36] bg-[#fcf8fa]">
    <?php include 'navbar.php'; ?>

    <!-- Header Section -->
    <header class="relative py-24 bg-gradient-to-br from-[#BA9EA8] to-[#7A4E5E] text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('https://placehold.co/2000x500/BA9EA8/FFFFFF?text=Aura+Aesthetic'); background-size: cover;"></div>
        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Frequently Asked Questions</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Everything you need to know about our treatments, appointments, and services
            </p>
            <div class="mt-8">
                <a href="contact.php" class="inline-flex items-center px-6 py-3 bg-white text-[#7A4E5E] rounded-full font-semibold hover:bg-opacity-90 transition">
                    <i class='bx bx-message-rounded-dots mr-2'></i> Contact Us
                </a>
            </div>
        </div>
    </header>

    <!-- FAQ Content -->
    <!-- <main class="container mx-auto px-6 py-16">
        <div class="max-w-4xl mx-auto"> -->
    <!-- Featured Questions -->
    <!-- <div class="grid md:grid-cols-2 gap-6 mb-16">
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <i class='bx bx-calendar text-4xl text-[#BA9EA8] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Appointment Scheduling</h3>
                    <p class="text-[#7A4E5E]">Learn how to book, reschedule or cancel your appointments</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition">
                    <i class='bx bx-dollar-circle text-4xl text-[#BA9EA8] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Payment & Insurance</h3>
                    <p class="text-[#7A4E5E]">Information about pricing, packages and payment options</p>
                </div>
            </div> -->

    <!-- FAQ Accordion -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-[#7A4E5E]">General Questions</h2>
        <div class="accordion">
            <?php
            $faqs = [
                [
                    'question' => 'What makes Aura Aesthetic Clinic different?',
                    'answer' => 'We specialize in personalized treatments using advanced technology and organic products. Our certified aestheticians provide customized skin analysis and treatments tailored to your specific needs.'
                ],
                [
                    'question' => 'Do I need a consultation before treatment?',
                    'answer' => 'Yes, we require all new clients to have an initial 45-minute consultation ($50, credited toward your first treatment). This allows us to properly assess your skin and recommend the best treatment plan.'
                ],
                [
                    'question' => 'What safety measures do you have in place?',
                    'answer' => 'We maintain the highest hygiene standards: all equipment is sterilized between clients, single-use disposable materials, and our staff is fully vaccinated. We follow strict protocols from the Myanmar Medical Council.'
                ],
                [
                    'question' => 'How do I prepare for my treatment?',
                    'answer' => 'Avoid sun exposure, waxing, and harsh skincare products 3 days prior. Arrive with clean skin (no makeup). For laser treatments, shave the area 24 hours before (except for facial treatments).'
                ],
                [
                    'question' => 'What is your cancellation policy?',
                    'answer' => 'We require 48 hours notice for cancellations to avoid a 50% fee. Late cancellations (<24 hours) and no-shows will be charged the full treatment price.'
                ]
            ];

            foreach ($faqs as $index => $faq) {
                echo '<div class="accordion-item mb-4">';
                echo '<div class="accordion-header" onclick="toggleAccordion(this)">';
                echo '<h3 class="text-xl font-semibold flex items-center">';
                echo '<span class="text-[#7A4E5E]">' . ($index + 1) . '.</span>';
                echo '<span class="ml-2">' . $faq['question'] . '</span>';
                echo '</h3>';
                echo '<i class="bx bx-chevron-down text-xl transition-transform"></i>';
                echo '</div>';
                echo '<div class="accordion-content">';
                echo '<div class="text-[#7A4E5E] py-4">' . $faq['answer'] . '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <!-- Treatment-Specific FAQs -->
    <div class="mb-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-[#7A4E5E]">Treatment Questions</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="accordion">
                <?php
                $treatmentFaqs = [
                    [
                        'question' => 'Which facial is right for my skin type?',
                        'answer' => 'Our HydraFacial suits all skin types. For acne-prone skin we recommend the Deep Cleansing Facial. Mature skin benefits most from our Collagen Booster Facial.'
                    ],
                    [
                        'question' => 'How often should I get laser treatments?',
                        'answer' => 'Most clients need 4-6 sessions spaced 4-6 weeks apart for optimal results. Maintenance treatments every 3-6 months help sustain results.'
                    ],
                    [
                        'question' => 'Is there downtime after treatments?',
                        'answer' => 'Chemical peels may cause 1-3 days of flaking. Micro-needling typically has 24-hour redness. Our aesthetician will provide detailed aftercare instructions.'
                    ]
                ];

                foreach ($treatmentFaqs as $faq) {
                    echo '<div class="accordion-item mb-4">';
                    echo '<div class="accordion-header" onclick="toggleAccordion(this)">';
                    echo '<h3 class="font-semibold">' . $faq['question'] . '</h3>';
                    echo '<i class="bx bx-chevron-down text-xl transition-transform"></i>';
                    echo '</div>';
                    echo '<div class="accordion-content">';
                    echo '<div class="text-[#7A4E5E] py-4">' . $faq['answer'] . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <div class="accordion">
                <?php
                $moreTreatmentFaqs = [
                    [
                        'question' => 'Are your products cruelty-free?',
                        'answer' => 'Yes! We exclusively use vegan, cruelty-free skincare lines. All products are free from parabens, sulfates, and synthetic fragrances.'
                    ],
                    [
                        'question' => 'Can I combine treatments?',
                        'answer' => 'Many treatments can be combined in one session (e.g., Facial + LED Therapy). Our specialists will create a custom treatment plan during your consultation.'
                    ],
                    [
                        'question' => 'When will I see results?',
                        'answer' => 'Some treatments (like facials) show immediate results. Others (like microneedling) require 2-4 weeks for collagen production. Multiple sessions yield cumulative benefits.'
                    ]
                ];

                foreach ($moreTreatmentFaqs as $faq) {
                    echo '<div class="accordion-item mb-4">';
                    echo '<div class="accordion-header" onclick="toggleAccordion(this)">';
                    echo '<h3 class="font-semibold">' . $faq['question'] . '</h3>';
                    echo '<i class="bx bx-chevron-down text-xl transition-transform"></i>';
                    echo '</div>';
                    echo '<div class="accordion-content">';
                    echo '<div class="text-[#7A4E5E] py-4">' . $faq['answer'] . '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Meet the Experts -->
    <div class="bg-white rounded-2xl p-8 text-center mb-16">
        <h2 class="text-3xl font-bold mb-8 text-[#7A4E5E]">Need More Help?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div>
                <img src="https://placehold.co/200x200/7A4E5E/FFFFFF?text=Dr.Aye" alt="Portrait of Dr. Aye - Head Dermatologist at Aura Aesthetic Clinic" class="doctor-image mx-auto mb-4">
                <h3 class="font-bold text-lg">Dr. Aye Aye</h3>
                <p class="text-[#7A4E5E] mb-2">Head Dermatologist</p>
                <a href="mailto:aye@auraclinic.com" class="text-[#BA9EA8] hover:underline">aye@auraclinic.com</a>
            </div>
            <div>
                <img src="https://placehold.co/200x200/7A4E5E/FFFFFF?text=Khine" alt="Portrait of Khine Khine - Senior Aesthetician at Aura Aesthetic Clinic" class="doctor-image mx-auto mb-4">
                <h3 class="font-bold text-lg">Khine Khine</h3>
                <p class="text-[#7A4E5E] mb-2">Senior Aesthetician</p>
                <a href="mailto:khine@auraclinic.com" class="text-[#BA9EA8] hover:underline">khine@auraclinic.com</a>
            </div>
            <div>
                <img src="https://placehold.co/200x200/7A4E5E/FFFFFF?text=Hla" alt="Portrait of Daw Hla - Patient Coordinator at Aura Aesthetic Clinic" class="doctor-image mx-auto mb-4">
                <h3 class="font-bold text-lg">Daw Hla</h3>
                <p class="text-[#7A4E5E] mb-2">Patient Coordinator</p>
                <a href="mailto:hla@auraclinic.com" class="text-[#BA9EA8] hover:underline">hla@auraclinic.com</a>
            </div>
        </div>
    </div>
    </div>
    </main>

    <script>
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('i');

            header.classList.toggle('active');
            content.classList.toggle('show');
            icon.style.transform = content.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0)';
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>