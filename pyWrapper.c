#include "pyWrapper.h"


/*Opens the python file and runs functions to get data and dimensions*/
pyData* openPyFile(char* filename){
    PyObject *pName;
    PyObject *pModule;
    strcat(filename,".ppm");

    /*Start Python calling*/
    Py_Initialize();
    pName = PyUnicode_DecodeFSDefault("readppm");
    pModule = PyImport_Import(pName);
    Py_DECREF(pName);

    pyData *pData = malloc(sizeof(pyData));
    
    /*Call function to set dimension and data*/
    getData(pModule,filename,pData);
    Py_DECREF(pModule);

    Py_Finalize();
    return pData;
}

/*Opens python file and get the dimension and data from file*/
void getData(PyObject *pModule,char* filename, pyData *pData){
    PyObject *pFunc = PyModule_New("pFunc");
    PyObject *pValue = PyModule_New("pValue");
    PyObject *values = PyModule_New("values");
    PyObject *pArgs = PyTuple_New(1);


    if (pModule != NULL){
        pFunc = PyObject_GetAttrString(pModule, "openFile");
        if (pFunc && PyCallable_Check(pFunc)){
            
            pValue = PyUnicode_DecodeFSDefault(filename);
            PyTuple_SetItem(pArgs,0,pValue);
        }
        pValue = PyObject_CallObject(pFunc,pArgs);
        
        if (pValue != NULL){
            /*Call function to set dimensions values*/
            setDimensions(pValue,pData);

            /*Get list data for the values in the file*/
            values = PyList_GetItem(pValue,3);

            /*Call function to set data vlues*/
            setRows(values,pData->dimensions[1],pData->dimensions[0],pData);
            
        }
    }
    else{
        /*FIX*/
        printf("ERROR PYMODULE NULL");

    } 
    Py_DECREF(values);
    Py_DECREF(pFunc);
    Py_DECREF(pArgs); 
    Py_DECREF(pValue);
}

/*Print the dimensions and data values*/
void printPPMFile(pyData *pData){
    int i,j;
    int height = pData->dimensions[1];
    int width = pData->dimensions[0];

    /*Print dimensions*/
    for(i=0;i<3;i++){
        printf("%d ",pData->dimensions[i]);
    }
    printf("\n");

    /*print data*/
    for (i=0;i<height;i++){
        for (j=0;j<width;j++){
            printf("%d %d %d  ",pData->red[i].coloumn[j],pData->green[i].coloumn[j],pData->blue[i].coloumn[j]);
            /*printf("\t");*/
        }
        printf("\n");
    }
}

/*Parses through python list and sets the data values in struct pyData*/
void setRows(PyObject *pValue,int height,int width,pyData *pData){
    pData->red = mallocRows(height,width);
    pData->green = mallocRows(height,width);
    pData->blue = mallocRows(height,width);
    int i;
    int j;
    PyObject *line = PyModule_New("line");
    PyObject *index = PyModule_New("index");


    for (i=0;i<height;i++){
        /*Gets each row*/
        line = PyList_GetItem(pValue,i);
    
        for (j=0;j<width;j++){
            /*Gets each column*/
            index = PyList_GetItem(line,j);
            pData->red[i].coloumn[j] = (int)PyLong_AsLong(PyList_GetItem(index,0));
            pData->green[i].coloumn[j] = (int)PyLong_AsLong(PyList_GetItem(index,1));
            pData->blue[i].coloumn[j] = (int)PyLong_AsLong(PyList_GetItem(index,2));
        }
    }
    Py_DECREF(line);
    Py_DECREF(index);
    
}

/*Allcocates memory for 2D array*/
row* mallocRows(int height,int width){
    int i;
    row* r = malloc(sizeof(row*)*height);
    for (i=0;i<height;i++){
        r[i].coloumn = malloc(sizeof(int*)*width);
    }
    return r;
}

/*Sets the dimensions by parsing python object*/
void setDimensions(PyObject *pValue, pyData *pData){
    pData->dimensions = malloc(sizeof(int*)*3);
    int i;
    if (pValue != NULL){
        for (i=0; i<3; i++){
            pData->dimensions[i] = (int)PyLong_AsLong(PyList_GetItem(pValue,i));
        }
    }
}

/*Free struct pyData*/
void freePyWrapper(pyData *pData){
    int height = pData->dimensions[1];
    
    freeRows(pData->red,height);
    freeRows(pData->green,height);
    freeRows(pData->blue,height);

    free(pData->dimensions);
    free(pData);
}

/*Free struct row*/
void freeRows(row* r,int height){
    int i;
    for (i=0;i<height;i++){
        free(r[i].coloumn);
        /*printf("free %d\n",i);*/
    }
    free(r);
}
