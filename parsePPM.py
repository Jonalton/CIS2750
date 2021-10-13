#!/usr/bin/python3
def main():
    filename = "P3\n"
    openFile(filename)

def openFile(filename):
    P3 = filename
    P6 ="P6"
    file = open("P3.ppm")

    #print(file.readline())
    line = file.readline(3)
    #print("Line " + line)
    if (line == P3):
        dimensions = getDimensions(file)
        convertToInt(dimensions,3)
        #print(dimensions)
        data = getData(dimensions,file)
        for d in data:
            print(d)
    elif (line == P6):
        print("P6")
            
def getDimensions(file):
    counter = 0
    #print(file.readline()) 
    for line in file:
        current = line.rstrip()
        #print("current " +current)
        if (current[0] != '#'):
            #print(current)
            counter += 1
            if counter == 1:
                dimensions = current.split(" ")
            elif counter == 2:
                dimensions.append(int(current))
                return dimensions
        
def convertToInt(val,index):
    for i in range(index):
        val[i] = int(val[i])
        #print(val[i])

def getData(dimensions,file):
    row=[]
    data=[]
    for i in range(dimensions[1]):
        counter = 0
        line = file.readline()
        values = line.split()
        arr = [0,0,0]
        convertToInt(values,(dimensions[0]*3))
        for x in values:
            arr[counter] = int(x)
            if (counter == 2):
                row.append(arr)
                arr = [0,0,0]
                counter = 0
            else:
                counter += 1
        newRow = row.copy()
        data.insert(i,newRow)
        row.clear()   
    return data


if __name__ == '__main__':
    main()
