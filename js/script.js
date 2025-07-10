const togglePasswordButton = document.getElementsByClassName("togglePassword");
for (let element of togglePasswordButton) {
  element.addEventListener("click", function (e) {
    let passwordInput = this.parentElement.firstElementChild;
    let toggleIcon = this.firstElementChild;
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      toggleIcon.className = "bi bi-eye-slash";
    } else {
      passwordInput.type = "password";
      toggleIcon.className = "bi bi-eye";
    }
  });
}
