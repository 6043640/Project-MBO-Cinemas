<?php
session_start();
require_once '../config/database.php';
require_once '../classes/Reservering.php';

$db = (new Database())->connect();
$reservering = new Reservering($db);
$klant_id = $_SESSION['user_id'];

$reserveringen = $reservering->getByKlant($klant_id);
?>

<table>
    <tr>
        <th>Film</th>
        <th>Aantal kaartjes</th>
        <th>Status</th>
        <th>Actie</th>
    </tr>
    <?php foreach ($reserveringen as $res): ?>
    <tr>
        <td><?= htmlspecialchars($res['film_id']) ?></td>
        <td>
            <form method="post" action="update_reservering.php">
                <input type="number" name="aantal" value="<?= $res['aantal_kaartjes'] ?>" min="1">
                <input type="hidden" name="res_id" value="<?= $res['id'] ?>">
                <button type="submit">Wijzig</button>
            </form>
        </td>
        <td><?= htmlspecialchars($res['status']) ?></td>
        <td>
            <form method="post" action="annuleer_reservering.php">
                <input type="hidden" name="res_id" value="<?= $res['id'] ?>">
                <button type="submit">Annuleer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
