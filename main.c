#include "parser.h"
#include <stdio.h>

int main(int argc, char* argv[]){
    if (argc != 2){
        return -1;
    }
    else{
        fileData *data = readFile(argv[1]);
        /*printf("data %f",data->v[1][0]);*/
        printData(data);
        freeData(data);    
    }
    return 0;
}