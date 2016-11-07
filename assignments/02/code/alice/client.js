var request = require('request');

process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";

var HOST = "mathlab.utsc.utoronto.ca";
var PATH = "/courses/cscd27f16/assignment/02/server/"
var DATA = {
        username: "alice",
        password: "pass4alice"
}

var do_request = function(){
    request.get('http://' + HOST + PATH, function (err, response, body) {
        if (err) return console.log(err);
        if (response.statusCode != 200) return console.log(response.statusCode);
        var protocol = response.request.uri.protocol;
        setTimeout(function(){
            request.post(protocol + "//"+ HOST + PATH + "login.php", {form:DATA}, function (err, response, body) {
                if (err) return console.log(err);
                if (response.statusCode != 200) return console.log(response.statusCode);
                return console.log(body);
            });
        }, 1 * 1000);
    });
};

setInterval(do_request, 5 * 1000);