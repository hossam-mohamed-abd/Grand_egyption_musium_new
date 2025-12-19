<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | GEM</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 20px;
    }

    h1 {
      margin-bottom: 20px;
    }

    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .card h2 {
      margin: 0;
      font-size: 32px;
      color: #2c3e50;
    }

    .card p {
      margin-top: 8px;
      color: #777;
    }

    .actions {
      margin-bottom: 20px;
    }

    .actions button {
      padding: 10px 20px;
      margin-right: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      background: #2c3e50;
      color: white;
    }

    .section {
      display: none;
      background: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th,
    td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    select {
      padding: 5px;
    }

    .delete-btn {
      background: crimson;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
    }

    .add-form input {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
    }

    .add-form button {
      background: #27ae60;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <h1>Admin Dashboard – Grand Egyptian Museum</h1>

  <div class="stats">
    <div class="card">
      <h2><?= $usersCount ?></h2>
      <p>Total Users</p>
    </div>
    <div class="card">
      <h2><?= $plansCount ?></h2>
      <p>Visit Plans</p>
    </div>
    <div class="card">
      <h2>—</h2>
      <p>Total Bookings</p>
    </div>
  </div>

  <div class="actions">
    <button onclick="showSection('users')">Users</button>
    <button onclick="showSection('plans')">Visit Plans</button>
  </div>

  <div id="users" class="section">
    <h2>Manage Users</h2>

    <table>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
      </tr>

      <?php foreach ($users as $user): ?>
        <tr>
          <td><?= htmlspecialchars($user['name']) ?></td>
          <td><?= htmlspecialchars($user['email']) ?></td>

          <td>
            <form action="<?= BASE_URL ?>admin/users/update-role" method="POST">

              <input type="hidden" name="id" value="<?= $user['id'] ?>">

              <select name="role">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>user</option>
                <option value="restaurant" <?= $user['role'] === 'restaurant' ? 'selected' : '' ?>>restaurant</option>
              </select>
          </td>

          <td>
            <button type="submit">Save</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>

    </table>
  </div>

  <div id="plans" class="section">
    <h2>Visit Plans</h2>

    <table>
      <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Action</th>
      </tr>

      <?php foreach ($plans as $plan): ?>
        <tr>
          <td><?= htmlspecialchars($plan['name']) ?></td>
          <td><?= htmlspecialchars($plan['description']) ?></td>
          <td>
            <form action="<?= BASE_URL ?>admin/plans/delete" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this plan?');">

              <input type="hidden" name="id" value="<?= $plan['id'] ?>">

              <button type="submit" class="delete-btn">Delete</button>
            </form>
          </td>

        </tr>
      <?php endforeach; ?>

    </table>

    <h3 style="margin-top:20px;">Add New Plan</h3>

    <form class="add-form" action="<?= BASE_URL ?>admin/plans/store" method="POST" enctype="multipart/form-data">

      <input type="text" name="name" placeholder="Name" required>
      <input type="text" name="description" placeholder="Description" required>
      <input type="text" name="duration" placeholder="Duration (e.g. Half Day)" required>
      <input type="number" name="halls_count" placeholder="Halls Count" required>
      <input type="number" name="price" placeholder="Price" required>
      <input type="file" name="image" accept="image/*" required>

      <button type="submit">Add Plan</button>
    </form>

  </div>

  <script>
    function showSection(id) {
      document.getElementById('users').style.display = 'none';
      document.getElementById('plans').style.display = 'none';
      document.getElementById(id).style.display = 'block';
    }
  </script>

</body>

</html>