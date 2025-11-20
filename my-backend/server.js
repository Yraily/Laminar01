const express = require("express");
const app = express();

// route utama
app.get("/", (req, res) => {
  res.send("Hello dari Node.js + Express!");
});

// jalankan server
app.listen(3000, () => {
  console.log("Server jalan di http://localhost:3000");
});
