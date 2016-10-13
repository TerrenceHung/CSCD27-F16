from md5p import md5, padding

# Let's have
# Alice (the TA)
# Bob (the grade server)
# Mallory (the bad guy a.k.a you)
# Alice and Bob share a secret key but Mallory does not know it

# The code below is an accurate simulation of how the client (Alice)
# and the server (Bob) computes and verifies the tag (a.k.a MAC)

def B(tag, params):
    '''returns true/false whether the tag is valid given the params'''
    key = "secret"
    return md5(key + params).hexdigest() == tag

def A(params):
    '''returns true/false whether Alice sends the correct params and tag to the server'''
    key = "secret"
    tag = md5(key + params).hexdigest()
    return B(tag, params)

def M(params):
    '''returns true/false whether Mallory sends the correct tag and params to the server'''
    # Mallory does not know the key
    # but she knows one specific tag, the one resulting from md5("secret" + "show me the grade")
    tag = "9f4bb32ac843d6db979ababa2949cb52"
    return B(tag, params)

# this returns true because Alice is able to compute the correct tag given these params
print(A("show me the grade"))
# this returns true because Alice is able to compute the correct tag given these params
print(A("show me the grade and change it to 100"))

# this returns true because Mallory knows the correct tag given these params
print(M("show me the grade"))
# this returns false because Mallory does not know the correct tag given these params
print(M("show me the grade and change it to 100"))
# and your job is to make it otherwise without modfying A or B but M only