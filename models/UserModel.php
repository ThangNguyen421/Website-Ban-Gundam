<?php
class UserModel
{
    private $pdo;
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerUser($fullName, $email, $password)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'customer';

        $sql = "INSERT INTO NguoiDung (HoTen, Email, MatKhauHash, VaiTro) 
                VALUES (:fullname, :email, :passhash, :role)";

        try {
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':fullname' => $fullName,
                ':email' => $email,
                ':passhash' => $passwordHash,
                ':role' => $role
            ]);

            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {

            return false;
        }
    }

    //Đăng nhập người dùng
    public function loginUser($email, $password)
    {
        $sql = "SELECT * FROM NguoiDung WHERE Email = :email";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['MatKhauHash'])) {

                $this->updateLastLogin($user['MaNguoiDung']);

                unset($user['MatKhauHash']);
                return $user;
            }
            return false; 

        } catch (\PDOException $e) {
            return false;
        }
    }

    private function updateLastLogin($userId)
    {
        $sql = "UPDATE NguoiDung SET LanDangNhapCuoi = NOW() WHERE MaNguoiDung = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $userId]);
        } catch (\PDOException $e) {
        }
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM NguoiDung WHERE MaNguoiDung = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id' => $userId]);
            $user = $stmt->fetch();

            if ($user) {
                unset($user['MatKhauHash']);
            }
            return $user;
        } catch (\PDOException $e) {
            return false;
        }
    }


    public function getUserNameById($userId)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT TenNguoiDung FROM nguoidung WHERE MaNguoiDung = :userId");
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy tên người dùng: " . $e->getMessage());
            return null;
        }
    }

    public function getAllUsers()
    {
        $sql = "SELECT MaNguoiDung, HoTen, Email, VaiTro, NgayTao 
                FROM NguoiDung 
                ORDER BY NgayTao DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function updateRole(int $userId, string $newRole)
    {
        $newRole = strtolower($newRole);
        if ($newRole !== 'customer' && $newRole !== 'admin') {
            return false;
        }

        $sql = "UPDATE NguoiDung SET VaiTro = ? WHERE MaNguoiDung = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$newRole, $userId]);
    }

    public function deleteUser(int $userId)
    {
        $sql = "DELETE FROM NguoiDung WHERE MaNguoiDung = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId]);
    }
}

