# Travel Insurance Quote System

This is a web application built using **Laravel 10** and styled with **Tailwind CSS**. The system allows users to calculate travel insurance quotes based on their destination, travel dates, and selected coverage options. 

It supports key features like quote calculations, form validation, and storage of quotes in a database.

---

## Table of Contents

1. [Features](#features)
2. [Tech Stack](#tech-stack)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Folder Structure](#folder-structure)
6. [Tests](#tests)
7. [Author](#author)

---

## Features

- **Dynamic Quote Calculation**: Calculates quotes based on user input.
- **Form Validation**: Ensures user inputs are valid before submission.
- **Database Integration**: Stores quotes for future reference.
- **Responsive Design**: Built using Tailwind CSS for modern and adaptive UI.
- **Coverage Options**: Includes medical expenses and trip cancellation.

---

## Tech Stack

- **Backend**: Laravel 10
- **Frontend**: Tailwind CSS
- **Build Tools**: Vite
- **Database**: MySQL
- **Testing**: PHPUnit

---

## Installation

Follow these steps to set up the project locally:

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js >= 16.x
- MySQL (or any compatible database)

### Setup Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/Piyumi14/Travel_Insurance_System.git
   cd travel-insurance-system

2. Install PHP dependencies:  
    composer install

3. Install Node.js dependencies:
    npm install

4. Configure environment variables:
    - Copy .env.example to .env:
    cp .env.example .env

5. Update the .env file with your database credentials:
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=travel_insurance
    - DB_USERNAME=root
    - DB_PASSWORD=yourpassword

6. Run migrations to set up the database:
    php artisan migrate

7. Start the development server:
    php artisan serve

8. Start Vite to compile assets:
    npm run dev

9. Open your browser and visit:
    http://127.0.0.1:8000/
    

### Usage
- Visit the homepage to access the quote form.
- Fill in the following fields:
    - Destination: Select from Europe, Asia, or America.
    - Start Date and End Date: Specify your travel dates.
    - Coverage Options: Choose optional coverage for medical expenses or trip cancellation.
    - Number of Travelers: Enter the total number of travelers.

- Click "Get Quote" to calculate your travel insurance cost.

### Tests
- Running Tests
    - php artisan test

### Author
- Piyumi Dayarathna
- Email: lbpmdayarathna@gmail.com
- GitHub: https://github.com/Piyumi14/
