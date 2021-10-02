CC=gcc
CFLAGS = -Wall -g -ansi


a1: main.o parser.o
	$(CC) $(CFLAGS) -o a1 main.o parser.o

main.o: parser.o
	$(CC) $(CFLAGS) -c main.c -o $@

parser.o: parser.c parser.h
	$(CC) $(CFLAGS) -c parser.c -o $@

clean:
	rm *.o