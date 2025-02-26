<html>
<head>
    <title>DISC Assessment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="bg-[#2b57b5] p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="assessment.php" class="text-white font-bold text-lg">DISC ASSESSMENT</a>
            <div class="space-x-8">
                <a href="assessment.php" class="text-white">Home</a>
                <a href="about.php" class="text-white">About</a>
                <a href="mission.php" class="text-white">Mission</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto mt-4 px-4 fade-in">
        <h1 class="text-4xl font-bold mb-4 text-center text-[#2b57b5]">Situation-Based DISC Assessment</h1>
        <p class="mb-6 text-gray-700 text-lg text-center border border-gray-300 p-4 rounded">
            This assessment will help you understand your DISC personality type based on how you respond to different work situations. For each question, mark the option that best describes how you would typically respond in that scenario. Do not overthink your answers; go with what feels most natural. At the end, you will be able to calculate your scores to determine your primary DISC type.
        </p>
            <div class="flex justify-center">
                <button id="startButton" class="flex justify-center gap-2 items-center mx-auto shadow-xl text-lg bg-gray-50 backdrop-blur-md lg:font-semibold isolation-auto border-gray-50 before:absolute before:w-full before:transition-all before:duration-700 before:hover:w-full before:-left-full before:hover:left-0 before:rounded-full before:bg-[#2b57b5] hover:text-gray-50 before:-z-10 before:aspect-square before:hover:scale-150 before:hover:duration-700 relative z-10 px-4 py-2 overflow-hidden border-2 rounded-full group"
                >
                Get Started
                <svg
                    class="w-8 h-8 justify-end group-hover:rotate-90 group-hover:bg-gray-50 text-gray-50 ease-linear duration-300 rounded-full border border-gray-700 group-hover:border-none p-2 rotate-45"
                    viewBox="0 0 16 19"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                    d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z"
                    class="fill-gray-800 group-hover:fill-gray-800"
                    ></path>
                </svg>
                </button>
            </div>
    </div>

    <div id="questionContainer" class="container mx-auto mt-10 px-4 hidden">
    
    <!-- Modal for User Information -->
    <div id="userModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">Enter Your Information</h2>
            <form id="userInfoForm" class="space-y-4" onsubmit="formatUserInfo()">
                <input type="text" id="firstNameInput" name="firstName" placeholder="First Name" class="w-full px-3 py-2 border rounded" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/^[0-9]+|[0-9]+$/g, ''); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();">
                <div class="flex items-center">
                    <input type="text" id="middleInitialInput" name="middleInitial" placeholder="M" class="w-12 px-3 py-2 border rounded text-center" maxlength="1" oninput="this.value = this.value.replace(/[^A-Za-z]/g, '').toUpperCase();">
                    <span class="ml-2">.</span>
                </div>
                <input type="text" id="lastNameInput" name="lastName" placeholder="Last Name" class="w-full px-3 py-2 border rounded" required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/^[0-9]+|[0-9]+$/g, ''); this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();">
                <input type="email" id="emailInput" name="email" placeholder="Email" class="w-full px-3 py-2 border rounded" required maxlength="35" oninput="this.value = this.value.replace(/[^a-zA-Z0-9@._-]/g, '');">
                <div class="flex justify-end space-x-4">
                    <button type="button" id="cancelButton" class="bg-gray-400 text-white px-4 py-2 rounded hover:opacity-90">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:opacity-90">Proceed</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function formatUserInfo() {
            const firstNameInput = document.getElementById('firstNameInput');
            const lastNameInput = document.getElementById('lastNameInput');
            firstNameInput.value = firstNameInput.value.charAt(0).toUpperCase() + firstNameInput.value.slice(1).toLowerCase();
            lastNameInput.value = lastNameInput.value.charAt(0).toUpperCase() + lastNameInput.value.slice(1).toLowerCase();
        }
    </script>
    
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 h-2 rounded-full mt-6">
        <div id="progressBar" class="bg-blue-600 h-2 rounded-full" style="width: 0%;"></div>
    </div>
    <p id="progressPercentage" class="text-gray-600 mt-2 text-sm">0% Complete</p>
    <p id="progressText" class="text-gray-600 mb-5">Question 1 of 28</p>
    <form id="assessmentForm" method="POST" action="process.php" class="space-y-4">
        <input type="hidden" name="first_name" id="firstName">
        <input type="hidden" name="middle_initial" id="middleInitial">
        <input type="hidden" name="last_name" id="lastName">
        <input type="hidden" name="email" id="email">
        <input type="hidden" name="totalQuestions" value="28">


        <?php
        $questions = [ // QUESTIONS
            "Which of the following best describes your approach to work?",
            "How do you handle deadlines?",
            "What is your leadership style?",
            "How do you react when a project is falling behind schedule?",
            "What motivates you most in a work environment?",
            "How do you approach problem-solving?",
            "When communicating, what is your preference?",
            "How do you handle criticism?",
            "What is your approach to decision-making?",
            "When you face a setback, how do you typically respond?",
            "How do you prefer to work within a team?",
            "How do you handle stress at work?",
            "What is your approach to change?",
            "When starting a new task, how do you begin?",
            "How do you typically respond to conflict?",
            "What drives you to succeed?",
            "How do you handle feedback from others?",
            "What is your approach to planning?",
            "How do you prioritize tasks?",
            "What describes your work ethic?",
            "How do you prefer to be recognized for your work?",
            "How do you approach learning new skills?",
            "What is your reaction to strict rules or guidelines?",
            "How do you manage your time?",
            "What is your approach to handling risks?",
            "How do you prefer to handle new challenges at work?",
            "What role do you usually take in group discussions?",
            "How do you react to sudden changes in a project?",
        ];

        $options = [
            // DOMINANCE - INFLUENCE - STEADINESS - CONSCIENTIOUSNESS
            ["D" => "I take charge and aim for quick results.", "I" => "I motivate others and maintain a positive atmosphere.", "S" => "I focus on teamwork and support others.", "C" => "I ensure accuracy and follow processes."],
            ["I" => "I use them as motivation to keep energy high.", "D" => "I use them as motivation to keep energy high.", "S" => "I plan carefully to meet them without stress.", "C" => "I double-check details to ensure everything is correct before submitting."],
            ["S" => "Supportive and patient.", "D" => "Direct and goal-oriented.", "I" => "Charismatic and engaging.", "C" => "Analytical and methodical."],
            ["S" => "I work with others to calmly address the delays.", "C" => "I reassess the plan to identify and correct the issues.", "I" => "I rally the team and boost morale to get back on track.", "D" => "I take control and drive the team to catch up."],
            ["C" => "Precision and quality in work.", "S" => "Stability and a harmonious team.", "D" => "Achieving ambitious goals.", "I" => "Recognition and social interactions."],
            ["C" => "I analyze the problem thoroughly before acting.", "S" => "I seek a solution that everyone is comfortable with.", "I" => "I brainstorm with others and think creatively.", "D" => "I quickly find the most efficient solution."],
            ["D" => "Being direct and to the point.", "S" => "Being considerate and supportive. ", "C" => "Being clear and detailed.", "I" => "Being enthusiastic and engaging."],
            ["I" => "I discuss it openly and move on quickly.", "C" => "I carefully evaluate it to improve my performance.", "S" => "I reflect on it and consider how it affects the team.", "D" => "I address it directly and take action if needed."],
            ["C" => "I base my decisions on data and thorough analysis.", "D" => "I make quick, decisive choices.", "S" => "I prefer to take my time and avoid risks.", "I" => "I consult with others and consider their input."],
            ["D" => "I push harder to overcome it.", "S" => "I remain calm and adjust my approach.", "I" => "I stay positive and encourage others.", "C" => "I analyze what went wrong and plan to avoid it in the future."],
            ["C" => "I focus on the details and ensure quality.", "S" => "I support others and help maintain harmony.", "I" => "I collaborate and keep the team energized.", "D" => "I lead and drive the group forward."],
            ["C" => "I become more focused and organized.", "S" => "I stay calm and rely on routines to manage stress.", "I" => "I use humor and positive thinking to diffuse tension.", "D" => "I tackle challenges head-on and keep moving."],
            ["D" => "I embrace it and take the lead in adapting.", "C" => "I analyze the impact and plan accordingly.", "I" => "I see it as an opportunity and encourage others to join in.", "S" => "I prefer gradual changes that don’t disrupt the routine."],
            ["I" => "I gather input from others and brainstorm ideas.", "C" => "I research and plan before taking action.", "D" => "I dive in and take immediate action.", "S" => "I prepare carefully and proceed steadily."],
            ["D" => "I confront it directly and resolve it quickly.", "S" => "I seek a peaceful resolution that satisfies everyone.", "I" => "I try to smooth things over and keep the mood light.", "C" => "I analyze the situation and find a logical solution."],
            ["C" => "The pursuit of excellence and accuracy.", "D" => "A desire to win and achieve top results.", "I" => "The chance to inspire and lead others.", "S" => "The satisfaction of being reliable and dependable."],
            ["D" => "I consider it and make changes if necessary.", "C" => "I carefully assess it and refine my work.", "I" => "I appreciate it and use it to improve my approach.", "S" => "I take it to heart and adjust to maintain harmony."],
            ["D" => "I set ambitious goals and outline steps to achieve them.", "C" => "I develop detailed plans and follow them closely.", "S" => "I plan carefully to ensure consistency.", "I" => "I create flexible plans that allow for spontaneity."],
            ["D" => "I tackle the most important tasks first.", "C" => " I order tasks based on logical importance.", "S" => "I prioritize tasks that maintain stability.", "I" => "I focus on tasks that involve collaboration."],
            ["C" => "Detail-oriented and thorough.", "I" => "Energetic and people-oriented.", "D" => "Driven and results-focused.", "S" => "Dependable and consistent."],
            ["S" => "Quiet appreciation and acknowledgment.", "D" => "Public acknowledgment of achievements.", "C" => "Recognition of accuracy and quality.", "I" => "Positive feedback and social recognition."],
            ["I" => "I prefer interactive and group-based learning.", "D" => "I learn quickly through hands-on experience.", "C" => "I research thoroughly and practice until perfect.", "S" => "I take a steady, methodical approach to learning."],
            ["C" => "I respect and follow them closely.", "S" => "I adhere to them to maintain order.", "I" => "I adapt them to fit the situation.", "D" => "I follow them if they help achieve goals."],
            ["I" => "I balance tasks with social interaction.", "D" => "I prioritize tasks that yield the greatest results.", "C" => "I plan my schedule carefully to ensure accuracy and efficiency.", "S" => "I stick to a routine to manage time effectively."],
            ["D" => "I take calculated risks to achieve goals.", "C" => " I analyze risks thoroughly before deciding.", "S" => "I prefer to avoid risks and maintain stability.", "I" => "I consider risks if they lead to exciting opportunities."],
            ["C" => "I analyze the challenge in detail before taking action.", "I" => "I collaborate with others to find a creative solution.", "D" => "I take charge and address the challenge head-on.", "S" => "I approach it carefully, considering the impact on others."],
            ["I" => "I contribute enthusiastically and encourage participation.", "C" => "I provide well-thought-out input based on facts.", "D" => "I lead the conversation and direct the focus.", "S" => "I listen carefully and offer support where needed."],
            ["I" => "I find a way to make the changes exciting and positive.", "C" => "I assess how the changes will affect the overall plan before proceeding", "S" => "I prefer to understand the reasons behind the change and adapt slowly.", "D" => "I adapt quickly and keep things moving forward."],
        ];

        for ($i = 0; $i < count($questions); $i++) {    
            echo "<fieldset class='mb-6' id='question$i' style='display: none;'>";
            echo "<label class='text-2xl font-bold block mb-4'>{$questions[$i]}</label>";
            echo "<div class='mt-4 flex flex-col space-y-4'>";
        
            foreach ($options[$i] as $key => $value) {
                echo "<label for='q{$i}_{$key}' class='block border border-gray-300 p-4 rounded-lg cursor-pointer hover:bg-gray-100 transition flex items-center'>
                        <input type='radio' id='q{$i}_{$key}' name='q" . ($i + 1) . "' value='$key' class='hidden peer' required>
                        <span class='text-gray-700 peer-checked:font-bold peer-checked:text-blue-600'>$value</span>
                      </label>";
            }
        
            echo "</div></fieldset>";
        }
        
        ?>
        <div class="flex mt-4">
            <button type="button" id="backButton" class="bg-blue-500 text-white mr-4 px-4 py-2 rounded hover:opacity-90" hidden>Back</button>
            <button type="button" id="nextButton" class="bg-blue-500 text-white mr-4 px-4 py-2 rounded hover:opacity-90" disabled>Next</button> 
            <button type="submit" id="submitButton" class="bg-blue-500 text-white px-4 py-2 rounded hover:opacity-90" hidden>Submit</button>
        </div>
        </form>
    </div>

    <script>
        let currentQuestion = 0;
        const totalQuestions = 28; 

        document.getElementById('startButton').addEventListener('click', function() {
            document.getElementById('userModal').classList.remove('hidden');
            document.getElementById('questionContainer').classList.remove('hidden');
            this.parentElement.classList.add('hidden');
            document.getElementById('progressBar').style.width = '0%';
            document.getElementById('progressPercentage').textContent = '0% Complete';
        });

        document.getElementById('userInfoForm').addEventListener('submit', function(event) {
            event.preventDefault();

            document.getElementById('firstName').value = document.getElementById('firstNameInput').value;
            document.getElementById('middleInitial').value = document.getElementById('middleInitialInput').value;
            document.getElementById('lastName').value = document.getElementById('lastNameInput').value;
            document.getElementById('email').value = document.getElementById('emailInput').value;

            document.getElementById('userModal').classList.add('hidden');
            document.getElementById('questionContainer').classList.remove('hidden');

            showQuestion(currentQuestion);
        });

        document.getElementById('cancelButton').addEventListener('click', function() {
            document.getElementById('userModal').classList.add('hidden');
            window.location.href = 'assessment.php';
        });


        function showQuestion(index) {
            const questions = document.querySelectorAll('fieldset');
            questions.forEach((q, i) => {
                q.style.display = (i === index) ? 'block' : 'none';
            });
            document.getElementById('progressText').textContent = `Question ${index + 1} of ${totalQuestions}`;
            const selectedOption = document.querySelector(`input[name="q${index + 1}"]:checked`);
            document.getElementById('nextButton').disabled = !selectedOption;
            updateProgress();
        }

        document.getElementById('assessmentForm').addEventListener('change', function() {
            const selected = this.querySelector('input[type="radio"]:checked');
            document.getElementById('nextButton').disabled = !selected;
        });

        document.getElementById('nextButton').addEventListener('click', function() {
            currentQuestion++;
            if (currentQuestion < totalQuestions) {
                showQuestion(currentQuestion);
                updateProgress();
            } 
            if (currentQuestion === totalQuestions - 1) {
                this.style.display = 'none';
                document.getElementById('submitButton').removeAttribute('hidden');
                document.getElementById('backButton').classList.remove('ml-4');
            }

            if (currentQuestion > 0) {
                document.getElementById('backButton').removeAttribute('hidden');
            }
        });

        document.getElementById('backButton').addEventListener('click', function() {
            if (currentQuestion > 0) {
                currentQuestion--;
                showQuestion(currentQuestion);
                updateProgress();
            }
            if (currentQuestion < totalQuestions - 1) {
                document.getElementById('submitButton').setAttribute('hidden', true);
            }
            if (currentQuestion < totalQuestions - 1) {
                document.getElementById('nextButton').style.display = 'block';
            }
            if (currentQuestion === 0) {
                this.setAttribute('hidden', true);
            }
        });


        function updateProgress() {
            let progress = ((currentQuestion) / totalQuestions) * 100;
            document.getElementById('progressBar').style.width = `${progress}%`;
            document.getElementById('progressPercentage').textContent = `${Math.round(progress)}% Complete`;
        }
    </script>
</body>
</html>