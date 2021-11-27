<?php

//ESTABLISH CONNECTION TO SQL SERVER
function createConnection(){
  $username = "jjudeham";
  $password = "1045218";
  $database = "jjudeham";
  $server = "dursley.socs.uoguelph.ca";

      // create connection to the database
  $conn = new mysqli($server, $username, $password, $database);

      // check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "connected successfully <BR>";
  return $conn;
}

//CREATE VTABLE AND ADD ROWS
function createVTable($vData, $conn){

  //number of total rows
  $len = count($vData);
  $totalRows = $len/9;

  //temp delete table
  //dropTable("vTable",$conn);
  //creates table if it doesnt exist already 
  $vTable = "create table if not exists vTable(
      id int,
      Pt1_x decimal(7,6),
      Pt1_y decimal(7,6),
      Pt1_z decimal(7,6),
      Pt2_x decimal(7,6),
      Pt2_y decimal(7,6),
      Pt2_z decimal(7,6),
      Pt3_x decimal(7,6),
      Pt3_y decimal(7,6),
      Pt3_z decimal(7,6)
  )";

  //ERROR CHECKING TABLE
  if ($conn->query($vTable) === TRUE){
    //echo "vTable created successfully <br>";
  }
  else{
    echo "Error creating vTable: " . $conn->error;
  }

  //check index value
  /*$vSql = $conn->query('select count(*) from infoTable');
  if ($vSql == FALSE){
    $vFirst = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($vSql);
    $vFirst = $arr['id'] + 1;
  }
  echo 'vfirst ' .$vFirst. '<br>';*/
  

  $infoNum = $conn->query('select count(*) from infoTable');
  if ($infoNum == TRUE){
    $arr = mysqli_fetch_assoc($infoNum);
    $index = $arr['count(*)'];
    //echo $index;
    $infoRow = $conn->query('select * from infoTable where id='.$index);
    if($infoRow == TRUE){
      $arr2 = mysqli_fetch_assoc($infoRow);
      //print_r($arr2);
      //echo '<br>';
      $vFirst = $arr2['firstV'];
    }
    if ($infoRow == FALSE){
      echo 'FALSE<BR>';
    }
  }
  





  
  $j = 0;
  for ($i = 0; $i < $totalRows; $i++){
    if ($i == 0){
      $index = $vFirst;
      $vRows = array("insert into vTable values ($index,$vData[$j],$vData[1],$vData[2],$vData[3],$vData[4],$vData[5],$vData[6],$vData[7],$vData[8])");
      $j = 9;
    }
    else{
      $index = $index + 1;
      $k = $j+1;
      $l = $j+2;
      $m = $j+3;
      $n = $j+4;
      $o = $j+5;
      $p = $j+6;
      $q = $j+7;
      $r = $j+8;
      array_push($vRows,"insert into vTable values ($index,$vData[$j],$vData[$k],$vData[$l],$vData[$m],$vData[$n],$vData[$o],$vData[$p],$vData[$q],$vData[$r])");
      $j = $j + 9;
    }
  }


  for ($i=0; $i< $totalRows; $i++){
    if ($conn->query($vRows[$i]) === TRUE){
      //echo "New record created successfully $i <BR>";
    }
    else{
      echo "Error: " . $vRows[$i] . "<br>" . $conn->error . "<br>";
    }
  }
  
  //mysqli_close($conn);
}

