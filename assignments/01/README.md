# CSCD27 Assignment 1

The primary goals of this assignment are to improve your understanding of

- Part 1. PGP/GPG Secure Email (seen in lab 2)
- Part 2. RC4 encryption algorithm (seen in lab 3)
- Part 3. Secure-hash exploits (seen in lab 4)

Good Luck!

## Instructions

### Submission

Make sure to send your course feedback for part 1 as a secure email message to the TA.

Submit on the `mathlab.utsc.utoronto.ca` system your solutions:

- for part 1: `public.cert` and `revoke.cert`
- for part 2: `rc4.py`
- for part 4: `extension.py`, `md5_collisions.txt`, `nice.py`, and `nasty.py`

```shell
submit -c cscd27f16 -a a1 public.cert revoke.cert rc4.py extension.py md5_collisions.txt nice.py nasty.py
```

### Academic Integrity

___

## Part 1. PGP/GPG Secure Email

In this problem, you will gain experience with PGP, a popular format for email encryption. Ordinary email is completely insecure: it is very easy to send forged email with a spoofed `From:` address, and furthermore, in some environments it is easy to eavesdrop or even modify email during transmission.

Pretty Good Privacy (PGP) was created by Phil Zimmerman as a way for activists to communicate securely over the Internet.

![Phil Zimmerman](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/media/phil.jpg)

Over time, it has evolved into an open standard, called OpenPGP. Several implementations support the PGP message format: PGP is distributed by PGP Corporation; GPG (Gnu Privacy Guard) is an open-source Gnu implementation. Because PGP and GPG are based on common underlying protocols, all the implementations can interoperate.

### 1.1 PGP/GPG in practice [5 marks]

**Task:** If you have not done so yet in [lab 02](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/02), create a public-private key pair and publish is on the MIT keyserver and export your public key as an ASCII-armored certificate.

### 1.2 Course Feedback [10 marks]

What topic would you most like to see explained in more depth in lecture or discussed in tutorials? You may answer with as little as a single sentence or as much as a single paragraph.

**Task:** Send this message to as a signed and encrypted attachment to an email message to the TA (williamwei.feng@mail.utoronto.ca). The email subject must be:

```
[CSCD27] A1 1.1
```

### 1.3 GPG: Revoking a Key [5 marks]

