# CSCD27 Discussion 2

## Cryptosystems

2.1 An English mono-alphabetic encryption key can be represented in about ______ bits.

2.2 Vigenere's cipher is vulnerable to chosen plaintext/ciphertext attacks. What is the most efficient chosen-plaintext attack? What does the attack achieve?

## Frequency analysis

In this discussion, we will preview the first sophisticated approach to cryptanalysis, described by Al-Kindi, born in Basra in what is now Iraq, in 801.

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/al-kindi.png)

The first graph below shows the letter frequencies for an article that appeared in the Toronto Star. The graph was produced by generating a frequency count of alphabetic characters using a Python program, and then displaying that data using an MS-Excel chart.

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/original.png)

The second graph below shows the letter frequencies for a Caesar (shift) cipher encoding of that same article. Caesar certainly simplifies the cryptanalyst's job!

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/caesar.png)

In class we will see that Caesar and its more sophisticated cousin, monoalphabetic cipher, are both vulnerable to frequency cryptanalysis. Vigenere, a polyalphabetic cipher, should be less vulnerable to this attack. The third graph below shows a graph of letter-frequency for a Vigenere-encoding of the same newspaper article whose letter frequency is displayed above.

![original](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/discussions/02/media/vigenere.png)

2.3 What do you notice about the third graph compared to the first two above?

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
