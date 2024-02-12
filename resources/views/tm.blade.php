<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button id="loginBtn">Login with Google</button>
    <script>
        document.getElementById('loginBtn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default button behavior

            // Make a request to the backend API to get the authentication URL
            fetch('http://smaster.com/api/auth/google')
                .then(response => response.json()) // Parse the JSON response
                .then(data => {
                    // Redirect the user to the authentication URL
                    window.location.href = data.authUrl;
                })
                .catch(error => console.error('Error:', error)); // Log any errors
        });

        // Check if the URL contains the token after redirection
        const urlParams = new URLSearchParams(window.location.search);
        const token = urlParams.get('token');
        if (token) {
            // Log the authentication token
            console.log('Token:', token);

            // Optional: You can make another request to your backend to get user information
            // fetch('http://smaster.com/api/user', {
            //     method: 'GET',
            //     headers: {
            //         'Authorization': `Bearer ${token}`
            //     }
            // })
            // .then(response => response.json())
            // .then(data => console.log('User:', data))
            // .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>
