<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title><!--password/change-->

    <!-- External Font for Modern Typography -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }

        /* Form Container */
        .form-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #777;
            margin-bottom: 20px;
        }

        /* Success/Error Message */
        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* Form Input Fields */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            position: relative;
        }

        label {
            font-weight: 500;
            font-size: 14px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        select,
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 12px 40px 12px 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            outline: none;
            transition: border-color 0.3s ease;
        }

        select:focus,
        input[type="password"]:focus,
        input[type="text"]:focus {
            border-color: #6a0dad;
            box-shadow: 0 0 4px rgba(106, 13, 173, 0.3);
        }

        /* Custom Toggle Button */
        .password-toggle {
            position: absolute;
            top: 70%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Toggle Switch Style */
        .toggle-switch {
            position: relative;
            width: 36px;
            height: 20px;
            background-color: #ccc;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .toggle-switch::before {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: white;
            transition: transform 0.3s ease;
        }

        .toggle-switch.active {
            background-color: #6a0dad;
        }

        .toggle-switch.active::before {
            transform: translateX(16px);
        }

        /* Submit Button */
        button {
            background-color: #6a0dad;
            color: white;
            font-size: 16px;
            font-weight: bold;
            padding: 14px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #530d9b;
        }

        /* Password Validation Message */
        .password-validation {
            color: #ff0000;
            font-size: 12px;
            margin-top: 5px;
        }

        /* User Details */
        .user-details {
            margin-top: 30px;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            text-align: left;
            display: none;
        }

        /* User Details Table */
        .user-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-details table,
        .user-details th,
        .user-details td {
            border: 1px solid #ddd;
        }

        .user-details th,
        .user-details td {
            padding: 10px;
            text-align: left;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .form-container {
                padding: 30px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>

</head>
<body>

    <!-- Form Container -->
    <div class="form-container">
        <h1>Change Password</h1>

        <!-- Display Success or Error Messages -->
        @if (session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="message error">{{ session('error') }}</div>
        @endif

        <!-- Password Change Form -->
        <form action="{{ route('update-password') }}" method="POST">
            @csrf

            <!-- User Type Selection -->
            <div class="form-group">
                <label for="user_type">User Type:</label>
                <select name="user_type" id="user_type" required>
                    <option value="hod">Head of Department</option>
                    <option value="staff">Office Staff</option>
                    <option value="security">Security</option>
                </select>
            </div>

            <!-- Department Selection (Only for HOD) -->
            <div class="form-group" id="department-group" style="display: none;">
                <label for="department">Department (HOD only):</label>
                <select name="department" id="department">
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

            <!-- New Password Field -->
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" class="password-field" required>
                <div id="password-validation" class="password-validation" style="display: none;">
                    Password must be 6 characters long and include at least one letter, one number, and one special character.
                </div>
                <!-- Toggle Button -->
                <span class="password-toggle" id="password-toggle-1">
                    <div class="toggle-switch" id="toggle-1"></div>
                </span>
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label for="new_password_confirmation">Confirm New Password:</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="password-field" required>
                <!-- Toggle Button -->
                <span class="password-toggle" id="password-toggle-2">
                    <div class="toggle-switch" id="toggle-2"></div>
                </span>
            </div>

            <!-- Submit Button -->
            <button type="submit">Change Password</button>
        </form>

        <!-- Button to show user details -->
        <button type="button" id="show-details-button" style="margin-top: 20px;">Show Details</button>

        <!-- User Details Section -->
        <div class="user-details" id="user-details">
            <h3>User Details</h3>
            <table>
                <tr>
                    <th>User Type</th>
                    <td id="user-type"></td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td id="department-name"></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td id="user-password"></td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td id="created-at"></td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td id="updated-at"></td>
                </tr>
            </table>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const userTypeSelect = document.getElementById('user_type');
        const departmentGroup = document.getElementById('department-group');
        
        // Toggle department selection based on user type selection
        userTypeSelect.addEventListener('change', function () {
            if (userTypeSelect.value === 'hod') {
                departmentGroup.style.display = 'block'; // Show the department field
            } else {
                departmentGroup.style.display = 'none';  // Hide the department field
            }
        });

        // Trigger change event to check the default value on page load
        userTypeSelect.dispatchEvent(new Event('change'));

        // Password toggle functionality
        const toggle1 = document.getElementById('toggle-1');
        const toggle2 = document.getElementById('toggle-2');
        const password1 = document.getElementById('new_password');
        const password2 = document.getElementById('new_password_confirmation');
        const passwordValidation = document.getElementById('password-validation');

        toggle1.addEventListener('click', function () {
            password1.type = password1.type === 'password' ? 'text' : 'password';
            toggle1.classList.toggle('active');
        });

        toggle2.addEventListener('click', function () {
            password2.type = password2.type === 'password' ? 'text' : 'password';
            toggle2.classList.toggle('active');
        });

        // Password validation check
        password1.addEventListener('input', function () {
            const password = password1.value;
            const regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*]).{6,}$/;
            
            if (regex.test(password)) {
                passwordValidation.style.display = 'none'; // Hide validation message
            } else {
                passwordValidation.style.display = 'block'; // Show validation message
            }
        });

        // Fetch user details when the button is clicked
        document.getElementById('show-details-button').addEventListener('click', function () {
            fetch('/api/user-details')  // API endpoint to fetch user details
                .then(response => {
                    // Check if the response is valid (200 OK)
                    if (!response.ok) {
                        throw new Error(`Error: ${response.status} - ${response.statusText}`);
                    }
                    return response.json();  // Parse the JSON response
                })
                .then(data => {
                    if (data) {
                        // Update the table with user data
                        document.getElementById('user-type').textContent = data.user_type;
                        document.getElementById('department-name').textContent = data.department;
                        document.getElementById('user-password').textContent = data.password;  // Show actual password
                        document.getElementById('created-at').textContent = data.created_at;
                        document.getElementById('updated-at').textContent = data.updated_at;

                        // Display the user details section
                        document.getElementById('user-details').style.display = 'block';
                    }
                })
                .catch(error => {
                    // Log the error and show a friendly message to the user
                    console.error('Error fetching user details:', error);
                    alert("Failed to fetch user details. Please check the server or endpoint.");
                });
        });
    });
</script>
</body>
</html>
