<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office - GVNC Gate Pass Requests</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        h2 {
            color: #333;
        }
        .badge {
            padding: 5px 10px;
        }
        .btn-action {
            margin-right: 10px;
            margin-bottom: 5px;
        }
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .waiting-requests {
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .approved-requests {
            background-color: #c3e6cb;
            padding: 10px;
            border-radius: 5px;
        }
        /* Print-Friendly Styling */
        .print-container {
            width: 230px;  /* Smaller size for bill-like appearance */
            height: 350px;
            margin: auto;
            padding: 10px;
            border: 1px solid #ccc;
            font-size: 12px;
            text-align: left;
            overflow: hidden;
            background-color: white;
        }
        .print-container h3 {
            margin-bottom: 20px;
            font-size: 16px;
            text-align: center;
        }
        .print-container table {
            width: 100%;
            margin-bottom: 20px;
        }
        .print-container table th, .print-container table td {
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }

        /* Search Bar Styling */
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .search-container label {
            margin-right: 15px;
            font-size: 16px;
            color: #333;
        }
        .search-container select {
            width: 250px;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        .search-container select:focus {
            border-color: #007bff;
            outline: none;
        }
        /* Navbar */
        .navbar {
            background-color: #343a40;
        }
        .navbar .navbar-brand, .navbar .nav-link {
            color: white !important;
        }
        .navbar .nav-link:hover {
            color: #007bff !important;
        }
        .navbar .navbar-nav {
            margin-left: auto;
        }
        .navbar .dropdown-menu {
            right: 0;
            left: auto;
        }
        /* Added Hover only for Settings and Logout */
        .navbar .dropdown-item:hover {
            background-color: transparent !important;
        }
        .navbar .dropdown-item:hover {
            background-color: #007bff;
            color: Pink !important;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">GVNC Gate Pass - Office</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- User Info and Logout -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User: Office
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

    <div class="container mt-5" id="mainContent">
        <!-- Search Form for Departments -->
        <div class="search-container">
            <label for="departmentSelect">Search by Department:</label>
            <form id="searchForm" method="GET" action="">
                <select class="form-select" id="departmentSelect" name="department" onchange="filterRequests()">
                    <option value="">-- Select Department --</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Information Technology">Information Technology</option>
                    <option value="Costume Design & Fashion">Costume Design & Fashion</option>
                    <option value="Computer Application">Computer Application</option>
                    <option value="English">English</option>
                    <option value="Commerce">Commerce</option>
                    <option value="Commerce Professional Accounting">Commerce Professional Accounting</option>
                    <option value="Business Analytics">Business Analytics</option>
                    <option value="Business Administration">Business Administration</option>
                    <option value="Statistics">Statistics</option>
                    <option value="Electronics">Electronics</option>
                </select>
            </form>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">Office - Manage GVNC Gate Pass Requests</h2>

        <div id="requestContainer">
            <!-- New Requests (Waiting) -->
            <div class="waiting-requests">
                <h4>New Requests (Waiting)</h4>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Roll Numbers</th>
                            <th>Names</th>
                            <th>Department</th>
                            <th>Reason</th>
                            <th>Timing</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="waitingRequests">
                        @foreach($requests as $request)
                            @if($request->status == 'waiting')
                                <tr class="requestRow" data-department="{{ $request->department }}">
                                    <td>{{ $request->rollnos }}</td>
                                    <td>{{ $request->names }}</td>
                                    <td>{{ $request->department }}</td>
                                    <td>{{ $request->reason }}</td>
                                    <td>{{ $request->timing }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ ucfirst($request->status) }}</span>
                                    </td>
                                    <td class="action-buttons">
                                        <form action="{{ route('hod.updateStatus', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="status" value="approved" class="btn btn-success btn-action">
                                                Approve
                                            </button>
                                            <button type="submit" name="status" value="waiting" class="btn btn-warning btn-action">
                                                Wait
                                            </button>
                                        </form>
                                        <form action="{{ route('hod.deleteRequest', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Approved Requests -->
            <div class="approved-requests">
                <h4>Approved Requests</h4>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Roll Numbers</th>
                            <th>Names</th>
                            <th>Department</th>
                            <th>Reason</th>
                            <th>Timing</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="approvedRequests">
                        @foreach($requests as $request)
                            @if($request->status == 'approved')
                                <tr class="requestRow" data-department="{{ $request->department }}">
                                    <td>{{ $request->rollnos }}</td>
                                    <td>{{ $request->names }}</td>
                                    <td>{{ $request->department }}</td>
                                    <td>{{ $request->reason }}</td>
                                    <td>{{ $request->timing }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ ucfirst($request->status) }}</span>
                                    </td>
                                    <td class="action-buttons">
                                        <form action="{{ route('hod.deleteRequest', $request->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action">Delete</button>
                                        </form>
                                        <button class="btn btn-info btn-action" onclick="printRequest({{ $request->id }})">Print</button>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Print View -->
    <div id="printView" class="print-container" style="display: none;">
        <h3>GVNC Gate Pass Request</h3>
        <div id="printContent"></div>
        <button class="btn btn-primary" onclick="goBack()">Go Back</button> <!-- Go Back Button -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Function to filter requests based on department
        function filterRequests() {
            var department = document.getElementById('departmentSelect').value;
            var requestRows = document.querySelectorAll('.requestRow');

            requestRows.forEach(function(row) {
                var rowDepartment = row.getAttribute('data-department');
                if (department === '' || rowDepartment === department) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Function to print selected request
        function printRequest(requestId) {
            // Hide the main content
            document.getElementById('mainContent').style.display = 'none';
            
            // Find the specific request by ID
            const request = @json($requests);
            const selectedRequest = request.find(req => req.id === requestId);

            // Set up the print content dynamically
            const printContent = ` 
                <table>
                    <tr><th>Roll Number</th><td>${selectedRequest.rollnos}</td></tr>
                    <tr><th>Name</th><td>${selectedRequest.names}</td></tr>
                    <tr><th>Department</th><td>${selectedRequest.department}</td></tr>
                    <tr><th>Reason</th><td>${selectedRequest.reason}</td></tr>
                    <tr><th>Timing</th><td>${selectedRequest.timing}</td></tr>
                    <tr><th>Status</th><td>${selectedRequest.status.charAt(0).toUpperCase() + selectedRequest.status.slice(1)}</td></tr>
                </table>
            `;

            // Display the content in the print container
            document.getElementById('printContent').innerHTML = printContent;

            // Show the print container
            document.getElementById('printView').style.display = 'block';

            // Trigger print
            window.print();

            // Hide the print container and show the main content after printing
            window.onafterprint = function () {
                document.getElementById('printView').style.display = 'none';
                document.getElementById('mainContent').style.display = 'block';
            };
        }

        // Go back to the office page
        function goBack() {
            window.location.href = "{{ url('/office') }}";  // Replace with the appropriate route for your office page
        }
    </script>
</body>
</html>
