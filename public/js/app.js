function parseTanggal(teks) {
    var tanggalSaja = String(teks).trim().split(/[ T]/)[0];
    var bagian = tanggalSaja.split("-");

    return new Date(
        Number(bagian[0]),
        Number(bagian[1]) - 1,
        Number(bagian[2])
    );
}

function hitungSisaHari(deadlineTeks) {
    var hariIni = new Date();
    hariIni.setHours(0, 0, 0, 0);

    var selisih = parseTanggal(deadlineTeks) - hariIni;
    return Math.round(selisih / (1000 * 60 * 60 * 24));
}

class EventItem {
    constructor(judul, deadlineTeks) {
        this.judul = judul;
        this.deadlineTeks = deadlineTeks;
        this.sisaHari = hitungSisaHari(deadlineTeks);
    }

    kodeStatus() {
        if (this.sisaHari < 0) {
            return "closed";
        } else if (this.sisaHari <= 3) {
            return "closing";
        }

        return "open";
    }

    labelStatus() {
        var label;

        switch (this.kodeStatus()) {
            case "closed":
                label = "Ditutup";
                break;

            case "closing":
                label = "Segera Ditutup";
                break;

            default:
                label = "Dibuka";
        }

        return label;
    }

    teksSisa() {
        if (this.sisaHari < 0) {
            return "Pendaftaran sudah ditutup";
        }

        if (this.sisaHari === 0) {
            return "Deadline hari ini";
        }

        return "Sisa " + this.sisaHari + " hari lagi";
    }
}

class ClosingEventItem extends EventItem {
    constructor(judul, deadlineTeks) {
        super(judul, deadlineTeks);
        this.peringatan = true;
    }

    teksSisa() {
        return "Segera ditutup! " + super.teksSisa();
    }
}

function buatEventItem(judul, deadlineTeks) {
    var sisa = hitungSisaHari(deadlineTeks);

    if (sisa >= 0 && sisa <= 3) {
        return new ClosingEventItem(judul, deadlineTeks);
    }

    return new EventItem(judul, deadlineTeks);
}

function hitungSisaSemuaKartu() {
    var kartu = document.querySelectorAll("article[data-deadline]");

    for (var i = 0; i < kartu.length; i++) {
        var deadline = kartu[i].getAttribute("data-deadline");

        if (!deadline) {
            continue;
        }

        var target = kartu[i].querySelector("[data-sisa-hari]");

        if (!target) {
            continue;
        }

        var elJudul = kartu[i].querySelector("h2");
        var judul = elJudul ? elJudul.textContent.trim() : "Event";

        var item = buatEventItem(judul, deadline);

        target.textContent = item.teksSisa();
        target.setAttribute("data-status", item.kodeStatus());
    }
}


function setPesanError(form, namaField, pesan) {
    var kolom = form.elements[namaField];

    if (!kolom) {
        return;
    }

    var span = kolom.parentNode.querySelector(
        ".error-js[data-for='" + namaField + "']"
    );

    if (!span) {
        span = document.createElement("span");
        span.className = "error-js";
        span.setAttribute("data-for", namaField);
        kolom.parentNode.appendChild(span);
    }

    span.textContent = pesan;
}

