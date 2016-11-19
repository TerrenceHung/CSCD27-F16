#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define BUFFER_SIZE 20
#define on_error(...) { fprintf(stderr, __VA_ARGS__); fflush(stderr); exit(1); }

void backdoor(){
	printf("Welcome to the backdoor!\n");
    system("/bin/bash");
}

void echo(char *arg){
    char input[BUFFER_SIZE];
    strcpy(input, arg);
    printf("Echo response: %s\n", input);
}

int main(int argc, char **argv){
    if (argc < 2) on_error("Usage: %s [argument]\n", argv[0]);
    echo(argv[1]);
    return 0;
}