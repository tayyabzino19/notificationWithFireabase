<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">

        <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
        <script>
            var firebaseConfig = {

                apiKey: "AIzaSyDwj3nPjSTAxdO96FABpwhGWVjlQxvIGjU",
                databaseURL: 'https://notificationrepo.firebaseio.com',
                authDomain: "notificationrepo.firebaseapp.com",
                projectId: "notificationrepo",
                storageBucket: "notificationrepo.appspot.com",
                messagingSenderId: "208655285787",
                appId: "1:208655285787:web:33d5812aa325a6cfdbc2be",
                measurementId: "G-TJFJWJMVEN"


            };
            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();
            function startFCM() {

                messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function (response) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url: '{{ route("store.token") }}',
                            type: 'POST',
                            data: {
                                token: response
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                alert('Token stored.');
                            },
                            error: function (error) {
                                alert(error);
                            },
                        });
                    }).catch(function (error) {
                        alert(error);
                    });
            }
            messaging.onMessage(function (payload) {

                const title = payload.notification.title;
                const options = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(title, options);
            });


        </script>
        <script> startFCM()</script>
    </body>
</html>
