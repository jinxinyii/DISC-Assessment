<?php
require __DIR__ . '/../connection/config.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$scores = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
$answers = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $totalQuestions = 28;

    $first_name = $_POST['first_name'] ?? '';
    $middle_initial = $_POST['middle_initial'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';

    for ($i = 1; $i <= $totalQuestions; $i++) {
        if (isset($_POST["q$i"])) {
            $answer = $_POST["q$i"];
            $scores[$answer]++;
            $answers[$i] = $answer;
        }
    }

    $totalAnswers = array_sum($scores);
    if ($totalAnswers > 0) {
        foreach ($scores as $type => $score) {
            $scores[$type] = round(($score / $totalAnswers) * 100, 2);
        }
    }
    $answers_json = json_encode($answers);

    $stmt = $conn->prepare("INSERT INTO disc_assessment_results 
    (first_name, middle_initial, last_name, email, dominance, influence, steadiness, conscientiousness, answers) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiiiss", 
        $first_name, 
        $middle_initial, 
        $last_name, 
        $email, 
        $scores['D'], 
        $scores['I'], 
        $scores['S'], 
        $scores['C'], 
        $answers_json
    );

    if ($stmt->execute()) {
        $last_id = $stmt->insert_id;
    } else {
        die("Error saving assessment: " . $conn->error);
    }

    $stmt->close();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thisemailisfortestonly14@gmail.com';
        $mail->Password = 'Panganiban11!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('thisemailisfortestonly14@gmail.com', 'DISC Assessment');
        $mail->addAddress($email, $first_name . ' ' . $last_name);

        $mail->isHTML(true);
        $mail->Subject = 'Your DISC Assessment Results';
        $mail->Body = "
            <h2>Your DISC Assessment Results</h2>
            <p><strong>Name:</strong> {$first_name} {$middle_initial} {$last_name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Dominance (D):</strong> {$scores['D']}%</p>
            <p><strong>Influence (I):</strong> {$scores['I']}%</p>
            <p><strong>Steadiness (S):</strong> {$scores['S']}%</p>
            <p><strong>Conscientiousness (C):</strong> {$scores['C']}%</p>
            <p>Thank you for taking the DISC assessment!</p>
        ";

        $mail->send();
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
    }
}

$result = $conn->query("SELECT * FROM disc_assessment_results ORDER BY assessment_date DESC LIMIT 1");
$data = $result->fetch_assoc();

$scores['D'] = $data['dominance'];
$scores['I'] = $data['influence'];
$scores['S'] = $data['steadiness'];
$scores['C'] = $data['conscientiousness'];
$answers = json_decode($data['answers'], true);
$conn->close();
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISC Assessment</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-white">
    <!-- Navbar -->
    <nav class="bg-[#2b57b5] p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white font-bold text-lg">DISC Assessment</div>
            <div class="space-x-8">
                <a href="assessment.php" class="text-white">Home</a>
                <a href="about.php" class="text-white">About</a>
                <a href="mission.php" class="text-white">Mission</a>
            </div>
        </div>
    </nav>
    
    <!-- Title -->
    <h1 class="text-3xl font-bold text-center text-black mt-2 mb-2">Your DISC Assessment Results</h1>

    <!-- Disc Chart -->
    <div class="p-2 w-full max-w-xl mx-auto text-center">
        <div class="mt-2 flex justify-center">
            <a href="assessment.php" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Retake Assessment
            </a>
            <button id="showRadarChart" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition ml-4">
                Show Radar Chart
            </button>
            <button id="showTraits" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition ml-4" onclick="window.location.href='result.php';">
                Show Your Traits
            </button>
        </div>

        <div class="flex justify-center">
            <canvas id="discChart" class="w-full max-w-[550px] h-[550px]"></canvas>
            <canvas id="radarChart" class="w-full max-w-[600px] h-[550px] hidden"></canvas>
        </div>
    </div>

    <div class="mt-4 text-lg flex justify-center space-x-8">
        <p class="text-gray-700"><strong>Dominance (D):</strong> <?php echo $scores['D']; ?>%</p>
        <p class="text-gray-700"><strong>Influence (I):</strong> <?php echo $scores['I']; ?>%</p>
        <p class="text-gray-700"><strong>Steadiness (S):</strong> <?php echo $scores['S']; ?>%</p>
        <p class="text-gray-700"><strong>Conscientiousness (C):</strong> <?php echo $scores['C']; ?>%</p>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        const pieCanvas = document.getElementById('discChart');
        const radarCanvas = document.getElementById('radarChart');
        const toggleButton = document.getElementById('showRadarChart');

        if (!pieCanvas || !radarCanvas || !toggleButton) {
            console.error("Canvas elements or button not found!");
            return;
        }

        const ctxPie = pieCanvas.getContext('2d');
        const ctxRadar = radarCanvas.getContext('2d');

        let pieChart, radarChart;
        let showingPieChart = true;

        const totalAnswers = <?php echo array_sum($scores); ?>;
        const chartData = {
            labels: ['Dominance (D)', 'Influence (I)', 'Steadiness (S)', 'Conscientiousness (C)'],
            datasets: [{
                data: [<?php echo $scores['D']; ?>, <?php echo $scores['I']; ?>, <?php echo $scores['S']; ?>, <?php echo $scores['C']; ?>],
                backgroundColor: ['#FF5733', '#FFC300', '#36A2EB', '#2ECC71'],
            }]
        };

        // PIE CHART
        function createPieChart() {
            pieChart = new Chart(ctxPie, {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: { boxWidth: 20, padding: 20 }
                        }
                    }
                }
            });
        }

        // RADAR CHART
        function createRadarChart() {
            radarChart = new Chart(ctxRadar, {
                type: 'radar',
                data: {
                    labels: ['Dominance (D)', 'Influence (I)', 'Steadiness (S)', 'Conscientiousness (C)'],
                    datasets: [{
                        label: 'Your Scores',
                        data: [<?php echo $scores['D']; ?>, <?php echo $scores['I']; ?>, <?php echo $scores['S']; ?>, <?php echo $scores['C']; ?>],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            suggestedMin: 0,
                            suggestedMax: 100,
                            ticks: { beginAtZero: true, stepSize: 20 }
                        }
                    }
                }
            });
        }

        if (totalAnswers > 0) {
            createPieChart();
        } else {
            pieCanvas.parentElement.innerHTML = "<p class='text-center text-red-500'>No data available. Please complete the assessment.</p>";
        }

        toggleButton.addEventListener('click', function () {
            if (showingPieChart) {
                if (pieChart) pieChart.destroy();
                pieCanvas.classList.add('hidden');
                radarCanvas.classList.remove('hidden');
                createRadarChart();
                toggleButton.textContent = "Show Pie Chart";
            } else {
                if (radarChart) radarChart.destroy();
                radarCanvas.classList.add('hidden');
                pieCanvas.classList.remove('hidden');
                createPieChart();
                toggleButton.textContent = "Show Radar Chart";
            }
            showingPieChart = !showingPieChart;
        });
    });
    </script>
</body>
</html>