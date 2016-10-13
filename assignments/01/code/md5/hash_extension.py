import httplib, urlparse, urllib, sys
url = sys.argv[1]

# ADD CODE HERE

# parameter url is the attack url you construct
parsedURL = urlparse.urlparse(url)

# open a connection to the server
httpconn = httplib.HTTPSConnection(parsedURL.hostname)

# issue server-API request
httpconn.request("GET", parsedURL.path + "?" + parsedURL.query)

# httpresp is response object containing a status value and possible message
httpresp = httpconn.getresponse()

# valid request will result in httpresp.status value 200
print httpresp.status

# in the case of a valid request, print the server's message
print httpresp.read()
