// implementation of memory efficient bitwise data structure
// array of bit, "array of bool"
//
// author fh
// created 03-26-2023

#include <stdlib.h>

#include "bitarray.h"

// allocate bitarray using malloc
//
// param1 len - length (bitcount)
// param2 ini - init value (0 or anything else treated as 1)
//
// returns a reference to the allocated memory
bitarray ba_create(int len, int ini)
{
    int num_chunks = len / (sizeof(unsigned char) * 8) + 1;
    bitarray ba = malloc(sizeof(unsigned char) * num_chunks);
    for (int i = 0; i < num_chunks; i++)
    {
        ba[i] = 0;
        if (ini) {
            ba[i] = ~ba[i];
        }
    }
    return ba;
}

// set one index-specified bit to 1
//
// param1 ba - the bitarray to operate on
// param2 idx - the index of the bit to be set
void ba_set(bitarray ba, int idx) {
    int num_chunks = idx / (sizeof(unsigned char) * 8);
    unsigned char bit_idx = (unsigned char) idx % (sizeof(unsigned char) * 8);

    unsigned char mask = 1; // 0...01
    mask = mask << bit_idx; // 0...010...0

    ba[num_chunks] = ba[num_chunks] | mask;
}

// clear one index-specified bit to 0
//
// param1 ba - the bitarray to operate on
// param2 idx - the index of the bit to be cleared
void ba_clear(bitarray ba, int idx)
{
    int num_chunks = idx / (sizeof(unsigned char) * 8);
    unsigned char bit_idx = (unsigned char) idx % (sizeof(unsigned char) * 8);

    unsigned char mask = 1; // 0...01
    mask = mask << bit_idx; // 0...010...0
    mask = ~mask; // 1...101...1

    ba[num_chunks] = ba[num_chunks] & mask;
}

// test if a bit is set or not
//
// param1 ba - the bitarray to operate on
// param2 idx - the index of the bit to be tested
//
// returns 0 if the bit is cleared, 1 if it is set
int ba_test(bitarray ba, int idx)
{
    int num_chunks = idx / (sizeof(unsigned char) * 8);
    unsigned char bit_idx = (unsigned char) idx % (sizeof(unsigned char) * 8);

    unsigned int mask = 1; // 0...01
    mask = mask << bit_idx;

    return (ba[num_chunks] & mask) != 0;
}

// deallocate bitarray
void ba_destroy(bitarray ba)
{
    free(ba);
}