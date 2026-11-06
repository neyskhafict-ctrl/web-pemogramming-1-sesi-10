-- Jalankan pada database web_programming_1 melalui phpMyAdmin.
-- Backup database terlebih dahulu. Jalankan query ini satu kali.
ALTER TABLE mahasiswa
    ADD foto VARCHAR(255) NULL,
    ADD audio VARCHAR(255) NULL,
    ADD dokumen VARCHAR(255) NULL;
