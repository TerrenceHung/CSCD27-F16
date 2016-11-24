# CSCD27 Assignment 3

So, You Want to be a Hacker? This is your chance. In this assignment you will have the chance to write your own exploits, penetrate a server and hack a web application:

- Part 1. Vulnerability exploitation (Lab 9)
- Part 2. Penetration Testing (Lab 6 & 10)
- Part 3. Web Security (Lab 11)

Like assignment 1 and 2, assignment 3 is worth 100 points however there are up to 300 points to grab here! This assignment has been designed to offer 100 points by applying course materials. However, getting extra points will require you to go beyond that.

Therefore, I recommend to attempt the bonus questions once you believe you have secured a good grade.

Good Luck!

## Instructions

There are two kinds of challenges in this assignment:

- Regular challenges (#1, #2, #3, #4, #12, #13, #14 and #15) are worth 100 points and are due Friday December 2nd 11:59pm (last day of class)
- Bonus challenges (#5, #6, #7, #8, #9, #10, #11, #16, #17, #18) are worth 200 points and are due Friday 9th 11:59 pm

### Submission

To submit the regular challenges:

```shell
submit -c cscd27f16 -a a3 attack1.py attack2.py attack3.py attack4.py attack12.txt attack13.txt attack14.txt attack15.txt
```

To submit the regular challenges:
```shell
submit -c cscd27f16 -a bonus attack5.py attack6.py attack7.py attack8.py attack9.nmap attack10.pdf attack11.txt attack16.txt attack17.txt attack18.txt
```

### Academic Integrity

Most of the exercises proposed here are about understanding a vulnerability and writing an exploit.

- you are **allowed** to discuss the vulnerability with someone else in details
- you are **not allowed** to discuss how to write the exploit
- you are **not allowed** to share your exploit

___

## Part 1. Vulnerability exploitation

These challenges should be compiled within the following vagrant VM:
```shell
cd ~/cscd27f16_space/CSCD27-F16/assignments/03/code/part1
$ vagrant up
$ vagrant ssh
ubuntu-trusty64$ cd /vagrant
```
### Challenge 1 [10 points]: Overwriting a return-address with a buffer-overflow

Challenge #1 reads an input from the command line and prints a message. Your attack will provide an input value that causes the program to execute a backdoor that is already in the program.

- Compile: `gcc challenge1.c -o challenge1 -fno-stack-protector -m32`
- Attack: `./challenge1 $(python attack1.py)`
- Reading: [Lab 09: Attack 1](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/09)

### Challenge 2 [10 points]: Routing control to shellcode

Challenge #2 reads from stdin and prints a message. Your attack will provide an input value that causes the program to execute a backdoor that is **not** already in the program.

- Compile: `gcc challenge2.c -o challenge2 -fno-stack-protector -m32 -z execstack`
- Attack: `./challenge2 $(python attack2.py)`
- Reading: [Lab 09: Attack 2](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/09)

### Challenge 3 [15 points]: Indirect control-transfer to shellcode

This challenge code uses "safe" string-copy function strncpy(), so you won't be able to use the same approach as for challenge #1 and #2. Instead, you'll have to find a more devious way to get the shellcode to execute. As with challenge #2, your goal is to obtain a root shell, using the provided shellcode.

- Compile: `gcc challenge3.c -o challenge3 -fno-stack-protector -m32 -z execstack`
- Attack: `./challenge3 $(python attack3.py)`
- Reading: [Adjacent Memory Overflows](https://www.exploit-db.com/papers/13148/)

### Challenge 4 [15 points]: File-based shellcode

The command-line argument to challenge #4 names a file to be read. The file contains a 32-bit unsigned integer value N, followed by N 32-bit integer values. Your goal is to create a data file in this format that leads to a root shell, using the provided shellcode.

- Compile: `gcc challenge4.c -o challenge4 -fno-stack-protector -m32 -z execstack`
- Attack: `./challenge4 <(python attack4.py)`

### Challenge 5 [20 bonus points]: Shellcode in a no-execute stack environment

An important defense against buffer overflows is use of a hardware/OS feature that flags the stack address space as non-executable. The processor will not execute any instructions that are stored on the stack. You can still use buffer-overflow tactics, such as overflowing variable storage space and modifying a return address, but you'll have to find a new mechanism for obtaining a root shell.

- Compile: `gcc challenge5.c -o challenge5 -m32`
- Attack: `./challenge3 $(python attack5.py)`
- Reading: [Stack Smashing On A Modern Linux System](https://www.exploit-db.com/papers/24085/)

### Challenge 6 [20 bonus points]: Shellcode in randomized-addressing stack environment

In all the previous challenges, stack addresses were consistent across executions, so that every time a vulnerable function was called the stack layout would be the same. In real systems, this is usually not the case, due to the address-space-layout randomization defense, which changes the layout of program address-space, including the stack, on every execution. Challenge #6 is similar to earlier challenge #2, except that the stack position is randomly shifted by 0-255 bytes for each execution. Your challenge is to construct an string that challenge #6 will read from the command line,	which obtains a root shell in spite of ASLR.

- Enable ASRL: `sudo bash -c `echo 2 | sudo tee /proc/sys/kernel/randomize_va_space`
- Compile: `gcc challenge6.c -o challenge6 -m32`
- Attack: `./challenge3 $(python attack5.py)`
- Reading: [Stack Smashing On A Modern Linux System](https://www.exploit-db.com/papers/24085/)

### Challenge 7 [30 bonus points]: Bypassing authentication

Challenge #7 reads an input from the command line and asks the user for a password. If the password is correct, the program will execute the command given at the command line. Rather than trying to crack the password (it is a strong password), use your hacking skills to bypass the authentication and execute any arbitrary command.

- Compile: `gcc challenge7.c -o challenge7 -m32 -fno-stack-protector -z execstack -lcrypt`
- Attack: `python attack7.py | ./challenge7 bash`

### Challenge 8 [30 bonus points]: Remote code execution via a reverse shell

Challenge #8 is a network service that reads messages from a socket and sends a message back. Assuming that you do not have access to the machine where this programs run, use your hacking skills to install a backdoor (on port 55555) on that remote server.

- Compile: `gcc challenge8.c -o challenge8 -m32 -fno-stack-protector -z execstack`
- Run: `./challenge8 11111`
- Attack: `python attack7.py`

___

## Part 2. Penetration Testing

These challenges requires a vulnerable vagrant box:
```shell
cd ~/cscd27f16_space/CSCD27-F16/assignments/03/code/part2
$ vagrant up
```

You should **not** ssh into the vagrant.

### Challenge 9 [10 bonus points]:

### Challenge 10 [20 bonus points]:

### Challenge 11 [20 bonus points]:

___

## Part 3. Web Security

These challenges requires a web application hosted on a vagrant box:
```shell
cd ~/cscd27f16_space/CSCD27-F16/assignments/03/code/part3
$ vagrant up
```

You should **not** ssh into the vagrant. Instead, all interactions can be done through the web browser by visiting [here](http://localhost:8080/).

While using and attacking this web application, you may want to reset it. No need to reset the vagrant, you can just reset the web application by visiting [the reset page](http://localhost:8080/reset.php).

### Challenge 12 [10 points]: Incomplete mediation

The application was built in such a way that only authenticated users can delete their own messages. From the frontend, it seems correctly implemented as authenticated users can click on a delete button for their own messages only. However, it might not be correctly implemented in the backend. As Mallory, find an easy way to delete Alice's message that says "Mallory should not be trusted!".

### Challenge 13 [10 points]: Content spoofing with CSRF attack

The application seems to  be vulnerable to a cross-site request forgery attack. As Mallory, find and exploit this vulnerability to make Alice post a message that says "Mallory is a trustworthy person!".

### Challenge 14 [15 points]: Stealing authentication token with XSS attack

The application seems to be vulnerable to a cross-site scripting attack. As Mallory, find and exploit this vulnerability to steal Alice's authentication token and send it to the Mallory's website at `http://mathlab.com/?id=__alice_id__&utorid=__your_utorid__` (replace `__alice_id_` with alice's authentication token and `__your_utorid__` with your utorid).

### Challenge 15 [15 points]: Bypassing authentication with SQLi attack

The application seems to be vulnerable to an SQL injection attack. As Mallory, find and exploit this vulnerability to login as Alice and anything with her account.

### Challenge 16 [15 bonus points]: Stealing login/password with XSS attack

By exploiting the same cross-site scripting attack as in challenge #14, find a way to steal Alice's login and password instead of the authentication token.

### Challenge 17 [15 bonus points]: Remote Code Execution with file inclusion Attack

The application seems to be vulnerable to a file inclusion attack. As Mallory, find and exploit this vulnerability to install a reverse shell on the server.

### Challenge 18 [20 bonus points]: Remote Code Execution with SQLi attack

By exploiting the same SQL injection attack as in challenge #13, find a way to install a reverse shell on the server.


