#include <stdbool.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>

typedef struct faces{
    int *v;
    int *vt;
    int *vn;
    int vCount;
    int vtCount;
    int vnCount;
    int vSize;
    int vnSize;
    int vtSize;
    int faceType;
    int numFaces;
} faces;

typedef struct fileData{
    float **v;
    float **vt;
    float **vn;
    int vCount;
    int vtCount;
    int vnCount;
    int fCount;
    int vSize;
    int vnSize;
    int vtSize;
    int fSize;
    char *gName;
    char *oName;
    faces *f;
} fileData;


fileData* readFile(char* filename);
void printData(fileData* data);
void freeData(fileData* data);
void parse(char* buffer, fileData *data,FILE *fp);
void getLine(char c,char *buffer, FILE *fp);
void getGroupName(char* buffer,fileData *data);
void getFaces(char* buffer, faces *f, int count);
void getObjectName(char *buffer, fileData *data);
void getVertices(char* buffer, float** v,int count);
void getTextures(char *buffer, float **vt, int count);
void getNormals(char* buffer, float **vn, int count);
void parseData(char *name,char *buffer,float *arr,int index);
float** create2DArray(int size, int index);
float** realloc2DArray(float** ptr,int *size,int index);
void getToken(char* buffer,char* tok);
void freeArray(float **arr, int size);
void freeFaces(faces *f,int size);
faces* allocFaces(int size);
void parseFaces(char* buffer,faces *f);
void setFaces(char **data, faces *f,int numFaces);
int identifyFaceType(char* str);
void setVVT(faces* f, int numFaces,char **data);
void setFaceValues(faces *f,int numFaces,char **data);
faces* reallocFaces(faces *f, int *size);
void printV(fileData *d, int type, int numFaces);
void printVT(fileData *d, int type, int numFaces);
void printVN(fileData *d, int type, int numFaces);
