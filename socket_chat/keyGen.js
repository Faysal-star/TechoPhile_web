const crypto = require('crypto');
const secretKey = crypto.randomBytes(32).toString('hex'); // 32 bytes = 256 bits key
console.log(secretKey);