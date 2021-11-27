<HTML><BODY>

    <FORM method='post' action='indextest.php' enctype='multipart/form-data'>

    Select OBJ File: <input type='file' name='objfilename' size=10>

    Select PPM File: <input type='file' name='ppmfilename' size=10>

    <input type='submit' value='Upload'>

    <input type='submit' name='Exit' value='Exit'>   
    </FORM>

    <br><br>

    <FORM method='post' action='newindex.php' enctype='multipart/form-data'>

    Transfer: <input type='file' name='filename' size=10 value='Transfer'>
    <input type='submit' value='Upload'>
    <input type='submit' name='Delete' value='Delete'>
    <input type='submit' name='DelTab' value='Delete Tables'>
    </FORM>

<?php
$pyPath = "./";
putenv("PYTHONPATH=$pyPath");

//Exit the webpage when exit button clicked
if(array_key_exists('Exit',$_POST)){
    echo 'Exit';
    exit();
}

//execute C program and store file data, call function to create JS file
function execCProgram($ppmFile,$objFile){
    echo "<br>";
    //get data
    $vData = getVData($objFile);
    $vnData = getVNData($objFile);
    $vtData = getVTData($objFile);
    $height = getHeight($ppmFile);
    $width = getWidth($ppmFile);
    $ppmData = getPPMData($ppmFile);
    $vertexCount = getVertexCount($objFile);
    $indices = getIndices($objFile);

    //delete files from server
    unlink($ppmFile);
    unlink($objFile);

    //create javascript file
    createJSFile($vData,$vnData,$vtData,$height,$width,$ppmData,$vertexCount,$indices);
}

//get height of ppm
function getHeight($ppmFile){
    $cmd = './a1 ' . $ppmFile . ' height';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$output,$status);
    if ($status)
        echo "getHeight failed";
    else{
        foreach($output as $height)
            return $height;
    }
}

//get width of ppm
function getWidth($ppmFile){
    $cmd = './a1 ' . $ppmFile . ' width';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$output,$status);
    if ($status)
        echo "getWidth failed";
    else{
        foreach($output as $width)
            return $width;
    }
}

//get ppmData   
function getPPMData($ppmFile){
    $cmd = './a1 ' . $ppmFile . ' ppmData';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$ppm,$status);
    if ($status)
        echo "getPPMData failed";
    else{
        return $ppm;
    }
}

//get vertex data
function getVData($objFile){
    $cmd = './a1 ' . $objFile . ' vData';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$vData,$status);
    if ($status)
        echo "getVData failed";
    else{
        return $vData;
    }
}

//get normals data
function getVNData($objFile){
    $cmd = './a1 ' . $objFile . ' vnData';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$vnData,$status);
    if ($status)
        echo "getVNData failed";
    else{
        return $vnData;
    }
}

//get textures data
function getVTData($objFile){
    $cmd = './a1 ' . $objFile . ' vtData';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$vtData,$status);
    if ($status)
        echo "getVTData failed";
    else{
        return $vtData;
    }
}

//get indices
function getIndices($objFile){
    $cmd = './a1 ' . $objFile . ' index';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$indices,$status);
    if ($status)
        echo "getIndices failed";
    else{
        return $indices;
    }
}

//get vertex count
function getVertexCount($objFile){
    $cmd = './a1 ' . $objFile . ' vCount';
    #echo "<br>". $cmd . "<br>";
    exec($cmd,$output,$status);
    if ($status)
        echo "getVertexCount failed";
    else{
        foreach($output as $vCount)
            return $vCount;
    }
}

//create javascript file
function createJSFile($vData,$vnData,$vtData,$height,$width,$ppmData,$vertexCount,$indices){
    $file = fopen("loaddata.js","w");

    //getVertexCount()
    $txt = PHP_EOL.'function getVertexCount(){'.PHP_EOL.'    return ' . $vertexCount . ';'.PHP_EOL.'}'.PHP_EOL;
    fwrite($file,$txt);

    //getdistance()
    $txt = PHP_EOL.'function getdistance(){'.PHP_EOL.'    return -6.0;'.PHP_EOL.'}'.PHP_EOL;
    fwrite($file,$txt);

    //loadvertices()
    $txt = createLoadVerticesFunction($vData);
    fwrite($file,$txt);

    //loadnormals()
    $txt = createLoadNormalsFunction($vnData);
    fwrite($file,$txt);

    //loadtextcoords()
    $txt = createLoadTextFunction($vtData);
    fwrite($file,$txt);

    //loadvertexindices()
    $txt = createLoadIndicesFunction($indices);
    fwrite($file,$txt);

    //loadwidth()
    $txt = PHP_EOL.'function loadwidth(){'.PHP_EOL.'    return ' . $width . ';'.PHP_EOL.'}'.PHP_EOL;
    fwrite($file,$txt);

    //loadheight()
    $txt = PHP_EOL.'function loadheight(){'.PHP_EOL.'    return ' . $height . ';'.PHP_EOL.'}'.PHP_EOL;
    fwrite($file,$txt);

    //loadtexture()
    $txt = createLoadPPMFunction($ppmData);
    fwrite($file,$txt);

    fclose($file);
    showImage();

}

