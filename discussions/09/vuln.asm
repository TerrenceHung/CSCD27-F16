
vuln:     file format elf32-i386

0804844d <func>:
 804844d:	55                   	push   ebp
 804844e:	89 e5                	mov    ebp,esp
 8048450:	81 ec 88 00 00 00    	sub    esp,0x88
 8048456:	8b 45 08             	mov    eax,DWORD PTR [ebp+0x8]
 8048459:	89 44 24 04          	mov    DWORD PTR [esp+0x4],eax
 804845d:	8d 45 94             	lea    eax,[ebp-0x6c]
 8048460:	89 04 24             	mov    DWORD PTR [esp],eax
 8048463:	e8 b8 fe ff ff       	call   8048320 <strcpy@plt>
 8048468:	8d 45 94             	lea    eax,[ebp-0x6c]
 804846b:	89 44 24 04          	mov    DWORD PTR [esp+0x4],eax
 804846f:	c7 04 24 30 85 04 08 	mov    DWORD PTR [esp],0x8048530
 8048476:	e8 95 fe ff ff       	call   8048310 <printf@plt>
 804847b:	c9                   	leave
 804847c:	c3                   	ret

0804847d <main>:
 804847d:	55                   	push   ebp
 804847e:	89 e5                	mov    ebp,esp
 8048480:	83 e4 f0             	and    esp,0xfffffff0
 8048483:	83 ec 10             	sub    esp,0x10
 8048486:	8b 45 0c             	mov    eax,DWORD PTR [ebp+0xc]
 8048489:	83 c0 04             	add    eax,0x4
 804848c:	8b 00                	mov    eax,DWORD PTR [eax]
 804848e:	89 04 24             	mov    DWORD PTR [esp],eax
 8048491:	e8 b7 ff ff ff       	call   804844d <func>
 8048496:	b8 00 00 00 00       	mov    eax,0x0
 804849b:	c9                   	leave
 804849c:	c3                   	ret
 804849d:	66 90                	xchg   ax,ax
 804849f:	90                   	nop