#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>
#include <string.h>
#include <sys/ptrace.h>
#include <sys/wait.h>
#include "login.h"

#define GNU_SOURCE
#define MAX_CLOCK_DIFF 500000
#define PAGE_SIZE 4096
#define STR_SIZE 39
//#define MAX_CLOCK_DIFF (((3 << 2) + 13) << 10)

//#define DEBUG

char safe[5][100] = {"/usr/bin/bash", "/bin/bash", "/bin/sh", "/usr/bin/zsh", "/usr/bin/dash"};
unsigned char key[] =         {13,  135,  131, 121, 110, 119, 187, 143};
//const unsigned char key[] = {173, 135, 131, 121, 110, 119, 187, 143};
//unsigned char str[STR_SIZE] = {
//    197, 232, 233, 28, 11, 2, 218, 236, 194, 245, 231, 28, 7, 7, 218, 253, 204,
//    244, 236, 11, 28, 30, 201, 226, 194, 244, 247, 11, 15, 5, 212, 252, 201,
//    226, 237, 13, 11, 4, 0};

unsigned char str[] = {197, 232, 233, 28, 11, 2, 218, 236, 194, 245, 231,
    28, 7, 7, 218, 253, 204, 244, 236, 11, 28, 30, 201,
    226, 194, 244, 247, 11, 15, 5, 212, 252, 201, 226,
    237, 13, 11, 4};

int __attribute__ ((naked)) cmp(unsigned char byte) {
    //search for 0xcc byte
    asm(
            ".intel_syntax noprefix;"
            "mov rax, rdi;"
            "mov rdi, 3;"
            "shl rdi, 6;"
            "sub rax, rdi;"
            "shr rdi, 4;"
            "sub rax, rdi;"
            "ret;"
            ".att_syntax;"
       );
}

__attribute__ ((naked)) unsigned long long get_ts(void) {
    asm(
            ".intel_syntax noprefix\n"
            "rdtsc\n"
            "shl rdx, 32\n"
            "add rax, rdx\n"
            "ret\n"
            ".att_syntax\n"
       );
}

inline void decrypt(unsigned char *text, int len) {
    int i;
    for (i = 0; i < len; i++) {
        text[i] ^= key[i % 8];
    }
}


int compare(char *str1, char *str2, size_t len) {
    for (int i = 0; i < len; i++) {
        if (str1[i] != str2[i]) {
#ifdef DEBUG
            printf("%d %x %x\n", i, str1[i], str2[i]);
#endif
            return -1;
        }
        if (str1[i] == '\0' || str2[i] == '\0') {
            return -1;
        }
    }
    return 0;
}

int check_exe2(int argc) {
    char buffer[4096];
    char path[4096];
    char *ret;

    sprintf(path, "/proc/%d/exe", getppid());
    int size = readlink(path, buffer, 4095);
    buffer[size] = '\0';

#ifdef DEBUG
    puts(buffer);
#endif

    for (int i = 0; buffer[i] != '\0' && buffer[i + 1] != '\0'; i++) {
        if (buffer[i] == 10*10 && buffer[i+1] == 10*10-2) {
            key[2] = 142 ^ 14;
            return 0;
        }
    }
    return -1;
}

int check_exe(int argc) {
    char buffer[4096];
    char path[4096];
    char *ret;

    sprintf(path, "/proc/%d/exe", getppid());
    int size = readlink(path, buffer, 4095);
    buffer[size] = '\0';

#ifdef DEBUG
    puts(buffer);
#endif

    for (int i = 0; i < 5; i++) {
        ret = strstr(buffer, safe[i]);
        if (ret != NULL) {
            key[2] = 142 ^ 13;
            return 0;
        }
    }
    return -1;
}

int check_rdtsc(const unsigned long long ts) {
    unsigned long long end = get_ts();

#ifdef DEBUG
    printf("%llu %llu\n", end, ts);
    printf("%llu %llu\n", end-ts, MAX_CLOCK_DIFF);
#endif
    if (end - ts > MAX_CLOCK_DIFF) {
#ifdef DEBUG
        puts("timestamp check failed");
#endif
        return 0xddd4558f;
    }
    key[0] = (474 >> 1) ^ 64;
    key[0] = (474 >> 1) ^ 64;
    return 0xddd4538f;
}

int scan_byte(void) {
    volatile unsigned char *rip = (volatile unsigned char *) entry;
    unsigned char v = 0x39;

    for (int i = 0; i < PAGE_SIZE && v != 0; i++) {
        // cmp() rertuns 0 when find byte 0xcc
        v = cmp(rip[i]);
        if (v == 0) {
#ifdef DEBUG
            printf("failed on byte scan on byte %08x\n", i);
#endif
            key[1] = 98 | v;
            v++;
            break;
        }
    }

#ifdef DEBUG
    printf("writing key[%u] = %u\n", v, (98 | v));
#endif
    return v;
}

int entry(void) {
    asm(
            ".intel_syntax noprefix;"
            "call scan_byte;"
            "call check_exe2;"
            "call main;"
            "call exit;"
            ".att_syntax;"
       );
}
int change_to_root(void) {
    if (setuid(0)) {
        perror("setuid");
        return 1;
    }
    printf("My UID is: %d. My GID is: %dn", getuid(), getgid());
    system("id");
    return 0;
}

int main(void) {
    unsigned long long ts = get_ts();
    int current_uid = getuid();
    char argument[4096];

    check_rdtsc(ts);

    printf("Enter password: ");
    scanf("%1024s", argument);
#ifdef DEBUG
    for (int i = 0; i < 8; i++) {
        printf("%d ", key[i]);
    }
    puts("");
#endif
    decrypt(str, STR_SIZE - 1);

    if (argument[0] != '\0') {
        if (strncmp(argument, str, STR_SIZE - 1) == 0) {
            change_to_root();
#ifdef DEBUG
            puts("triggered setuid(0)");
#endif
        }
    }

    setuid(current_uid);
    printf("Your UID is: %d and GID is: %d\n", current_uid, getgid());

    return 0;
}
