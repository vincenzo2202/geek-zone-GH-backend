// import dotenv from 'dotenv';
// import express from 'express';
// import http from 'http';
// import { Server } from 'socket.io';

// dotenv.config();

// const app = express();

// const server = http.createServer(app);

// const io = new Server(server, {
//     cors: { origin: 'http://localhost:3000' }
// });

// io.on('connection', (socket) => {
//     console.log('Se ha conectado un cliente');

//     socket.broadcast.emit('chat_message', {
//         usuario: 'INFO',
//         mensaje: 'Se ha conectado un nuevo usuario'
//     });

//     socket.on('chat_message', (data) => {
//         io.emit('chat_message', data);
//     });
// });

// server.listen( process.env.PORT ||3000, () => {
//     console.log(`server listening on port ${port}`);
// });