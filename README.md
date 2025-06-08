## Laravel Chat App

This app includes a real-time chat system built using Laravel Broadcasting and Pusher.

Users can chat in real time with other users.

All messages are stored in the database so users can see their conversation history when they return.

### Backend (Laravel)
Real-time message broadcasting is handled by the MessageSent class, which implements the ShouldBroadcast interface.

This is important because implementing ShouldBroadcast tells Laravel to automatically queue and send the event to Pusher (or another broadcasting driver) when it is dispatched.

Messages are broadcasted over a unique channel between two users using the broadcastOn method.

### Frontend
On the frontend, the app uses Laravel Echo, a JavaScript library that makes it easy to subscribe to channels and listen for events broadcast from the Laravel backend.

