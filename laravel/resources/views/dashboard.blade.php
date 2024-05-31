<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css')}}">

    <!-- Include Pusher-js from CDN  -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <!-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/pusher.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        const token = localStorage.getItem('token');
        if(!token){
          window.location.href = '/';
        }
    </script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <script>
        const pusherKey = "{{ $pusherKey ?? ''}}";
        const pusherCluster = "{{ $pusherCluster ?? ''}}";
    </script>
</head>
<body>

<div class="header">
    <h1>PROJECT</h1>
</div>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="/users-home">Home</a></li>
        <li><a href="profile">Profile</a></li>
        <li><a href="/users">Users</a></li>
        <li><a href="#posts">Posts</a></li>
        <li><button class="logout-button" onclick="openModal()">Log-Out</button></li>
    </ul>
</div>

<div class="content">
     <main class="container-fluid vh-100 pb-4 mb-2">
        @yield('content')
    </main>
</div>

<!-- The modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <div class="button-container">
            <button class="modal-button" onclick="logout()">Yes</button>
            <button class="modal-button" onclick="closeModal()">No</button>
        </div>
    </div>
</div>

<script>
    function openModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    function logout() {
        localStorage.removeItem('token');
        window.location.href = '/';
    }
</script>

</body>
</html>
