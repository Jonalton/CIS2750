#include "parser.h"


/*Reads file and parses through it*/
fileData* readFile(char* filename){
    FILE *fp;

    fileData *data = malloc(sizeof(fileData));
    data->vSize = 1024;
    data->vnSize = 1024;
    data->vtSize = 1024;
    data->fSize = 1024;
    
    char *buffer;


    data->gName = malloc(sizeof(char));
    data->oName = malloc(sizeof(char));
    data->v = create2DArray(data->vSize,3);
    data->vCount = 0;
    data->vn = create2DArray(data->vnSize,3);
    data->vnCount = 0;
    data->vt = create2DArray(data->vtSize,2);
    data->vtCount = 0;
    data->f = allocFaces(data->fSize);
    data->fCount = 0;

    /*OPEN FILE*/
    strcat(filename,".obj");
    fp = fopen(filename,"r");
    if (fp == NULL){
        printf("Error: filename not found\n");
        return NULL;
    }

    buffer = malloc(sizeof(char)*128);
    strcpy(buffer,"");
    parse(buffer,data,fp);
    free(buffer);
    fclose(fp);
    return data;
    
}

/*prints the output*/
void printData(fileData *data){
    int type = data->f[1].faceType;
    int numFaces = data->f[1].numFaces;
    if (type == 1){
        printV(data,type,numFaces);
    }
    if (type == 2){
        printV(data,type,numFaces);
        printVT(data,type,numFaces);
    }
    if (type == 3){
        printV(data,type,numFaces);
        printVN(data,type,numFaces);
    }
    if (type == 4){
        printV(data,type,numFaces);
        printVT(data,type,numFaces);
        printVN(data,type,numFaces);
    }

}

/*prints vectors*/
void printV(fileData *d, int type, int numFaces){
    int i;
    int j;
    int k;
    for (i=1; i <= d->fCount; i++){
        printf("f%d v ",(i+1));
        for (j=0; j<numFaces; j++){

            for (k=0;k<3;k++){
                
                printf("%f ",d->v[d->f[i].v[j]][k]);
            }
            printf("  ");
        }
        printf("\n");
    }
}

/*prints textures*/
void printVT(fileData *d, int type, int numFaces){
    int i;
    int j;
    int k;
    for (i=1; i <= d->fCount; i++){
        printf("f%d vt ",(i+1));
        for (j=0; j<numFaces; j++){
            for (k=0;k<2;k++){
                
                printf("%f ",d->vt[d->f[i].vt[j]][k]);
            }
            printf("  ");
        }
        printf("\n");
    }
}


/*prints normals*/
void printVN(fileData *d, int type, int numFaces){
    int i;
    int j;
    int k;
    for (i=1; i <= d->fCount; i++){
        printf("f%d vn ",(i+1));
        for (j=0; j<numFaces; j++){
            for (k=0;k<3;k++){
                printf("%f ",d->vn[d->f[i].vn[j]][k]);
            }
            printf("  ");
        }
        printf("\n");
    }
}

/*free everything*/
void freeData(fileData *data){
    freeArray(data->v,data->vSize);
    freeArray(data->vn,data->vnSize);
    freeArray(data->vt,data->vtSize);
    freeFaces(data->f,data->fSize);
    
    free(data->gName);
    free(data->oName);
    free(data);
}

