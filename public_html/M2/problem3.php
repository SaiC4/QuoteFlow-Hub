<?php
$a1 = [-1, -2, -3, -4, -5, -6, -7, -8, -9, -10];
$a2 = [-1, 1, -2, 2, 3, -3, -4, 5];
$a3 = [-0.01, -0.0001, -.15];
$a4 = ["-1", "2", "-3", "4", "-5", "5", "-6", "6", "-7", "7"];

function bePositive($arr) {
    echo "<br>Processing Array:<br><pre>" . var_export($arr, true) . "</pre>";
    echo "<br>Positive output:<br>";
    //TODO use echo to output all of the values as positive (even if they were originally positive) 
    //hint: may want to use var_dump() to show final data types
    //---------UCID: sjc65--------------
    //---------Date: 06/05/2023---------
    //Explanation: As the code iterates over each value in the array sets,
    //it checks to see if each value is positive or negative. If a value is
    //negative, then it is converted to a positive before adding them to a 
    //new array, which is then printed.
    $nums = count($arr);
    $pos = array();
    $x = 0;

    for ($i = 0; $i < $nums; $i++) {
        $pos[$x] = abs($arr[$i]);
        $x++;
    }
    echo var_dump($pos);
}
echo "Problem 3: Be Positive<br>";
?>
<table>
    <thread>
        <th>A1</th>
        <th>A2</th>
        <th>A3</th>
        <th>A4</th>
    </thread>
    <tbody>
        <tr>
            <td>
                <?php bePositive($a1); ?>
            </td>
            <td>
                <?php bePositive($a2); ?>
            </td>
            <td>
                <?php bePositive($a3); ?>
            </td>
            <td>
                <?php bePositive($a4); ?>
            </td>
        </tr>
</table>
<style>
    table {
        border-spacing: 2em 3em;
        border-collapse: separate;
    }

    td {
        border-right: solid 1px black;
        border-left: solid 1px black;
    }
</style>