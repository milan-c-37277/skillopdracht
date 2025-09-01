<?php
$host = 'mariadb';
$db   = 'skillsopdracht';
$username = 'web';
$password = 'admin';
$port = 3306;
$conn = new mysqli($host, $username, $password, $db, $port);

$sql = "SELECT * FROM projects";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Skillsopdracht</title>
  <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body>
  <aside>
    <div class="logo">
      <img src="./assets/img/logo-livingshapes.png" alt="Logo" />
    </div>
    <div class="contact-info">
      Interested?<br>
      Drop us an email at:<br>
      <a class="email" href="mailto:newbusiness@livingshapes.eu">newbusiness@livingshapes.eu</a>
    </div>
  </aside>

  <main class="grid-container">
    <?php foreach ($result as $row): ?>
      <div class="project" id="project-<?= htmlspecialchars($row['id']) ?>" draggable="true">
        <img class="main-img" src="assets/img/projects/<?= htmlspecialchars($row['image_main']) ?>" alt="Main Image" />
        <img class="hover-img" src="assets/img/projects/<?= htmlspecialchars($row['image_second']) ?>" alt="Hover Image" />
        <div class="overlay">
          <h3><?= htmlspecialchars($row['title']) ?></h3>
          <p><?= htmlspecialchars($row['city_location']) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </main>

  <script>
    const container = document.querySelector('.grid-container');
    let draggedItem = null;

    container.addEventListener('dragstart', (e) => {
      const project = e.target.closest('.project');
      if (!project) return;

      draggedItem = project;
      draggedItem.classList.add('dragging');
      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/plain', '');
    });

    container.addEventListener('dragover', (e) => {
      e.preventDefault();

      const target = e.target.closest('.project');
      if (!target || !draggedItem || target === draggedItem) return;

      const children = Array.from(container.querySelectorAll('.project'));
      const draggedIndex = children.indexOf(draggedItem);
      const targetIndex = children.indexOf(target);

      if (draggedIndex < targetIndex) {
        if (target.nextElementSibling) {
          container.insertBefore(draggedItem, target.nextElementSibling);
        } else {
          container.appendChild(draggedItem);
        }
      } else {
        container.insertBefore(draggedItem, target);
      }
    });

    container.addEventListener('drop', (e) => {
      e.preventDefault();
      if (draggedItem) {
        draggedItem.classList.remove('dragging');
        draggedItem = null;
      }
    });

    container.addEventListener('dragend', () => {
      if (draggedItem) {
        draggedItem.classList.remove('dragging');
        draggedItem = null;
      }
    });
  </script>
</body>
</html>
