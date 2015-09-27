<h1>Hello <?= htmlentities($data->getUsername(), ENT_HTML5)?></h1>
<h3>Resources</h3>
<p>Gold: <?= htmlentities($data->GetGold(), ENT_HTML5) ?></p>
<p>Good: <?= htmlentities($data->GetFood(), ENT_HTML5) ?></p>

<p>Update profile</p>
<form action="#" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">

    <label for="pw">Password:</label>
    <input type="password" name="password" id="pw">

    <label for="confirm-pw">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm-pw">

    <input type="hidden" name="token">
    <input type="submit" value="Edit" name="edit">
</form>

<a href="buildings.php">Buildings</a>

<?php if (isset($_GET['error'])):?>
    <h2>An error occurred</h2>
<?php elseif(isset($_GET['success'])): ?>
    <h2>Successfully updated profile</h2>
<?php endif; ?>
