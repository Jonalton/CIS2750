#include "parser.h"
#include "pyWrapper.h"
#include <stdio.h>

int main(int argc, char* argv[]){
    char *filename;
    if (argc != 3){
        return -1;
    }
    else{
        filename = malloc(sizeof(char)*(strlen(argv[1])+1));
        strcpy(filename,argv[1]);
        if (strcmp(argv[2],"height") == 0){
            getHeight(filename);
        }
        else if(strcmp(argv[2],"width") == 0){
            getWidth(filename);
        }
        else if(strcmp(argv[2],"ppmData") == 0){
            int *data = getPPMData(filename);
            free(data);
        }
        else if(strcmp(argv[2],"vData") == 0){
            float *vData = getVData(filename);
            free(vData);
            /*return */
        }
        else if (strcmp(argv[2],"vnData") == 0){
            float *vnData = getVNData(filename);
            free(vnData);
        }
        else if (strcmp(argv[2],"vtData") == 0){
            float *vtData = getVTData(filename);
            free(vtData);
        }
        else if (strcmp(argv[2],"index") == 0){
            int* index = getIndices(filename);
            free(index);
        }
        else if (strcmp(argv[2],"vCount") == 0){
            getVertexCount(filename);
        }
        /*fileData *data = readOBJFile(filename);
        printData(data);
        freeData(data);
        strcpy(filename,"");
        strcpy(filename,argv[1]);
        pyData *pData = openPyFile(filename);
        printPPMFile(pData);
        freePyWrapper(pData);
        free(filename);*/
    }
    
    return 0;
}

/* Get height of PPM file*/
void getHeight(char* filename){
    pyData *data = openPyFile(filename);
    int height = data->dimensions[1];
    freePyWrapper(data);
    printf("%d\n",height);
}

/* Get width of PPM file*/
void getWidth(char* filename){
    pyData *data = openPyFile(filename);
    int width = data->dimensions[0];
    freePyWrapper(data);
    printf("%d\n",width);
}

/* Reformat PPM data*/
int* getPPMData(char* filename){
    pyData *data = openPyFile(filename);
    int height = data->dimensions[1];
    int width = data->dimensions[0];
    int size = height*width*4;
    int *txt = malloc(sizeof(int)*(size));
    int i,j;
    int cnt = 0;
    for (i=0; i<height; i++){
        for (j=0;j<width;j++){
           /* printf("%d %d %d\n",data->red[i].coloumn[j],data->green[i].coloumn[j],data->blue[i].coloumn[j]);*/
            txt[cnt] = data->red[i].coloumn[j];
            cnt++;
            txt[cnt] = data->green[i].coloumn[j];
            cnt++;
            txt[cnt] = data->blue[i].coloumn[j];
            cnt++;
            txt[cnt] = 255;
            cnt++;
            /*printf("%d %d %d %d %d\n",cnt-4,txt[cnt-4],txt[cnt-3],txt[cnt-2],txt[cnt-1]);*/
        }
        
    }
    
    for (i=0;i<(height*width*4);i++){
        printf("%d\n",txt[i]);
    }
    freePyWrapper(data);
    return txt;
}

/* Reformat Vertices*/
float* getVData(char* filename){
    fileData *data = readOBJFile(filename);
    int numFaces = data->f[1].numFaces;

    int size = data->fCount * numFaces*3;
    float* vertices = malloc(sizeof(float)*size);
    int i,j,k;
    int cnt = 0;
    int index;
    for (i=1; i<=data->fCount; i++){
        for (j=0;j<numFaces;j++){
            /* Index holds the line of the vertex to get */
            index = data->f[i].v[j];
            for (k=0;k<3;k++){
                vertices[cnt] = data->v[index][k];
                printf("%f\n",vertices[cnt]);
                cnt++;
            }
        }  
    }
    freeData(data);
    return vertices;
}

float* getVNData(char* filename){
    fileData *data = readOBJFile(filename);
    int numFaces = data->f[1].numFaces;
    int size = data->fCount * numFaces * 3;
    float* normals = malloc(sizeof(float)*size);
    int i,j,k;
    int cnt = 0;
    int index;

    for (i=1; i<=data->fCount; i++){
        for (j=0; j<numFaces; j++){
            index = data->f[i].vn[j];
            for (k=0; k<3; k++){
                normals[cnt] = data->vn[index][k];
                printf("%f\n", normals[cnt]);
                cnt++;
            }
        }
    }
    freeData(data);
    return normals;
}

float* getVTData(char* filename){
    fileData *data = readOBJFile(filename);
    int numFaces = data->f[1].numFaces;
    int size = data->fCount * numFaces * 2;
    float* textures = malloc(sizeof(float)*size);
    int i,j,k;
    int cnt = 0;
    int index;

    for (i=1; i<=data->fCount; i++){
        for (j=0; j<numFaces; j++){
            index = data->f[i].vt[j];
            for (k=0; k<2; k++){
                textures[cnt] = data->vt[index][k];
                printf("%f\n",textures[cnt]);
                cnt++;
            }
        }
    }
    freeData(data);
    return textures;
}

int* getIndices(char* filename){
    fileData *data = readOBJFile(filename);
    int numFaces = data->f[1].numFaces;
    int totalFaces = data->fCount;
    int size = numFaces * totalFaces;
    int* indices = malloc(sizeof(int)*size);
    int i,j;
    int counter = 0;
    for (i=0; i<totalFaces; i++){
        for (j=0; j<numFaces; j++){
            indices[counter] = counter;
            printf("%d\n",indices[counter]);
            counter++;
        }
    }
    freeData(data);
    return indices;
}

void getVertexCount(char* filename){
    fileData *data = readOBJFile(filename);
    int numFaces = data->f[1].numFaces;
    int totalFaces = data->fCount;
    int count = numFaces * totalFaces;
    printf("%d\n",count);
}