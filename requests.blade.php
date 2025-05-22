<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Gate Pass Requests</title>
    
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #000; /* Black navbar */
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: #fff;
            font-size: 24px;
            margin: 0;
        }

        /* Status Styles */
        .status-waiting {
            color: #721c24;
            background-color: #f8d7da;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .status-approved {
            color: #155724;
            background-color: #c3e6cb;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        /* Button Styles */
        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 4px 10px;  /* Reduced padding for a smaller button */
            font-size: 14px;  /* Smaller text */
            width: auto;  /* Ensures button size is based on text */
            max-width: 150px;  /* Prevents the button from becoming too wide */
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Status Select Styles */
        .status-select {
            padding: 5px;
            font-size: 14px;
        }

        /* Information Styles */
        .info-text {
            font-style: italic;
            color: #888;
        }

        /* Success Alert Styles */
        .alert-success {
            display: none;
        }

        /* Table Hover Effect */
        table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>

    <script>
        // Ensure that clicking the back button only takes the user to the HOD page
        window.history.pushState(null, document.title, window.location.href);
        window.addEventListener('popstate', function() {
            window.history.pushState(null, document.title, window.location.href);
            window.location.href = '/hod'; // Adjust this path if needed
        });
    </script>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <h1>HOD Gate Pass</h1>
    </div>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Student Gate Pass Requests</h2>

        <!-- Success Alert -->
        <div id="successMessage" class="alert alert-success" role="alert">
            Status information sent successfully!
        </div>

        @if($requests->isEmpty())
            <div class="alert alert-warning text-center">
                No requests found.
            </div>
        @else
            <!-- New Requests First -->
            <h4>New Requests</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Roll Nos</th>
                        <th>Names</th>
                        <th>Department</th>
                        <th>Reason</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th>Information</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests->where('status', 'waiting') as $request)
                        <tr data-id="{{ $request->id }}">
                            <td>{{ $request->rollnos }}</td>
                            <td>{{ $request->names }}</td>
                            <td>{{ $request->department }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>{{ $request->timing }}</td>
                            <td>
                                <span class="status-waiting">{{ ucfirst($request->status) }}</span>
                            </td>
                            <td>
                                @if($request->info)
                                    <span>{{ $request->info }}</span>
                                @else
                                    <span class="info-text">No info updated</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('hod.deleteRequest', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Approved Requests</h4>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Roll Nos</th>
                        <th>Names</th>
                        <th>Department</th>
                        <th>Reason</th>
                        <th>Timing</th>
                        <th>Status</th>
                        <th>Information</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests->where('status', 'approved') as $request)
                        <tr data-id="{{ $request->id }}">
                            <td>{{ $request->rollnos }}</td>
                            <td>{{ $request->names }}</td>
                            <td>{{ $request->department }}</td>
                            <td>{{ $request->reason }}</td>
                            <td>{{ $request->timing }}</td>
                            <td>
                                <span class="status-approved">{{ ucfirst($request->status) }}</span>
                            </td>
                            <td>
                                @if($request->info)
                                    <span>{{ $request->info }}</span>
                                @else
                                    <span class="info-text">No info updated</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('hod.deleteRequest', $request->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
