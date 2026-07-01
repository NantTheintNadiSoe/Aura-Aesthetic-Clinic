# AURA Aesthetic Clinic

AURA Aesthetic Clinic is a PHP-based web application for showcasing clinic services, managing appointments, collecting skin assessments, and presenting treatments and skincare products online.

## Overview

This project is designed for an aesthetic clinic website where patients can:

- browse treatments and skincare products
- book appointments
- take a skin assessment
- view consultation and treatment details
- explore staff and doctor information

## Features

- Responsive homepage with featured services and latest treatments
- Appointment booking page
- Skin assessment form
- Treatment and product listings
- Product details and shopping cart support
- Staff/doctor profile display
- Database-driven content using MySQL

## Technologies Used

- PHP
- MySQL
- HTML, CSS, and JavaScript
- Tailwind CSS

## Requirements

To run this project locally, you need:

- XAMPP or WAMP server
- PHP
- MySQL
- A web browser

## Installation

1. Place the project folder inside the XAMPP htdocs directory.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create a database named `auraclinic_db`.
4. Update the database connection settings in [connect.php](connect.php) if needed.
5. Open the project in your browser:
   - http://localhost/AURA_Aesthetic_Clinic/

## Database Setup

Make sure your MySQL database contains the required tables for:

- treatments
- products
- staff registration
- appointments or related records



## Project Structure

- [index.php](index.php) – homepage
- [appointment.php](appointment.php) – appointment booking page
- [treatment.php](treatment.php) – treatment listing
- [productview.php](productview.php) – product listing
- [consultation.php](consultation.php) – consultation page
- [skinassessment.php](skinassessment.php) – skin assessment page
- [connect.php](connect.php) – database connection



This project is intended for educational or personal use unless otherwise specified by the project owner.
