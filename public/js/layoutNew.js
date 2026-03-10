function addSchedule() {
  const wrapper = document.getElementById("schedule-wrapper");

  // Nếu trang không có schedule-wrapper thì thoát luôn
  if (!wrapper) return;

  const firstItem = wrapper.querySelector(".schedule-item");

  if (!firstItem) return;

  const clone = firstItem.cloneNode(true);

  // Reset value của select
  clone.querySelectorAll("select").forEach(function (select) {
    select.selectedIndex = 0;
  });

  // Xóa input value nếu có
  clone.querySelectorAll("input").forEach(function (input) {
    input.value = "";
  });

  // Chỉ thêm nút X nếu chưa có
  if (!clone.querySelector(".remove-btn")) {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.innerText = "X";
    btn.className = "remove-btn";
    btn.addEventListener("click", function () {
      removeSchedule(this);
    });
    clone.appendChild(btn);
  }

  wrapper.appendChild(clone);
}

function removeSchedule(btn) {
  const wrapper = document.getElementById("schedule-wrapper");
  if (!wrapper) return;

  // Không cho xóa nếu chỉ còn 1 schedule-item
  if (wrapper.querySelectorAll(".schedule-item").length <= 1) {
    return;
  }

  btn.closest(".schedule-item").remove();
}

//#region ================= semesterSelect MODULE =================
function initSemesterDate() {
  const semesterSelect = document.getElementById("semester_number");
  const academicYearInput = document.getElementById("academic_year");
  const startDateInput = document.getElementById("start_date");
  const endDateInput = document.getElementById("end_date");

  // nếu không phải trang semester thì dừng
  if (
    !semesterSelect ||
    !academicYearInput ||
    !startDateInput ||
    !endDateInput
  ) {
    return;
  }

  const semesterConfig = {
    1: { start: "09-01", end: "01-10" },
    2: { start: "01-15", end: "05-30" },
  };

  function updateSemesterDate() {
    const semester = semesterSelect.value;
    const yearText = academicYearInput.value;

    if (!yearText.includes("-")) return;

    const years = yearText.split("-");
    const year1 = years[0];
    const year2 = years[1];

    const config = semesterConfig[semester];

    let startYear = semester == 1 ? year1 : year2;
    let endYear = year2;

    startDateInput.value = startYear + "-" + config.start;
    endDateInput.value = endYear + "-" + config.end;
  }

  semesterSelect.addEventListener("change", updateSemesterDate);
  academicYearInput.addEventListener("input", updateSemesterDate);

  updateSemesterDate();
}

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

