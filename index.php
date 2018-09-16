<style type="text/css">@import url("style.css");</style>
<a href="<?php echo $_SERVER["REQUEST_URI"];?>">Refresh</a>
<br><br>
<?php
error_reporting(-1);
include "./_pdo.php";
include "inc/Parser.php";

$db_file = "./verbs_db.db";
PDO_Connect("sqlite:$db_file");

$data = PDO_FetchAll("SELECT * FROM words");
echo "<pre>";
print_r ($data);
echo "</pre>";

$pars = new Parser();
$result = "";
if(isset($_POST['submit']))
{
    //$result = $pars->getresult($_POST['in_word'])
    $result = $pars->getResult();
}

?>
<div style="width: 300px">
<form method="post">
    <table align="left">
        <tr>
            <td><h1>Глаголы</h1></td>
        </tr>
        <tr>
            <td>Входные данные:</td>
            <td><input type="text" name="in_word"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value = "Преобразовать"></td>
        </tr>
        <tr>
            <td><strong>Результат:<strong></td>
            <td><?php echo $result; ?></td>
        </tr>
        <tr>
        </tr>
    </table>

</form>
<table align="left">
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td></td></tr>
    <tr><td><b>Слова на вход:</b></td></tr>
    <tr><td></td></tr>
    <tr><td>повольн_одУмьсктоу(а)тi_#</td></tr>
    <tr><td>въкеУвьсктвоу(а)тi_# сьн</td></tr>
    <tr><td>възкеУвьсктвоу(а)тi_#</td></tr>
</table>
</div>