//CREATE VNTABLE AND ADD ROWS
function createVNTable($vnData, $conn){
  
  //number of total rows
  $len = count($vnData);
  $totalRows = $len/9;

  //temp delete table
  //dropTable("vnTable",$conn);
  //creates table if it doesnt exist already 
  $vnTable = "create table if not exists vnTable(
      id int not null auto_increment,
      Pt1_x decimal(7,6),
      Pt1_y decimal(7,6),
      Pt1_z decimal(7,6),
      Pt2_x decimal(7,6),
      Pt2_y decimal(7,6),
      Pt2_z decimal(7,6),
      Pt3_x decimal(7,6),
      Pt3_y decimal(7,6),
      Pt3_z decimal(7,6),
      PRIMARY KEY (id)
  )";

  //ERROR CHECKING TABLE
  if ($conn->query($vnTable) === TRUE){
    //echo "vnTable created successfully <br>";
  }
  else{
    echo "Error creating vnTable: " . $conn->error;
  }

  //check index value
  /*
  $vnSql = $conn->query('select count(*) from vnTable');
  if ($vnSql == FALSE){
    $vnFirst = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($vnSql);
    $vnFirst = $arr['count(*)'] + 1;
  }*/

  $infoNum = $conn->query('select count(*) from infoTable');
  if ($infoNum == TRUE){
    $arr = mysqli_fetch_assoc($infoNum);
    $index = $arr['count(*)'];
    //echo $index;
    $infoRow = $conn->query('select * from infoTable where id='.$index);
    if($infoRow == TRUE){
      $arr2 = mysqli_fetch_assoc($infoRow);
      //print_r($arr2);
      //echo '<br>';
      $vnFirst = $arr2['firstVN'];
    }
    if ($infoRow == FALSE){
      echo 'FALSE<BR>';
    }
  }


  //echo 'vnFirst'.$vnFirst.'<br>';

  
  $j = 0;
  for ($i = 0; $i < $totalRows; $i++){
    if ($i == 0){
      $index = $vnFirst;
      $vnRows = array("insert into vnTable values ($index,$vnData[$j],$vnData[1],$vnData[2],$vnData[3],$vnData[4],$vnData[5],$vnData[6],$vnData[7],$vnData[8])");
      $j = 9;
    }
    else{
      $index = $index + 1;
      $k = $j+1;
      $l = $j+2;
      $m = $j+3;
      $n = $j+4;
      $o = $j+5;
      $p = $j+6;
      $q = $j+7;
      $r = $j+8;
      array_push($vnRows,"insert into vnTable values ($index,$vnData[$j],$vnData[$k],$vnData[$l],$vnData[$m],$vnData[$n],$vnData[$o],$vnData[$p],$vnData[$q],$vnData[$r])");
      $j = $j + 9;
    }
  }


  for ($i=0; $i< $totalRows; $i++){
    if ($conn->query($vnRows[$i]) === TRUE){
      //echo "New record created successfully $i <BR>";
    }
    else{
      echo "Error: " . $vnRows[$i] . "<br>" . $conn->error . "<br>";
    }
  }
  
}

//CREATE VTTABLE AND ADD ROWS
function createVTTable($vtData, $conn){
  
  //number of total rows
  $len = count($vtData);
  $totalRows = $len/6;

  //temp delete table
  //dropTable("vtTable",$conn);
  //creates table if it doesnt exist already 
  $vtTable = "create table if not exists vtTable(
      id int not null auto_increment,
      Pt1_x decimal(7,6),
      Pt1_y decimal(7,6),
      Pt2_x decimal(7,6),
      Pt2_y decimal(7,6),
      Pt3_x decimal(7,6),
      Pt3_y decimal(7,6),
      PRIMARY KEY (id)
  )";

  //ERROR CHECKING TABLE
  if ($conn->query($vtTable) === TRUE){
    //echo "vtTable created successfully <br>";
  }
  else{
    echo "Error creating vtTable: " . $conn->error;
  }

  //check index value
  /*
  $vtSql = $conn->query('select count(*) from vtTable');
  if ($vtSql == FALSE){
    $vtFirst = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($vtSql);
    $vtFirst = $arr['count(*)'] + 1;
  }*/


  $infoNum = $conn->query('select count(*) from infoTable');
  if ($infoNum == TRUE){
    $arr = mysqli_fetch_assoc($infoNum);
    $index = $arr['count(*)'];
    //echo $index;
    $infoRow = $conn->query('select * from infoTable where id='.$index);
    if($infoRow == TRUE){
      $arr2 = mysqli_fetch_assoc($infoRow);
      //print_r($arr2);
      //echo '<br>';
      $vtFirst = $arr2['firstVT'];
    }
    if ($infoRow == FALSE){
      echo 'FALSE<BR>';
    }
  }
  //echo 'vtFirst'.$vtFirst.'<br>';



  $j = 0;
  for ($i = 0; $i < $totalRows; $i++){
    if ($i == 0){
      $index = $vtFirst;
      $vtRows = array("insert into vtTable values ($index,$vtData[$j],$vtData[1],$vtData[2],$vtData[3],$vtData[4],$vtData[5])");
      $j = 6;
    }
    else{
      $index = $index + 1;
      $k = $j+1;
      $l = $j+2;
      $m = $j+3;
      $n = $j+4;
      $o = $j+5;

      array_push($vtRows,"insert into vtTable values ($index,$vtData[$j],$vtData[$k],$vtData[$l],$vtData[$m],$vtData[$n],$vtData[$o])");
      $j = $j + 6;
    }
  }


  for ($i=0; $i< $totalRows; $i++){
    if ($conn->query($vtRows[$i]) === TRUE){
      //echo "New record created successfully $i <BR>";
    }
    else{
      echo "Error: " . $vtRows[$i] . "<br>" . $conn->error . "<br>";
    }
  }
  
}

