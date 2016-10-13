# CSCD27 Discussion 3

## Stream Cipher

3.1 We implement a basic stream cipher that combines (xor) a plaintext message (m) with a key (k) of the same length.

- How is the message encrypted and decrypted? Write down the equations.
- Considering a known-plaintext attack (1 instance), can you recover the key? If so, write down the equations.
- Considering a ciphertext-only attack (2 instances), what can you recover? If so, write down the equations and name the attack.

3.2 We use RC4 that uses a pseudo-random number generator RNG(s), s being the seed.

- How is the message encrypted and decrypted? Write down the equations.
- Considering the same known-plaintext attack as in 3.1, can you recover the key?
- Considering the same ciphertext-only attack as in 3.1, what can you recover?

3.3 What recommendation could you give to a software engineer who wants to use a stream cipher?

## Block Cipher

3.4 We use AES 128 bits to encode a 128 bits message.

- Considering the same known-plaintext attack as in 3.1, can you recover the key?
- Considering the same ciphertext-only attack as in 3.1, what can you recover?

## Block Cipher Modes

We use AES 128 bits to encrypt the following message (32 characters):

```
On Thursday, we attack Mallory!
```

Let's consider a chosen-plaintext attack where the attacker (Mallory) has chosen by luck the following message (16 characters):

```
 attack Mallory!
```

3.5 Considering that we use AES in ECB mode (Electronic Code Book), can the attacker ...

- recover the key?
- recover the first half of the message?
- recover the second half of the message?
- modify the message in an intelligible way using another chosen-plaintext?

3.6 Same questions but considering the use of the CBC mode (Cipher Block Chaining)

## Stream cipher vs Block Cipher

3.7 What are the pros and cons of using Block cipher vs Stream cipher?

## Public Key Cryptography

3.8 Alice wishes to send a signed and confidential message to Bob using public-key cryptography, such as a GPG implementation. Which of the following is correct: (choose 1)

- Alice signs with Bob's public key, and encrypts with her private key.
- Alice signs with her private key and encrypts with Bob's public key.
- Alice signs with her private key and encrypts with Bob's private key.
- Alice signs with Bob's private key and encrypts with Bob's public key.
- Alice signs with her private key and encrypts with her private key.
