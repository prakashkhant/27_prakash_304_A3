// Task 6: Express app that calls the PHP REST API (Node 18+ has global fetch)
// Run: node call_php_api.js  -> open http://localhost:3001/students
const express = require('express');
const app = express();
const PHP_API = 'http://localhost/php_assignment/php_api/api.php'; // adjust to your htdocs path

app.get('/students', async (req, res) => {
  try { res.json(await (await fetch(PHP_API)).json()); }
  catch (err) { res.status(500).json({ error: err.message }); }
});
app.get('/add', async (req, res) => {
  try {
    const r = await fetch(PHP_API, { method: 'POST', headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name: 'Express User', email: 'ex@example.com', course: 'BCA' }) });
    res.json(await r.json());
  } catch (err) { res.status(500).json({ error: err.message }); }
});
app.listen(3001, () => console.log('Express client on http://localhost:3001'));
