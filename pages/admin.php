<?php
session_start();
require_once('../includes/connection.php');

$page = $_GET['page'] ?? 'kullanicilar';

$stmt = $connection->prepare("SELECT * FROM user");
$stmt->execute();
$kullanicilar = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $connection->prepare("SELECT * FROM calisanlar");
$stmt->execute();
$calisanlar = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yönetim Paneli</title>
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Paneli</h2>
            <nav>
                <ul>
                    <li><a href="?page=kullanicilar" class="<?= $page === 'kullanicilar' ? 'active' : '' ?>"><i
                                class="fas fa-users"></i> Kullanıcılar</a></li>
                    <li><a href="?page=calisanlar" class="<?= $page === 'calisanlar' ? 'active' : '' ?>"><i
                                class="fas fa-user-md"></i> Çalışanlar</a></li>
                    <li><a href="?page=ekle" class="<?= $page === 'ekle' ? 'active' : '' ?>"><i
                                class="fas fa-plus-circle"></i> Yeni Çalışan Ekle</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-panel">
            <div class="topbar">
                <select>
                    <option>Kategori Seçin</option>
                    <option>Kullanıcılar</option>
                </select>
                <input type="date" value="<?= date('Y-m-d') ?>">
                <div class="topbar-icons">
                    <i class="fas fa-bell"></i>
                    <i class="fas fa-envelope"></i>
                    <img src="../assets/images/admin_avatar.png" class="avatar">
                </div>
            </div>

            <?php if ($page === 'kullanicilar'): ?>
            <section class="user-cards">
                <?php foreach ($kullanicilar as $k): ?>
                <div class="user-card">
                    <img src="../uploads/<?= htmlspecialchars($k['profil_resmi']) ?>" alt="Profil">
                    <div class="user-info">
                        <h3><?= ucfirst($k['u_adi']) . ' ' . ucfirst($k['u_soyadi']) ?></h3>
                        <p><strong>TC:</strong> <?= $k['u_tc'] ?></p>
                        <p><strong>Telefon:</strong> <?= $k['u_telefon'] ?></p>
                        <p><strong>Email:</strong> <?= $k['u_mail'] ?></p>
                        <p><strong>Doğum Tarihi:</strong> <?= $k['u_dogumtarih'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php elseif ($page === 'calisanlar'): ?>
            <h2>Çalışanlar</h2>
            <section class="user-cards">
                <?php foreach ($calisanlar as $c): ?>
                <div class="user-card">
                    <img src="../assets/images/admin_avatar.png" alt="Profil">
                    <div class="user-info">
                        <h3><?= ucfirst($c['c_adi']) . ' ' . ucfirst($c['c_soyadi']) ?></h3>
                        <p><strong>Mail:</strong> <?= $c['c_mail'] ?></p>
                        <p><strong>Tür:</strong> <?= $c['tur'] ?></p>
                        <p><strong>Uzmanlık:</strong> <?= $c['uzmanlik'] ?></p>
                        <p><strong>Çalışma Saatleri:</strong> <?= $c['calisma_saatleri'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>
            <?php elseif ($page === 'ekle'): ?>
            <h2>Yeni Çalışan Ekle</h2>

            <form action="calisan_ekle.php" method="POST" class="form-add">
                <div class="form-group">
                    <label for="c_adi">Adı</label>
                    <input type="text" id="c_adi" name="c_adi" required>
                </div>

                <div class="form-group">
                    <label for="c_soyadi">Soyadı</label>
                    <input type="text" id="c_soyadi" name="c_soyadi" required>
                </div>

                <div class="form-group">
                    <label for="c_mail">Mail</label>
                    <input type="email" id="c_mail" name="c_mail" required>
                </div>

                <div class="form-group">
                    <label for="c_sifre">Şifre</label>
                    <input type="text" id="c_sifre" name="c_sifre" required>
                </div>

                <div class="form-group">
                    <label for="tur">Görev Türü</label>
                    <select id="tur" name="tur" required>
                        <option value="">Seçiniz</option>
                        <option value="diyetisyen">Diyetisyen</option>
                        <option value="spor_egitmeni">Spor Eğitmeni</option>
                        <option value="doktor">Doktor</option>
                        <option value="hayat_kocu">Hayat Koçu</option>
                    </select>
                </div>

                <div class="form-group">
                    <h1>tekrar bak uzmanlık seçimle yapılmalı tablodada</h1>
                    <label for="uzmanlik">Uzmanlık</label>
                    <textarea id="uzmanlik" name="uzmanlik" rows="2" required></textarea>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="calisma_saatleri">Çalışma Saatleri</label>
                    <textarea placeholder="Çalışma Saatleri Gün-Saat Şeklinde (Hafta içi 12.00-18.00) şeklinde"
                        id="calisma_saatleri" name="calisma_saatleri" rows="2" required></textarea>
                </div>

                <button type="submit">Çalışanı Ekle</button>
            </form>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>