// Express REST API (run: npm install && node server.js) -> http://localhost:3000
const express = require('express');
const app = express();
app.use(express.json());
let students = [{ id: 1, name: 'Amit Shah', course: 'BCA' }, { id: 2, name: 'Riya Patel', course: 'MCA' }];

app.get('/api/students', (req, res) => res.json(students));
app.get('/api/students/:id', (req, res) => {
  const s = students.find(x => x.id == req.params.id);
  s ? res.json(s) : res.status(404).json({ error: 'Not found' });
});
app.post('/api/students', (req, res) => {
  const s = { id: students.length + 1, ...req.body }; students.push(s); res.status(201).json(s);
});
app.listen(3000, () => console.log('Express API on http://localhost:3000'));
