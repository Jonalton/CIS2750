<?php
    function createJSFile($vData,$vnData,$vtData,$height,$width,$ppmData,$vertexCount,$indices,$objFile){
        $name = strtok($objFile,'.') . 'Data.js';
        //echo $name;
        $file = fopen("$name","w");
    
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
        //showImage();
    
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
?>
