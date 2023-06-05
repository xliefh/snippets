#include <stdio.h>
#include <stdlib.h>

#include "bitarray.h"

int main(int argc, char* argv[])
{
    if (argc != 2)
    {
        printf("usage: %s <upper_limit>", argv[0]);
        return 0;
    }

    int limit = atoi(argv[1]) + 1;

    if (limit < 1)
    {
        printf("Prime limit below 1 given. Exit.");
        return -1;
    }

    // sieve of erastothenes: begin with all numbers being potential primes
    bitarray sieve = ba_create(limit, 1);
    // by definition, 0 is not prime, 1 is prime
    ba_clear(sieve, 0);
    // iterate over the multiples of every unmarked number (which are by definition non-prime)
    for (int i = 2; i < limit; i++)
    {
        if (ba_test(sieve, i))
        {
            for (int multiple = i + i; multiple < limit; multiple += i)
            {
                ba_clear(sieve, multiple);
            }
        }
    }

    printf("Primes found:\n");
    int printrow = 1;
    for (int i = 0; i < limit; i++)
    {
        if (ba_test(sieve, i))
        {
            printf("%6d  ", i);
            if ((printrow++ % 20) == 0)
            {
                printf("\n");
                printrow = 1;
            }
        }
    }

    printf("\ntest sieve[1]: %u\n", ba_test(sieve, 1));
    ba_clear(sieve, 1);
    printf("after clear: %u\n", ba_test(sieve, 1));
    ba_set(sieve, 1);
    printf("after set: %u\n", ba_test(sieve, 1));

    ba_destroy(sieve);

    return 0;
}