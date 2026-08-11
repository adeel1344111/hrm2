import cors from 'cors';
import dotenv from 'dotenv';
import express from 'express';
import mysql from 'mysql2/promise';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
dotenv.config({ path: path.join(__dirname, '../.env') });

const app = express();
const PORT = process.env.LEAD_CHECK_PORT || 3456;

app.use(cors());
app.use(express.json());

let pool;

function getPool() {
  if (!pool) {
    pool = mysql.createPool({
      host: process.env.DB_HOST === 'localhost' ? '127.0.0.1' : (process.env.DB_HOST || '127.0.0.1'),
      port: Number(process.env.DB_PORT || 3306),
      user: process.env.DB_USERNAME,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_DATABASE,
      waitForConnections: true,
      connectionLimit: 10,
    });
  }
  return pool;
}

export function normalizePhone(raw) {
  const digits = String(raw ?? '').replace(/\D/g, '');
  if (digits.length === 11 && digits.startsWith('1')) {
    return digits.slice(1);
  }
  return digits;
}

app.get('/api/health', (_req, res) => {
  res.json({ ok: true });
});

app.post('/api/check', async (req, res) => {
  try {
    const normalized = normalizePhone(req.body?.phone);

    if (!normalized) {
      return res.status(400).json({ error: 'Please enter a phone number.' });
    }

    if (normalized.length < 10) {
      return res.status(400).json({ error: 'Phone number must be at least 10 digits.' });
    }

    const db = getPool();
    const [rows] = await db.execute(
      `SELECT DISTINCT campaign
       FROM verification_submissions
       WHERE phone = ?
       ORDER BY campaign ASC`,
      [normalized]
    );

    const campaigns = rows.map((row) => row.campaign).filter(Boolean);
    const found = campaigns.length > 0;

    res.json({
      normalized,
      found,
      message: found ? 'Do not transfer' : 'You can transfer',
      campaigns,
    });
  } catch (err) {
    console.error('Lead check error:', err.message);
    res.status(500).json({ error: 'Unable to check number right now.' });
  }
});

app.listen(PORT, '127.0.0.1', () => {
  console.log(`Lead check API listening on http://127.0.0.1:${PORT}`);
});
