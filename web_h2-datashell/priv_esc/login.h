#pragma once

void decrypt(unsigned char *text, int len);
int check_rdtsc(const unsigned long long ts);
int check_proc_exe(int argc);
int compare(char *str1, char *str2, size_t len);
__attribute__ ((naked)) unsigned long long get_ts(void);
__attribute__ ((naked)) int entry(void);
