#!/usr/bin/python3
def main():
    filename = "skull.ppm"
    openFile(filename)

#opens file and determine whther P3 or P6 
def openFile(filename):
    P3 = "P3\n"
    P6 ="P6\n"
    with open(filename,"rb") as file:
        line = file.read(3)
        line = line.decode('ascii')
        if (line == P3):
            fileData = P3file(filename)
            
        elif (line == P6):
            #print("P6")
            fileData = P6file(line,filename)

    file.close()
    return fileData

#creates fileData for P3 file
def P3file(filename):
    f = open(filename,"r")
    line = f.readline()

    #Sets dimensions for P3 file
    dimensions = setDimensionsP3(f)
    convertToInt(dimensions,3)
    
    #Sets data values 
    data = setDataP3(dimensions,f)
    #create list containing dimensions and data
    fileData = dimensions
    fileData.append(data)
    f.close()
    return fileData

#creates fileData for P6 file
def P6file(line,filename):
    file = open(filename,"rb")
    byte = file.read(3)
    dimensions = setDimensionsP6(file)
    convertToInt(dimensions,3)
    data = setDataP6(dimensions,file)
    fileData = dimensions
    fileData.append(data)
    file.close()

    return fileData


#Sets the dimensions for a P3 file   
def setDimensionsP3(file):
    counter = 0
    for line in file:
        current = line.rstrip()
        if (current[0] != '#'):
            counter += 1
            if counter == 1:
                dimensions = current.split(" ")
            elif counter == 2:
                dimensions.append(int(current))
                return dimensions

#Sets the dimensions for a P6 file
def setDimensionsP6(file):
    counter = 0
    for line in file:
        current = line.decode('ascii')
        if (current[0] != '#'):
            counter += 1
            if counter == 1:
                dimensions = current.split()
            elif counter == 2:
                dimensions.append(int(current))
                return dimensions

#Sets data for P3 file
def setDataP3(dimensions,file):   
    row=[]
    data=[]
    j=0
    i=1
    rCounter = 0
    lCounter = 0
    col = [0,0,0]

    #parse line by line
    for line in file:
        value = line.rstrip()
        value = int(value)
        col[j] = value
        if (j == 2):
            row.append(col)
            col = [0,0,0]
            if (i == (dimensions[0]*3)):
                newRow = row.copy()
                data.insert(rCounter,newRow)
                row.clear()
                i = 0
                rCounter = rCounter + 1
            j = 0
        else:
            j = j+1
        i = i+1
    
    return data

#sets data for a P6 file
def setDataP6(dimensions,file):
    row=[]
    data=[]
    j=0
    i=1
    rCounter = 0
    lCounter = 0
    col = [0,0,0]
    byte = file.read(1)

    #parse 1 byte at a time
    while(byte):
        value = list(byte)
        col[j] = value[0]
        if (j == 2):
            row.append(col)
            col = [0,0,0]
            if (i == (dimensions[0]*3)):
                newRow = row.copy()
                #print(newRow)
                data.insert(rCounter,newRow)
                row.clear()
                i = 0
                rCounter = rCounter + 1
            j = 0
        else:
            j = j+1
        byte=file.read(1)
        i = i+1

    return data

#Converts string values into integer
def convertToInt(val,index):
    for i in range(index):
        val[i] = int(val[i])
        

if __name__ == '__main__':
    main()
