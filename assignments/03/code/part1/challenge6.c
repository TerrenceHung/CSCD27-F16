#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#include <assert.h>
#include <alloca.h>

#define BUFFER_SIZE 1000
#define on_error(...) { fprintf(stderr, __VA_ARGS__); fflush(stderr); exit(1); }

void echo(char *arg){
    char input[BUFFER_SIZE];
    strcpy(input, arg);
    printf("Echo response: %s\n", input);
}

int main(int argc, char **argv){
    if (argc < 2) on_error("Usage: %s [argument]\n", argv[0]);

	FILE *f = fopen("/dev/urandom", "rb");
	assert(f);
	unsigned int r;
	fread(&r, sizeof(r), 1, f);
	fclose(f);

	alloca(r & 0xFF);

    echo(argv[1]);
    return 0;
}