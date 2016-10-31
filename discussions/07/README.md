# CSCD27 Discussion 7

A website requires its users to have passwords with a length of exactly 8 characters long and made of alpha-numeric characters.

7.1 How many passwords are possible?

7.2 What is the password entropy (n-bit security)?

Now, let assume that we want to crack the password of 1000 users. We want to consider several types of attack:

- dictionary attack on lowercase words and names (~50,000 in english)
- dictionary attack with a pattern of 4 lowercase words and names (~300,000 in english) followed by a year between 1967 and 2006 (included)
- brute force attack
- rainbow table attack (when applicable)

## Cracking passwords from the login page

Assuming that we use a password cracking tool that tries different login/password using the login page. We roughly estimates that:

- the login page returns a response in 100ms
- the cracking tool can spawn 100 threads sending such requests

7.3 For all types of attack, how long would it take to:

- try one password for all users
- try all passwords for one user
- try all passwords for all users

## Cracking unsalted hash passwords

Assuming that we hack into their server and download their (lame) database of unsalted passwords. We roughly estimates that:

- computing a hash takes 10^(-9) seconds
- a table lookup takes 10^(-3) seconds

7.4 For all types of attack, how long would it take to:

- try one password for all users
- try all passwords for one user
- try all passwords for all users

## Cracking salted hash passwords

Assuming now that the passwords are salted.

7.5 For all types of attack, how long would it take to:

- try one password for all users
- try all passwords for one user
- try all passwords for all users


