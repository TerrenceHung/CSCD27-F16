# CSCD27 Lab 2 : PGP/GPG Secure Email

Ordinary email is totally insecure:
it is trivial to send forged email with a spoofed
`From:` address, and in some environments,
it is easy to intercept (eavesdrop) and even tamper with
email contents during transmission from sender to receiver.

PGP (Pretty Good Privacy)
was created by Phil Zimmerman as a way for activists to
communicate securely over the Internet.

![Phil Zimmerman](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/labs/02/media/phil.jpg)

Over time, it has evolved into an open standard,
called OpenPGP. Several implementations support the PGP message format:
PGP is distributed by PGP Corporation;
GPG (Gnu Privacy Guard) is an open-source Gnu implementation.
Because they are based on common underlying protocols,
all the implementations can interoperate.
The mathlab server has gpg installed.

The following instructions describe how to use GPG.
Since the steps are fairly detailed, you are encouraged
to try them out in tutorial, so that if you get stuck,
you can ask the instructor or the TA for assistance.
Note that you can view additional documentation on how to use
gpg on mathlab.utsc by typing `man gpg` at the command prompt.


## Generating a matching pair of public and private keys

Begin by generating a new key pair using command:

```shell
    $ gpg --gen-key
```

This will perform a sequence of steps (with options for you
	to choose if you don't want to use the default), resulting in
	the creation of a matching pair of public and private keys.
	Some of the dialog that the system will display are shown below:

``` shell
gpg (GnuPG) 1.4.11; Copyright (C) 2010 Free Software Foundation, Inc.
This is free software: you are free to change and redistribute it.
There is NO WARRANTY, to the extent permitted by law.

Please select what kind of key you want:
   (1) RSA and RSA (default)
   (2) DSA and Elgamal
   (3) DSA (sign only)
   (4) RSA (sign only)
Your selection?
```

You should choose the default, option (1).
Next you will see the following message asking you to specify a keysize:

```shell
RSA keys may be between 1024 and 4096 bits long.
What keysize do you want? (2048)
```

Make sure you select a keysize of at least 1024 bits.
Next the system will ask how long the key should remain valid:

```shell
Please specify how long the key should be valid.
         0 = key does not expire
         d = key expires in n days
         w = key expires in n weeks
         m = key expires in n months
         y = key expires in n years
Key is valid for? (0)
```

Make sure your key is valid at least for the duration of the term,
say 14 weeks.
The system will ask you for a user ID to identify your key;
note that the data shown in the sample:

```shell
You need a user ID to identify your key; the software constructs the user ID
from the Real Name, Comment and Email Address in this form:
"Heinrich Heine (Der Dichter) <heinrichh@duesseldorf.de>"
```

Your response is entered in response to 3 separate prompts,
as shown below:

```shell
Real name: Thierry Sans
Email address:
Comment: UofT
You selected this USER-ID:
    "Thierry Sans (UofT) <thierry.sans@utoronto.ca>"

Change (N)ame, (C)omment, (E)mail or (O)kay/(Q)uit?
```

Next you will be prompted for a passphrase to protect your secret key:

```shell
You need a Passphrase to protect your secret key.
Enter passphrase:
```

After you enter your passphrase,
which is used to protect your secret key,
you may see the following message displayed:

```shell
gpg: gpg-agent is not available in this session
```
You may safely ignore this.

Next, you should see the following message:

```shell
We need to generate a lot of random bytes. It is a good idea to perform
some other action (type on the keyboard, move the mouse, utilize the
disks) during the prime generation; this gives the random number
generator a better chance to gain enough entropy.

Not enough random bytes available.  Please do some other work to give
the OS a chance to collect more entropy! (Need 284 more bytes)
```

This task monitors /dev/random, which generates random bytes at a slow rate
(don't bother typing on a remote session keyboard, that has no effect since
you aren't on the system console).
The upshot is that this step may take a long time, depending on what time
of day you run it and whether anyone else is doing anything on the system.
It took about 5 minutes when I ran it.  Eventually, you should get some
additional output similar to the following:

```shell
+++++
....+++++
We need to generate a lot of random bytes. It is a good idea to perform
some other action (type on the keyboard, move the mouse, utilize the
disks) during the prime generation; this gives the random number
generator a better chance to gain enough entropy.
...................+++++
...+++++
gpg: /cmsfaculty/sansthie/.gnupg/trustdb.gpg: trustdb created
gpg: key 331D549F marked as ultimately trusted
public and secret key created and signed.

gpg: checking the trustdb
gpg: 3 marginal(s) needed, 1 complete(s) needed, PGP trust model
gpg: depth: 0  valid:   1  signed:   0  trust: 0-, 0q, 0n, 0m, 0f, 1u
pub   2048R/331D549F 2016-09-16
      Key fingerprint = E5EA 739C F3EF 6CA5 0DA3  A682 E9A2 04A8 331D 549F
uid                  Thierry Sans (UofT)
sub   2048R/5CBCBFA6 2016-09-16
```

Your matching pair of public and private keys is now ready and store into your keyring on the mathlab server.

You can list the public keys stored in your keyring as follows:

```shell
$ gpg --list-keys
/cmsfaculty/sansthie/.gnupg/pubring.gpg
---------------------------------------
pub   2048R/331D549F 2016-09-16
uid                  Thierry Sans (UofT)
sub   2048R/5CBCBFA6 2016-09-16
```

This pair has an id that you will need for the rest of this tutorial. The `__key_id__` is `331D549F` in my case.

You can also list the secret keys stored in your keyring:

```shell
$ gpg --list-secret-keys
```

You can export the keys previously generated as follows::

```shell
gpg --export --armor __key_id__
```

```shell
gpg --export-secret-keys --armor __key_id__
```


**Never ever store, transmit or reveal your secret key to anyone.** Contrarily, you can do whatever you want with your public key. However, you might need to export the private key in case you want to use the same GPG on another machine.


Now extract the fingerprint of your public key.
With gpg, the fingerprint is printed out when you
generate the key, or you can use:

```shell
gpg --fingerprint __key_id__
```

The fingerprint is 40-digit hex string (160b)
that can be used to uniquely identify your public key.
It is generated by applying a collision-resistant hash
function to your public key, so no two public keys will have
the same fingerprint.


This is very useful; if I want to send you my public key, I can email you my
public key (or send it to you over any insecure channel),
and then we can compare fingerprints over a secure channel.
For instance, I might print my fingerprint on my business card,
or you can telephone me and I can read off my fingerprint out loud.
Write down your fingerprint as the answer to this question.

## Publishing your public key to a key server

When two persons want to communicate securely with PGP, they will need to exchange their public keys. They could do so by any mean: publish them on their personal website, exchange files ect ...

One convenient way to make your public key available to anyone is to upload it on one of the available gpg keyserver. Here, we are going to use the [MIT PGP key server](http://pgp.mit.edu/). You can either upload the public through the web interface or use the command line:

```shell
$ gpg --keyserver pgp.mit.edu --send-keys __key_id__
```

## Importing someone's public key

Once someone has uploaded his or her key on the keyserver, you can import it. Next, search for Thierry Sans's public key on the MIT server and import it into your keyring.

```shell
$ gpg --keyserver pgp.mit.edu --search-keys thierry.sans@utoronto.ca
gpg: searching for "thierry.sans@utoronto.ca" from hkp server pgp.mit.edu
(1)	Thierry Sans (UofT)
	  2048 bit RSA key E5EA739CF3EF6CA50DA3A682E9A204A8331D549F, created: 2016-09-16
Keys 1-1 of 1 for "thierry.sans@utoronto.ca".  Enter number(s), N)ext, or Q)uit > 1
```

Select `1` to import the key.

```shell
gpg: requesting key 331D549F from hkp server pgp.mit.edu
gpg: key 331D549F: "Thierry Sans (UofT) " not changed
gpg: Total number processed: 1
gpg:               imported: 1  (RSA: 1)
```

## Importing and signing someone's public key

It is important to check the fingerprint of the key you just imported. You can view the fingerprint of the key you just imported using:

```shell
$ gpg --fingerprint name@email.com
```

For instance, here is Thierry's correct public-key fingerprint:

```shell
E5EA 739C F3EF 6CA5 0DA3  A682 E9A2 04A8 331D 549F
```

Verifying fingerprints is important; otherwise, Oscar (a malicious adversary) could generate a public-key
and potentially trick you into accepting it as your instructor's key,
enabling Oscar to read all the encrypted mail you send to your instructor.

Once you have verified someone's public key, you should sign it. It will prevent Oscar to modify this key once stored in your keyring. With gpg, you can use

```shell
$ gpg --sign-key name@email.com
```

## Encrypting and signing messages

Now practice signing and encrypting messages. First, create a text file `msg.txt` containing your sample message to be
signed and encrypted. This is your plaintext. Now sign it with your private key, encrypt it with your public key, and save it in "ASCII-armored" formatted file `msg.asc`.

With gpg, you can use:

```shell
gpg --encrypt --sign --armor --recipient name@email.com &lt; msg.txt > msg.asc
```

You can decrypt the contents of `msg.asc` by typing:

```shell
gpg < msg.asc
```

As a final step, you can email the file `msg.asc` to yourself,
and try decrypting the content of the email once received (as shown above).
To better approximate the assignment's secure-email question,
pair up with another student, exchange public keys with them,
and then send each other signed, encrypted messages.  You should each be
able to read the received messages and to verify the signatures on them
(just as the TA will do with the message you send him).

## Revoking a GPG key

There are several reasons why you might want or need to revoke an
existing GPG key, for example:

- your private key is stolen or compromised,
- this key is no longer in use,
- you've replaced this with a newer key,
- your key is not large enough to be secure,
- you forget the key's passphrase (it happens, surprisingly often ;-).

To access your secret key, you need to know your passphrase.
As mentioned above, if you forget the passphrase for a key,
you would like to revoke that key, but you can't generate
a revocation certificate without the passphrase ("catch 22").
To avoid finding yourself in this unfortunate position,
it is wise to create a revocation certificate at the same
time or soon after you create your GPG keys,
while the passphrase is still fresh in your mind.

The GPG command to create a key-revocation certificate is:

```shell
gpg --gen-revoke name@email.com
```

The gen-revoke command will work only if you possess the secret key
for user-id, which ensures that only you can revoke your own keys
(why is this important?).

The command will ask you a couple questions before producing
an ASCII-armored revocation certificate,
as shown at the end of the following dialog:

```shell
Create a revocation certificate for this key? (y/N) y
Please select the reason for the revocation:
  0 = No reason specified
  1 = Key has been compromised
  2 = Key is superseded
  3 = Key is no longer used
  Q = Cancel
(Probably you want to select 1 here)
Your decision? 0
Enter an optional description; end it with an empty line:
> Just in case the passphrase is lost
>
Reason for revocation: No reason specified
Just in case the passphrase is lost
Is this okay? (y/N) y

You need a passphrase to unlock the secret key for
user: "Thierry Sans (UofT) "
2048-bit RSA key, ID 331D549F, created 2016-09-16

gpg: gpg-agent is not available in this session
gpg: Invalid passphrase; please try again ...

You need a passphrase to unlock the secret key for
user: "Thierry Sans (UofT)"
2048-bit RSA key, ID 331D549F, created 2016-09-16

ASCII armored output forced.
Revocation certificate created.

Please move it to a medium which you can hide away; if Mallory gets
access to this certificate he can use it to make your key unusable.
It is smart to print this certificate and store it away, just in case
your media become unreadable.  But have some caution:  The print system of
your machine might store the data and make it available to others!
-----BEGIN PGP PUBLIC KEY BLOCK-----
Version: GnuPG v1.4.11 (GNU/Linux)
Comment: A revocation certificate should follow

I have remove this key on purpose.
I do not want you to revoke  my certificate :)

-----END PGP PUBLIC KEY BLOCK-----
```

Once generated, **do not import this revocation certificate to your keyring or to the keyserver**,
since if you do, your public-private key will
become unusable, and you'll have to go back and generate a new one.

## [optional] Configuring your email client to work with PGP

It is cumbersome to use the command line to sign and/or encrypt every email that we send daily. Most of email client's have a way to integrate GPG.

- [GPG Tools](https://gpgtools.org/) for Apple Mail
- [Enigmail](https://addons.mozilla.org/en-US/thunderbird/addon/enigmail/) for Mozilla Thunderbird
- [Outlook Privacy Plugin](http://dejavusecurity.github.io/OutlookPrivacyPlugin/) for Microsoft Outlook

If you are using a webmail interface through your browser like Gmail, there is no official support yet. However, there are extensions such as [Mailvelope](http://www.mailvelope.com/) that can be useful.
