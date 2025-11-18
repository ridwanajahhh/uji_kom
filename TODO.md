# TODO: Implement WhatsApp Purchase for Featured Products

## Tasks
- [x] Modify the "Beli Sekarang" button in `resources/views/welcome.blade.php` to link to WhatsApp with pre-filled purchase message
- [x] Use the store's contact number (`kontak_toko`) for WhatsApp link
- [x] Include product name and store name in the WhatsApp message
- [x] Test the functionality by running the application

## Notes
- Assumes `kontak_toko` in Toko model is a valid phone number
- WhatsApp link format: https://wa.me/{phone}?text={encoded_message}
- Message template: "Halo, saya ingin membeli produk {nama_produk} dari toko {nama_toko}"
- Application is running on http://127.0.0.1:8000
