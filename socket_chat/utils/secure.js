require('dotenv').config();
const CryptoJS = require('crypto-js');

const secretKey = process.env.SECRET_KEY;

function encryptMessage(message) {
    return CryptoJS.AES.encrypt(message, secretKey).toString();
}

function decryptMessage(encryptedMessage) {
    const bytes = CryptoJS.AES.decrypt(encryptedMessage, secretKey);
    return bytes.toString(CryptoJS.enc.Utf8);
}

module.exports = { encryptMessage, decryptMessage };