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

const dropboxAdmin = document.querySelector(".dropboxAdmin");
const ctx = document.getElementById("studentChart");

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

const avatar = document.querySelector(".avatar");
avatar.addEventListener("click", function (e) {
  e.stopPropagation();
  dropboxAdmin.classList.toggle("active");
});

document.addEventListener("DOMContentLoaded", function () {
  const icons = document.querySelectorAll(".info-item i");
  let tooltip;

  icons.forEach(icon => {
    icon.addEventListener("mouseenter", function (e) {
      const text = this.dataset.label;
      if (!text) return;

      tooltip = document.createElement("div");
      tooltip.className = "tooltip";
      tooltip.innerText = text;
      document.body.appendChild(tooltip);

      const rect = this.getBoundingClientRect();
      tooltip.style.left = rect.left + rect.width / 2 + "px";
      tooltip.style.top = rect.top - 10 + window.scrollY + "px";
      tooltip.style.transform = "translate(-50%, -100%)";
      tooltip.style.opacity = 1;
    });

    icon.addEventListener("mouseleave", function () {
      if (tooltip) {
        tooltip.remove();
        tooltip = null;
      }
    });
  });
});
document.querySelector('.fake-file button').addEventListener('click', function () {
  document.getElementById('realFile').click();
});

function updateFileName(input) {
  if (input.files && input.files[0]) {
    // đổi tên file
    document.getElementById('fileName').innerText = input.files[0].name;

    // preview ảnh avatar
    const reader = new FileReader();
    reader.onload = function (e) {
      const img = document.getElementById('avatarPreview');
      if (img) {
        img.src = e.target.result;
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}

document.querySelectorAll(".more-btn").forEach(btn => {
  btn.addEventListener("click", function (e) {
    e.stopPropagation();

    const parent = this.closest(".more-actions");

    // đóng dropdown khác
    document.querySelectorAll(".more-actions").forEach(menu => {
      if (menu !== parent) menu.classList.remove("active");
    });

    // toggle menu hiện tại
    parent.classList.toggle("active");
  });
});

// click ra ngoài => đóng menu
document.addEventListener("click", () => {
  document.querySelectorAll(".more-actions").forEach(menu => {
    menu.classList.remove("active");
  });
});
function addSchedule() {

    let wrapper = document.getElementById("schedule-wrapper");
    let firstItem = wrapper.querySelector(".schedule-item");

    let clone = firstItem.cloneNode(true);

    // Reset value
    clone.querySelectorAll("select").forEach(select => {
        select.selectedIndex = 0;
    });

    // Thêm nút X nếu chưa có
    if (!clone.querySelector("button")) {
        let btn = document.createElement("button");
        btn.type = "button";
        btn.innerText = "X";
        btn.onclick = function () {
            removeSchedule(this);
        };
        clone.appendChild(btn);
    }

    wrapper.appendChild(clone);
}

function removeSchedule(btn) {
    btn.parentElement.remove();
}

