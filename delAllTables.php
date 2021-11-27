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
    </FORM>

    <FORM method='post' action='delAllTables.php' enctype='multipart/form-data'>
        <input type='submit' name='DelTab' value='Delete Tables'>
    </FORM>
    
</BODY></HTML>

<?php
    require __DIR__ . '/createDatabase.php';
    if (array_key_exists('DelTab',$_POST)){
        $conn = createConnection();
        dropAllTables($conn);
        echo "DROPPED ALL TABLES <br>";
        mysqli_close($conn);
        displayButtons();
    }

?>