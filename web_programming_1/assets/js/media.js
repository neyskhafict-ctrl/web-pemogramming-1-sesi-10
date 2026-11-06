document.addEventListener("DOMContentLoaded", function () {
    const MAX_FILE_SIZE = 2 * 1024 * 1024;

    const form = document.querySelector("[data-media-form]");
    const fotoInput = document.getElementById("foto");
    const audioInput = document.getElementById("audio");
    const dokumenInput = document.getElementById("dokumen");

    const previewFoto = document.getElementById("previewFoto");
    const previewAudio = document.getElementById("previewAudio");
    const previewDokumen = document.getElementById("previewDokumen");

    let fotoURL = null;
    let audioURL = null;

    function validasiFile(input, file, prefix, allowedTypes) {
        if (!allowedTypes.includes(file.type)) {
            alert(prefix + " memiliki tipe file yang tidak diizinkan.");
            input.value = "";
            return false;
        }

        if (file.size > MAX_FILE_SIZE) {
            alert("Ukuran " + prefix.toLowerCase() + " maksimal 2 MB.");
            input.value = "";
            return false;
        }
        return true;
    }

    if (fotoInput && previewFoto) {
        fotoInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) {
                previewFoto.hidden = true;
                previewFoto.removeAttribute("src");
                return;
            }

            if (!validasiFile(this, file, "Foto", ["image/jpeg", "image/png", "image/webp"])) {
                previewFoto.hidden = true;
                return;
            }

            if (fotoURL) URL.revokeObjectURL(fotoURL);
            fotoURL = URL.createObjectURL(file);
            previewFoto.src = fotoURL;
            previewFoto.hidden = false;
        });
    }

    if (audioInput && previewAudio) {
        audioInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) {
                previewAudio.hidden = true;
                previewAudio.removeAttribute("src");
                return;
            }

            if (!validasiFile(this, file, "Audio", [
                "audio/mpeg", "audio/wav", "audio/x-wav",
                "audio/wave", "audio/vnd.wave", "audio/x-pn-wav"
            ])) {
                previewAudio.hidden = true;
                return;
            }

            if (audioURL) URL.revokeObjectURL(audioURL);
            audioURL = URL.createObjectURL(file);
            previewAudio.src = audioURL;
            previewAudio.hidden = false;
        });
    }

    if (dokumenInput && previewDokumen) {
        dokumenInput.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) {
                previewDokumen.textContent = "Belum ada dokumen dipilih.";
                return;
            }

            if (!validasiFile(this, file, "Dokumen", ["application/pdf"])) {
                previewDokumen.textContent = "Belum ada dokumen dipilih.";
                return;
            }

            previewDokumen.textContent =
                file.name + " - " + Math.round(file.size / 1024) + " KB";
        });
    }

    if (form) {
        form.addEventListener("submit", function (event) {
            const nim = document.getElementById("nim");
            const nama = document.getElementById("nama");
            const prodi = document.getElementById("program_studi");
            const email = document.getElementById("email");
            let valid = true;

            document.querySelectorAll(".form-error").forEach(function (el) {
                el.textContent = "";
            });
            document.querySelectorAll(".is-invalid").forEach(function (el) {
                el.classList.remove("is-invalid");
            });

            function tandaiError(input, errorId, pesan) {
                const errorEl = document.getElementById(errorId);
                if (errorEl) errorEl.textContent = pesan;
                if (input) input.classList.add("is-invalid");
                valid = false;
            }

            if (!nim || nim.value.trim() === "") {
                tandaiError(nim, "errorNim", "NIM wajib diisi.");
            }
            if (!nama || nama.value.trim() === "") {
                tandaiError(nama, "errorNama", "Nama wajib diisi.");
            }
            if (!prodi || prodi.value.trim() === "") {
                tandaiError(prodi, "errorProdi", "Program studi wajib diisi.");
            }
            if (!email || email.value.trim() === "" || !email.checkValidity()) {
                tandaiError(email, "errorEmail", "Email tidak valid.");
            }

            const wajibFoto = form.dataset.requireFoto === "true";
            if (wajibFoto && fotoInput && fotoInput.files.length === 0) {
                const errorFoto = document.getElementById("errorFoto");
                if (errorFoto) errorFoto.textContent = "Foto wajib dipilih.";
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
                alert("Form belum valid. Periksa kembali input Anda.");
            }
        });
    }

    document.querySelectorAll(".media-delete-form").forEach(function (formDelete) {
        formDelete.addEventListener("submit", function (event) {
            if (!confirm("Data dan file media terkait akan dihapus. Lanjutkan?")) {
                event.preventDefault();
            }
        });
    });

    const searchMedia = document.getElementById("searchMedia");
    const mediaRows = document.querySelectorAll("#mediaTable tbody tr");

    if (searchMedia) {
        searchMedia.addEventListener("input", function () {
            const keyword = this.value.toLowerCase().trim();
            mediaRows.forEach(function (row) {
                row.style.display = row.textContent.toLowerCase().includes(keyword) ? "" : "none";
            });
        });
    }

    const params = new URLSearchParams(window.location.search);
    const status = params.get("status");
    if (status === "tambah") alert("Data media berhasil ditambahkan.");
    if (status === "update") alert("Data media berhasil diperbarui.");
    if (status === "hapus") alert("Data media berhasil dihapus.");
});