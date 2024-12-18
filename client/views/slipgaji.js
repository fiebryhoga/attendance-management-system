document
  .getElementById("salary-form")
  .addEventListener("submit", async function (event) {
    event.preventDefault();

    const employeeName = document.getElementById("employee-name").value;
    const salaryMonth = document.getElementById("salary-month").value;

    if (!employeeName || !salaryMonth) {
      alert("Nama karyawan dan bulan harus diisi.");
      return;
    }

    const salaryResult = document.getElementById("salary-slip-result");
    salaryResult.textContent = "Memuat data...";

    try {
      const response = await fetch("../../middleware/middleware_slip_gaji.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          name: employeeName,
          month: salaryMonth,
        }),
      });

      const data = await response.json();

      if (data.success) {
        const { name, month, salary, allowance, deduction, total_salary } =
          data;

        salaryResult.innerHTML = `
                <h3>Slip Gaji untuk ${name} (Bulan ${month})</h3>
                <p><strong>Nama:</strong> ${name}</p>
                <p><strong>Bulan:</strong> ${month}</p>
                <p><strong>Gaji Pokok:</strong> Rp ${salary.toLocaleString()}</p>
                <p><strong>Tunjangan:</strong> Rp ${allowance.toLocaleString()}</p>
                <p><strong>Potongan:</strong> Rp ${deduction.toLocaleString()}</p>
                <p><strong>Total Gaji:</strong> Rp ${total_salary.toLocaleString()}</p>
            `;
      } else {
        salaryResult.textContent = `Error: ${data.message}`;
      }
    } catch (error) {
      salaryResult.textContent = `Terjadi kesalahan: ${error.message}`;
    }
  });
