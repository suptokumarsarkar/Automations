importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');
firebase.initializeApp({apiKey: "AIzaSyDeALoPrQ3HXLM7BDwZ2CuTJT4pBLhZsRc",authDomain: "namastecurryhousesgp.firebaseapp.com",projectId: "namastecurryhousesgp",storageBucket: "namastecurryhousesgp.appspot.com", messagingSenderId: "975263911432", appId: "1:975263911432:web:dacb6bda817a0e6e68cbbd"});
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) { return self.registration.showNotification(payload.data.title, { body: payload.data.body ? payload.data.body : '', icon: payload.data.icon ? payload.data.icon : '' }); });
