<h1>Buildings</h1>

<h3>Resources:</h3>

<p>Gold: <?= htmlentities($data->getUser()->getGold(), ENT_HTML5); ?></p>
<p>Food: <?= htmlentities($data->getUser()->getFood(), ENT_HTML5);?></p>

<table border="1">
    <tr>
        <td>Building name</td>
        <td>Level</td>
        <td>Gold</td>
        <td>Food</td>
        <td>Action</td>
    </tr>
    <?php foreach($data->getBuildings() as $building):?>
        <tr>
            <td><?=htmlentities($building['name'], ENT_HTML5)?></td>
            <td><?=htmlentities($building['level'] > 3 ? "MAX" : $building['level'], ENT_HTML5)?></td>
            <td><?=htmlentities($building['gold'], ENT_HTML5)?></td>
            <td><?=htmlentities($building['food'], ENT_HTML5)?></td>
            <td><a href="buildings.php?id=<?=htmlentities($building['building_id'], ENT_HTML5)?>">Build</a></td>
        </tr>
    <?php endforeach; ?>
    <input type="hidden" name="token">
</table>