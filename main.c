#include "parser.h"
#include "pyWrapper.h"
#include <stdio.h>

int main(int argc, char* argv[]){
    char *filename;
    if (argc != 2){
        return -1;
    }
    else{
        filename = malloc(sizeof(char)*(strlen(argv[1])+1));
        strcpy(filename,argv[1]);
        fileData *data = readFile(filename);
        /*printData(data);*/
        freeData(data);
        strcpy(filename,"");
        strcpy(filename,argv[1]);
        pyData *pData = openPyFile(filename);
        printPPMFile(pData);
        freePyWrapper(pData);
        free(filename);
    }
    
    return 0;
}