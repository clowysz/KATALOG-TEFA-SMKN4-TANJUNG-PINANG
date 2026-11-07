

@push('css')
    <link rel="stylesheet" href="{{ asset('css/popup-batal-pesanan.css') }}?v=1">
@endpush

@push('js')
    <script src="{{ asset('js/popup-batal-pesanan.js') }}?v=1"></script>
@endpush

<div class="cancel-modal" id="cancelModal" hidden>
    <div
        class="cancel-modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cancelModalTitle"
    >
        
        <div class="cancel-modal-header">
            <h2 id="cancelModalTitle">Batalkan Pesanan</h2>

            <button
                type="button"
                class="cancel-modal-close"
                id="cancelModalClose"
                aria-label="Tutup popup"
            >
                &times;
            </button>
        </div>

        
        <form id="cancelOrderForm" class="cancel-modal-form" method="POST">
            @csrf

            <div class="cancel-modal-body" id="cancelModalBody">
                <p class="cancel-modal-description">
                    Mohon pilih alasan pembatalan pesanan kamu.
                </p>

                <div class="cancel-reason-list">
                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Saya berubah pikiran"
                            required
                        >
                        <span>Saya berubah pikiran</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Salah memilih produk atau jasa"
                        >
                        <span>Salah memilih produk atau jasa</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Ingin mengubah jumlah pesanan"
                        >
                        <span>Ingin mengubah jumlah pesanan</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Menemukan pilihan lain"
                        >
                        <span>Menemukan pilihan lain</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Waktu pengerjaan terlalu lama"
                        >
                        <span>Waktu pengerjaan terlalu lama</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="lainnya"
                        >
                        <span>Alasan lainnya</span>
                    </label>
                </div>

                <textarea
                    class="cancel-reason-other"
                    id="cancelReasonOther"
                    placeholder="Tuliskan alasan lainnya..."
                    maxlength="2000"
                    hidden
                ></textarea>
            </div>

            
            <p
                class="cancel-modal-message"
                id="cancelModalMessage"
                role="status"
                aria-live="polite"
            ></p>

            
            <div class="cancel-modal-footer" id="cancelModalFooter">
                <button
                    type="submit"
                    class="cancel-modal-submit"
                    id="cancelModalSubmit"
                >
                    Oke, Ajukan Pembatalan
                </button>
            </div>
        </form>
    </div>
</div>