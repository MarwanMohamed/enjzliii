<?php global $setting;?>

@extends('front.__template')
@section('content')
<h1>فاير بيز تست</h1>
@endsection

@section('script')
    <script src="https://www.gstatic.com/firebasejs/3.6.9/firebase.js"></script>
    <script>
        // Initialize Firebase
        // TODO: Replace with your project's customized code snippet
        var config = {
            apiKey: "AIzaSyAG5bNX5eIYqqyjGDppm50y9PZPm0s5pmo",
            authDomain: "aziz-5897f.firebaseapp.com",
            messagingSenderId: "891902733012",
        };
        firebase.initializeApp(config);
        const messaging = firebase.messaging();
        messaging.requestPermission()
                .then(function() {
                    console.log('Notification permission granted.');
                    // TODO(developer): Retrieve an Instance ID token for use with FCM.
                    // ...
                })
                .catch(function(err) {
                    console.log('Unable to get permission to notify.', err);
                });
        messaging.getToken()
                .then(function(currentToken) {
                    if (currentToken) {
                        sendTokenToServer(currentToken);
                        updateUIForPushEnabled(currentToken);
                    } else {
                        // Show permission request.
                        console.log('No Instance ID token available. Request permission to generate one.');
                        // Show permission UI.
                        updateUIForPushPermissionRequired();
                        setTokenSentToServer(false);
                    }
                })
                .catch(function(err) {
                    console.log('An errors occurred while retrieving token. ', err);
                    showToken('Error retrieving Instance ID token. ', err);
                    setTokenSentToServer(false);
                });

    </script>
@endsection