//create loadvertices()
function createLoadVerticesFunction($vData){
    $txt = PHP_EOL.'function loadvertices(){'.PHP_EOL.'    return [';
    $i = 0;
    $len = count($vData);

    foreach ($vData as $val)
        if ($i == $len-1){
            $txt .= $val;
        }
        else{
            $txt .= $val.',';
            $i++; 
        }
          
    $txt .= '];'.PHP_EOL.'}'.PHP_EOL;
    return $txt;
}

//create loadnormals()
function createLoadNormalsFunction($vnData){
    $txt = PHP_EOL.'function loadnormals(){'.PHP_EOL.'    return [';
    $i = 0;
    $len = count($vnData);

    foreach ($vnData as $val)
        if ($i == $len-1){
            $txt .= $val;
        }
        else{
            $txt .= $val.',';
            $i++; 
        }

    $txt .= '];'.PHP_EOL.'}'.PHP_EOL;
    return $txt;
}

//create loadtextcoords()
function createLoadTextFunction($vtData){
    $txt = PHP_EOL.'function loadtextcoords(){'.PHP_EOL.'    return [';
    $i = 0;
    $len = count($vtData);

    foreach ($vtData as $val)
        if ($i == $len-1){
            $txt .= $val;
        }
        else{
            $txt .= $val.',';
            $i++; 
        }

    $txt .= '];'.PHP_EOL.'}'.PHP_EOL;
    return $txt;
}

//create loadvertexindices()
function createLoadIndicesFunction($indices){
    $txt = PHP_EOL.'function loadvertexindices(){'.PHP_EOL.'    return [';
    $i = 0;
    $len = count($indices);

    foreach ($indices as $val)
        if ($i == $len-1){
            $txt .= $val;
        }
        else{
            $txt .= $val.',';
            $i++; 
        }

    $txt .= '];'.PHP_EOL.'}'.PHP_EOL;
    return $txt;
}

//create loadtexture()
function createLoadPPMFunction($ppmData){
    $txt = PHP_EOL.'function loadtexture(){'.PHP_EOL.'    return( new Uint8Array([';
        $i = 0;
        $len = count($ppmData);
    
        foreach ($ppmData as $val)
            if ($i == $len-1){
                $txt .= $val;
            }
            else{
                $txt .= $val.',';
                $i++; 
            }
    
        $txt .= ']) );'.PHP_EOL.'}'.PHP_EOL;
        return $txt;    
}

function showImage(){
    echo <<<__END
        <head>
        <meta charset="utf-8">
        <title>WebGL Demo</title>
        <link rel="stylesheet" href="./webgl.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gl-matrix/2.8.1/gl-matrix-min.js"
        integrity="sha512-zhHQR0/H5SEBL3Wn6yYSaTTZej12z0hVZKOv3TwCUXT1z5qeqGcXJLLrbERYRScEDDpYIJhPC1fk31gqR783iQ=="
        crossorigin="anonymous" defer>
        </script>
        <script src="webgl-demo.js" defer></script>
        <script src="loaddata.js" ></script>
        </head>

        <body>
            <canvas id="glcanvas" width="640" height="480"></canvas>
        </body>
    __END;
}

/*echo <<<__END
    <HTML><BODY>

    <FORM method='post' action='index.php' enctype='multipart/form-data'>

    Select OBJ File: <input type='file' name='objfilename' size=10>

    Select PPM File: <input type='file' name='ppmfilename' size=10>

    <input type='submit' value='Upload'>

    <input type='submit' name='Exit' value='Exit'>

    <br><br>
    Transfer: <input type='file' name='filename' size=10 value='Transfer'>
    <input type='submit' name='Delete' value='Delete'>
    <input type='submit' name='DelTab' value='Delete Tables'>
    </FORM>

__END;*/

if ($_FILES) {
    $objname = $_FILES['objfilename']['name'];
    move_uploaded_file($_FILES['objfilename']['tmp_name'], $objname);
    $ppmname = $_FILES['ppmfilename']['name'];
    move_uploaded_file($_FILES['ppmfilename']['tmp_name'], $ppmname);
    execCProgram($ppmname,$objname);
}
/*elseif(array_key_exists('Exit',$_POST)){
    exit();
}*/
echo "</BODY></HTML>"
?>


