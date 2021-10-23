CC=gcc
CFLAGS = -ansi -Wall


a2: main.o parser.o pyWrapper.o
	$(CC) $(CFLAGS) main.o parser.o pyWrapper.o -o a2 -L/usr/lib/python3.7/config-3.7m-x86_64-linux-gnu -L/usr/lib -lpython3.7m -lcrypt -lpthread -ldl  -lutil -lm  -Xlinker -export-dynamic -Wl,-O1 -Wl,-Bsymbolic-function

main.o: main.c parser.o pyWrapper.o
	$(CC) $(CFLAGS) -c main.c -o $@ -I/usr/include/python3.7m -I/usr/include/python3.7m  -Wno-unused-result -Wsign-compare -g -fdebug-prefix-map=/build/python3.7-3.7.3=. -specs=/usr/share/dpkg/no-pie-compile.specs -fstack-protector -Wformat -Werror=format-security  -DNDEBUG -g -fwrapv -O3 -Wall -fPIC

pyWrapper.o: pyWrapper.c pyWrapper.h
	$(CC) $(CFLAGS) -c pyWrapper.c -o $@ -I/usr/include/python3.7m -I/usr/include/python3.7m  -Wno-unused-result -Wsign-compare -g -fdebug-prefix-map=/build/python3.7-3.7.3=. -specs=/usr/share/dpkg/no-pie-compile.specs -fstack-protector -Wformat -Werror=format-security  -DNDEBUG -g -fwrapv -O3 -Wall -fPIC

parser.o: parser.c parser.h
	$(CC) $(CFLAGS) -c parser.c -o $@

clean:
	rm *.o