# Project Title: DISC Assessment

## Purpose
This project aims to evaluate the personality traits and behavioral styles of participants through the DISC Assessment. The assessment focuses on understanding Dominance, Influence, Steadiness, and Conscientiousness to enhance team dynamics, individual performance, and self-awareness.

## Team Members
- Elmar - Code Integrator
- Hanns - Web Developer
- Jessie - User Experience Designer
- Justin - Quality Assurance Tester
- Kim - Quality Assurance Tester and User Experience Designer
- Rhoen - Web Developer

## Objectives
- To establish a comprehensive assessment framework that accurately measures DISC personality traits.
- To promote learning through practical applications, enabling participants to apply their insights in real-world scenarios.
- To provide participants with personalized feedback and development plans based on their assessment results.
- To foster a culture of self-awareness and collaboration within teams by utilizing DISC insights.
- To enhance communication, teamwork, and leadership effectiveness through DISC-based insights.

## Intended Audience
This assessment is intended for individuals and organizations aiming to improve communication skills, foster teamwork, and support personal growth and development.

## Methodology
Participants complete a series of situation-based questions that are analyzed to generate scores in the four DISC categories: Dominance, Influence, Steadiness, and Conscientiousness. The results are presented in both pie and radar charts for easy interpretation. Additionally, participants receive detailed feedback on their strengths, weaknesses, and behavioral tendencies.

## Features
- **Dynamic Assessment**: Interactive questionnaire with progress tracking.
- **Results Visualization**: Scores displayed in pie and radar charts.
- **Email Integration**: Personalized results sent via email using PHPMailer.
- **Database Storage**: Results stored in a MySQL database for future reference.
- **User-Friendly Interface**: Tailwind CSS for responsive and modern design.

## Technologies Used
- **Frontend**: HTML, Tailwind CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Email Service**: PHPMailer
- **Charting**: Chart.js

## How to Run
1. Clone the repository to your local server directory (e.g., `c:\xampp\htdocs\`).
2. Import the `disc_assessment_results.sql` file into your MySQL database.
3. Update the database credentials in `Connection/config.php`.
4. Install dependencies using Composer:
   ```bash
   composer install