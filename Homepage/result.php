<?php
require __DIR__ . '/../connection/config.php';

$result = $conn->query("SELECT * FROM disc_assessment_results ORDER BY assessment_date DESC LIMIT 1");
$data = $result->fetch_assoc();

$scores = [
    'Dominance' => $data['dominance'],
    'Influence' => $data['influence'],
    'Steadiness' => $data['steadiness'],
    'Conscientiousness' => $data['conscientiousness']
];
$conn->close();

// Determine the lowest trait
asort($scores);
$lowestTrait = key($scores);
$traitsWeaknesses = [
    'Dominance' => "May come off as overly aggressive or controlling. Individuals with high Dominance can struggle with patience and may need to work on listening to others' perspectives.",
    'Influence' => "Can be perceived as superficial or overly talkative. Those with high Influence may need to focus on being more detail-oriented and following through on commitments.",
    'Steadiness' => "May resist change and struggle with assertiveness. Individuals with high Steadiness can sometimes be seen as indecisive or overly accommodating.",
    'Conscientiousness' => "Can be overly critical or perfectionistic. People with high Conscientiousness may need to work on being more flexible and open to new ideas."
];

// Determine the highest trait
arsort($scores);
$highestTrait = key($scores);
$traitsDescriptions = [
    'Dominance' => "Assertive, goal-oriented, and determined. Individuals with high Dominance are often seen as leaders who thrive in competitive environments. They are not afraid to take risks and are driven by results, often pushing themselves and others to achieve their goals.",
    'Influence' => "Outgoing, enthusiastic, and persuasive. Those who score high in Influence are typically charismatic and excel in social situations. They have a natural ability to inspire and motivate others, making them effective communicators and team players.",
    'Steadiness' => "Calm, patient, and supportive. People with a high Steadiness score are known for their reliability and loyalty. They create a sense of stability in their relationships and are often the peacemakers in group settings, valuing harmony and cooperation.",
    'Conscientiousness' => "Analytical, detail-oriented, and systematic. Individuals with high Conscientiousness are meticulous in their work and strive for accuracy. They are often seen as dependable and thorough, making them well-suited for roles that require careful planning and execution."
];
$traitsDetails = [
    'Dominance' => "The Dominant personality type is characterized by decisiveness, assertiveness, and a focus on results. People with a dominant personality are often direct, confident, and take initiative. They are natural leaders and are not afraid to take control of a situation. In the workplace, individuals with a dominant personality type thrive in roles that require leadership, decision-making, and the ability to take charge. They are often strategic and goal-oriented, focusing on achieving results.",
    'Influence' => "The Influence personality type is characterized by sociability, enthusiasm, and a focus on building relationships. People with an influential personality are often outgoing, optimistic, and enjoy interacting with others. They are natural networkers and are able to motivate and inspire those around them. In the workplace, individuals with an influential personality type excel in roles that require social skills, such as sales, marketing, and customer service. They are often creative and thrive in environments that allow them to express their ideas and build connections with others.",
    'Steadiness' => "The Steadiness personality type is characterized by patience, empathy, and a focus on cooperation. People with a steady personality are often supportive, reliable, and value harmony in their relationships. They are good listeners and are able to build trust and create a sense of security in their interactions with others. In the workplace, individuals with a steady personality type excel in roles that require teamwork, empathy, and a steady hand, such as human resources, counseling, or administrative positions. They are often good at resolving conflicts and creating a positive work environment.",
    'Conscientiousness' => "The Conscientiousness personality type is characterized by precision, organization, and a focus on quality. People with a conscientious personality are often detail-oriented, analytical, and value accuracy in their work. They are thorough and methodical in their approach, and they strive for excellence in everything they do. In the workplace, individuals with a conscientious personality type excel in roles that require attention to detail, such as accounting, research, or project management. They are often able to develop and adhere to processes and standards, ensuring that work is completed to the highest level of quality."
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISC Assessment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-roboto">
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

    <!-- Main Content -->
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">DISC Assessment Traits</h1>

        <div class="mt-2 mb-4 flex justify-center">
            <a href="assessment.php" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Retake Assessment
            </a>
            <button id="goBack" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition ml-4" onclick="window.location.href='process.php';">
                Go Back
            </button>
        </div>

        <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
            <!-- Traits Section -->
            <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Your Dominant Trait</h2>
                <h3 class="font-semibold text-lg text-center"> <?php echo $highestTrait; ?></h3>
                <p class="mt-4 text-justify"> <?php echo $traitsDetails[$highestTrait]; ?> </p>
            </div>

            <!-- Bar Graph Section -->
            <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Your Scores</h2>
                <?php 
                $colors = ['D' => '#FF5733', 'I' => '#FFC300', 'S' => '#36A2EB', 'C' => '#2ECC71']; // Corresponding colors for each trait
                foreach ($scores as $trait => $score): ?>
                    <div class="mb-3">
                        <div class="flex justify-between">
                            <span class="font-semibold"> <?php echo $trait; ?> </span>
                            <span> <?php echo $score; ?>% </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-6">
                            <div class="bg-blue-600 h-6 rounded-full" style="width: <?php echo $score; ?>%; background-color: <?php echo $colors[$trait[0]]; ?>;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Strengths & Weaknesses -->
            <div class="w-full md:w-1/3 bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Strengths & Weaknesses</h2>
                <p style="text-align: justify;"><strong>Strengths:</strong> You are <?php echo strtolower($traitsDescriptions[$highestTrait]); ?>. Additionally, you possess strong problem-solving skills and the ability to inspire others.</p>
                <p style="text-align: justify;"><strong>Weaknesses:</strong> <?php echo ucfirst(strtolower($traitsWeaknesses[$lowestTrait])); ?></p>
        </div>
    </div>
</body>
</html>