**Task:** If you have not done so yet in [lab 02](https://github.com/ThierrySans/CSCD27-F16/tree/master/labs/02), create a revocation certificate.


___

## Part 2. RC4 Implementation

In class, we covered "stream" ciphers, which can be a better choice than block ciphers (like DES, AES) in situations where the data to be en/decrypted arrives as a stream of bytes or bits rather than whole blocks. As well, stream ciphers are often faster and simpler than block ciphers.

RC4 is a stream cipher, meaning that it processes (encrypts/decrypts) data a byte at-a-time, rather than encrypting a block at-a-time like DES and AES. RC4 works by taking a user-supplied key and generating from that an arbitrary-length pseudorandom byte-string, that is XOR'd with plaintext/ciphertext to perform encryption/decryption (in other words, it behaves like a keyed-OTP).

The algorithm, based on a 256-byte state array, operates in two stages, first initializing its key schedule (like AES's init_key_schedule) with a user-supplied key, and then generating a sequence of pseudo-random bytes to be XOR'd with plaintext to encrypt or with ciphertext to decrypt.

In the following, we ask you to complete the Python [starter code](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/code/rc4/rc4.py) (Python 3) that implements RC4 and provide various supports to encrypt and decrypt textfiles, binary files and wave files. For each function, make sure to adhere to the type signature given in the Docstring. Implement the utilities functions that will allow you to convert between UTF-8 strings, ASCII-armored strings and their binary representation (`Bytes` in Python). Finally, implement a set of tests to convince yourself that your functions behave as expected. The marker(s) will supply their own tests for your code. Your implementation will be marked based on correctness, adequacy of the tests, and adherence to good coding practices such as modularity, clear design, appropriate use of comments, descriptive variable names, etc.

### 2.1 RC4 encryption and decryption [20 marks]

**Task:** Complete the basic RC4 encryption/decryption function called `rc4`. This function relies on two sub-functions called `ksa` and `prga` for which the specification and pseudo-code can be found in [Wikipedia](https://en.wikipedia.org/wiki/RC4).

### 2.2 Textfile support [10 marks]

**Task:** Complete the RC4 textfile file support functions called `rc4_textfile_encrypt` and `rc4_textfile_decrypt` that respectively encrypt and decrypt a textfile into its ASCII-armored cipher (Base64 encoding) and vice versa.

### 2.3 Binary file support [5 marks]

**Task:** Complete the RC4 binary file support function called `rc4_binary` that encrypts/decrypts a binary file.

### 2.4 Wave file support [5 marks]

An interesting application of RC4 is stream-encrypting WAV-format audio files, using the Python "wave" module. Implement the RC4 wave support function called `rc4_wave` that encrypts/decrypts a wave file that remains playable by audio players.

Here are samples below. Beware, this encrypted file may play at loud volume using headphones connected to a BV-473 machine.

- [unencrypted WAV file](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignment/01/media/neil.wav) and it's companion
- [encrypted WAV file](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignment/01/media/neilc.wav)

You can convert audio in various formats to .wav using this [online tool](http://audio.online-convert.com/convert-to-wav).

To keep file-sizes small, we are going to use mono rather than stereo audio, and use 8-bit sampling rather than a higher sample rate. Together these 2 choices cause audio to be stored as a sequence of 1-byte samples, rather than e.g. 4-byte samples for stereo/16-bit, which is convenient for RC4-encryption/decryption since RC4 works on a byte-stream. You can choose whatever sampling rate you wish; higher sampling rate will translate to larger file sizes.

**Task:** Complete the RC4 wave file file support function called `rc4_wave` that encrypts/decrypts audio files encoded in `.wav` format.

For this tasks, you can use the Python `wave` module (see the [python documentation](https://docs.python.org/2/library/wave.html) for more details). To simplify your implementation, you need only support mono (not stereo) audio, and you can assume that each audio sample fits in a single byte. These restrictions imply that each audio sample will fit in a single byte, for ease of interoperation with RC4's byte-oriented keystream.

In order to make an encrypted `.wav` file playable, it must include proper `.wav` format header information, and this format information must not itself be encrypted, otherwise you will not be able to play the encrypted file. So, when your algorithm encrypts plaintext that is not a `.wav` file, it will completely encrypt the file, but when encrypting a `.wav` file, it will leave the `.wav` header unencrypted, and encrypt the audio sample data.

In order to support playback of encrypted audio files, leave the WAV file-header intact (unencrypted) in cipher files. The `wave` module provides methods `getparams() and setparams()` to get and set the WAV audio header.

The `wave` module provides method `getnframes()` to provide the number of frames (= bytes for our mono-1-byte-sample WAV files).

To read/write a byte from/to a WAV file, you can use `readframes(), writeframes()`.
___

## Part 3. Hash Extensions and Collisions

The use of secure hash functions such as MD5 or SHA to protect the integrity of messages and documents is widespread; however, in many situations, these hash functions fail to provide adequate security protection. Intuitively, we want a construct that behaves like a pseudo-random function, and unfortunately, secure hash functions do not behave that way.

A crucial weakness of collision-resistant hash functions based on the Merkle-Damgard block-compression model is that, unlike pseudo-random functions, they are subject to length-extension attacks. That is, an attacker who knows the hash of an n-block message can efficiently compute the hash of an n+k block message, for any k, even when the attacker knows only the original message-length n, but not the content of that message.

This problem will give you an opportunity to:

- experience use of message-integrity hashing mechanisms, such as MD5 and SHA-256
- appreciate how misuse of hashing, for example to create a MAC (an HMAC), can compromise security
- observe that a weak hashing mechanism, MD5, creates serious security vulnerabilities

Before attempting to construct a length-extension attack, you should work through the simple hash-length extension attack setup covered in tutorial 2. Although we will explore length-extension vulnerability of MD5 for this problem, the same vulnerability exists for SHA-1 and SHA-256.

### 3.1 Hash Extension Attack [15 marks]

Numerous Web-service API's, including the Flickr photo-sharing service, have been found to be vulnerable to length-extension attacks that target weak HMAC constructions of the form "hash(key || message)" (see e.g. [flickr attack](http://netifera.com/research/flickr_api_signature_forgery.pdf)).

In this problem, you will attack a new Web-app that has recently been put into service at U of T, for student's marks in a server database. The app's server implements this simple API:

- Retrieve mark for student_number

```
URL?tag=md5_hash&amp;utorid=student_id</pre>
```

- Set student_number mark (integer value in range 0 to 100)

```
URL?tag=md5_hash&utorid=student_id&mark=100;
```

Both requests are idempotent, meaning that the server-state resulting from 1 request is the same as the state resulting from N repetitions of this request, so although an adversary could re-send API-requests captured with Wireshark, doing so would have no visible effect (server state is unchanged).

The app-client and app-server share a secret key, that is used to compute the tag value as: `md5(key || URL_params)`, where `URL_params` are the name-value pairs after the first & in the URL (following the tag value). The tag serves as a message-authentication code (MAC) that protects app requests against tampering; the server rejects/ignores messages with tag values that do not match their URL_param values.

The secret key is an 8-16 character string value that is hard-coded into the app client and server software. Only TA's can access the app client, and only system administrators can access the app server.

While working on a D27 assignment using Wireshark, you stumble upon some of this marking app's curious HTTP requests, and piece together how the API functions. You are familiar with HMAC's and guess the purpose of the "tag". Having studied length-extension attacks, you are intrigued at the potential to bypass the MAC protection mechanism (for academic purposes only!).

Here is a URL that you intercept using Wireshark, which when loaded in a browser shows a mark of 0.

<!--div id="utorid_form>">
    <label for="username">The URL is student specific, please enter your UTORid:</label>
    <input id="utorid" type="text" name="utorid" required />
</div>

<script type="text/javascript">
$("#utorid").keyup(function(event){
    if(event.keyCode===13){ // enter key has code 13
        var utorid = $("#utorid").val();
        $("#utorid_form").children().hide();
        $.get("./server/tag.php?utorid=" + utorid, function(tag){
            $("#test_url").html("https://mathlab.utsc.utoronto.ca/courses/cscd27f16/assignment/01/server/?tag=" + tag + "&amp;utorid=" + utorid);
        });
    }
});
</script>

<pre id="test_url">
</pre-->

The mechanism used in your attack will be similar to the example covered in the Length-Extension Concepts section (above). For this attack, you will write Python program "`extension.py URL mark`" to:

- take a valid marking-query URL as its first argument, as shown in the above example, to query the vulnerable marking database (note your code should not depend on the server hostname or parameter values or lengths),
- take a mark value in the range 0 to 100 inclusive as its 2nd argument
- convert the URL-argument from mark-query form into marking-database update form, using the above API format to set the mark to the argument value,
- issue the modified URL to a vulnerable server and print the server's response

You can verify that your attack has worked by loading the above marks-query URL in a browser. It should display the mark you have set.

**Task:** Complete the [starter code](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/code/md5/hash_extension.py) (Python 2.7).

This starter code contains sample code that shows how to interact with a Web server.

### 3.2 MD5 Hash Collisions [15 marks]

The security of a hash function is only as good as its resistance to collisions; that is, finding two messages that hash to the same "fingerprint"-value should be computationally infeasible. It is this infeasibility that enables a hash value to serve as an assurance of data integrity: if you change the data, the hash value will change and there's no computationally-feasible way to arrange for the hash of the modified data to match the hash of the original data.

Secure hash functions have 2 collision-related properties:

- weak collision-resistance (aka 2nd-pre-image resistance)
- strong collision-resistance

The first says that given `H(x) = h` it must be computationally infeasible to find a value `y` such that `H(y) = H(x) = h`. The second says that given complete freedom in choosing `x` and `y`, nevertheless it should be computationally infeasible to find `x` and `y` such that `H(y) = H(x) = h`.

In a paper presented at the EuroCrypt 2005 conference, Xiaoyun Wang and Hongbo Yu described a [computationally-efficient algorithm](http://merlot.usc.edu/csac-f06/papers/Wang05a.pdf) for finding different byte-sequences with identical MD5 hash values. This breakthrough-result signalled that MD5 was no longer suitable as a secure guarantor of message-integrity.

Marc Stevens et al extended this result in a EuroCrypt 2007 [conference paper](http://www.win.tue.nl/hashclash/EC07v2.0.pdf) that showed how to find collisions, starting from 2 distinct files (the chosen prefixes) that are extended until a collision is found. This process required about 2<sup>50</sup> hash function calls.

This same research group also implemented much faster algorithms for finding random pairs of colliding bitstrings, that have an expected cost of just 2<sup>39</sup> hash-function calls. We will use the MD5 collision-finding tool [hashclash](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/code/md5/hashclash) (compiled for the Mathlab server from the [](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/code//md5/fastcoll_v1.0.0.5-1_source.zip)) from this group in this problem.

**Task:** This warmup exercise will give you practice working with the hashclash MD5 collision-generator.

- Use hashclash to generate a pair of files with identical MD5 hash values:

```shell
time hashclash -o f1 f2
```

- View the contents of each collision file in hex format (do **not** use `xxd f1 f2` as this will overwrite f2 with hex-format of f1):

```shell
xxd f1
xxd f2
```

Can you spot the difference(s) between f1 and f2?

- Confirm that the 2 files are actually different:

```shell
sha256sum f1 f2
```
or

```shell
cmp f1 f2
```

- Verify that f1 and f2 have the same MD5 hash value:

```shell
md5sum f1 f2
```

### 3.3 Don't be Evil [10 marks]

For this problem, you will utilize the hashclash fast-collision algorithm in concert with hash length-extension, to create 2 Python programs with different behavior but with the same MD5 hash value. The general form of this construction relies on 2 hash-colliding bitstrings, binary0 and binary1, such that:

```
hash(prefix + binary0 + suffix) == hash(prefix + binary1 + suffix)
```

As we saw earlier with the length-extension attack, if hash(m) == hash(m), then we can extend m with x and the two hash values will remain the same: hash(m+x) == hash(m+x). In this problem, we use the same prefix and suffix strings in both hashes, and hashclash provides us with two binary strings binary1 and binary2 that have the same hash value, so the above equality will hold.

We'll start by preparing Python prefix and suffix strings. File `prefix`, shown indented below, includes a triple-quote to precede a bitstring value:

```python
# -*- coding: utf-8 -*-
bits = """
```

File `suffix`, shown indented below,
includes a triple-quote to terminate a bitstring value,
and outputs the sha256 hash of its bitstring value:

```python
"""
from hashlib import sha256
print sha256(bits).hexdigest()
```

Now we're ready to use hashclash to produce 2 colliding bitstrings which appear at the end of the prefix Python code:

```shell
hashclash -p prefix -o prefix1 prefix2
```

Next, append suffix to each of the prefix files:

```shell
cat prefix1 suffix &gt; pgm1.py
cat prefix2 suffix &gt; pgm2.py
```

Next, run the 2 programs to check the sha256 values of their bitstrings. Finally, verify that `pgm1.py` and `pgm2.py` have identical MD5 hash values,

**Task:** Your challenge is to extend the above approach by writing a pair of Python programs, `nice.py` and `nasty.py`, that hash to the same MD5 value, but that exhibit visibly different, and preferably interesting and/or amusing behavior. For example, `nice.py` might print a "fortune" for the user, and `nasty.py` might pretend that it is erasing all the user's files.

___

That's all folks!

