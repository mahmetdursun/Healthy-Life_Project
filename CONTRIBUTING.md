# 🤝 Katkı Rehberi / Contribution Guide

Bu proje ekip çalışması için hazırlanmıştır. Aşağıdaki adımlar, projeye nasıl katkı sağlayabileceğinizi açıklar.

---

## 🧲 Projeyi Klonlama / Clone the Project

```bash
git clone https://github.com/mahmetdursun/Healthy-Life_Project.git
cd Healthy-Life_Project


⚙️ Değişiklik Yapma Süreci / Making Changes

1-Her zaman en güncel hal ile başla:
git pull origin main

2-Gerekli düzenlemeleri yaptıktan sonra(kodu güncelledikten sonra).

3-Değişiklikleri sahnele:
git add .

4-Commit mesajını yaz (Artık neyi güncellediysen açıklama olarak hem türkçe hem ingilizce yaz, "" olan yere yazılacak):
git commit -m "Özellik eklendi: kullanıcı giriş ekranı"

5-GitHub’a gönder:
git push origin main


## 🗃️ Veritabanını Yükleme / Importing the Database

Proje klasöründeki `sql/healthylife.sql` dosyasını phpMyAdmin üzerinden içe aktararak veritabanını kullanıma hazır hale getirebilirsiniz.

1. `http://localhost/phpmyadmin` adresine gidin.
2. Yeni bir veritabanı oluşturun: **`healthylife`**
3. Üst menüden **"İçe Aktar"** sekmesine tıklayın.
4. `sql/healthylife.sql` dosyasını seçin.
5. Sayfanın alt kısmındaki **Git** butonuna tıklayın.
