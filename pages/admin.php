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

$secili_tur = $_POST['tur'] ?? '';
$uzmanliklar = [
    'diyetisyen' => ['Kilo Verme', 'Kilo Alma', 'Obezite', 'Diyabet'],
    'spor_egitmeni' => ['Kas Gelişimi', 'Kardiyo', 'Esneklik', 'Fitness'],
    'doktor' => ['Beslenme', 'Genel Sağlık', 'İç Hastalıklar', 'Check-up'],
    'hayat_kocu' => ['Motivasyon', 'Hedef Belirleme', 'Ruhsal Gelişim', 'Stres Yönetimi'],
];
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
            <?php if ($page === 'kullanicilar'): ?>
                <h2>Kullanıcılar</h2>
            <section class="user-cards">
                <?php foreach ($kullanicilar as $k): ?>
                <div class="user-card">
                    <img src="<?= !empty($c['profil_resmi']) ? '../uploads/' . htmlspecialchars($c['profil_resmi']) : 'assets/images/default.png' ?>" alt="Profil Resmi">

                    <div class="user-info">
                        <h3><?= ucfirst($k['u_adi']) . ' ' . ucfirst($k['u_soyadi']) ?></h3>
                        <p><strong>TC:</strong> <?= $k['u_tc'] ?></p>
                        <p><strong>Telefon:</strong> <?= $k['u_telefon'] ?></p>
                        <p><strong>Email:</strong> <?= $k['u_mail'] ?></p>
                        <p><strong>Doğum Tarihi:</strong> <?= $k['u_dogumtarih'] ?></p>
                        <div class="card-actions">
                            <a href="kullanici_guncelle.php?id=<?= $k['u_id'] ?>" class="btn btn-edit">Güncelle</a>
                            <a href="kullanici_sil.php?id=<?= $k['u_id'] ?>" class="btn btn-delete"
                                onclick="return confirm('Kullanıcıyı silmek istediğinize emin misiniz?');">Sil</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>

            <?php elseif ($page === 'calisanlar'): ?>
            <h2>Çalışanlar</h2>
            <section class="user-cards">
                <?php foreach ($calisanlar as $c): ?>
                <div class="user-card">
                    <div class="user-info">
                        <h3><?= ucfirst($c['c_adi']) . ' ' . ucfirst($c['c_soyadi']) ?></h3>
                        <p><strong>Mail:</strong> <?= $c['c_mail'] ?></p>
                        <p><strong>Tür:</strong> <?= $c['tur'] ?></p>
                        <p><strong>Uzmanlık:</strong> <?= $c['uzmanlik'] ?></p>
                        <p><strong>Çalışma Saatleri:</strong> <?= $c['calisma_saatleri'] ?></p>
                        <div class="card-actions">
                            <a href="calisan_guncelle.php?id=<?= $c['c_id'] ?>" class="btn btn-edit">Güncelle</a>
                            <a href="calisan_sil.php?id=<?= $c['c_id'] ?>" class="btn btn-delete"
                                onclick="return confirm('Çalışanı silmek istediğinize emin misiniz?');">Sil</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </section>

            <?php elseif ($page === 'ekle'): ?>
            <h2>Yeni Çalışan Ekle</h2>
            <?php $secili_tur = $_GET['tur'] ?? ''; ?>

            <form action="calisan_ekle.php" method="POST" class="form-add" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="tur">Görev Türü</label>
                    <select id="tur" name="tur" required
                        onchange="window.location.href='?page=ekle&tur=' + this.value;">
                        <option value="">Seçiniz</option>
                        <?php foreach ($uzmanliklar as $key => $val): ?>
                        <option value="<?= $key ?>" <?= $secili_tur === $key ? 'selected' : '' ?>>
                            <?= ucfirst(str_replace('_', ' ', $key)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($secili_tur)): ?>
                <div class="form-group">
                    <label for="uzmanlik">Uzmanlık</label>
                    <select id="uzmanlik" name="uzmanlik" required>
                        <?php foreach ($uzmanliklar[$secili_tur] as $uzman): ?>
                        <option value="<?= $uzman ?>"><?= $uzman ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php else: ?>
                <div class="form-group">
                    <label for="uzmanlik">Uzmanlık</label>
                    <select id="uzmanlik" name="uzmanlik" disabled>
                        <option>Önce görev türü seçin</option>
                    </select>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="c_adi">Adı</label>
                    <input type="text" id="c_adi" name="c_adi" value="<?= $_POST['c_adi'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="c_soyadi">Soyadı</label>
                    <input type="text" id="c_soyadi" name="c_soyadi" value="<?= $_POST['c_soyadi'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="c_mail">Mail</label>
                    <input type="email" id="c_mail" name="c_mail" value="<?= $_POST['c_mail'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label for="c_sifre">Şifre</label>
                    <input type="text" id="c_sifre" name="c_sifre" value="<?= $_POST['c_sifre'] ?? '' ?>" required>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="calisma_saatleri">Çalışma Saatleri</label>
                    <textarea id="calisma_saatleri" name="calisma_saatleri" rows="2"
                        required><?= $_POST['calisma_saatleri'] ?? '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="telefon">Telefon</label>
                    <input type="text" id="telefon" name="telefon" value="<?= $_POST['telefon'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="mezuniyet">Mezuniyet</label>
                    <input type="text" id="mezuniyet" name="mezuniyet" value="<?= $_POST['mezuniyet'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="deneyim">Deneyim</label>
                    <input type="text" id="deneyim" name="deneyim" value="<?= $_POST['deneyim'] ?? '' ?>">
                </div>

                <div class="form-group">
                    <label for="sertifikalar">Sertifikalar</label>
                    <input type="text" id="sertifikalar" name="sertifikalar"
                        value="<?= $_POST['sertifikalar'] ?? '' ?>">
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="aciklama">Açıklama</label>
                    <textarea id="aciklama" name="aciklama" rows="3"><?= $_POST['aciklama'] ?? '' ?></textarea>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="profil_resmi">Profil Resmi</label>
                    <input type="file" id="profil_resmi" name="profil_resmi" accept="image/*">
                </div>

                <button type="submit">Çalışanı Ekle</button>
            </form>
            <?php endif; ?>
        </main>
    </div>
</body>

</html>