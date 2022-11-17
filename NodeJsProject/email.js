const nodemailer = require("nodemailer");

const gmail = 'emailAddress';


var transportor = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: gmail,
        pass: 'password',
    }
});






function sendEmail(subject, message) {

    var mailOptions = {
        from: gmail,
        to: gmail,
        subject: subject,
        text: message,
    };

    transportor.sendMail(mailOptions, function (err, info) {
        if(err) {
            console.log(err)
        } else {
            console.log('Email sent: ' + info.response);
        }

    })
}

exports.sendEmail = sendEmail;