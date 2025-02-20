<?php
require_once(__DIR__ . '/../config/init.php');

$controller = new TachesController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titre']) && isset($_POST['description'])) {
    $tache = new Taches(null, $_POST['titre'], $_POST['description'], 0);
    $controller->ajouterTache($tache);
    echo json_encode(["status" => "success"]);
    exit;
}

if (isset($_GET['changer_statut'])) {
    $controller->changerStatut($_GET['changer_statut'], 1);
    header("Location: home.php");
}

if (isset($_GET['supprimer'])) {
    $controller->supprimerTache($_GET['supprimer']);
    header("Location: home.php");
}

$taches = $controller->getTaches();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tâches</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-4">Ajouter une Tâche</h2>
        <form id="taskForm" class="flex space-x-2">
            <input type="text" name="titre" id="titre" placeholder="Titre" required class="flex-1 p-2 border rounded">
            <input type="text" name="description" id="description" placeholder="Description" required class="flex-1 p-2 border rounded">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
        </form>

        <h2 class="text-2xl font-bold mt-6 mb-4">Liste des Tâches</h2>
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-2">ID</th>
                    <th class="p-2">Titre</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Statut</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody id="taskList">
                <?php foreach ($taches as $tache): ?>
                <tr class="border hover:bg-gray-100 transition">
                    <td class="p-2"><?= $tache->getId(); ?></td>
                    <td class="p-2"><?= htmlspecialchars($tache->getTitre()); ?></td>
                    <td class="p-2"><?= htmlspecialchars($tache->getDescription()); ?></td>
                    <td class="p-2">
                        <?= ($tache->getStatus() == 0) ? "<span class='text-red-500'>À faire</span>" : "<span class='text-green-500'>Terminé</span>"; ?>
                    </td>
                    <td class="p-2">
                        <?php if ($tache->getStatus() == 0): ?>
                            <a href="?changer_statut=<?= $tache->getId(); ?>" class="text-blue-500">✔ Terminer</a>
                        <?php endif; ?>
                        <a href="#" class="text-red-500 deleteTask" data-id="<?= $tache->getId(); ?>">🗑 Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("taskForm").addEventListener("submit", function (e) {
                e.preventDefault();
                
                let formData = new FormData(this);
                
                fetch("home.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        location.reload();  
                    }
                });
            });

            document.querySelectorAll(".deleteTask").forEach(button => {
                button.addEventListener("click", function (e) {
                    e.preventDefault();
                    let taskId = this.getAttribute("data-id");

                    if (confirm("Supprimer cette tâche ?")) {
                        window.location.href = "?supprimer=" + taskId;
                    }
                });
            });
        });
    </script>

</body>
</html>
