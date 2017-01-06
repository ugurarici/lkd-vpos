# lkd-vpos
Türkiye Linux Kullanıcıları Derneği için 2017 itibari ile kullanılacak bağış - aidat ödeme sayfası geliştirmesi

## Kurulum
Kurulumun uygulanacağı makinede composer kurulu olmalıdır
```composer install``` ile gerekli bağımlılıkların indirilmesi ve kurulması sağlanır.

```config.example.php``` dosyası ```config.php``` ismiyle kopyalanır ve içindeki tanımlamalarda gerekli ayarlar yapılır

```lkd-vpos.sql``` dosyası veritabanına aktarılır ve yapısının kurulması sağlanır (veritabanı ayarlarını config.php'de girmiş olmalıyız)

## Nasıl çalışır?
```index.php``` kullanıcının doğrudan tarayıcısından erişmesi gereken tek sayfadır. Geri kalan tüm işlemler bu sayfadaki hareketlere göre javascript ile back-end'e sorulur ve sonucu gösterilir

Sistem temelde şu adımları uygular;

* Girilen bilgilerin temel geçerliliği ön yüzde kontrol edilir
* Girilen bilgilerin geçerliliği arka tarafta kontrol edilir (PaymentInformationValidation)
* Gelen talepteki bilgilerle ödeme denemesi kaydedilir (Payment)
* Eldeki ödeme objesi kullanılarak sanal postan ödeme alınması denenir (PaymentVPOS)
* Ödemenin başarılı olduğuna ilişkin e-postalar gönderilir (PaymentMailer)
* Ön yüzde json olarak alınan yanıt yorumlanarak modal içinde gösterilir

## Notlar
- Ön yüz dosyalarının düzenlenmesi, dış kaynaklı js ve css dosyalarının içeri alınması, bu varlıkların proje dizinlerine organize bir şekilde yerleştirilmesi sağlanabilir
- Güvenlik tarafı için yetkili bi abiye gösterilebilir