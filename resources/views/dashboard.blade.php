
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


    <div class="container">
        <div class="row"><br>
            <div class="col-lg-12" style="padding:30px 50px;background:#eee;">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="create_order"> Create Order </a>  | <a href="allowNotification"> Allow Notification ? </a>
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!  <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-12">
                <hr>
                <div class="alert alert-success" role="alert" id="alert" >  </div>

                <h2>
                    My Orders
                </h2>
                <ul>
                        @foreach ($orders as $order )
                            <li>
                                {{ $loop->iteration}} -  {{ $order->total}}  |  {{ $order->status}}
                            </li>
                        @endforeach


                </ul>
            </div>
        </div>
    </div>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
    <script>
        $('#alert').hide();
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

            $('#alert').show();
            $('#alert').html('payload.notification.title');

            // const title = payload.notification.title;
            // const options = {
            //     body: payload.notification.body,
            //     icon: payload.notification.icon,
            // };


            //new Notification(title, options);
        });


    </script>





</body>
</html>
