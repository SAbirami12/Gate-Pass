<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Gate Pass Form</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts (Roboto) for a more professional font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #343a40;
            padding: 15px;
        }

        .navbar .navbar-brand, .navbar .nav-link {
            color: white !important;
        }

        .navbar .nav-link:hover {
            color: #007bff !important;
        }

        .navbar .navbar-nav {
            margin-left: 0; /* No space to the left of the nav items */
        }

        .navbar .navbar-nav.ml-auto {
            margin-left: auto; /* Moves the user info to the right */
        }

        .navbar .dropdown-menu {
            right: 0;
            left: auto;
        }

        .navbar .dropdown-item:hover {
            background-color: transparent !important;
        }

        .navbar .dropdown-item:hover {
            background-color: #007bff;
            color: Pink !important;
        }

        /* Main Content */
        .main-content {
            padding: 30px;
        }

        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 700px;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 700;
            color: #004085;
        }

        .form-header p {
            font-size: 18px;
            color: #6c757d;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control {
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .btn-primary {
            font-size: 16px;
            padding: 12px 20px;
            background-color: #004085;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #003366;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GVNC Gate Pass - HOD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Student Requests Link -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('hod.requests') }}">Student Requests</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto"> <!-- User Info and Logout on the right -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User: HOD
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container form-container">
            <div class="form-header">
                <h2>HOD Gate Pass Form</h2>
                <p>Please fill out the details below to issue gate passes for students.</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('hod.store') }}" method="POST">
                @csrf

                <!-- Roll Numbers and Names -->
                <div class="mb-3">
                    <label for="rollnos" class="form-label">Roll Number</label>
                    <input type="text" class="form-control" id="rollnos" name="rollnos" placeholder="Enter Roll Numbers (e.g., 101, 102, 103)" required>
                </div>

                <div class="mb-3">
                    <label for="names" class="form-label">Student Name</label>
                    <input type="text" class="form-control" id="names" name="names" placeholder="Enter Names (e.g., Mukesh, Divya, Anu)" required>
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-control" id="department" name="department" required>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Costume Design & Fashion">Costume Design & Fashion</option>
                        <option value="Computer Application">Computer Application</option>
                        <option value="English">English</option>
                        <option value="Commerce">Commerce</option>
                        <option value="Commerce Professional Accounting">Commerce Professional Accounting</option>
                        <option value="Commerce Business Analytics">Commerce Business Analytics</option>
                        <option value="Business Administration">Business Administration</option>
                        <option value="Statistics">Statistics</option>
                        <option value="Electronics">Electronics</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Gate Pass</label>
                    <textarea class="form-control" id="reason" name="reason" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="timing" class="form-label">Timing</label>
                    <input type="text" class="form-control" id="timing" name="timing" required>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
