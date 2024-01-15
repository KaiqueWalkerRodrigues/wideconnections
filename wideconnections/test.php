<?php
    if(isset($_POST['btnTestar'])){
        echo $_POST['test'];
    }
?>
<form action="?" method="post">
    Expira em :
    <input type="date" name="test" id="test">
    <button type="submit" name="btnTestar" id="btnTestar">Testar</button>
</form>