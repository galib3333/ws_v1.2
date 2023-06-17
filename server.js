const WebSocket = require('ws');

const server = new WebSocket.Server({
  port: 8080,
  perMessageDeflate: false,
  handleProtocols: (protocols, request) => {
    return protocols.includes('chat') ? 'chat' : false;
  }
});

// handle incoming WebSocket connections
server.on('connection', (socket) => {
  console.log('WebSocket client connected');

  // handle incoming messages from the client
  socket.on('message', (data) => {
    try {
      const message = JSON.parse(data);
      console.log(`Received message: ${message.message} from ${message.name}`);

      // broadcast the message to all connected clients
      server.clients.forEach((client) => {
        if (client !== socket && client.readyState === WebSocket.OPEN) {
          client.send(JSON.stringify({
            name: message.name,
            message: message.message
          }));
        }
      });
    } catch (error) {
      console.error(error);
    }
  });

  // handle WebSocket connection close
  socket.on('close', () => {
    console.log('WebSocket client disconnected');
  });
});




// const WebSocket = require('ws');

// const server = new WebSocket.Server({
//   port: 8080,
// });

// // handle incoming WebSocket connections
// server.on('connection', (socket) => {
//   console.log('WebSocket client connected');

//   // handle incoming messages from the client
//   socket.on('message', (data) => {
//     console.log(`Received message: ${data}`);

//     // broadcast the message to all connected clients
//     server.clients.forEach((client) => {
//       if (client !== socket && client.readyState === WebSocket.OPEN) {
//         client.send(data);
//       }
//     });
//   });

//   // handle WebSocket connection close
//   socket.on('close', () => {
//     console.log('WebSocket client disconnected');
//   });
// });

// server.listen(8080, '0.0.0.0'); // listen on all network interfaces
