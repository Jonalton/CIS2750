<?php 
  
    $pyPath = "./";
    putenv("PYTHONPATH=$pyPath");

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

?>