# Spam Mail Detection and Filtering System

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Setup and Installation](#setup-and-installation)
- [Usage](#usage)
- [Machine Learning Model](#machine-learning-model)
- [Routes](#routes)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This project is a Spam Mail Detection and Filtering System built with Laravel for the backend and Bootstrap for the frontend. It leverages a machine learning model to detect and classify spam emails.

## Features

- User Authentication
- Send and receive emails
- Detect spam emails using a machine learning model
- Organize emails into inbox, sent, spam, and trash categories
- Display counts for each email category
- Responsive design with Bootstrap

## Technologies Used

- Laravel (PHP Framework)
- Bootstrap (CSS Framework)
- Machine Learning (Logistic Regression Model)
- Python (for training the ML model)
- Flask (for serving the ML model API)
- Select2 (for enhanced select boxes)

## Setup and Installation

1. **Clone the Repository:**
   ```sh
   git clone https://github.com/yourusername/spam-mail-detection.git
   cd spam-mail-detection
   ```

2. **Install Dependencies:**
   ```sh
   composer install
   npm install
   ```

3. **Set Up Environment Variables:**
   Copy `.env.example` to `.env` and configure your database and other environment settings.

4. **Generate Application Key:**
   ```sh
   php artisan key:generate
   ```

5. **Run Migrations:**
   ```sh
   php artisan migrate
   ```

6. **Serve the Application:**
   ```sh
   php artisan serve
   ```

7. **Set Up Machine Learning Model API:**
   - Follow the instructions to set up and run the Flask API for the machine learning model.
   - Ensure the Flask API is running and accessible.

## Usage

- **Home Page:**
  The home page displays a login form and a register form for unauthenticated users. Authenticated users can see a welcome message and navigate to the emails page.

- **Emails Page:**
  The emails page lists all emails for the authenticated user, categorized into inbox, sent, spam, and trash. Spam detection is performed on page load, and counts for each category are displayed.

- **Sending Emails:**
  Authenticated users can send new emails by selecting a receiver, adding a subject, and writing the body.

## Machine Learning Model

- The machine learning model is trained using the SpamAssassin dataset.
- It uses Logistic Regression for spam classification.
- The model is exposed via a Flask API which the Laravel application calls for spam detection.

## Routes

- **Home:** `/`
- **Emails Index:** `/emails`
- **Sent Emails:** `/emails/sent`
- **Spam Emails:** `/emails/spam`
- **Trash Emails:** `/emails/trash`
- **Add New Email:** `/emails/create`
- **Profile:** `/profile`

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request for any improvements or bug fixes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.