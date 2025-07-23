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


document.getElementById('productImages').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    for (let i = 0; i < e.target.files.length; i++) {
        const file = e.target.files[i];
        const reader = new FileReader();

        reader.onload = function(e) {
            const col = document.createElement('div');
            col.className = 'col-md-3 mb-3';
            col.innerHTML = `
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body p-2">
                                <button type="button" class="btn btn-sm btn-outline-danger w-100">Remove</button>
                            </div>
                        </div>
                    `;
            preview.appendChild(col);
        };

        reader.readAsDataURL(file);
    }
});