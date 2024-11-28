<?php
use Web\Auth;

class LoginTest extends \PHPUnit\Framework\TestCase{
    private $auth;
    private $dbMock;

    protected function setUp(): void
    {
        // Mock untuk PDO
        $this->dbMock = $this->createMock(PDO::class);
        $this->auth = new Auth($this->dbMock);
        
        // Mulai sesi untuk pengujian
        session_start();
    }

    public function testLoginAdminBerhasil()
    {
        $nik = '1234567890';
        $password = 'admin123';

        // mock untuk mengembalikan data pegawai
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['nik' => $nik, 'password' => $password, 'id_jenis' => 1]);
        $stmtMock->method('rowCount')->willReturn(1);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        // memanggil metode login dengan NIK dan password yang benar
        $result = $this->auth->login($nik, $password);

        $this->assertTrue($result);
        $this->assertEquals($_SESSION['namaPegawai'], $nik);
        $this->assertEquals($_SESSION['id_jenis'], 1);
    }
    
    public function testLoginGuruBerhasil()
    {
        $nik = '0099887766';
        $password = '0099887766';

        // mock untuk mengembalikan data pegawai
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['nik' => $nik, 'password' => $password, 'id_jenis' => 2]);
        $stmtMock->method('rowCount')->willReturn(2);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        // memanggil metode login dengan NIK dan password yang benar
        $result = $this->auth->login($nik, $password);

        $this->assertTrue($result);
        $this->assertEquals($_SESSION['namaPegawai'], $nik);
        $this->assertEquals($_SESSION['id_jenis'], 2);
    }

    public function testLoginAdminPasswordSalah()
    {
        $nik = '1234567890';
        $wrongPassword = 'admin';

        // mock untuk mengembalikan data pegawai
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['nik' => $nik, 'password' => 'admin123', 'id_jenis' => 1]);
        $stmtMock->method('rowCount')->willReturn(1);

        // memanggil metode login dengan NIK dan password yang benar
        $result = $this->auth->login($nik, $wrongPassword);

        $this->assertTrue($result);
        $this->assertEquals('Password salah', $this->auth->getLastError());
    }
    
    public function testLoginGuruPasswordSalah()
    {
        $nik = '0099887766';
        $wrongPassword = '00998877';

        // mock untuk mengembalikan data pegawai
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['nik' => $nik, 'password' => '0099887766', 'id_jenis' => 2]);
        $stmtMock->method('rowCount')->willReturn(2);

        // memanggil metode login dengan NIK dan password yang benar
        $result = $this->auth->login($nik, $wrongPassword);

        $this->assertTrue($result);
        $this->assertEquals('Password salah', $this->auth->getLastError());
    }

    public function testLoginNikTidakTerdaftar()
    {
        $nik = '0192837465';
        $password = '0192837465';

        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(0);

        $this->dbMock->method('prepare')->willReturn($stmtMock);

        $result = $this->auth->login($nik, $password);
        
        $this->assertFalse($result);
        $this->assertEquals('NIK tidak terdaftar', $this->auth->getLastError());
    }

    public function testLoginNikKosong()
    {
        $nik = '';
        $password = '112233';

        // Memanggil metode login dengan NIK kosong
        $result = $this->auth->login($nik, $password);

        $this->assertFalse($result);
        $this->assertEquals('NIK wajib diisi', $this->auth->getLastError());
    }

    public function testLoginPasswordKosong()
    {
        $nik = '23456432345';
        $password = '';

        // Memanggil metode login dengan password kosong
        $result = $this->auth->login($nik, $password);

        $this->assertFalse($result);
        $this->assertEquals('Password wajib diisi', $this->auth->getLastError());
    }

    protected function tearDown(): void
    {
        session_destroy();
    }
}