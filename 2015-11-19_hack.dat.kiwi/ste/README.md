Simple Stegano
==============

Firstly I wanted to be completely sure that I know where two different pictures
differ. My analysis revealed that they always differ only in the identifier of
the color in the palette. One color in the palette represented white and
the rest 255 represented black.

To make sure that I know in which bits of the image the text is stored
I diffed two images representing sequence of `1` and `N` (because
`'N' ^ '1' = 0x7f`) using [diff.py](diff.py). This revealed that all
information is stored column wise in last bit of black color pixels.

The [final.py](final.py) contains implementation of decoder.