//CREATE PPM TABLE AND ADD ROWS
function createPPMTable($ppmData, $conn){
  
  //number of total rows
  $len = count($ppmData);
  $totalRows = $len/4;

  /**********TEMP DELETE************/
  //dropTable("ppmTable",$conn);
  //creates table if it doesnt exist already 
  $ppmTable = "create table if not exists ppmTable(
      id int not null auto_increment,
      r int,
      g int,
      b int,
      val int,
      PRIMARY KEY(id)
  )";

  //ERROR CHECKING TABLE
  if ($conn->query($ppmTable) === TRUE){
    //echo "ppmTable created successfully <br>";
  }
  else{
    echo "Error creating ppmTable: " . $conn->error;
  }


  //check index value
  /*$ppmSql = $conn->query('select * from ppmTable');
  if ($ppmSql == FALSE){
    $ppmFirst = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($ppmSql);
    $ppmFirst = $arr['count(*)'] + 1;
  }*/

  $ppmSql = $conn->query('select * from ppmTable order by id');
  if (mysqli_num_rows($ppmSql) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($ppmSql)) {
      $ppmFirst = $row["id"] + 1;
    }
  } else {
    $ppmFirst = 1;
  }
  //echo 'ppmFirst'.$ppmFirst.'<br>';







  
  $j = 0;
  for ($i = 0; $i < $totalRows; $i++){
    if ($i == 0){
      $index = $ppmFirst;
      $ppmRows = array("insert into ppmTable values ($index,$ppmData[$j],$ppmData[1],$ppmData[2],$ppmData[3])");
      $j = 4;
    }
    else{
      $index = $index + 1;
      $k = $j+1;
      $l = $j+2;
      $m = $j+3;
      array_push($ppmRows,"insert into ppmTable values ($index,$ppmData[$j],$ppmData[$k],$ppmData[$l],$ppmData[$m])");
      $j = $j + 4;
    }
  }


  for ($i=0; $i< $totalRows; $i++){
    if ($conn->query($ppmRows[$i]) === TRUE){
      //echo "New record created successfully $i <BR>";
    }
    else{
      echo "Error: " . $ppmRows[$i] . "<br>" . $conn->error . "<br>";
    }
  }
  
}

//CREATE INFO TABLE AND ADD ROWS
function createInfoTable($vData,$vnData,$vtData,$height,$width,$objFile,$conn){

  /****************TEMP DELETE *******************/
  /*dropTable("infoTable",$conn);
  dropTable("vTable",$conn);
  dropTable("vnTable",$conn);
  dropTable("vtTable",$conn);
  dropTable("ppmTable",$conn);*/
  //first initialize variables

  //number of total rows
  $vLen = count($vData);
  $vRows = $vLen/9;
  $vnLen = count($vnData);
  $vnRows = $vnLen/9;
  $vtLen = count($vtData);
  $vtRows = $vtLen/6;

  //FIND FIRST INDEX OF V, VN, AND VT ROWS
  //$vSql = $conn->query('select * from vTable');
  $vSql = 'select * from vTable';
  $vResult = $conn->query($vSql);
  if ($vResult == TRUE){
    if (mysqli_num_rows($vResult) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($vResult)) {
        $vFirst = $row["id"] + 1;
      }
    }
  }
  else {
    $vFirst = 1;
  }

  $vnSql = 'select * from vnTable';
  $vnResult = $conn->query($vnSql);
  if ($vnResult == TRUE){
    if (mysqli_num_rows($vnResult) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($vnResult)) {
        $vnFirst = $row["id"] + 1;
      }
    } 
  }
  else {
    $vnFirst = 1;
  }

  $vtSql = 'select * from vtTable';
  $vtResult = $conn->query($vtSql);
  if ($vtResult == TRUE){
    if (mysqli_num_rows($vtResult) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($vtResult)) {
        $vtFirst = $row["id"] + 1;
      }
    }
  }
   else {
    $vtFirst = 1;
  }
  
  $name = strtok($objFile,'.');


  //creates table if it doesnt exist already 
  $infoTable = "create table if not exists infoTable(
      id int,
      name char(20),
      numV int,
      numVN int,
      numVT int,
      firstV int,
      firstVN int,
      firstVT int,
      height int,
      width int
    )";

  //ERROR CHECKING TABLE
  if ($conn->query($infoTable) === TRUE){
    //echo "infoTable created successfully <br>";
  }
  else{
    echo "Error creating infoTable: " . $conn->error . "<br>";
  }

  //check index value
  /*$infoSql = $conn->query('select count(*) from infoTable');
  if ($infoSql == FALSE){
    $infoFirst = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($infoSql);
    $infoFirst = $arr['count(*)'] + 1;
  }*/

  $infoSql = $conn->query('select * from infoTable order by id');
  if (mysqli_num_rows($infoSql) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($infoSql)) {
      $infoFirst = $row["id"] + 1;
    }
  } else {
    $infoFirst = 1;
  }
  
  
  /*$infoNum = $conn->query('select count(*) from infoTable');
  if ($infoNum == TRUE){
    $arr = mysqli_fetch_assoc($infoNum);
    $index = $arr['count(*)'];
    echo $index;
    $infoRow = $conn->query('select * from infoTable where id='.$index);
    if($infoRow == TRUE){
      $arr2 = mysqli_fetch_assoc($infoRow);
      print_r($arr2);
      echo '<br>';
      $vFirst = $arr2['firstV'] + $arr2['numV'];
    }
    if ($infoRow == FALSE){
      echo 'FALSE<BR>';
    }
  }*/



  //echo 'ppmFirst'.$ppmFirst.'<br>';

  //create record and inert into table
  $sql = "insert into infoTable (id,name,numV,numVN,numVT,firstV,firstVN,firstVT,height,width) values ($infoFirst,'$name', $vRows, $vnRows, $vtRows, $vFirst, $vnFirst, $vtFirst, $height, $width)";
  //echo $infoFirst . ' ' . $name . ' ' . $vRows . ' ' . $vnRows . ' ' . $vtRows . ' ' . $vFirst . ' ' . $vnFirst . ' ' . $vtFirst . ' ' . $height . ' ' . $width. '<br>';
  if ($conn->query($sql) === TRUE){
    //echo "New record created successfully $sql <BR>";
  }
  else{
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
  }
  
}

