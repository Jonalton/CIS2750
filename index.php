<HTML><BODY>

    <FORM method='post' action='indextest.php' enctype='multipart/form-data'>

    Select OBJ File: <input type='file' name='objfilename' size=10>

    Select PPM File: <input type='file' name='ppmfilename' size=10>

    <input type='submit' value='Upload'>

    <input type='submit' name='Exit' value='Exit'>   
    </FORM>

    <br><br>

    <FORM method='post' action='index.php' enctype='multipart/form-data'>

    Transfer: <input type='file' name='filename' size=10 value='Transfer'>
    <input type='submit' value='Upload'>
    
    <input type='submit' name='DelTab' value='Delete Tables'>
    </FORM>
    <FORM method='post' action='delete.php' enctype='multipart/form-data'>
        <input type='submit' name='Delete' value='Delete'>
    </FORM>

<?php
    require __DIR__ . '/getCData.php';
    require __DIR__ . '/createDatabase.php';
    require __DIR__ . '/createJSFile.php';

    
    if ($_FILES && array_key_exists('DelTab',$_POST) === FALSE && array_key_exists('Delete',$_POST) === FALSE){
        $filename = $_FILES['filename']['name'];
        move_uploaded_file($_FILES['filename']['tmp_name'], $filename);
        checkForPair($filename);
        displayButtons();
    }
    /*else if (array_key_exists('Delete',$_POST)){
        echo 'delete';
    }*/
    else if (array_key_exists('DelTab',$_POST)){
        $conn = createConnection();
        dropAllTables($conn);
        echo "dropped all tables <br>";
        mysqli_close($conn);
        displayButtons();
    }
    else if (array_key_exists('filenum',$_POST)){
        $id = $_POST["filenum"];
        $name = getFilename($id);
        if (strcmp($name,'NULL') != 0){
            deletefromTable($id);
        } 
        echo 'deleted '.$name.'<br>';
        displayButtons();
    }
    else{
        displayButtons();
    }

    //CHECK IF THERE ARE PAIRS OF FILES
    function checkForPair($filename){
        $dir = new DirectoryIterator(dirname(__FILE__));
        $name = [];
        

        //split filename into name and type
        $tok = strtok($filename,'.');
        while ($tok !== false){
            $name[] = $tok;
            $tok = strtok('.');
        }

        //search through files in directory for matching filename but different file type
        foreach($dir as $fileinfo){
            if (!$fileinfo->isDot()){
                $search = [];
                $tok2 = strtok($fileinfo->getFilename(),'.');
                while ($tok2 !== false){
                    $search[] = $tok2;
                    $tok2 = strtok('.');
                }

                //finds matching pair of obj and ppm file
                if ((strcmp($name[0],$search[0]) == 0) && (strcmp($name[1],$search[1]) !== 0)){
                    if (strcmp($name[1],"obj") == 0){
                        $objFile = $name[0].'.'.$name[1];
                        $ppmFile = $search[0].'.'.$search[1];
                    }
                    else{
                        $objFile = $search[0].'.'.$search[1];
                        $ppmFile = $name[0].'.'.$name[1];
                    }
                    getData($objFile,$ppmFile);
                }
            }
        }
    }

    //GET DATA FROM C FILES
    function getData($objFile,$ppmFile){
        //echo $objFile . " " . $ppmFile;
        $vData = getVData($objFile);
        $vnData = getVNData($objFile);
        $vtData = getVTData($objFile);
        $height = getHeight($ppmFile);
        $width = getWidth($ppmFile);
        $ppmData = getPPMData($ppmFile);
        $vertexCount = getVertexCount($objFile);
        $indices = getIndices($objFile);
        //echo "<br>";
        //echo $vertexCount .' ' . $height . ' ' . $width ."<br>";
        #print_r($vData);
        //echo count($vData) . "<br>";

        //connect to sql server
        $conn = createConnection();

        //create tables
        createInfoTable($vData,$vnData,$vtData,$height,$width,$objFile,$conn);
        createVTable($vData,$conn);
        createVNTable($vnData,$conn);
        createVTTable($vtData, $conn);
        createPPMTable($ppmData, $conn);
        createJSFile($vData,$vnData,$vtData,$height,$width,$ppmData,$vertexCount,$indices,$objFile);
        mysqli_close($conn);
        
        
    }

    //CREATE BUTTON FOR THE NUMBER OF ROWS IN INFOTABLE
    function displayButtons(){
        $conn = createConnection();
        $sql = "select * from infoTable order by id";
        $result = mysqli_query($conn, $sql);
        $id = [];

        if ($result == TRUE){
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    //print_r($row);
                    array_push($id,$row["id"]);
                }
            }
            //print_r($id);
            echo "<FORM method='post' action='createImage.php' enctype='multipart/form-data'>";
            foreach ($id as $val){
                echo "<input type=\"submit\" name=" .$val. " value=".$val."><br>";
            }
            echo "</FORM>";
            mysqli_close($conn);
        }

        else{
            mysqli_close($conn);
        }
        
    }


?>

