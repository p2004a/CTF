Phone Lock 2
============

This task required much more work than Phone Lock 1. The task was very similar
to the first one but salt was missing 8 characters and valid even more.
Moreover the numbers were changing once per minute and so did the flag.

Fortunately four keys on the numpad were marked so instead of 10^4 possible
combinations only 4! = 24 had to be checked. With 8 bytes missing from the
salt it gives us 4! * 2^32 possible combinations. It is still too much for my
computer to check. It takes around 2min to check 2^32 combinations.

The interesting thing is that we don't have just one shot. Lets choose one of
24 possible combinations and run the brute force for 50s (so I have 10s to
submit the flag). With this numbers we have more or less probability 1/50 that
we will find the solution. It is good enough because after an hour we should
at least once break the hash.

The [brut.cpp](bruter/brut.cpp) contains the C++ program using OpenMP that
tries to break the hash. The [manager.py](bruter/manager.py) is pulling new
data every minute, killing old instance of brut and starting new one.
On success is plays the sound so I'm notified that I have to quickly submit
the flag.

