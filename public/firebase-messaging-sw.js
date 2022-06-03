// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({



    apiKey: "AIzaSyDwj3nPjSTAxdO96FABpwhGWVjlQxvIGjU",
    databaseURL: 'https://notificationrepo.firebaseio.com',
    authDomain: "notificationrepo.firebaseapp.com",
    projectId: "notificationrepo",
    storageBucket: "notificationrepo.appspot.com",
    messagingSenderId: "208655285787",
    appId: "1:208655285787:web:33d5812aa325a6cfdbc2be",
    measurementId: "G-TJFJWJMVEN"


});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});