/*parse through file*/
void parse(char* buffer,fileData *data, FILE* fp){
    char tok[5];
    int cont = 1;
    char c = '\0';
    strcpy(buffer,"");
    strcpy(tok,"");

    
    if ((c = getc(fp)) != EOF){
    
        getLine(c,buffer,fp);
        /*printf("buffer: %s\n",buffer);*/
        if (buffer[0] == '#'){
            cont = 0;
        }

        else if (buffer[0] == '\n'){
            cont = 0;
        }
        if (cont == 1){
            
            getToken(buffer,tok);

            if (strcmp(tok,"g") == 0){
                getGroupName(buffer, data);
            }

            else if (strcmp(tok,"o") == 0){
                getObjectName(buffer, data);
            }

            else if (strcmp(tok,"v") == 0){
                
                data->vCount++;
                if (data->vCount == (data->vSize)){
                    data->v = realloc2DArray(data->v,&data->vSize,3);
                }
                getVertices(buffer,data->v,data->vCount);
                if (data->v == NULL){
                    printf("VERTICES NULL\n");
                }
            }

            else if (strcmp(tok,"vt") == 0){
                data->vtCount++;
                if (data->vtCount == data->vtSize){
                    data->vt = realloc2DArray(data->vt, &data->vtSize,2);
                }
                getTextures(buffer,data->vt,data->vtCount);
                if (data->vt == NULL){
                    printf("TEXTURES NULL\n");
                }
            }

            
            else if (strcmp(tok,"vn") == 0){
                data->vnCount++;
                if (data->vnCount == data->vnSize){
                    data->vn = realloc2DArray(data->vn, &data->vnSize,3);
                }
                getNormals(buffer,data->vn,data->vnCount);
                if (data->vn == NULL){
                    printf("NORMALS NULL\n");
                }
            }

            else if (strcmp(tok,"f") == 0){
                data->fCount++;
                if(data->fCount == data->fSize){
                    data->f = reallocFaces(data->f,&data->fSize);
                }
                getFaces(buffer,data->f,data->fCount);
                if (data->f == NULL){
                    printf("FACES NULL");
                }   
            }
        }
        parse(buffer,data,fp);
    }
    else{
        /*printf("REACHED END\n");*/
    }
    
}


/*store each line*/
void getLine(char c,char *buffer,FILE *fp){
    strncat(buffer,&c,1);
    while ((c=getc(fp)) != '\n'){
        strncat(buffer,&c,1);
    }
    
}

/*gets group name*/
void getGroupName(char *buffer, fileData *data){
    int i;
    i = 2;
    data->gName = realloc(data->gName,sizeof(char)*(strlen(buffer)-1));
    strcpy(data->gName,"");
    while (buffer[i] != '\0'){
        strncat(data->gName,&buffer[i],1);
        i++;
    }
}

/*gets object name*/
void getObjectName(char* buffer, fileData *data){
    int i;
    i = 2;
    data->oName = realloc(data->oName,sizeof(char)*(strlen(buffer)-1));
    strcpy(data->oName,"");
    while (buffer[i] != '\0'){
        strncat(data->oName,&buffer[i],1);
        i++;
    }
    strncat(data->oName,"\0",1);
}

/*allocates faces*/
faces* allocFaces(int size){
    faces *temp = malloc(sizeof(faces)*size);
    int i;
    for (i=0; i<size; i++){
        temp[i].v = malloc(sizeof(int)*4);
        temp[i].vn = malloc(sizeof(int)*4);
        temp[i].vt = malloc(sizeof(int)*4);
    }
    return temp;
}

/*realllocates faces*/
faces* reallocFaces(faces *f, int *size){
    int prevSize = *size;
    int i;
    *size = *size * 2;
    f = realloc(f,sizeof(faces)*(*size));
    for (i = prevSize;i<(*size);i++){
        f[i].v = malloc(sizeof(int)*4);
        f[i].vn = malloc(sizeof(int)*4);
        f[i].vt = malloc(sizeof(int)*4);
    }
    return f;
}

/*creates 2D array*/
float** create2DArray(int size, int index){
    float** temp = malloc(sizeof(float*)*size);
    int i;
    for (i=0; i<size; i++){
        if (i == 0){
            temp[0] = malloc(sizeof(float)*index);
            temp[0][i] = 0.0;
        }
        else{
            temp[i] = malloc(sizeof(float)*index);
        }
        
    }
    return temp;
}

/*free array*/
void freeArray(float** arr,int size){
    int i;
    for (i=0; i<size; i++){
        free(arr[i]);
        if (i == 0 && arr[0] == NULL){
            printf("NULL\n");
        }
    }
    free(arr);
}

/*free faces*/
void freeFaces(faces *f,int size){
    int i;
    for (i = 0; i < size; i++){
        free(f[i].v);
        free(f[i].vn);
        free(f[i].vt);
    }
    free(f);
}

