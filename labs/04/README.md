# CSCD27 Lab 4: Hash-length Extension

The use of secure hash functions such as MD5 or SHA to protect the integrity of messages and documents is widespread; however, in many situations, these hash functions fail to provide adequate security protection. Intuitively, we want a construct that behaves like a pseudo-random function, and unfortunately, secure hash functions do not behave that way.

A crucial weakness of collision-resistant hash functions based on the Merkle-Damgard block-compression model is that, unlike pseudo-random functions, they are subject to length-extension attacks. That is, an attacker who knows the hash of an n-block message can efficiently compute the hash of an n+k block message, for any k, even when the attacker knows only the original message-length n, but not the content of that message.

## Example of a hash-length extension

Before attempting to construct a length-extension attack, you should work through this simple example of the process, using a Python implementation of the MD5 hash algorithm, [md5p.py](https://raw.githubusercontent.com/ThierrySans/CSCD27-F16/master/assignments/01/code/md5/md5p.py), linked to the assignments Web page.

Suppose you want to protect the following message against tampering, by computing its MD5 hash value:  "This is the end of the message."

```python
from md5p import md5, padding
m = "This is the end of the message."
print md5(m).hexdigest()
# or by creating an md5 object with state ...
h = md5()
h.update(m)
print h.hexdigest()
```

The output should be `536eece26ee4f95ea73e5d39b7963537`.

MD5 is based on a block-compression algorithm, with 64-byte (512-bit) blocks.
MD5 pads the input message so that it is an integral multiple of the blocksize,
using a pad value consisting of a leading 1-bit,
a sequence of 0-bits (padding),
and a 64-bit length value indicating the number of bits in the original
(unpadded) message.  If the padding data overflows the blocksize (e.g. the
original data was 480-bits long), another block is added.

md5p function `padding(n)` will return the padding that will
be added for an n-bit message.

The interesting (scary) thing about length-extension is that
an adversary doesn't have to know the value of message "m"
in order to create a valid hash of "m+x" for some message extension x.
By setting the internal state of MD5 to the hash of the original message "m"
(which is commonly a public value),
the attacker can iteratively append additional blocks while preserving
the validity of the hash.

In general, the adversary will compute the hash of:
`m + padding(len(m)*8) + x`.  Let's try this out with
the above example:

```python
h = md5(state="536eece26ee4f95ea73e5d39b7963537".decode("hex"),count=512)
x = "Or maybe not!"
h.update(x)
print h.hexdigest()
```

Which should result in this hash value: `0bbad48fbf13bed07a4c22807c811945`
To confirm that we have successfully extended the message
we need to compute the hash of the original message plus padding plus
the extension:

```python
print md5(m + padding(len(m)*8) + x).hexdigest()
```

Although the attacker doesn't have to know the <em>value</em>
of "m" to perform an extension, they do have to know the length of "m",
and the value of hash(m).
<p>
In practice the length-extension attack is highly effective against
improperly constructed MACs such as <code>hash(secret || message)</code>.
In this situation, the secret is intended to provide HMAC
authentication plus integrity protection;
however, as we saw above,
an attacker who can guess the length of secret
will be able to extend the message value.
</p></ol></body></html>

## Hash-length extension attack setup

<!-- We're going to start by working through the examples on this
<a href="../../handout/hash-extension.html">hash-extension</a> handout.
</p>
<p>
For Assignment 1 - Part 3.1, the target system's API uses standard
Web "URL encoding" to pass parameters to a grade-management program.
Notice that the parameters begin after the "?" character,
are separated by "&amp;" characters, and that each parameter
is expressed as a "name=value" pair.
</p><p>
A marker can query the target-system API to retrieve a
student mark for a particular assignment,
and can set assignment marks for a particular student number and assignment.
</p><p>
In both cases, the target system attempts to ensure that requests
are not tampered (integrity protection) and that they originate from a
trusted party (authentication), by attaching a message-authentication code
(MAC) to the request as a "tag" parameter.
</p>
Your program will implement a hash-extension
to extend the URL-query parameter into a mark-update-URL.
It will then send that mark-update-URL to the marking server,
and print the server's response.
<p>
The marking-server API supports 2 requests:
</p><pre>URL?tag=md5_hash&amp;utorid=student_id
</pre>
&nbsp;&nbsp;&nbsp;&nbsp;(retrieve mark for student_number)
<pre>URL?tag=md5_hash&amp;utorid=student_id&amp;mark=&lt;0-100&gt;
</pre>
&nbsp;&nbsp;&nbsp;&nbsp;(set student_number mark (integer value in range 0 to 100))
<p>
Your script's job is to take a valid URL of the first form,
and produce a valid URL of the 2nd form.
</p><p>
The 1st part of your code will obtain its argument values
(URL and mark) and perform routine parsing to
extract the various URL parts (e.g. with <code>split()</code>.
You'll want to pick off:
</p><ul>
<li>the marking server URL (shown as URL above)
for use in constructing your attack URL,
</li><li>the input tag value,
</li><li>the parameters other than the tag value (to be extended)
</li></ul>
<p>
The core of your attack code will compute a new tag value
representing a valid MAC of the secret key together with the
URL parameters (other than the tag) with the mark parameter appended.
To do this, you'll implement a hash extension attack to extend
the URL with the mark value,
generating a valid tag so that the receiving system will
interpret this as a legitimate mark-update request.
</p><p>
You need to know the length of the secret key in order
to calculate how much padding to insert to fill exactly 512 bits.
However, you only know that they key-length is in the range 8-16 bytes,
inclusive.
Your code will thus have to guess the key-length,
send the resulting URL to the server, and check
the response to see if the URL was accepted.
</p><p>
If the response status returned by <code>conn.getresponse()</code>
is the value 200, then you've got a valid tag.
</p><p>
As a final step, print the response value associated with this
status-200 response. -->