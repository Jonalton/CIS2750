CIS2750 A3
Jonalton Jude Hamilton - jjudeham@uoguelph.ca
1045218
Everything should be working properly

to run:
    1. make
    2. Open webpage upload obj and ppm files, then click upload, image will show
=======

Issues:
    - Valgrind memory leaks come from Py_Initialize() and Py_Finalize, not sure how to solve leaks
    - Compiler Warnings for struct *timespec, unable to solve the warning
    - Exit button does not close webpage, but exits the php script instead

All functions of the assignemnt work as specified