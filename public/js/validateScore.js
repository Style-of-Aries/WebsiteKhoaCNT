document.addEventListener("DOMContentLoaded", function () {
  const inputs = document.querySelectorAll('.main-table input[type="number"]');

  inputs.forEach((input) => {
    input.addEventListener("input", function () {
      let value = this.value;

      // Chỉ cho nhập số và dấu chấm
      if (!/^\d*\.?\d*$/.test(value)) {
        this.value = value.slice(0, -1);
        return;
      }

      if (value === "") {
        resetStyle(this);
        return;
      }

      let number = parseFloat(value);

      // Giới hạn 0 - 10
      if (number > 10) {
        this.value = 10;
        number = 10;
      }

      if (number < 0) {
        this.value = 0;
        number = 0;
      }

      // Đổi màu theo mức điểm
      if (number >= 8) {
        this.style.borderColor = "#22c55e"; // xanh
      } else if (number >= 5) {
        this.style.borderColor = "#f59e0b"; // vàng
      } else {
        this.style.borderColor = "#ef4444"; // đỏ
      }
    });

    // Format 2 chữ số thập phân khi blur
    input.addEventListener("blur", function () {
      if (this.value === "") return;

      let number = parseFloat(this.value);

      // Làm tròn 1 chữ số
      number = Math.round(number * 10) / 10;

      // Nếu là số nguyên (0 hoặc 10 hoặc 7.0...)
      if (Number.isInteger(number)) {
        this.value = number.toString();
      } else {
        this.value = number.toFixed(1);
      }
    });
  });

  function resetStyle(input) {
    input.style.borderColor = "#d1d5db";
  }
});
