<?php
/**
 * Licensed under The Apache License
 *
 * @copyright Copyright 2012-2013 Patrick Farnkopf, Tanja Weiser, Gabriel Wanzek (PaTaGa)
 * @link https://github.com/pataga/SAS
 * @since SAS v1.0.0
 * @license Apache License v2 (http://www.apache.org/licenses/LICENSE-2.0.txt)
 * @author Gabriel Wanzek
 * @version 1.0
 *
 */
?>
<?php
$hdds = $server->execute("df -h");
$kernel = $server->execute("uname -a");
$cpu = $server->execute("grep \"model name\" /proc/cpuinfo");
$distr = $server->execute("head -n1 /etc/issue");
$hdd = $server->execute("hdparm -i /dev/sda | head -n4", 2);
$hw_info_hw = $server->execute("lspci -vm", 2);
$hw_info_lw = $server->execute("lsblk -iln");

$meminfo = $server->execute("cat /proc/meminfo");        //für RAM-Info
$total = explode("\n", $meminfo);
$totalram = str_replace("MemTotal:", " ", $total[0]);
$totalram_ = str_replace("kB", " ", $totalram);
$totalram_a = $totalram / 1024;     //Umrechnung in MB

$cpu_ = str_replace("model name", "", $cpu);
$cpu_1 = str_replace(":", "<br>", $cpu_);
$distr_ = explode('\\', $distr);

$filter = array('Class:', 'Rev:', 'ProgIf:', 'SVendor:', 'SDevice:', 'Vendor:', 'Device:');
$ready = array('<b>Class:</b>', '<b>Rev:</b>', '<b>ProgIf:</b>', '<b>SVendor:</b>', '<b>SDevice:</b>', '<b>Vendor:</b>', '<b>Device:</b>');
?>

<h3>HW-Info</h3>
<div class="tabnav" >
    <ul class="tabl" id="tabs_ui">
        <li id="tab1" class="selected" onclick="tabs(this);">Hardware</li>
        <li id="tab2" onclick="tabs(this);">PCI-Geräte</li>
        <li id="tab3"  onclick="tabs(this);">HDD Status</li>
    </ul>
    <div id="tabcontent">
        <?php
        echo "<b>Kernel:</b> <code>" . $kernel . "</code><br><br>";
        echo "<b>Distribution:</b> " . $distr_[0] . "<br><br>";
        echo "<b>CPU(s):</b>" . $cpu_1 . "<br><br>";
        echo "<b>RAM Total:</b> " . round($totalram_a, 2) . " MB<br><br>";
        echo "<b>Partitionen:</b> <pre>" . $hw_info_lw . "</pre><br><br>";
        echo "<b>HDD (sda):</b> <pre>" .  isset($hdd[3]) ? "" : $hdd[3]  . "</pre><br><br>";
        ?>
    </div>
</div> 
<div id="tab1content" style="display:none;">
    <?php
    echo "<b>Kernel:</b> <code>" . $kernel . "</code><br><br>";
    echo "<b>Distribution:</b> " . $distr_[0] . "<br><br>";
    echo "<b>CPU</b>" . $cpu_ . "<br><br>";
    echo "<b>RAM Total:</b> " . round($totalram_a, 2) . " MB<br><br>";
    echo "<b>Partitionen:</b> <pre>" . $hw_info_lw . "</pre><br><br>";
    echo "<b>HDD (sda):</b> <pre>" . isset($hdd[3]) ?  "" : $hdd[3] . "</pre><br><br>";
    ?>
</div>
<div id="tab2content" style="display:none;">
    <?php
    foreach ($hw_info_hw as $value) {
        echo str_replace($filter, $ready, $value) . "<br>";
    }
    ?>
</div>
<div id="tab3content" style="display:none;">
    <pre><?php echo $hdds ?></pre>
</div>
<div class="clearfix"> <p>&nbsp;</p> </div>
