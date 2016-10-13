#!/usr/local/bin/python3
import binascii
import wave

#########################
####### RC4 #############
#########################

def ksa(key_b):
    ''' KSA - Key-scheduling algorithm (KSA)
    '''

def prga(s):
    ''' PRGA - Pseudo-random generation algorithm
    '''


def rc4(key_b,plaintext_b):
    ''' returns the RC4 ciphertext corresponding to the keys and plaintext given as bytes
    (bytes, bytes) -> bytes
    >>> rc4(b'Key',b'Plaintext')
    b'\xbb\xf3\x16\xe8\xd9@\xaf\n\xd3'
    '''


#########################
####### utils ###########
#########################


def utf82bytes(s):
    ''' returns the bytes encoding of utf-8 string s given as argument
    (string) -> bytes
    >>> utf82ba('Key')
    b'Key'
    '''


def bytes2utf8(b):
    ''' returns the utf-8 string of the bytes ba given as parameter
    (bytes) -> string
    >>> ba2utf8(b'Key')
    'Key'
    '''


def armor2bytes(a):
    ''' returns the bytes of the ASCII armor string a given as parameter
    (string)-> bytes
    >>> armor2ba('S2V5')
    b'Key'
    '''


def bytes2armor(b):
    ''' returns the ASCII armor string of the bytes ba given as parameter
    (bytes)-> string
     >>> ba2armor(b'Key')
    'S2V5'
    '''

#########################
### textfile support ####
#########################

def rc4_textfile_encrypt(key, input_filename, output_filename):
    ''' encrypts the input plaintext file into the ASCI-armored output file using the key
    (string, string, string) -> None
    '''


def rc4_textfile_decrypt(key, input_filename, output_filename):
    ''' decrypts the ASCII-armored input file to the plaintext output file using the key
    (string, string, string) -> None
    '''

#########################
### binary support ######
#########################

def rc4_binary(key, input_filename, output_filename):
    ''' encrypts/decrypts the binary input file to the binary output file file using the key
    (string, string, string) -> None
    '''

#########################
### wave support ########
#########################

def rc4_wave(key, input_filename, output_filename):
    ''' encrypts/decrypts the wave input file to the wave output file file using the key
    (string, string, string) -> None
    '''

#########################
### tests  ##############
#########################

if __name__ == '__main__':
    ''' Tests
    '''
    # Works with Python 3
    # Declare a value of type Bytes
    plaintext_b = b'Plaintext'
    # iterate throught a bytes value
    for byte in plaintext_b:
        print(byte)
    # modify a byte does not work because Bytes are immutable
    # the following line raises an exception
    # plaintext_b[0],plaintext_b[-1] = plaintext_b[-1],plaintext_b[0]
    # so we need to convert it into a mutable bytearray
    plaintext_ba = bytearray(plaintext_b)
    plaintext_ba[0],plaintext_ba[-1] = plaintext_ba[-1],plaintext_ba[0]
    # and convert it back to byte
    plaintext_b = bytes(plaintext_ba)
    print(plaintext_b)
    # making a xor byte per byte
    key_b = b'Secretext'
    cipher_b = bytearray(b'')
    for i in range(len(plaintext_b)):
        print(i)
        cipher_b.append(plaintext_b[i] ^ key_b[i])
    print(bytes(cipher_b))