/*reallocates 2D array*/
float** realloc2DArray(float** ptr,int *size,int index){
    int prevSize = *size;
    int i;
    *size = *size * 2;
    ptr = realloc(ptr,sizeof(float*)*(*size));
    for(i = prevSize; i<*size; i++){
        ptr[i] = malloc(sizeof(float)*index);
    }
    return ptr;
}

/*gets vertices*/
void getVertices(char* buffer, float** v,int count){
    parseData("v",buffer,v[count],3);
}

/*gets normals*/
void getNormals(char* buffer, float **vn, int count){
    parseData("vn",buffer,vn[count],3);
}

/*gets textures*/
void getTextures(char *buffer, float **vt, int count){
    parseData("vt", buffer, vt[count],2);
}

/*gets faces*/
void getFaces(char* buffer, faces *f, int count){
    parseFaces(buffer,&f[count]);  
}

/*parses through faces data*/
void parseFaces(char* buffer,faces *f){
    char space[] = " ";
    char **temp = malloc(sizeof(char*));
    int i = 0;
    char *ptr = strtok(buffer,space);

    while(ptr != NULL){
        temp = realloc(temp,sizeof(char*)*(i+1));
        if (strcmp(ptr,"f") != 0){
            temp[i-1] = malloc(sizeof(char) * (strlen(ptr)+1));
            strcpy(temp[i-1],ptr);
        }
        ptr = strtok(NULL,space);
        i++;
    }
    setFaces(temp,f,(i-1));
}

/*sets value in face struct*/
void setFaces(char** data, faces *f,int numFaces){
    int i;
    int id = identifyFaceType(data[0]);
    if (id == 0){
        for (i = 0; i<numFaces; i++){
            f->v[i] = atoi(data[i]);
        }
        f->faceType = 1;
    }


    else if(id == 1){
        setVVT(f,numFaces,data);
        f->faceType = 2;
    }
    else if (id == 2){
        setFaceValues(f,numFaces,data);
    }
    
    f->numFaces = numFaces;
    
    
}

/*sets face values*/
void setFaceValues(faces *f,int numFaces,char **data){
    char slash[] = "/";
    char* ptr;
    int temp[3] = {0,0,0};
    int j = 0;
    int i;
    for (i=0; i<numFaces; i++){
        
        ptr = strtok(data[i],slash);
        j = 0;
        while (ptr != NULL){
            temp[j] = atoi(ptr); 
            ptr = strtok(NULL,slash);
            j++;
        }
        if ((j) == 2){
            f->v[i] = temp[0];
            f->vn[i] = temp[1];
            f->vt[i] = 0;
            f->faceType = 3;
        }
        else if((j) == 3){
            f->v[i] = temp[0];
            f->vt[i] = temp[1];
            f->vn[i] = temp[2];
            f->faceType = 4;
        }
        free(data[i]);
    }

    free(data);
    
    
}

/*sets vertex and textures in face*/
void setVVT(faces* f, int numFaces,char **data){
    char slash[] = "/";
    char* ptr; 
    int i;
    for (i=0;i<numFaces; i++){
        ptr = strtok(data[i],slash);
        if (ptr != NULL){
            f->v[i] = atoi(ptr);
            ptr = strtok(NULL,slash);
            f->vt[i] =atoi(ptr);
        }
        free(data[i]);
    }
    free(data);
}

/*identifies input type for faces*/
int identifyFaceType(char* str){
    int i = 0;
    int counter = 0;
    while (str[i] != '\0'){
        if (str[i] == '/'){
            counter++;
        }
        i++;
    }
    return counter;
}

/*parses through data and sets vertices,textures, and normals*/
void parseData(char *name,char *buffer,float* arr,int index){
    char space[] = " ";
    float temp[index];
    int i;
    char *ptr = strtok(buffer,space);
    int count = 0;

    while (ptr != NULL){
        if (strcmp(ptr,name) != 0){
            temp[count] = atof(ptr);
            count++;
        }
        ptr = strtok(NULL,space);
    }
    for(i=0; i<index; i++){
        arr[i] = temp[i];
    }
}

/*gets token*/
void getToken(char* buffer,char tok[5]){

    int i;
    i = 0;

    while(buffer[i] != ' '){
        tok[i] = buffer[i];
        tok[i+1] = '\0';
        i++;
    }

}
