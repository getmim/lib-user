# lib-user

Adalah module dasar penyedia user pada aplikasi berbasis mim. Module ini tidak
bisa berdiri sendiri, dibutuhkan module user handler yang bertugas berhubungan
langsung dengan penyedia data user seperti `lib-user-main`, dan module authorizer
yang memparse request untuk menemukan informasi user yang melakukan request seperti
module `lib-user-auth-cookie`.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-user
```

## Penggunaan

Module ini membuat satu service dengan nama `user` yang bisa di panggil dari
aplikasi dengan perintah `$this->user->{method|property}`.

```php
// ...
   $this->user->isLogin();
   $this->user->id;
   $this->user->fullname;
   $this->user->logout();
//
```

## Method

Service user memilki beberapa method sebagai berikut:

### getAuthorizer(): ?string
### getByCredentials(string $identity, string $password): ?object
### getById(string $identity): ?object
### getSession(): ?object
### hashPassword(string $password): ?string
### isLogin(): bool
### logout(): void
### setAuthorizer(string $name)
### setUser(object $user): void
### verifyPassword(string $password, object $user): bool

## Custom Handler

Module ini membutuhkan user provider, module yang disediakan sampai saat ini adalah
module `lib-user-main` yang menyimpan data user di database.

Satu aplikasi hanya boleh memiliki satu user handler.

Handler harus mengimplementasikan interface `LibUser\Iface\Handler` dan mendaftarkan diri
pada konfigurasi seperti di bawah:

```php
return [
    'libUser' => [
        'handler' => 'Class'
    ]
];
```

User handler harus memiliki method-method sebagai berikut:

### getByCredentials(string $identity, string $password): ?object

Mengambil data user berdasarkan nama user ( email, phone, atau identitas lain ) dengan
password. Object user yang dikembalikan harus sama dengan struktur yang dikembalkan oleh
method `getById`.

### getById(string $identity): ?object

Mengambil user dengan pengenal identity, umumnya identity user adalah kolom `id` pada tabel.
Object user yang dikembalikan harus dalam format minimal seperti di bawah:

```php
$user = (object)[
    'id' => ::int,
    'name' => ::string,
    'fullname' => ::string,
    'password' => ::string,
    'avatar' => ::string,
    'status' => ::int
    'created' => ::string(Y-m-d H:i:s)
];
```

Dengan status user adalah sebagai berikut:

status | description
-------|-------------
0      | Deleted
1      | Suspended
2      | Unverified
3      | Verified

### hashPassword(string $password): ?string

Meng-hash password user.

### verifyPassword(string $password, object $user): bool

Mencoba kecocokan password yang di post user dengan password user yang asli.

## Custom Authorizer

Selain user provider, module ini juga membutuhkan module tambahan yang bertugas
meng-authorize user. Module ini bertugas mengidentifikasi user berdasarkan request
yang sedang berlangsung, atau menggenerasi session/token untuk seorang user berdasarkan
request dari user.

Dalam satu aplikasi mungkin memiliki beberapa authorizer, system akan mencoba satu
persatu sampai menemukan authorizer yang mengembalikan identitas user login. Jika tidak
ada authorizer yang mengembalikan data user login, maka user dianggap tidak login.

Semua user authorizer harus mengimplementasikan interface `LibUser\Iface\Authorizer` dan
mendaftarkan diri pada konfigurasi seperti di bawaah:

```php
return [
    'libUser' => [
        'authorizers' => [
            'name' => 'Class'
        ]
    ]
];
```

Masing-masing authorizer harus memiliki method sebagai berikut:

### getSession(): ?object

Fungsi untuk mengambil informasi session user yang sedang login. Secara umum, fungsi
ini mengembalikan informasi sebagai berikut:

```php
$session = (object)[
    'type' => 'cookie',
    'expires' => time() + 60,
    'token' => 'random-string'
];
```

### identify(): ?string

Mengidentifikasi user pada request yang sedang terjadi, jika user ditemukan, maka fungsi
ini diharapkan mengembalikan identitas user, pada umumnya nilai identitas user adalah 
kolom `id` pada tabel.

Fungsi ini sebaiknya menyimpan data session/token user untuk digunakan jika user akan
memanggil fungsi `logout`.

### loginById(string $identity): ?array

Fungsi untuk menset login user. Fungsi ini diharapkan mengembalikan object session/token
yang akan diteruskan ke user. Fungsi ini yang akan di panggil kontroler ketika user
sedang login. Masing-masing authorizer mungkin mengembalikan data array yang berbeda.

### logout(): void

Fungsi untuk menghilangkan session/token.