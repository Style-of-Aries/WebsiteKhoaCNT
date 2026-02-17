document.getElementById("searchTable").addEventListener("keyup", function () {
  let keyword = this.value.toLowerCase();
  let rows = document.querySelectorAll("#mainTable tbody tr");

  rows.forEach((row) => {
    row.style.display = row.innerText.toLowerCase().includes(keyword)
      ? ""
      : "none";
  });
});

let sortDirection = true;

function sortTable(colIndex) {
  let tbody = document.querySelector("#mainTable tbody");
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

document.addEventListener("DOMContentLoaded", function () {
  const scoreInputs = document.querySelectorAll(
    ".score-input:not(.disabled-input)",
  );

  scoreInputs.forEach((input) => {
    // Khi nhập
    input.addEventListener("input", function () {
      let value = this.value;

      // Không cho nhập chữ
      value = value.replace(/[^0-9.]/g, "");

      // Chỉ cho 1 dấu chấm
      if ((value.match(/\./g) || []).length > 1) {
        value = value.substring(0, value.length - 1);
      }

      // Giới hạn 1 chữ số thập phân
      if (value.includes(".")) {
        let parts = value.split(".");
        parts[1] = parts[1].substring(0, 1);
        value = parts[0] + "." + parts[1];
      }

      this.value = value;

      // Reset custom message
      this.setCustomValidity("");
    });

    // Khi blur (rời khỏi ô)
    input.addEventListener("blur", function () {
      if (this.value === "") return;

      let num = parseFloat(this.value);

      if (isNaN(num)) {
        this.value = "";
        return;
      }

      if (num < 0) num = 0;
      if (num > 10) num = 10;

      let rounded = Math.round(num * 10) / 10;

      // Nếu là số nguyên thì không thêm .0
      if (rounded % 1 === 0) {
        this.value = rounded;
      } else {
        this.value = rounded.toFixed(1);
      }
    });

    // Khi submit form
    input.addEventListener("invalid", function () {
      if (this.validity.rangeUnderflow) {
        this.setCustomValidity("Điểm phải lớn hơn hoặc bằng 0");
      } else if (this.validity.rangeOverflow) {
        this.setCustomValidity("Điểm phải nhỏ hơn hoặc bằng 10");
      } else if (this.validity.stepMismatch) {
        this.setCustomValidity("Điểm chỉ được tối đa 1 chữ số thập phân");
      } else {
        this.setCustomValidity("Giá trị không hợp lệ");
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const alertBox = document.getElementById("autoHideAlert");
  if (alertBox) {
    setTimeout(() => {
      alertBox.classList.add("hide");
      setTimeout(() => alertBox.remove(), 500);
    }, 3000);
  }
});
