const moment = require('moment');

function formatMessage(username , text , time= moment().format('h:mm a')){
    return {
        username,
        text,
        time: time
    }
}


module.exports = formatMessage;