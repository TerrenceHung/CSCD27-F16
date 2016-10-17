# CSCD27 Lab 5: SSL-Stripping

In this lab, we are going to setup a **virtual** penetration testing environment. This setup will allow us to attack and defend these virtual machines without interfering with each other (as we would if we were all tampering with a shared server). Despite being virtual, this setup is technically similar to a real one, at least for the attack and defense techniques that we are going to consider.

There are three part in this lab:

1. creating a virtual machine (VM) using vagrant,
2. creating a virtual network such that the host (the lab machine) and the VM can communicate,
3. Setting-up an SSL-Stripping proxy

## 1. Creating a virtual machine

In this part, we are going to create a virtual machine (called VM, Vagrant box or guest) that will be hosted on your lab machine computer (called host) using Vagrant. For more information on Vagrant, you can look at its [documentation](https://www.vagrantup.com/docs/getting-started/index.html).

1. Create a virtual machine (VM)

```shell
$ mkdir ubuntu
$ cd ubuntu
$ vagrant init ubuntu/xenial64
```

You should now have a file called `Vagrantfile` in the `ubuntu` directory

2. Turning the VM on

```shell
$ vagrant up
```

3. SSHing into the VM

```shell
$ vagrant ssh
```

4. You are now working on the VM that is different from the one in the lab. You have root access on this machine :-)

```shell
ubuntu@ubuntu-xenial:~$ lsb_release -a
No LSB modules are available.
Distributor ID:	Ubuntu
Description:	Ubuntu 16.04.1 LTS
Release:	16.04
Codename:	xenial
```

5. Closing the SSH connection (leaving the virtual machine).

```shell
ubuntu@ubuntu-xenial:~$ exit
```

6. Turning the machine off

```shell
$ vagrant halt
```

## 2. Creating a virtual network

In this part, we are going to create a virtual network such that the host (the lab machine) and the VM can communicate.

1. Edit the `Vagrantfile`, uncomment the line that starts with `config.vm.network` and modify the IP address as follows:
```
config.vm.network "private_network", ip: "10.0.1.102"
```
2. Turn the VM on

From now on, you should have two terminal windows opened: one with the host shell and one with the VM shell.

3. Get the IP addresses of both machines

```shell
$ ifconfig
```

4. Try to `ping` each other IP adresses.

Both of them should answer ping coming from the other machine.

## 3. Setting-up an SSL-Stripping proxy

The sslstrip tool is designed to intercept traffic from a target (victim) host by redirecting its traffic to the attacker's computer. However, for the assignment you're <ins>not</ins> going to attempt to reroute traffic from mathlab router. Instead, we'll set up a browser-proxy as our test vehicle, which will enable you to experience the effects of an sslstrip attack without interfering with public-system resources. A browser proxy is an agent used to process all browser requests. It is typically used to provide more efficient caching across the browsers within an organization, and to filter requests to block access to certain kinds of content.

In this part, we are going to use the VM to host the browser proxy and use the host to connect to the Web through this proxy.

1. From the VM, download and install SSLStrip:

```shell
    sudo apt-get update
    sudo apt-get install python python-twisted-web
    wget https://moxie.org/software/sslstrip/sslstrip-0.9.tar.gz
    tar xvzf sslstrip-0.9.tar.gz
    cd sslstrip-0.9
```

2.  From the VM, launch the `sslstrip` program:

```shell
python sslstrip.py -a -w log.txt -l 8080 -f
```

3. From the host, test it with both HTTP and HTTPS:

```shell
curl --proxy 10.0.1.102:8080 http://mathlab.utsc.utoronto.ca
curl --proxy 10.0.1.102:8080 https://mathlab.utsc.utoronto.ca
```

4. Configure your Chrome browser to use an HTTP Proxy by starting it from the command line as shown below:

```shell
chromium-browser --proxy-server="10.0.1.102:8080"
```

Once your proxy-setup step is completed your Chrome browser will forward all requests to the Proxy port you have designated, which corresponds to the port where the sslstrip agent is listening.

Navigate to a Web page that requires authentication such as the UTSC Intranet (type https://weblogin.utoronto.ca/index.cgi in the browser location window). Attempt to log in with bogus credentials, such as email: "superman/superwoman@gmail.com", password "supersecret".

5. Terminate your sslstrip program with cntl-C.

6. View the contents of your sslstrip log.txt file, and you should be able to find "superman@gmail.com" and "supersecret" in the file.