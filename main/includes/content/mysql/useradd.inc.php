 <h3 class="ubuntu">MySQL Benutzer anlegen</h3> 
<form action="?p=mysql&s=adduser">
    <table>
        <tr><td> Benutzername </td><td><input type="text" name="user"></td>
        <tr><td> Passwort </td><td><input type="password" name="pass"></td>
        <tr><td> Passwort WDH </td><td><input type="password" name="passr"></td>
        <tr><td> Vollzugriff? </td><td><select name="admin">
            <option value="0">Nein</option>
            <option value="1">Ja</option>
        </select></td>
        <tr><td>&nbsp;</td><td><input class="button white" type="submit" name="adduser" value="Benutzer anlegen"></td>
    </table>
</form>