function validasiFormEvent(form) {
    var valid = true;

    var wajib = {
        title: "Judul wajib diisi",
        category: "Kategori wajib dipilih",
        description: "Deskripsi wajib diisi",
        location: "Lokasi wajib diisi",
        event_date: "Tanggal pelaksanaan wajib diisi",
        registration_deadline: "Deadline pendaftaran wajib diisi",
        registration_url: "Tautan pendaftaran wajib diisi"
    };

    for (var nama in wajib) {
        var kolom = form.elements[nama];

        var kosong = !kolom || kolom.value.trim() === "";

        setPesanError(
            form,
            nama,
            kosong ? wajib[nama] : ""
        );

        if (kosong) {
            valid = false;
        }
    }

    var tglAcara = form.elements["event_date"];
    var tglDeadline = form.elements["registration_deadline"];

    if (
        tglAcara &&
        tglDeadline &&
        tglAcara.value !== "" &&
        tglDeadline.value !== "" &&
        parseTanggal(tglDeadline.value) > parseTanggal(tglAcara.value)
    ) {
        setPesanError(
            form,
            "registration_deadline",
            "Deadline tidak boleh setelah tanggal acara"
        );

        valid = false;
    }

    var kolomURL = form.elements["registration_url"];

    if (kolomURL && kolomURL.value.trim() !== "") {
        var url = kolomURL.value.trim();

        if (!/^https?:\/\/.+/i.test(url)) {
            setPesanError(
                form,
                "registration_url",
                "Tautan harus diawali http:// atau https://"
            );

            valid = false;
        }
    }

    var poster = form.elements["poster"];

    if (poster && poster.files.length > 0) {
        var berkas = poster.files[0];

        if (berkas.type.indexOf("image/") !== 0) {
            setPesanError(
                form,
                "poster",
                "Poster harus berupa gambar"
            );

            valid = false;
        } else if (berkas.size > 2 * 1024 * 1024) {
            setPesanError(
                form,
                "poster",
                "Ukuran poster maksimal 2 MB"
            );

            valid = false;
        } else {
            setPesanError(form, "poster", "");
        }
    }

    return valid;
}

var jendelaPratinjau = null;
var urlPratinjauSementara = null;

function bukaPratinjau(urlPoster) {
    if (jendelaPratinjau && !jendelaPratinjau.closed) {
        jendelaPratinjau.close();
    }

    jendelaPratinjau = window.open(
        urlPoster,
        "pratinjauPoster",
        "width=600,height=800,scrollbars=yes"
    );

    return false;
}

function tutupPratinjau() {
    if (jendelaPratinjau && !jendelaPratinjau.closed) {
        jendelaPratinjau.close();
    }

    jendelaPratinjau = null;
}

function previewPosterTerpilih(inputPoster) {
    if (!inputPoster.files || inputPoster.files.length === 0) {
        alert("Pilih poster terlebih dahulu!");
        return;
    }

    var berkas = inputPoster.files[0];

    if (berkas.type.indexOf("image/") !== 0) {
        alert("File harus berupa gambar!");
        return;
    }

    if (berkas.size > 2 * 1024 * 1024) {
        alert("Ukuran poster maksimal 2 MB!");
        return;
    }

    if (urlPratinjauSementara) {
        URL.revokeObjectURL(urlPratinjauSementara);
    }

    urlPratinjauSementara = URL.createObjectURL(berkas);

    bukaPratinjau(urlPratinjauSementara);
}

function pasangKonfirmasiHapus() {
    var formHapus = document.querySelectorAll("form.form-hapus");

    for (var i = 0; i < formHapus.length; i++) {
        formHapus[i].addEventListener("submit", function (event) {
            var pesan = event.currentTarget.getAttribute("data-pesan")
                || "Yakin ingin menghapus data ini?";

            if (!confirm(pesan)) {
                event.preventDefault();
            }
        });
    }
}

function inisialisasi() {
    pasangKonfirmasiHapus();
    hitungSisaSemuaKartu();

    var formEvent = document.getElementById("form-event");

    if (formEvent) {
        formEvent.addEventListener("submit", function (event) {
            if (!validasiFormEvent(formEvent)) {
                event.preventDefault();
            }
        });
    }

    var inputPoster = document.getElementById("poster");

    var tombolPreview = document.getElementById("btn-preview-poster");

    if (inputPoster && tombolPreview) {
        tombolPreview.addEventListener("click", function () {
            previewPosterTerpilih(inputPoster);
        });
    }

    if (inputPoster && inputPoster.form) {
        inputPoster.addEventListener("change", function () {
            setPesanError(inputPoster.form, "poster", "");
        });
    }
}

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", inisialisasi);
} else {
    inisialisasi();
}