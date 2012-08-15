var lastElement;

$(document).ready(function()
{
    sendControls("load");
    
    $(".controls .control").click(function() 
    {
        sendControls(this.id);
    });
});

function sendControls(action)
{
    $.getJSON("core/minesweeper/", {keydown: action}, function(data) 
    {
        processToDoList(data.todo);
    });
}

function processToDoList(list)
{
    for (var taskNum in list) 
    {
        task = list[taskNum];
        element = getCellElementByCoord(task.x, task.y);
        
        switch(task.taskName)
        {
            case "movePointer":
                movePointer(element);
                break;
            case "putFlag":
                putFlag(element);
                break;
            case "clearCell":
                clearCell(element);
                break;
            
        }
    }
    //setChangedCell(data.todo.1.x, data.todo.1.y);
}

function movePointer(element)
{
    if(lastElement != null)
    {
        lastElement.empty();
    }
    
    lastElement = element;
    element.html('<img src="data/images/cell_cursor.png" />');
}

function putFlag(element)
{
    element.css("background-position","-86px");
}


function clearCell(element)
{
    element.css("background-position","0px");
}

function getCellElementByCoord(x, y)
{
    return $(".f_line_" + y + " .cell_" + x);
}