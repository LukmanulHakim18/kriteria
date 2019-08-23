<p align="center">
 <a href="https://topapp.id" target="_blank">
        <img src="https://topapp.id/admin/images/profil/logo.png" height="250px">
    </a>
    <h1 align="center">Sistem Mutu Universitas 9 Kriteria</h1>
    <br/>
</p>
   


Sistem Mutu Universitas adalah aplikasi untuk mengisi data akreditasi dan monitoring.

Struktur Folder
-------------------

```
admin
    assets/              contains application assets such as JavaScript and CSS
    config/              contains akreditasi configurations
    controllers/         contains Web controller classes
    models/              contains akreditasi-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for akreditasi application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains akreditasi widgets
akreditasi
    assets/              contains application assets such as JavaScript and CSS
    config/              contains akreditasi configurations
    controllers/         contains Web controller classes
    models/              contains akreditasi-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for akreditasi application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains akreditasi widgets
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
monitoring
    assets/              contains application assets such as JavaScript and CSS
    config/              contains monitoring configurations
    controllers/         contains Web controller classes
    models/              contains monitoring-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for monitoring application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```

## Cara Instalasi
1. Download dan install [VirtualBox](https://www.virtualbox.org/wiki/Downloads).
2. Download dan install [vagrant](https://www.vagrantup.com/).
3. Create Github [Personal API Token](https://github.com/blog/1509-personal-api-tokens).
4. Clone Repository dengan cara `git clone https://github.com/adryanev/mutu.git`.
5. Copy `vagrant/config/vagrant.local.example.yml` menjadi `vagrant/config/vagrant.local.yml`.
6. Ganti Personal Api token di `vagrant/config/vagrant.local.yml`.
7. Jalankan command `vagrant plugin install vagrant-hostmanager` `vagrant up`.
8. Jalankan `php yii migrate` & `php yii auth/up`
8. Tambahkan hosts file. 
```
192.168.2.1 monitoring.mutu.test
192.168.2.1 akreditasi.mutu.test
192.168.2.1 admin.mutu.test
```
## Cara Kontribusi
Silahkan baca di [CONTRIBUTE.md](CONTRIBUTE.md)

## Lisensi
1. Yii2: New BSD-3-Clause License [LICENSE.md](LICENSE.md)
2. Sistem Mutu: TopApp.id

## Catatan Perubahan
Silahkan lihat di [CHANGELOG.md](CHANGELOG.md)