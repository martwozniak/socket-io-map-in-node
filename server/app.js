const Express = require("express")();
const Http = require("http").Server(Express);
const Socketio = require("socket.io")(Http, {
    cors: {
        origin: "http://localhost",
        methods: ["GET", "POST"]
    }
});

const markers = [];

Socketio.on("connection", socket => {
    // Po połączeniu
    for(var i = 0; i < markers.length; i++) {
        socket.emit("marker", markers[i]);
    }
    // W trakcie połączenia
    socket.on("marker", data => {
        markers.push(data);
        Socketio.emit("marker", data);
    });
});

Http.listen(3000, () => {
    console.log('Dziala');
})
