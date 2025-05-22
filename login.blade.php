<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Gatepass System - Login</title>
    <!-- Link to Font Awesome for professional icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* General Reset */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            flex-direction: column;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(90deg, #9b27b0, #6a0dad);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 20px;
            box-sizing: border-box;
            z-index: 10;
        }

        .navbar .video-container {
            position: absolute;
            top: -30px;
            left: 20px;
            width: 210px;
            height: 100px;
            overflow: hidden;
            border-radius: 5px;
        }

        .navbar video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .navbar .nav-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            font-size: 18px;
        }

        .navbar .nav-links a {
            color: white;
            text-decoration: none;
        }

        .navbar .nav-links a:hover {
            text-decoration: none;
        }

        /* Animated Text Styling */
        .header-banner {
            margin-top: 160px;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(90deg, #ff6f61, #6a0dad, #ffcc00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: typing 10s steps(40, end) infinite;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
        }

        @keyframes typing {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        /* Login Container Styling */
        .container {
            margin-top: 40px;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        select, input[type="password"], input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            color: #333;
            transition: border-color 0.3s ease;
        }

        select:focus, input:focus {
            border-color: #6a0dad;
            outline: none;
            box-shadow: 0 0 4px rgba(106, 13, 173, 0.5);
        }

        button {
            width: 100%;
            background-color: #6a0dad;
            color: white;
            border: none;
            padding: 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #530d9b;
        }

        .user-form {
            display: none;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 20px;
            color: #555;
        }

        .password-container .toggle-password:hover {
            color: #6a0dad;
        }

        /* Information Containers */
        .info-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
            padding: 20px;
            width: 100%;
            max-width: 1200px;
            gap: 40px;
            flex-wrap: wrap;
        }

        .info-box {
            width: 45%;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .info-box h2 {
            color: #6a0dad;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .info-box p {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        /* Video Container Styling */
        .video-container {
            width: 100%;
            height: 400px;
            margin-top: 40px;
        }

        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        #visual-info {
            width: 100%;
            max-width: 1200px;
            margin: 40px auto;
            position: relative;
            padding-top: 50%; /* Slightly shorter height */
            overflow: hidden;
        }

        #visual-info video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 70%;
            object-fit: contain;
        }

        /* Footer Styling */
        .footer {
            background-color: #6a0dad;
            color: white;
            padding: 40px 20px;
            text-align: center;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        .footer .social-icons {
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .footer .social-icons a {
            color: white;
            font-size: 24px;
            text-decoration: none;
        }

        .footer .social-icons a:hover {
            color: #ffcc00;
        }

        .footer p {
            margin-top: 20px;
            font-size: 16px;
        }

        .footer .contact-info {
            margin-top: 20px;
            font-size: 14px;
            color: #ccc;
        }

        .footer .contact-info a {
            color: #ffcc00;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="navbar">
        <div class="video-container">
            <video autoplay muted loop>
                <source src="{{ asset('videos/pass.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="nav-links">
            <a href="#info">Info</a>
            <a href="#visual-info" >Visual Info</a>
        </div>
    </div>

    <div class="header-banner">
        GVNC Student Gatepass Request and Approval
    </div>

    <div class="container">
        <h1>Login</h1>
        <form id="loginForm" onsubmit="handleSubmit(event)">
            <div class="form-group">
                <label for="userType">Login as:</label>
                <select id="userType" name="userType" onchange="showForm()" required>
                    <option value="" disabled selected>Select User Type</option>
                    <option value="hod">Head of Department</option>
                    <option value="staff">Office Staff</option>
                    <option value="security">Security</option>
                </select>
            </div>

            <!-- HOD Form -->
            <div id="hodForm" class="user-form">
                <div class="form-group">
                    <label for="department">Select Department:</label>
                    <select id="department" name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="CS">Computer Science</option>
                        <option value="IT">Information Technology</option>
                        <option value="CDF">Costume Design & Fashion</option>
                        <option value="CA">Computer Application</option>
                        <option value="ENG">English</option>
                        <option value="COM">Commerce</option>
                        <option value="COM(pa)">Commerce Professional Accounting</option>
                        <option value="COM(ba)">Business Analytics</option>
                        <option value="BBA">Business Administration</option>
                        <option value="STAT">Statistics</option>
                        <option value="ELEC">Electronics</option>
                    </select>
                </div>
                <div class="form-group password-container">
                    <label for="hodPassword">Password:</label>
                    <input type="password" id="hodPassword" name="password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('hodPassword', this)">👁️</span>
                </div>
                <button type="submit">Login</button>
            </div>

            <!-- Office Staff Form -->
            <div id="staffForm" class="user-form">
                <div class="form-group password-container">
                    <label for="staffPassword">Password:</label>
                    <input type="password" id="staffPassword" name="password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('staffPassword', this)">👁️</span>
                </div>
                <button type="submit">Login</button>
            </div>

            <!-- Security Form -->
            <div id="securityForm" class="user-form">
                <div class="form-group password-container">
                    <label for="securityPassword">Password:</label>
                    <input type="password" id="securityPassword" name="password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('securityPassword', this)">👁️</span>
                </div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>

    <div class="info-container"  id="info">
        <div class="info-box">
            <h2>Gatepass System</h2>
            <p>The gatepass system allows students to request permission to leave the campus during official hours.</p>
        </div>
        <div class="info-box">
            <h2>Head of Department (HOD)</h2>
            <p>The HOD receives and approves the gatepass request based on the reason provided. After approval, the request is forwarded to the office staff.</p>
        </div>
        <div class="info-box">
            <h2>Office Staff</h2>
            <p>The office staff verifies the details and ensures the proper documentation before the gatepass is issued. If approved, the request is forwarded to the security for final approval.</p>
        </div>
        <div class="info-box">
            <h2>Security and Verification</h2>
            <p>After the request is approved, the student can collect the gatepass from the security office. The security team verifies the student's identity and allows them to exit the premises after confirming all details.</p>
        </div>
    </div>

    <!-- Full Width Video -->
    <div class="video-container" id="visual-info">
        <video autoplay muted loop>
            <source src="{{ asset('videos/visual.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://linkedin.com" target="_blank"><i class="fab fa-linkedin"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
        <p>&copy; 2024 GVNC. All Rights Reserved.</p>
        <div class="contact-info">
            <p>Contact us: <a href="mailto:info@gvnc.edu">info@gvnc.edu</a> | Phone: +91 123 456 7890</p>
        </div>
    </div>

    <script>
    function showForm() {
        const userType = document.getElementById('userType').value;
        const forms = document.querySelectorAll('.user-form');
        forms.forEach(form => form.style.display = 'none');
        
        if (userType === 'hod') document.getElementById('hodForm').style.display = 'block';
        if (userType === 'staff') document.getElementById('staffForm').style.display = 'block';
        if (userType === 'security') document.getElementById('securityForm').style.display = 'block';
    }

    function togglePasswordVisibility(passwordFieldId, toggleIcon) {
        const passwordField = document.getElementById(passwordFieldId);
        const isPasswordVisible = passwordField.type === 'text';
        passwordField.type = isPasswordVisible ? 'password' : 'text';
        toggleIcon.textContent = isPasswordVisible ? '👁️' : '🙈';
    }

    function handleSubmit(event) {
        event.preventDefault();
        const userType = document.getElementById('userType').value;
        
        // Redirect based on user type
        if (userType === 'hod') {
            window.location.href = "/hod"; // Redirect to hod.blade.php
        } else if (userType === 'staff') {
            window.location.href = "/office"; // Redirect to office.blade.php
        } else if (userType === 'security') {
            window.location.href = "/security"; // Redirect to security.blade.php
        }
    }
</script>

</body>
</html>
