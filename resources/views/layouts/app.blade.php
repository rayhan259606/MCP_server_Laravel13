<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blade Voice AI')</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #8b5cf6;
            --secondary: #06b6d4;
            --bg: #0f172a;
            --card-bg: rgba(30, 41, 59, 0.7);
            --accent: #f43f5e;
            --text: #f8fafc;
            --text-muted: #94a3b8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background: var(--bg);
            background-image:
                radial-gradient(circle at 20% 30%, rgba(139, 92, 246, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.1) 0%, transparent 40%);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .navbar {
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .nav-links { display: flex; gap: 2rem; }
        .nav-links a { color: var(--text-muted); text-decoration: none; font-weight: 500; transition: 0.3s; }
        .nav-links a:hover { color: var(--primary); }
        .nav-links a.active { color: var(--secondary); border-bottom: 2px solid var(--secondary); }

        .content { padding: 3rem 2rem; max-width: 1200px; margin: 0 auto; }

        /* Floating Mic Assistant */
        .voice-assistant {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .mic-btn {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);
            border: 4px solid rgba(255,255,255,0.1);
            transition: 0.3s;
        }

        .mic-btn:hover { transform: scale(1.1); }
        .mic-btn i { font-size: 1.5rem; color: white; }

        .listening-ring {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 50%;
            border: 4px solid var(--secondary);
            animation: pulse-ring 1.5s infinite;
            display: none;
        }

        .active .listening-ring { display: block; }

        .voice-status {
            position: absolute;
            bottom: 80px;
            right: 0;
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            padding: 1rem;
            border-radius: 16px;
            width: 300px;
            border: 1px solid rgba(255,255,255,0.1);
            display: none;
            animation: fadeInUp 0.5s ease-out;
        }

        .voice-status h5 { font-size: 0.8rem; color: var(--secondary); margin-bottom: 0.5rem; text-transform: uppercase; }
        .voice-status p { font-size: 0.95rem; color: var(--text); }

        @keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        /* Form Styling */
        .card { background: var(--card-bg); border-radius: 24px; padding: 2rem; border: 1px solid rgba(255,255,255,0.1); }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; color: var(--text-muted); }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: white;
            outline: none;
            transition: 0.3s;
        }
        .form-control:focus { border-color: var(--primary); }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: 0.3s;
        }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }

    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">
            <h2 style="font-weight: 800; letter-spacing: -1px;">BLADE <span style="color: var(--secondary);">AI</span></h2>
        </div>
        <div class="nav-links">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="/login" class="{{ request()->is('login') ? 'active' : '' }}">Login</a>
            <a href="/register" class="{{ request()->is('register') ? 'active' : '' }}">Register</a>
            <a href="/career" class="{{ request()->is('career') ? 'active' : '' }}">Career</a>
        </div>
    </nav>

    <div class="content">
        @yield('content')
    </div>

    <!-- Voice Assistant UI -->
    <div class="voice-assistant" id="assistant">
        <div class="voice-status" id="voice-status">
            <h5 id="status-title">Listening...</h5>
            <p id="transcript-text">How can I help you?</p>
        </div>
        <div class="mic-btn" id="mic-trigger" onclick="toggleVoice()">
            <div class="listening-ring"></div>
            <i class="fa-solid fa-microphone" id="mic-icon"></i>
        </div>
    </div>

    <!-- Data Overlay Panel -->
    <div id="data-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15, 23, 42, 0.9); backdrop-filter:blur(15px); z-index:2000; padding:4rem 2rem; overflow-y:auto;">
        <div style="max-width:900px; margin:0 auto;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
                <h1 style="font-weight:800; color:var(--secondary);">DATABASE RECORDS</h1>
                <button onclick="document.getElementById('data-overlay').style.display='none'" style="background:none; border:none; color:white; font-size:2rem; cursor:pointer;">&times;</button>
            </div>
            <div id="data-content" class="card">
                <!-- Table will be injected here -->
            </div>
        </div>
    </div>

    <script>
        let recognition;
        let isListening = false;
        let currentLang = 'en-US';

        if ('webkitSpeechRecognition' in window) {
            recognition = new webkitSpeechRecognition();
            recognition.continuous = false;
            recognition.interimResults = true;

            recognition.onstart = () => {
                isListening = true;
                document.getElementById('assistant').classList.add('active');
                document.getElementById('voice-status').style.display = 'block';
                document.getElementById('status-title').innerText = "Listening...";
                document.getElementById('data-overlay').style.display = 'none';
            };

            recognition.onresult = (event) => {
                let finalTranscript = '';
                for (let i = event.resultIndex; i < event.results.length; ++i) {
                    if (event.results[i].isFinal) finalTranscript += event.results[i][0].transcript;
                }
                if (finalTranscript) {
                    document.getElementById('transcript-text').innerText = finalTranscript;
                    processWithAI(finalTranscript);
                }
            };

            recognition.onend = () => {
                isListening = false;
                document.getElementById('assistant').classList.remove('active');
                setTimeout(() => {
                    document.getElementById('voice-status').style.display = 'none';
                }, 5000);
            };
        }

        function toggleVoice() {
            if (isListening) recognition.stop();
            else {
                recognition.lang = currentLang;
                recognition.start();
            }
        }

        /**
         * Send text to AI to determine action.
         */
        async function processWithAI(text) {
            updateUI("AI is thinking...", "Processing");
            
            try {
                const response = await fetch("/ai-process", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ text: text })
                });

                const data = await response.json();
                handleAIResult(data, text);
            } catch (error) {
                console.error(error);
                updateUI("Failed to connect to AI.", "Error");
            }
        }

        function handleAIResult(data, originalText) {
            if (data.error) {
                updateUI(data.error, "Error");
                return;
            }

            const tool = data.ai.tool;
            const input = data.ai.input;
            const result = data.result;

            console.log("AI Tool:", tool, "Input:", input);

            // Handle Navigation Action (Special Case for Frontend)
            if (tool === 'navigation_action') {
                const page = input.page;
                speak(`Navigating to ${page}`);
                if (page === 'home') window.location.href = "/";
                else window.location.href = "/" + page;
                return;
            }

            // Handle Form Automation
            if (tool === 'form_fill_action') {
                fillFormOnly();
                return;
            }

            if (tool === 'form_submit_action') {
                submitFormReal();
                return;
            }

            // Handle Data Display (List Users)
            if (tool === 'user_action' && input.action === 'list') {
                displayData(result);
                return;
            }

            // Handle Standard Results
            let msg = result.message || "Action completed";
            updateUI(msg, "AI Success");
            speak(msg);
            
            // If the user wants to fill/submit, we can still use our local functions or AI can guide us
            if (originalText.includes("fill") || originalText.includes("পূরণ")) {
                fillFormOnly();
            }
        }

        async function fetchData() {
            speak("Fetching all records from the database");
            try {
                const response = await fetch("/mcp", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ tool: "user_action", input: { action: "list" } })
                });
                const data = await response.json();
                displayData(data);
            } catch (error) {
                console.error(error);
                speak("Failed to fetch data.");
            }
        }

        function displayData(data) {
            const overlay = document.getElementById('data-overlay');
            const content = document.getElementById('data-content');
            
            if (data.status === 'success' || data.data) {
                const users = data.data || [];
                let html = `
                    <table style="width:100%; border-collapse:collapse; text-align:left;">
                        <thead>
                            <tr style="border-bottom:2px solid rgba(255,255,255,0.1); color:var(--secondary);">
                                <th style="padding:1rem;">ID</th>
                                <th style="padding:1rem;">NAME</th>
                                <th style="padding:1rem;">EMAIL</th>
                                <th style="padding:1rem;">JOINED</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                users.forEach(user => {
                    html += `
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">
                            <td style="padding:1rem;">#${user.id}</td>
                            <td style="padding:1rem; font-weight:600;">${user.name}</td>
                            <td style="padding:1rem; color:var(--text-muted);">${user.email}</td>
                            <td style="padding:1rem; font-size:0.8rem;">${new Date(user.created_at).toLocaleDateString()}</td>
                        </tr>
                    `;
                });

                html += `</tbody></table>`;
                if (users.length === 0) html = "<p style='text-align:center;'>No records found in the database.</p>";
                
                content.innerHTML = html;
                overlay.style.display = 'block';
                speak(`I found ${users.length} records.`);
            }
        }

        function fillFormOnly() {
            const path = window.location.pathname;
            speak("Filling form with demo data");

            if (path.includes('login')) {
                document.getElementById('email').value = "rayhan@example.com";
                document.getElementById('password').value = "password123";
            }
            else if (path.includes('register')) {
                document.getElementById('name').value = "Rayhan Ahmed";
                document.getElementById('email').value = "rayhan@example.com";
                document.getElementById('password').value = "password123";
                document.getElementById('confirm_password').value = "password123";
            }
            else if (path.includes('career')) {
                document.getElementById('full_name').value = "Rayhan Developer";
                document.getElementById('position').value = "Full Stack Developer";
                document.getElementById('message').value = "I love AI and automation!";
            }
        }

        async function submitFormReal() {
            const path = window.location.pathname;
            
            if (path.includes('register')) {
                const name = document.getElementById('name').value;
                if (!name) { speak("Please fill the form first."); return; }

                speak("Registering user in the database");
                try {
                    const response = await fetch("/mcp", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ 
                            tool: "user_action", 
                            input: { action: "create", name: name } 
                        })
                    });
                    const data = await response.json();
                    if (data.status === 'success') {
                        speak("Registration successful. User " + name + " has been added.");
                        updateUI("User Registered: " + name, "Success");
                    }
                } catch (e) {
                    speak("Failed to register.");
                }
            } else {
                const form = document.querySelector('form');
                if (form) {
                    speak("Submitting form");
                    form.submit();
                }
            }
        }

        function updateUI(text, status) {
            document.getElementById('status-title').innerText = status;
            document.getElementById('transcript-text').innerText = text;
            document.getElementById('voice-status').style.display = 'block';
        }

        function speak(msg) {
            const speech = new SpeechSynthesisUtterance(msg);
            window.speechSynthesis.speak(speech);
        }
    </script>

    @yield('scripts')
</body>
</html>
