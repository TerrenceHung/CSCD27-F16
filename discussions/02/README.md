# CSCD27 Discussion 2

## About the lecture

2.1 An English mono-alphabetic encryption key can be represented in about ______ bits.

2.2 Vigenere's cipher is vulnerable to chosen plaintext/ciphertext attacks. What is the
most efficient chosen-plaintext attack? What does the attack achieve?

<!--
<h3>Overview of Frequency Analysis</h3>
<p>
What is frequency analysis and what purpose does it serve
in cryptanalysis?
</p>
<p>
What kinds of ciphers are vulnerable (made obsolete by)
frequency analysis?
</p>
<h3>Overview of Vigenere Polyalphabetic Ciphers </h3>
<p>
What is a polyalphabetic cipher?
</p>
<p>
How do the Vigenere encryption and decryption algorithms work?
</p>
<h3>Frequency Analysis in Python</h3>
<img src="./media/original.png" style="float: right; margin: 0.5em" width="360" />
<p>
How would we construct a simple Python tool to compile a
list of character frequencies associated with an input file?
</p>
<p>
To simplify the problem, let's assume that we are dealing with only
the ASCII alphabetic characters ([a-zA-Z]),
and that we will lump together counts of lower and upper-case characters
as if they were all upper-case.
For example, the word "Alas" would result in a histogram showing
A: 0.50
L: 0.25
S: 0.25
all others: 0.00
</p>
<img src="./media/caesar.png" style="float: left; margin: 0.5em" width="360" />
<p style="clear:right">
The upper-left adjacent graph shows the letter frequencies
for an article in today's Toronto Star.
The graph was produced by generating a
frequency count of alphabetic characters using a Python program,
and then displaying that data using an MS-Excel chart.
The upper-right adjacent graph shows the letter frequencies for a
Caesar (shift) cipher encoding of that same article.
Caesar certainly simplifies the cryptanalyst's job !
</p>
<p>
Working by yourself, or with partner(s),
write up a simple frequency counter in Python.
You may want to follow the test-driven-development (TDD)
practice of beginning by preparing a test suite for your program
- in this case, some input values with known frequencies that
you can check for in the output.
</p>
<h3>Vigenere Cipher in Python</h3>
<p>
Now let's move on to the more challenging task of implementing the
Vigenere cipher.
Use the same alphabet as for the histogram task above
(the upper and lower case alphabetic letters).
The algorithm makes use of a user-supplied keyword that controls
the polyalphabetic shift applied to the plaintext/ciphertext input string.
The algorithm uses a shift-list to control the substitution of
encrypted/decrypted characters for input characters.
Implement functions
<code>encrypt()</code> and <code>decrypt()</code>, each of which
begins execution by setting up the shift-list structure (possibly
using a common helper function).
</p>
<p>
You may want to use this
<a href="vigenere-starter.txt">starter code template</a>
to begin the problem.
Feel free to request help from your TA if you need hints or advice on how
to proceed.
You may not be able to complete this problem during tutorial,
but try to get to the point where you understand the what must be
implemented, and how you would proceed to finish writing the code
on your own.
</p>

<h3>Vigenere Cipher Unit Test in Python</h3>
<p>
Some of the programming assignments in this course will ask
you to write unit tests to demonstrate the correct
behavior of your code.  We will use the Python Nose module for
unit testing.  You may want to use this
<a href="vigenere-test-starter.txt">starter code template</a>,
which provides a single Nose test for Vigenere as an example.
</p>
-->

## Frequency analysis

In this discussion, we will preview the first sophisticated approach to cryptanalysis,
described by Al-Kindi, born in Basra in what is now Iraq, in 801.

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/original.png)
![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/caesar.png)
![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/vigenere.png)

The upper left graph shows the letter frequencies
for an article that appeared in the Toronto Star.
The graph was produced by generating a
frequency count of alphabetic characters using a Python program,
and then displaying that data using an MS-Excel chart.
The upper right graph shows the letter frequencies for a
Caesar (shift) cipher encoding of that same article.
Caesar certainly simplifies the cryptanalyst's job !

In class we will see that Caesar and its more sophisticated cousin,
monoalphabetic cipher, are both vulnerable to frequency cryptanalysis.
Vigenere, a polyalphabetic cipher, should be less vulnerable to this attack.

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/vigenere.png)

The adjacent graph shows a graph of letter-frequency for a Vigenere-encoding of the same newspaper
article whose letter frequency is displayed above.

2.3 What do you notice about this graph compared to the ones above?

2.4 What role does a Vigenere password play in frequency profile of the ciphertext?

2.5 What would the ideal histogram look like, from the point of view of making cryptanalysis as difficult as possible?

## Scale of key robustness

Let's assume that we have a 64 bits machine working at 2GHz (2 x 10^9 cycles/sec). Now, let's imagine that we have a super fast encryption algorithm that can encrypt 64 bits in 1 cycle.

2.6 Based on a 64 bits message and a 64 bits key, calculate:

- How many keys per sec can we compute?
- How many keys per year can we compute?
- How long would it take to compute all keys?
- How many computers would you need to crack all keys within a day?

2.8 Same questions with:

- 128 bits message and key that requires 2 cycles
- 256 bits message and key that requires 4 cycles
- 512 bits message and key that requires 8 cycles
