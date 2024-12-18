document.addEventListener("DOMContentLoaded", async () => {
  const attendanceContainer = document.getElementById("attendance-container");

  async function fetchAttendanceData() {
    try {
      const response = await fetch(
        "../../middleware/middleware_attendance.php"
      );
      const result = await response.json();

      attendanceContainer.innerHTML = ""; // Kosongkan kontainer sebelum menambahkan data baru

      if (result.length > 0) {
        result.forEach((attendance) => {
          // Buat section untuk setiap presensi
          const attendanceSection = document.createElement("section");
          attendanceSection.classList.add("attendance-section");

          // Tambahkan data ke section
          attendanceSection.innerHTML = `
                        <h3>Presensi ID: ${attendance.id}</h3>
                        <p><strong>Tanggal:</strong> ${attendance.date}</p>
                        <p><strong>Waktu Mulai:</strong> ${attendance.start_time}</p>
                        <p><strong>Waktu Selesai:</strong> ${attendance.end_time}</p>

                        <!-- Form Input Nama Karyawan -->
                        <div class="employee-name-form">
                            <label for="employee-name-${attendance.id}">Nama Karyawan:</label>
                            <input type="text" id="employee-name-${attendance.id}" placeholder="Masukkan nama karyawan" required>
                        </div>

                        <div class="reason-form" id="reason-form-${attendance.id}" style="display: none;">
                            <label for="reason-${attendance.id}">Alasan Izin:</label>
                            <textarea id="reason-${attendance.id}" placeholder="Masukkan alasan izin"></textarea>
                        </div>

                        <div class="button-container">
                            <button class="btn hadir-btn" data-id="${attendance.id}">Hadir</button>
                            <button class="btn izin-btn" data-id="${attendance.id}">Izin</button>
                        </div>
                    `;

          attendanceContainer.appendChild(attendanceSection);
        });

        // Tambahkan event listener ke tombol setelah elemen dibuat
        document.querySelectorAll(".hadir-btn").forEach((btn) => {
          btn.addEventListener("click", (e) => {
            const attendanceId = e.target.getAttribute("data-id");
            const employeeName = document.getElementById(
              `employee-name-${attendanceId}`
            ).value;

            if (!employeeName) {
              alert("Nama karyawan harus diisi!");
              return;
            }

            sendAttendanceData(attendanceId, employeeName, "Hadir");
          });
        });

        document.querySelectorAll(".izin-btn").forEach((btn) => {
          btn.addEventListener("click", (e) => {
            const attendanceId = e.target.getAttribute("data-id");
            const employeeName = document.getElementById(
              `employee-name-${attendanceId}`
            ).value;
            const reasonForm = document.getElementById(
              `reason-form-${attendanceId}`
            );
            const reasonInput = document.getElementById(
              `reason-${attendanceId}`
            );

            // Tampilkan form alasan izin
            reasonForm.style.display = "block";

            // Pastikan nama dan alasan sudah diisi sebelum mengirimkan
            const saveIzinHandler = async () => {
              const reason = reasonInput.value;

              if (!employeeName) {
                alert("Nama karyawan harus diisi!");
                return;
              }

              if (!reason) {
                alert("Alasan izin harus diisi!");
                return;
              }

              await sendIzinData(attendanceId, employeeName, reason);
              reasonForm.style.display = "none"; // Sembunyikan form setelah berhasil disimpan
            };

            // Tangani klik tombol submit izin
            reasonInput.onblur = saveIzinHandler;
          });
        });
      } else {
        attendanceContainer.innerHTML = "<p>Tidak ada presensi aktif.</p>";
      }
    } catch (error) {
      console.error("Error fetching attendance data:", error);
      attendanceContainer.innerHTML = "<p>Gagal memuat data presensi.</p>";
    }
  }

  async function sendAttendanceData(attendanceId, employeeName, status) {
    try {
      const response = await fetch(
        "../../server/save_attendance/save_attendance.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            attendance_id: attendanceId,
            employee_name: employeeName,
            status: status,
          }),
        }
      );

      const result = await response.json();
      if (result.success) {
        alert("Presensi berhasil disimpan!");
      } else {
        alert("Gagal menyimpan presensi: " + result.message);
      }
    } catch (error) {
      console.error("Error sending attendance data:", error);
      alert("Terjadi kesalahan saat mengirim data presensi.");
    }
  }

  async function sendIzinData(attendanceId, employeeName, reason) {
    try {
      const response = await fetch(
        "../../server/permission_attendance/save_izin.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            attendance_id: attendanceId,
            employee_name: employeeName,
            reason: reason,
          }),
        }
      );

      const result = await response.json();
      if (result.success) {
        alert("Izin berhasil disimpan!");
      } else {
        alert("Gagal menyimpan izin: " + result.message);
      }
    } catch (error) {
      console.error("Error sending izin data:", error);
      alert("Terjadi kesalahan saat mengirim data izin.");
    }
  }

  // Ambil data presensi saat halaman dimuat
  fetchAttendanceData();
});
