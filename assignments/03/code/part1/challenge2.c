/* compile instructions:
$ gcc victim2.c -o victim2 -fno-stack-protector -m32 -z execstack
*/

#include <stdio.h>
#include <string.h>
#include <stdlib.h>

#define BUFFER_SIZE 1000
#define on_error(...) { fprintf(stderr, __VA_ARGS__); fflush(stderr); exit(1); }

void echo(){
	char input[BUFFER_SIZE];
    printf("Echo request: ");
    scanf("%s", input);
    printf("Echo response: %s\n", input);
}

int main(int argc, char **argv){
    echo();
    return 0;
}