//DROP TABLE
function dropTable($table,$conn){
  $sql =  "drop table " . $table;


  if ($conn->query($sql) === TRUE) {
    //echo "Table ".$table." dropped successfully <BR>";
  } else {
    echo "Error dropping table: " . $conn->error . "<br>";
  }
}

function dropAllTables($conn){
    dropTable("vTable",$conn);
    dropTable("vnTable",$conn);
    dropTable("vtTable",$conn);
    dropTable("ppmTable",$conn);
    dropTable("infoTable",$conn);
}

//GET THE NAME OF THE FILE FROM CORRESSPONDING ID VALUE
function getFilename($id){
  $conn = createConnection();
  $sql = "select * from infoTable where id = $id";
  $result = mysqli_query($conn, $sql);
  $name = "NULL";
  if ($result == TRUE){
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
              #print_r($row);
              $name = $row["name"];
          }
      }
  }
  
  mysqli_close($conn);
  return $name;
}

function deletefromTable($id){
  $conn = createConnection();
  $sql = "select * from infoTable where id = $id";
  $result = mysqli_query($conn, $sql);
  
  //id,name,numV,numVN,numVT,firstV,firstVN,firstVT,height,width

  if ($result == TRUE){
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            #print_r($row);
            $name = $row["name"];
            $numV = $row["numV"];
            $numVN = $row["numVN"];
            $numVT = $row["numVT"];
            $firstV = $row["firstV"];
            $firstVN = $row["firstVN"];
            $firstVT = $row["firstVT"];
            $height = $row["height"];
            $width = $row["width"];

            //delete infoTable row
            deleteRow($id,"infoTable",$conn);

            //delete rows from vTable
            deleteMultipleRows($firstV, $numV,"vTable",$conn,$id);

            //delete rows from vnTable
            deleteMultipleRows($firstVN,$numVN,"vnTable",$conn,$id);

            //delete rows from vtTable
            deleteMultipleRows($firstVT, $numVT,"vtTable",$conn,$id);

            //delete rows from
            deleteMultipleRows($height, $width,"ppmTable",$conn,$id);
        }
    }
  }
  mysqli_close($conn);
}

function deleteRow($id,$tablename,$conn){

  $infoSql = $conn->query('select count(*) from infoTable');
  if ($infoSql == FALSE){
    $count = 1;
  }
  else {
    $arr = mysqli_fetch_assoc($infoSql);
    $count = $arr['count(*)'];
  }

  $sql = "delete from $tablename where id=$id";
  $result = mysqli_query($conn, $sql);

  //update info table if id is not the highest value
  if ($id < $count){
    for ($i = ($id+1); $i<=$count; $i++){
      $index = $i-1;
      $sql = $conn->query("update infoTable set id=".$index." where id=$i");
    }
  }
  

}

function deleteMultipleRows($min,$max,$tablename,$conn,$id){
  if (strcmp($tablename,"ppmTable") != 0){
    $last = $min + $max;
    for ($i = $min; $i < $last; $i++){
      $sql = "delete from $tablename where id=$i";
      $result = mysqli_query($conn, $sql);
    }
  }
  else{
    $first = (($id-1) * $min * $max * 4)+1;
    $last = $id * $min * $max * 4;
    echo $first . " " . $last. "<br>";
    for ($i = $first; $i <= $last; $i++){
      $sql = "delete from $tablename where id=$i";
      $result = mysqli_query($conn, $sql);
    }
  }
}


?>

