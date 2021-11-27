<HTML><BODY>
    <FORM method='post' action='index.php' enctype='multipart/form-data'>
        <input type='submit' value='RETURN' name='RETURN'>
    </FORM>

<?php
    require __DIR__ . '/createDatabase.php';
    //print_r($_POST);
    foreach($_POST as $val){
        $id = $val;
    }
    //
    $name = getFilename($id);
    $name = $name . "Data.js";
    showImage($name);


    //CREATE IMAGE
    function showImage($name){
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
            <script src="$name" ></script>
            </head>
    
            <body>
                <canvas id="glcanvas" width="640" height="480"></canvas>
            </body>
        __END;
    }
?>