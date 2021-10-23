#define PY_SSIZE_T_CLEAN
#include <Python.h>
#include <pytime.h>
#include <stdio.h>


typedef struct row{
    int *coloumn;
} row;
typedef struct pyData{
    row* red;
    row* green;
    row* blue;
    int rowCount;
    int *dimensions;
} pyData;

pyData* openPyFile(char* filename);
void setDimensions(PyObject *pValue, pyData *pData);
void getData(PyObject *pModule,char* filename, pyData *pData);
void setRows(PyObject *pValue,int height,int width, pyData *pData);
row* mallocRows(int height,int width);
void freePyWrapper(pyData *pData);
void freeRows(row* r,int height);
void printPPMFile(pyData *pData);


