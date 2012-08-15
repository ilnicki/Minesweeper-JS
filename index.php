<?php
define(LN_BREACK, "\n");
?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Minesweeper JS</title>
    <link href="data/css/main.css" rel="stylesheet" type="text/css">
    <link href="data/css/control.css" rel="stylesheet" type="text/css">
    <link href="data/css/field.css" rel="stylesheet" type="text/css">
    <script src="data/js/jquery.js" type="text/javascript"></script> 
    <script src="data/js/minesweeper.js" type="text/javascript"></script>
    <script src="data/js/ui.js" type="text/javascript"></script>
  </head>
  <body>
    <div class="board centered">
<?php
$width = 5;
$height = 5;

function buildField($width, $height)
{
    echo '        <div class="field">'.LN_BREACK;
    
    for($i = $height; $i >= 1; $i--)
    {
        echo '            <div class="line f_line_'.$i.'">'.LN_BREACK;
        
        for($j = 1; $j <= $width; $j++)
        {
            echo '              <div class="cell cell_'.$j.' button"></div>'.LN_BREACK;
        }
        
        echo '            </div>'.LN_BREACK;
    }
    
    echo '        </div>'.LN_BREACK;
}

buildField($width, $height);
?>
        <div class="controls">
            <div class="line c_line_1">
                <div class="empty"></div>
                <div class="control button" id="up"></div>
                <div class="empty"></div>
            </div>
            <div class="line c_line_2">
                <div class="control button" id="left"></div>
                <div class="control button" id="flag"></div>
                <div class="control button" id="right"></div>
            </div>
            <div class="line c_line_3">
                <div class="empty"></div>
                <div class="control button" id="down"></div>
                <div class="empty"></div>
            </div>
        </div>
    </div>    
  </body>
</html>