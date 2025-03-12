<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        jQuery(document).ready(function(){
            $(".welcome-text").fadeOut(3500, function(){
                window.location.href = "{{ route('dashboard') }}"; // Redirect to the dashboard
            });
        });
    </script>

    <style>
        /* Background styling */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background Image with Blur */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('/images/srinetworks.jpg') no-repeat center center/cover;
            filter: blur(10px);
            z-index: -1;
        }

        /* Centered Welcome Text */
        .welcome-text {
            font-size: 65px;
            font-weight: bold;
            text-transform: uppercase;
            color: #3f231c; /* Matched color from background */
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.7);
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out;
        }

        /* Hover effect */
        .welcome-text:hover {
            transform: scale(1.1);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="background"></div>  <!-- Blurred Background Image -->

    <div class="text-center">
        <h1 class="welcome-text">Welcome to Sri Networks!</h1>
    </div>
</body>
</html>