//#region ================= exportExcel ==============
function exportExcel(tableId = "mainTable", fileName = "DanhSach.xlsx") {
  const table = document.getElementById(tableId);
  if (!table) {
    alert("Không tìm thấy bảng!");
    return;
  }

  const clonedTable = table.cloneNode(true);

  const statusMap = {
    present: "Có mặt",
    late: "Muộn",
    absent: "Vắng",
  };

  // convert select/input -> text
  clonedTable.querySelectorAll("select, input").forEach((el) => {
    let text = "";

    if (el.tagName === "SELECT") {
      text = statusMap[el.value] || el.value;
    } else {
      text = el.value;
    }

    const td = el.closest("td");
    if (td) td.textContent = text;
  });

  clonedTable.querySelectorAll("button").forEach((btn) => btn.remove());

  // tạo sheet
  const ws = XLSX.utils.table_to_sheet(clonedTable, { raw: true });
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "DiemDanh");

  const range = XLSX.utils.decode_range(ws["!ref"]);

  // ===== FIX DATE HEADER =====
  for (let C = range.s.c; C <= range.e.c; C++) {
    const cell = ws[XLSX.utils.encode_cell({ r: 0, c: C })]; // hàng header
    if (cell && /^\d{1,2}\/\d{1,2}$/.test(cell.v)) {
      cell.t = "s"; // ép kiểu string
    }
  }

  // ===== AUTO WIDTH =====
  const colWidths = [];
  for (let C = range.s.c; C <= range.e.c; C++) {
    let max = 8;

    for (let R = range.s.r; R <= range.e.r; R++) {
      const cell = ws[XLSX.utils.encode_cell({ r: R, c: C })];
      if (cell && cell.v) {
        const len = cell.v.toString().length;
        if (len > max) max = len;
      }
    }

    colWidths.push({ wch: max + 2 });
  }

  ws["!cols"] = colWidths;

  XLSX.writeFile(wb, fileName);
}
//#endregion
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
  initSemesterDate();
  //#region ================= checkbox-semester =================
  document.querySelectorAll(".checkbox-semester").forEach((cb) => {
    cb.addEventListener("change", function () {
      let id = this.dataset.id;

      if (this.checked) {
        window.location.href =
          "index.php?controller=semester&action=activateSemester&id=" + id;
      } else {
        window.location.href =
          "index.php?controller=semester&action=deactivateSemester&id=" + id;
      }
    });
  });
  //#endregion
  //#region ================= FORMAT HỌ TÊN =================

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
  //#endregion

  //#region ================= ALERT MODULE =================
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

  //#region ================= FORMAT DATE =================
  // const start = document.querySelector("#start_date");
  // const end = document.querySelector("#end_date");

  // if (start) {
  //   flatpickr("#start_date", {
  //     dateFormat: "d/m/Y",
  //     locale: "vn",
  //   });
  // }

  // if (end) {
  //   flatpickr("#end_date", {
  //     dateFormat: "d/m/Y",
  //     locale: "vn",
  //   });
  // }
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

  //#region ================= SCORE STRUCTURE FORM =================
  (function () {
    "use strict";

    const table = document.getElementById("score-structure");
    if (!table) return;

    const tbody = table.querySelector("tbody");
    const totalWeightSpan = document.getElementById("totalWeight");
    const creditInput = document.getElementById("creditInput");
    const subjectTypeSelect = document.getElementById("subjectType");
    const useProjectCheckbox = document.getElementById(
      "useProjectInsteadOfExam",
    );

    if (!tbody || !totalWeightSpan) return;

    let index = 0;

    // =============================
    function updateTotalWeight() {
      let total = 0;

      tbody.querySelectorAll(".component-weight").forEach((input) => {
        total += parseFloat(input.value) || 0;
      });

      totalWeightSpan.textContent = total.toFixed(2);
      totalWeightSpan.style.color = total !== 100 ? "red" : "green";
    }

    // =============================
    function autoCalculateTX_DK() {
      const rows = tbody.querySelectorAll("tr");

      let txInputs = [];
      let dkInputs = [];

      rows.forEach((row) => {
        const type = row.querySelector(".component-type")?.value;
        const weightInput = row.querySelector(".component-weight");

        if (!type || !weightInput) return;

        if (type === "TX") txInputs.push(weightInput);
        if (type === "DK") dkInputs.push(weightInput);
      });

      const n = txInputs.length;
      const m = dkInputs.length;

      if (n === 0 && m === 0) return;

      const x = 40 / (n + 2 * m);

      let total = 0;

      // TX
      txInputs.forEach((input, i) => {
        let val = parseFloat(x.toFixed(2));
        input.value = val;
        input.readOnly = true;
        total += val;
      });

      // DK
      dkInputs.forEach((input, i) => {
        let val = parseFloat((2 * x).toFixed(2));

        // nếu là phần tử cuối thì bù sai số
        if (i === dkInputs.length - 1) {
          val = parseFloat((40 - total).toFixed(2));
        }

        input.value = val;
        input.readOnly = true;
        total += val;
      });
    }
    // =============================
    function createRow(type, weight = null, lock = false) {
      const tr = document.createElement("tr");

      tr.innerHTML = `
      <td>
        <select name="components[${index}][type]" 
                class="component-type" required>
          <option value="TX" ${type === "TX" ? "selected" : ""}>Thường xuyên</option>
          <option value="DK" ${type === "DK" ? "selected" : ""}>Định kỳ</option>
          <option value="CK" ${type === "CK" ? "selected" : ""}>Điểm thi</option>
          <option value="PROJECT" ${type === "PROJECT" ? "selected" : ""}>Đồ án</option>
        </select>
      </td>

      <td>
        <input type="number"
               name="components[${index}][weight]"
               min="0"
               max="100"
               step="0.01"
               class="component-weight"
               required>
      </td>

      <td></td>
    `;

      const weightInput = tr.querySelector(".component-weight");

      if (weight !== null) {
        weightInput.value = weight;
      }

      if (lock) {
        weightInput.readOnly = true;
        // tr.querySelector(".component-type").disabled = true;
      }

      tbody.appendChild(tr);
      index++;
    }

    // =============================
    function generateNormal(credit) {
      tbody.innerHTML = "";
      index = 0;

      let txCount = 0;
      let dkCount = 0;

      if (credit <= 2) {
        txCount = 1;
        dkCount = 1;
      } else if (credit === 3) {
        txCount = 2;
        dkCount = 1;
      } else if (credit <= 5) {
        txCount = 3;
        dkCount = 2;
      } else {
        txCount = 4;
        dkCount = 2;
      }

      for (let i = 0; i < txCount; i++) createRow("TX");
      for (let i = 0; i < dkCount; i++) createRow("DK");

      // 🔥 TÙY CHỌN CK hoặc PROJECT 60%
      if (useProjectCheckbox?.checked) {
        createRow("PROJECT", 60, true);
      } else {
        createRow("CK", 60, true);
      }

      autoCalculateTX_DK();
      updateTotalWeight();
    }

    // =============================
    function generateProjectSubject() {
      tbody.innerHTML = "";
      index = 0;

      createRow("PROJECT", 100, true);
      updateTotalWeight();
    }

    // =============================
    function regenerate() {
      const credit = parseInt(creditInput?.value);
      const subjectType = subjectTypeSelect?.value;

      if (subjectType === "PROJECT") {
        generateProjectSubject();
      } else if (credit && credit > 0) {
        generateNormal(credit);
      }
    }

    // =============================
    if (creditInput) {
      creditInput.addEventListener("input", regenerate);
    }

    if (subjectTypeSelect) {
      subjectTypeSelect.addEventListener("change", regenerate);
    }

    if (useProjectCheckbox) {
      useProjectCheckbox.addEventListener("change", regenerate);
    }
  })();
  //#endregion
});
document
  .getElementById("departmentSelect")
  .addEventListener("change", function () {
    let department_id = this.value;

    fetch(
      "index.php?controller=admin&action=getClassesByDepartment&department_id=" +
        department_id,
    )
      .then((response) => response.json())
      .then((data) => {
        let classSelect = document.getElementById("classSelect");
        classSelect.innerHTML = '<option value="">-- Chọn lớp --</option>';

        data.forEach((cls) => {
          classSelect.innerHTML += `<option value="${cls.id}">${cls.class_name}</option>`;
        });
      });
  });
// đổi màu khi chọn điểm danh
function changeColor(select) {
  let cls = select.options[select.selectedIndex].dataset.class;
  select.parentElement.className = cls;
}

document.getElementById("session_date").addEventListener("change", function () {
  const dateValue = this.value;
  if (!dateValue) return;

  const date = new Date(dateValue);
  const jsDay = date.getDay();
  // 0 = CN, 1 = Thứ 2, ..., 6 = Thứ 7

  if (jsDay === 0) {
    alert("Chủ nhật nghỉ");
    return;
  }

  const thu = jsDay + 1;

  // GÁN THẲNG VÀO SELECT
  document.getElementById("day_of_week").value = thu;
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
