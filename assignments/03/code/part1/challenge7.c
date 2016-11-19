/* compile instructions:
$ gcc victim2.c -o victim2 -fno-stack-protector -m32 -z execstack -lcrypt
*/

#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <crypt.h>

#define BUFFER_SIZE 9
#define on_error(...) { fprintf(stderr, __VA_ARGS__); fflush(stderr); exit(1); }

int check_password(char *pwd){
    const char *const pass = "$1$yS88MsbE$vj.GWUyxroB1gLKQtYvc20";
    char *result;
    int ok;
    result = crypt(pwd, pass);
    ok = strcmp (result, pass) == 0;
    puts(ok ? "Access granted." : "Access denied.");
    return ok ? 1 : 0;
}

int execute (char *cmd) {
   return system(cmd);
}

void echo(char *cmd){
    char buffer[BUFFER_SIZE];
    printf("Enter your password:\n");
    scanf("%s", buffer);
    if (check_password(buffer)){
        execute(cmd);
    }
}

int main(int argc, char **argv){
    if (argc < 2) on_error("Usage: %s [command]\n", argv[0]);
    echo(argv[1]);
    return 0;
}