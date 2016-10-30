var http = require('http');
var https = require('https');
var querystring = require('querystring');

var HOST = "mathlab.utsc.utoronto.ca";
var PATH = "/courses/cscd27f16/assignment/02/server/"

process.env.NODE_TLS_REJECT_UNAUTHORIZED = "0";

var HTTP = {
    method: require('http'),
    port: 80,
    data: {
        username: "jing",
        password: "lordnikon"
    }
};

var HTTPS = {
    method: require('https'),
    port: 443,
    data: {
        username: "thierry",
        password: "cerealkiller"
    }
};

var do_request = function(config){
    var data = querystring.stringify(config.data);
    var options = {
          host: HOST,
          path: PATH,
          method: 'POST',
          headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Content-Length': Buffer.byteLength(data)
          }
    };
    options.port = config.port;
    var req = config.method.request(options, function(res) {
        res.setEncoding('utf8');
        res.on('data', function (chunk) {
            console.log("body: " + chunk);
        });
    });
    req.write(data);
    req.end();

    req.on('error', function(e) {
      console.error(e);
    });

};

var flip = true;

setInterval(function(){
    if (flip) do_request(HTTP);
    else do_request(HTTPS);
    flip = !flip;
}, 5 * 1000);




