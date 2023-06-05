// interface to a bitwise data structure
// array of bit, "array of bool"
//
// author fh
// created 03-26-2023

#ifndef BITARRAY_H
#define BITARRAY_H

// operate on raw bytes
typedef unsigned char* bitarray;

// allocate bitarray
//
// param1 - length (bitcount)
// param2 - init value (0 or anything else treated as 1)
//
// returns a reference to the allocated memory
bitarray ba_create(int, int);

// set one bit to 1
//
// param1 - the bitarray to operate on
// param2 - the index of the bit to be set
void ba_set(bitarray, int);

// clear one bit to 0
//
// param1 - the bitarray to operate on
// param2 - the index of the bit to be cleared
void ba_clear(bitarray, int);

// test if a bit is set or not
//
// param1 - the bitarray to operate on
// param2 - the index of the bit to be tested
//
// returns 0 if the bit is cleared, 1 if it is set
int ba_test(bitarray, int);

// deallocate bitarray
void ba_destroy(bitarray);

#endif // BITARRAY_H