<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion des visiteurs</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: space-between;
      padding: 20px;
      background-color: #f5f5f5;
      margin: 0;
    }
    
    .form-section, .display-section {
      width: 48%;
      border: 1px solid #ddd;
      padding: 25px;
      border-radius: 12px;
      background-color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .form-section {
      border-left: 5px solid #3498db;
    }
    
    .display-section {
      border-left: 5px solid #2ecc71;
    }
    
    h2 {
      color: #2c3e50;
      border-bottom: 2px solid #eee;
      padding-bottom: 10px;
      margin-top: 0;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #34495e;
    }
    
    input[type="text"],
    input[type="email"],
    select {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 2px solid #ddd;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
      transition: border-color 0.3s;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    select:focus {
      border-color: #3498db;
      outline: none;
    }
    
    button[type="submit"] {
      background-color: #3498db;
      color: white;
      padding: 14px 28px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
    }
    
    button[type="submit"]:hover {
      background-color: #2980b9;
    }
    
    .visitor-entry {
      margin-bottom: 15px;
      padding: 20px;
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      border-radius: 8px;
      border-left: 4px solid #3498db;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .visitor-entry strong {
      color: #2c3e50;
      display: inline-block;
      width: 120px;
    }
    
    .visitor-entry span {
      color: #34495e;
    }
    
    .visitor-entry button {
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      margin-right: 10px;
    }
    
    .edit-btn {
      background-color: #2ecc71;
      color: white;
    }
    
    .edit-btn:hover {
      background-color: #27ae60;
      transform: translateY(-2px);
    }
    
    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }
    
    .delete-btn:hover {
      background-color: #c0392b;
      transform: translateY(-2px);
    }
    
    #emptyMessage {
      text-align: center;
      color: #7f8c8d;
      font-style: italic;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 6px;
      border: 2px dashed #bdc3c7;
    }
    
    #visitorCount {
      font-weight: bold;
      color: #e74c3c;
      font-size: 1.2em;
    }
    
    .display-section > p {
      color: #2c3e50;
      font-size: 16px;
      margin-bottom: 20px;
    }
    
    .section-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
  </style>
</head>
<body>

