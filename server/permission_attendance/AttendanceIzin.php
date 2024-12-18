<?php
require '../config/connectionServerToDatabase.php';

class AttendanceIzin
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     *
     * @return array - 
     */
    public function getIzinInfo()
{
    try {
        $stmt = $this->pdo->query("SELECT * FROM attendance_izin WHERE status = 'pending'");
        $izinData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log("Query executed: SELECT * FROM attendance_izin WHERE status = 'pending'");
        error_log("Fetched data: " . json_encode($izinData));

        if ($izinData) {
            return ['success' => true, 'data' => $izinData];
        } else {
            return ['success' => false, 'message' => 'Tidak ada data izin dengan status pending ditemukan.'];
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return ['success' => false, 'message' => 'Gagal mengambil data izin: ' . $e->getMessage()];
    }
}


    /**
     *
     * @param int 
     * @return array
     */
    public function acceptIzin($id)
    {
        try {
            $stmt = $this->pdo->prepare("UPDATE attendance_izin SET status = 'Approved' WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                error_log("Izin dengan ID $id berhasil diubah menjadi Approved.");
                return ['success' => true, 'message' => "Izin dengan ID $id telah diubah menjadi Approved."];
            } else {
                error_log("Tidak ada izin dengan ID $id yang ditemukan.");
                return ['success' => false, 'message' => "Tidak ada izin dengan ID $id yang ditemukan."];
            }
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Gagal mengubah status izin: ' . $e->getMessage()];
        }
    }
}
