/* compile instructions:
$ gcc victim2.c -o victim2 -fno-stack-protector -m32 -z execstack
*/

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define BUFFER_SIZE 10
#define on_error(...) { fprintf(stderr, __VA_ARGS__); fflush(stderr); exit(1); }

void backdoor(){
	printf("Welcome to the backdoor!\n");
    system("/bin/bash");
}

void echo(char *name){
    char input[BUFFER_SIZE];
    strcpy(input, name);
    printf("argv[1]: %s\n", input);
}

int main(int argc, char **argv){
    if (argc < 2) on_error("Usage: %s [command]\n", argv[0]);
    echo(argv[1]);
    return 0;
}