<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root"; // À modifier selon votre configuration
$password = ""; // À modifier selon votre configuration
$dbname = "gestion_visiteurs"; // À modifier selon votre configuration

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Traitement du formulaire d'ajout
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $nationality = $_POST['nationality'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $zone = $_POST['zone'] ?? '';
    
    // Insertion dans la base de données
    $stmt = $conn->prepare("INSERT INTO visiteurs (nom, email, nationalite, sexe, zone) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $nationality, $gender, $zone);
    
    if ($stmt->execute()) {
        echo "<script>console.log('Visiteur ajouté avec succès en base de données');</script>";
    } else {
        echo "<script>console.error('Erreur lors de l\'ajout en base de données');</script>";
    }
    
    $stmt->close();
}
?>

  <div class="form-section">
    <h2>Formulaire d'Inscription</h2>
    <form id="visitorForm" method="POST" action="">
      <label>Nom et Post-nom:</label>
      <input type="text" id="name" name="name" required placeholder="">
      
      <label>E-mail:</label>
      <input type="email" id="email" name="email" required placeholder="">
      
      <label>Nationalité:</label>
      <input type="text" id="nationality" name="nationality" required placeholder="">
      
      <label>Zone disponible pour vos visites:</label>
      <select id="zone" name="zone" required>
        <option value="">-- Choisissez votre zone --</option>
        <option value="AU NORD DU PARC">AU NORD DU PARC</option>
        <option value="AU SUD DU PARC">AU SUD DU PARC</option>
        <option value="À L'EST DU PARC">À L'EST DU PARC</option>
      </select>
      
      <label>Sexe:</label>
      <select id="gender" name="gender" required>
        <option value="">-- Choisissez votre sexe --</option>
        <option value="Homme">Homme</option>
        <option value="Femme">Femme</option>
        <option value="Autre">Autre</option>
      </select>
      
      <button type="submit">Inscrivez-vous</button>
    </form>
  </div>

  <div class="display-section">
    <div class="section-title">
      <h2>Liste des Visiteurs</h2>
      <p>Nombre des visiteurs: <span id="visitorCount">0</span></p>
    </div>
    <p id="emptyMessage">Votre gestion des visiteurs est vide !</p>
    <div id="visitorList"></div>
  </div>

  <script>
    const form = document.getElementById('visitorForm');
    const visitorList = document.getElementById('visitorList');
    const visitorCount = document.getElementById('visitorCount');
    const emptyMessage = document.getElementById('emptyMessage');

    let count = 0;

    // Charger les visiteurs existants depuis la base de données au démarrage
    window.onload = function() {
        loadVisitorsFromDatabase();
    };

    form.addEventListener('submit', function(event) {
      event.preventDefault();

      const name = document.getElementById('name').value;
      const email = document.getElementById('email').value;
      const nationality = document.getElementById('nationality').value;
      const zone = document.getElementById('zone').value;
      const gender = document.getElementById('gender').value;

      // Ajouter à l'affichage
      addVisitor(name, email, nationality, zone, gender);
      
      // Envoyer les données au serveur via AJAX
      saveToDatabase(name, email, nationality, zone, gender);
      
      form.reset();
    });

    function addVisitor(name, email, nationality, zone, gender) {
      const entry = document.createElement('div');
      entry.className = 'visitor-entry';

      entry.innerHTML = `
        <strong>Nom:</strong> <span class="name">${name}</span><br>
        <strong>Email:</strong> <span class="email">${email}</span><br>
        <strong>Nationalité:</strong> <span class="nationality">${nationality}</span><br>
        <strong>Zone:</strong> <span class="zone">${zone}</span><br>
        <strong>Sexe:</strong> <span class="gender">${gender}</span><br><br>
        <button class="edit-btn" onclick="editVisitor(this)">Modifier</button>
        <button class="delete-btn" onclick="deleteVisitor(this)">Supprimer</button>
      `;

      visitorList.appendChild(entry);
      count++;
      visitorCount.textContent = count;
      emptyMessage.style.display = 'none';
    }

    function saveToDatabase(name, email, nationality, zone, gender) {
      // Envoyer les données au serveur via AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          console.log("Données sauvegardées en base de données");
        }
      };
      
      const data = `name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&nationality=${encodeURIComponent(nationality)}&zone=${encodeURIComponent(zone)}&gender=${encodeURIComponent(gender)}`;
      xhr.send(data);
    }

    function loadVisitorsFromDatabase() {
      // Charger les visiteurs existants via AJAX
      const xhr = new XMLHttpRequest();
      xhr.open("GET", "?action=load", true);
      
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          try {
            const visitors = JSON.parse(xhr.responseText);
            visitors.forEach(visitor => {
              addVisitor(visitor.nom, visitor.email, visitor.nationalite, visitor.zone || '', visitor.sexe);
            });
          } catch(e) {
            console.log("Aucun visiteur en base de données ou erreur de chargement");
          }
        }
      };
      
      xhr.send();
    }

    function deleteVisitor(button) {
      const entry = button.parentElement;
      entry.remove();
      count--;
      visitorCount.textContent = count;
      if (count === 0) {
        emptyMessage.style.display = 'block';
      }
    }

    function editVisitor(button) {
      const entry = button.parentElement;
      const name = entry.querySelector('.name').textContent;
      const email = entry.querySelector('.email').textContent;
      const nationality = entry.querySelector('.nationality').textContent;
      const zone = entry.querySelector('.zone').textContent;
      const gender = entry.querySelector('.gender').textContent;

      document.getElementById('name').value = name;
      document.getElementById('email').value = email;
      document.getElementById('nationality').value = nationality;
      document.getElementById('zone').value = zone;
      document.getElementById('gender').value = gender;

      entry.remove();
      count--;
      visitorCount.textContent = count;
      if (count === 0) {
        emptyMessage.style.display = 'block';
      }
    }
  </script>

<?php
// Chargement des visiteurs pour AJAX
if (isset($_GET['action']) && $_GET['action'] == 'load') {
    $sql = "SELECT nom, email, nationalite, sexe, zone FROM visiteurs ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $visitors = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $visitors[] = $row;
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode($visitors);
    exit();
}

$conn->close();
?>

</body>
</html>