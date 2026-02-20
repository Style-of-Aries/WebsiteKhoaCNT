document.addEventListener("DOMContentLoaded", function () {
  //#region ================= INPUT SCORE VALIDATE =================
  

  //#endregion
  //#region ================= SORT MODULE =================
  let sortDirection = true;

  function sortTable(colIndex) {
    let tbody = document.querySelector("#mainTable tbody");
    if (!tbody) return;

    let rows = Array.from(tbody.rows);
    sortDirection = !sortDirection;

    rows.sort((rowA, rowB) => {
      let cellA = rowA.cells[colIndex].innerText.trim();
      let cellB = rowB.cells[colIndex].innerText.trim();

      // Number sort
      let numA = parseFloat(cellA.replace(/\D/g, ""));
      let numB = parseFloat(cellB.replace(/\D/g, ""));

      if (!isNaN(numA) && !isNaN(numB)) {
        return sortDirection ? numA - numB : numB - numA;
      }

      // Date sort
      let dateA = Date.parse(cellA);
      let dateB = Date.parse(cellB);

      if (!isNaN(dateA) && !isNaN(dateB)) {
        return sortDirection ? dateA - dateB : dateB - dateA;
      }

      // Text sort
      return sortDirection
        ? cellA.localeCompare(cellB)
        : cellB.localeCompare(cellA);
    });

    rows.forEach((row) => tbody.appendChild(row));
  }
  //#endregion

  //#region ================= SEARCH MODULE =================
  const searchInput = document.getElementById("searchTable");

  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      let keyword = this.value.toLowerCase();
      let rows = document.querySelectorAll("#mainTable tbody tr");

      rows.forEach((row) => {
        row.style.display = row.innerText.toLowerCase().includes(keyword)
          ? ""
          : "none";
      });
    });
  }
  //#endregion

  //#region ================= CHART MODULE =================
  const ctx = document.getElementById("studentChart");

  if (ctx) {
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["CNTT1", "CNTT2", "KT01", "QTKD"],
        datasets: [
          {
            label: "Nam",
            data: [30, 27, 20, 10],
            backgroundColor: "#3E7EDB",
          },
          {
            label: "Nữ",
            data: [10, 7, 6, 15],
            backgroundColor: "#4CAF50",
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: "top" },
        },
      },
    });
  }
  //#endregion

  //#region ================= AVATAR MODULE =================
  const avatar = document.querySelector(".avatar");
  const dropboxAdmin = document.querySelector(".dropboxAdmin");

  if (avatar && dropboxAdmin) {
    avatar.addEventListener("click", function (e) {
      e.stopPropagation();
      dropboxAdmin.classList.toggle("active");
    });

    document.addEventListener("click", function () {
      dropboxAdmin.classList.remove("active");
    });
  }
  //#endregion

  //#region ================= COURSE FORM MODULE =================
  const form = document.getElementById("courseForm");

  if (form) {
    const tableBody = document.querySelector("#componentsTable tbody");
    const btnAdd = document.getElementById("btnAddComponent");
    const totalWeightEl = document.getElementById("totalWeight");

    let index = 0;

    // Thêm thành phần
    btnAdd.addEventListener("click", function () {
      const row = document.createElement("tr");

      row.innerHTML = `
        <td>
          <input type="text" name="components[${index}][name]" required>
        </td>
        <td>
          <select name="components[${index}][type]" required>
            <option value="TX">Thường xuyên</option>
            <option value="DK">Định kỳ</option>
            <option value="CK">Điểm thi</option>
            <option value="PROJECT">Bài tập lớn</option>
          </select>
        </td>
        <td>
          <input type="number"
                 name="components[${index}][weight]"
                 min="0" max="100"
                 class="weight-input"
                 required>
        </td>
        <td>
          <button class="btn-remove btn-delete">
  <span class="X"></span>
  <span class="Y"></span>
  <div class="close">Xóa</div>
</button>

        </td>
      `;

      tableBody.appendChild(row);
      index++;
    });

    // Xóa dòng
    tableBody.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn-delete")) {
        e.target.closest("tr").remove();
        calculateTotal();
      }
    });

    // Tính tổng khi nhập
    tableBody.addEventListener("input", function (e) {
      if (e.target.classList.contains("weight-input")) {
        calculateTotal();
      }
    });

    function calculateTotal() {
      const inputs = document.querySelectorAll(".weight-input");
      let total = 0;

      inputs.forEach((input) => {
        total += parseFloat(input.value) || 0;
      });

      totalWeightEl.innerText = total;
      totalWeightEl.style.color = total === 100 ? "green" : "red";
    }

    // Validate submit
    form.addEventListener("submit", function (e) {
      const total = parseFloat(totalWeightEl.innerText);

      if (total !== 100) {
        e.preventDefault();
        showAlert("Tổng trọng số phải bằng 100%", "error");
      }
    });
  }
  //#endregion

  //#region ================= UPLOAD MODULE =================
  const fakeBtn = document.querySelector(".fake-file button");
  const realFile = document.getElementById("realFile");

  if (fakeBtn && realFile) {
    fakeBtn.addEventListener("click", function () {
      realFile.click();
    });
  }
  //#endregion

  //#region ================= ALERT MODULE =================
  const alertBox = document.getElementById("autoHideAlert");
  const alertMessage = document.getElementById("alertMessage");

  // 🔥 Auto hide nếu có alert từ session
  if (alertBox && !alertBox.classList.contains("hide")) {
    setTimeout(() => {
      alertBox.classList.add("hide");
    }, 3000);
  }

  function showAlert(message, type = "error") {
    if (!alertBox || !alertMessage) return;

    alertMessage.innerText = message;

    alertBox.classList.remove("alert-success", "alert-error", "hide");
    alertBox.classList.add(
      type === "success" ? "alert-success" : "alert-error",
    );

    setTimeout(() => {
      alertBox.classList.add("hide");
    }, 3000);
  }
  //#endregion
});
