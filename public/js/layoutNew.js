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

//#region ================= PREVIEW AVATAR ==============

//#region ================= INPUT FULL NAME ==============
// const fullNameInput = document.querySelector('input[name="full_name"]');

// if (fullNameInput) {
//   fullNameInput.addEventListener("input", function () {
//     this.value = this.value.toUpperCase();
//   });
// }
// //#endregion
// document.addEventListener("DOMContentLoaded", function () {
//   //#region ================= ALERT MODULE =================
//   const alertBox = document.getElementById("autoHideAlert");
//   const alertMessage = document.getElementById("alertMessage");

//   // 🔥 Auto hide nếu có alert từ session
//   if (alertBox && !alertBox.classList.contains("hide")) {
//     setTimeout(() => {
//       alertBox.classList.add("hide");
//     }, 3000);
//   }

//   function showAlert(message, type = "error") {
//     if (!alertBox || !alertMessage) return;

//     alertMessage.innerText = message;

//     alertBox.classList.remove("alert-success", "alert-error", "hide");
//     alertBox.classList.add(
//       type === "success" ? "alert-success" : "alert-error",
//     );

//     setTimeout(() => {
//       alertBox.classList.add("hide");
//     }, 3000);
//   }
// const fullNameInput = document.querySelector('input[name="full_name"]');
document.addEventListener("DOMContentLoaded", function () {
  // ================= FORMAT HỌ TÊN =================

  const fullNameInput = document.querySelector('input[name="full_name"]');

  if (fullNameInput) {
    fullNameInput.addEventListener("blur", function () {
      this.value = formatFullName(this.value);
    });
  }

  function formatFullName(str) {
    return str
      .toLowerCase()
      .trim()
      .replace(/\s+/g, " ")
      .split(" ")
      .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
      .join(" ");
  }

  // ================= ALERT MODULE =================
  const alertBox = document.getElementById("autoHideAlert");
  const alertMessage = document.getElementById("alertMessage");

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
  //   const form = document.getElementById("courseForm");

  //   if (form) {
  //     const tableBody = document.querySelector("#componentsTable tbody");
  //     const btnAdd = document.getElementById("btnAddComponent");
  //     const totalWeightEl = document.getElementById("totalWeight");

  //     let index = 0;

  //     // Thêm thành phần
  //     btnAdd.addEventListener("click", function () {
  //       const row = document.createElement("tr");

  //       row.innerHTML = `
  //         <td>
  //           <input type="text" name="components[${index}][name]" required>
  //         </td>
  //         <td>
  //           <select name="components[${index}][type]" required>
  //             <option value="TX">Thường xuyên</option>
  //             <option value="DK">Định kỳ</option>
  //             <option value="CK">Điểm thi</option>
  //             <option value="PROJECT">Bài tập lớn</option>
  //           </select>
  //         </td>
  //         <td>
  //           <input type="number"
  //                  name="components[${index}][weight]"
  //                  min="0" max="100"
  //                  class="weight-input"
  //                  required>
  //         </td>
  //         <td>
  //           <button class="btn-remove btn-delete">
  //   <span class="X"></span>
  //   <span class="Y"></span>
  //   <div class="close">Xóa</div>
  // </button>

  //         </td>
  //       `;

  //       tableBody.appendChild(row);
  //       index++;
  //     });

  //     // Xóa dòng
  //     tableBody.addEventListener("click", function (e) {
  //       if (e.target.classList.contains("btn-delete")) {
  //         e.target.closest("tr").remove();
  //         calculateTotal();
  //       }
  //     });

  //     // Tính tổng khi nhập
  //     tableBody.addEventListener("input", function (e) {
  //       if (e.target.classList.contains("weight-input")) {
  //         calculateTotal();
  //       }
  //     });

  //     function calculateTotal() {
  //       const inputs = document.querySelectorAll(".weight-input");
  //       let total = 0;

  //       inputs.forEach((input) => {
  //         total += parseFloat(input.value) || 0;
  //       });

  //       totalWeightEl.innerText = total;
  //       totalWeightEl.style.color = total === 100 ? "green" : "red";
  //     }

  //     // Validate submit
  //     form.addEventListener("submit", function (e) {
  //       const total = parseFloat(totalWeightEl.innerText);

  //       if (total !== 100) {
  //         e.preventDefault();
  //         showAlert("Tổng trọng số phải bằng 100%", "error");
  //       }
  //     });
  //   }
  //#endregion

  //#region ================= AVATAR UPLOAD =================
  const realFile = document.getElementById("realFile");
  const preview = document.getElementById("avatarPreview");
  const fileName = document.getElementById("fileName");

  if (realFile) {
    realFile.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return;

      preview.src = URL.createObjectURL(file);

      // Ẩn tên file
      if (fileName) {
        fileName.style.display = "none";
      }
    });
  }
  //#endregion

  //#region ================= FORM ADD SUBJECT =================

  const table = document.getElementById("score-structure");
  const tbody = table.querySelector("tbody");
  const addBtn = document.getElementById("btnAddComponent");
  const totalWeightSpan = document.getElementById("totalWeight");
  let index = tbody.querySelectorAll("tr").length;
  // =============================
  // TÍNH TỔNG TRỌNG SỐ
  // =============================
  function updateTotalWeight() {
    let total = 0;

    document.querySelectorAll(".weight-input").forEach((input) => {
      total += parseInt(input.value) || 0;
    });

    totalWeightSpan.textContent = total;

    if (total > 100) {
      totalWeightSpan.style.color = "red";
    } else {
      totalWeightSpan.style.color = "green";
    }
  }

  // =============================
  // TẠO 1 DÒNG
  // =============================
  function createRow() {
    const tr = document.createElement("tr");

    tr.innerHTML = `
            <td>
                <input type="text" 
                       name="components[${index}][name]" 
                       required>
            </td>

            <td>
                <select name="components[${index}][type]" required>
                    <option value="TX">Thường xuyên</option>
                    <option value="DK">Định kỳ</option>
                    <option value="CK">Điểm thi</option>
                    <option value="PROJECT">Đồ án</option>
                </select>
            </td>

            <td>
                <input type="number"
                       name="components[${index}][weight]"
                       min="0"
                       max="100"
                       class="weight-input"
                       required>
            </td>

            <td>
                <button type="button" class="btn-remove btn-delete">
                    <span class="X"></span>
                    <span class="Y"></span>
                    <div class="close">Xóa</div>
                </button>
            </td>
        `;

    tbody.appendChild(tr);
    index++;

    updateTotalWeight();
  }

  // =============================
  // THÊM DÒNG
  // =============================
  addBtn.addEventListener("click", function (e) {
    e.preventDefault(); // tránh submit form
    createRow();
  });

  // =============================
  // XÓA DÒNG (event delegation)
  // =============================
  tbody.addEventListener("click", function (e) {
    if (e.target.closest(".btn-remove")) {
      e.preventDefault();
      const row = e.target.closest("tr");
      row.remove();
      updateTotalWeight();
    }
  });

  // =============================
  // LẮNG NGHE THAY ĐỔI TRỌNG SỐ
  // =============================
  tbody.addEventListener("input", function (e) {
    if (e.target.classList.contains("weight-input")) {
      updateTotalWeight();
    }
  });

  // TẠO DÒNG ĐẦU MẶC ĐỊNH
  if (tbody.querySelectorAll("tr").length === 0) {
    createRow();
  }
  updateTotalWeight();
  //#endregion
});

function toggleDepartment() {
  var role = document.getElementById("roleSelect").value;
  var departmentField = document.getElementById("department_id");

  if (role === "lecturer") {
    departmentField.style.display = "block";
  } else {
    departmentField.style.display = "none";
  }
}

// chạy khi load trang
window.onload = toggleDepartment;

// load giảng viên trang classes add
document
  .getElementById("departmentSelect")
  .addEventListener("change", function () {
    let departmentId = this.value;
    let lecturerSelect = document.getElementById("lecturerSelect");

    lecturerSelect.innerHTML = '<option value="">Đang tải...</option>';

    fetch(
      "index.php?controller=classes&action=getLecturerByDepartment&id=" +
        departmentId,
    )
      .then((response) => response.json())
      .then((data) => {
        lecturerSelect.innerHTML =
          '<option value="">-- Chọn giảng viên --</option>';

        data.forEach(function (lecturer) {
          let option = document.createElement("option");
          option.value = lecturer.id;
          option.textContent = lecturer.full_name;
          lecturerSelect.appendChild(option);
        });
      })
      .catch((error) => {
        lecturerSelect.innerHTML = '<option value="">Lỗi tải dữ liệu</option>';
      });
  });
