<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - Approved Gate Pass Requests</title>

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
        .status-approved {
            background-color: #c3e6cb;
            color: #155724;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer; /* Show pointer cursor when hovering over the row */
        }
        .alert {
            margin-top: 15px;
        }

        /* Add black text color for info status */
        .info-status {
            color: black;
        }

        /* Style for info column */
        .info-column {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;  /* Ensure the column takes full height */
            background-color: transparent; /* Make background transparent initially */
            padding: 0px 10px; /* Add padding to ensure there's some space */
        }

        /* Hover effect for the entire info column */
        .info-column:hover {
            background-color: #e9ecef;  /* Change the background color on hover */
            cursor: pointer;
        }

        .info-button {
            margin-right: 10px;
        }

        /* Style the info badge */
        .badge-success {
            background-color: #28a745;
            color: white;
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
            <a class="navbar-brand" href="#">GVNC Gate Pass - Security</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- User Info and Logout -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User: Security
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

    <div class="container mt-5">
        <h2 class="mb-4">Approved Gate Pass Requests - Security</h2>

        <!-- Success Alert -->
        <div id="successMessage" class="alert alert-success d-none" role="alert">
            Successfully info updated!
        </div>

        @if($approvedRequests->isEmpty())
            <div class="alert alert-warning text-center">
                No approved gate pass requests found.
            </div>
        @else
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Roll Numbers</th>
                        <th>Names</th>
                        <th>Department</th>
                        <th>Reason</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th>Info</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($approvedRequests->sortByDesc('created_at') as $request) <!-- Sorting by creation date to show latest requests first -->
                        <tr id="request-{{ $request->id }}">
                            <td>{{ $request->rollnos }}</td>
                            <td>{{ $request->names }}</td>
                            <td>{{ $request->department }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>{{ $request->timing }}</td>
                            <td><span class="badge status-approved">Approved</span></td>
                            <td class="info-column" id="info-{{ $request->id }}">
                                @if($request->info)
                                    <!-- Display the saved info if already updated -->
                                    <span class="badge badge-success info-status">{{ $request->info }}</span>
                                @else
                                    <!-- Info Button -->
                                    <button type="button" class="btn btn-info info-button" data-bs-toggle="modal" data-bs-target="#infoModal" 
                                            data-id="{{ $request->id }}">Info
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Send Status Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Radio Buttons for Student Exit Status -->
                    <div class="mb-3">
                        <label for="studentExit">Select Status</label><br>
                        <input type="radio" name="studentExit" value="Student exited from the college" id="exitYes">
                        <label for="exitYes">Student exited from the college</label><br>
                        <input type="radio" name="studentExit" value="No student exited" id="exitNo">
                        <label for="exitNo">No student exited</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendInfoBtn">Send</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var infoModal = document.getElementById('infoModal');
        var selectedRequestId = null;

        // Set request ID when modal is shown
        infoModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            selectedRequestId = button.getAttribute('data-id');
        });

        // Handle the Send button click
        document.getElementById('sendInfoBtn').onclick = function () {
            var selectedStatus = document.querySelector('input[name="studentExit"]:checked');
            if (!selectedStatus) {
                alert('Please select the student status.');
                return;
            }

            var status = selectedStatus.value;

            // Send the info back to the backend (via AJAX)
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/hod/update-info/" + selectedRequestId, true); // Ensure this matches your route
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}'); // Laravel CSRF token

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Show success message
                        var successMessage = document.getElementById('successMessage');
                        successMessage.classList.remove('d-none');
                        successMessage.textContent = response.message;

                        // Update the information in the table dynamically without refreshing
                        var requestRow = document.getElementById("request-" + selectedRequestId);
                        var infoColumn = requestRow.querySelector(".info-column");

                        // Update the info column to display the selected status and hide the button
                        infoColumn.innerHTML = "<span class='badge badge-success info-status'>" + status + "</span>";

                        // Hide modal
                        var modalInstance = bootstrap.Modal.getInstance(infoModal);
                        modalInstance.hide();

                        // Optionally: Auto-hide the success message after 3 seconds
                        setTimeout(function () {
                            successMessage.classList.add('d-none');
                        }, 3000);
                    }
                }
            };

            xhr.send(JSON.stringify({
                info: status
            }));
        };
    </script>
</body>
</html>
