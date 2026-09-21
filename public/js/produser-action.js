document.addEventListener('DOMContentLoaded', function () {

    const detailPage = document.getElementById('formUpdateProgress');

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');

        if (meta) {
            return meta.getAttribute('content');
        }

        return null;
    }

    function submitForm(action, method, fields = {}) {
        const form = document.createElement('form');

        form.method = 'POST';
        form.action = action;
        form.style.display = 'none';

        const token = getCsrfToken();

        if (token) {
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = token;
            form.appendChild(csrf);
        }

        if (method !== 'POST') {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = method;
            form.appendChild(methodInput);
        }

        Object.keys(fields).forEach(function (key) {
            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = key;
            input.value = fields[key] ?? '';

            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }


    function showToast(message, success = true) {
        const toast = document.getElementById('toastUpdate');

        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.style.backgroundColor = success
            ? '#16A34A'
            : '#DC2626';

        toast.classList.add('show');

        setTimeout(function () {
            toast.classList.remove('show');
        }, 3000);
    }


    function formatRupiah(number) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }


    function formatTanggal(tanggal) {
        if (!tanggal) {
            return '-';
        }

        const date = new Date(tanggal);

        if (Number.isNaN(date.getTime())) {
            return tanggal;
        }

        return date.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
    }


    function getStatusClass(status) {
        if (status === 'Selesai') {
            return 'badge-soft-green';
        }

        if (
            status === 'Sedang Dikerjakan' ||
            status === 'Diproses' ||
            status === 'konfirmasi'
        ) {
            return 'badge-soft-blue';
        }

        if (
            status === 'Dalam Revisi' ||
            status === 'Revisi'
        ) {
            return 'badge-soft-yellow';
        }

        return 'badge-soft-gray';
    }


    /*
     * DETAIL PESANAN
     */

    if (detailPage) {

        const orderId = detailPage.dataset.orderId;

        let stages = [];

        try {
            stages = JSON.parse(
                detailPage.dataset.stages || '[]'
            );
        } catch (error) {
            stages = [];
        }


        const heroOrderId =
            document.getElementById('heroOrderId');

        const heroStatusPesanan =
            document.getElementById('heroStatusPesanan');

        const heroStatusPengerjaan =
            document.getElementById('heroStatusPengerjaan');

        const heroTitle =
            document.getElementById('heroTitle');

        const heroType =
            document.getElementById('heroType');

        const heroCode =
            document.getElementById('heroCode');

        const statDate =
            document.getElementById('statDate');

        const statCustomer =
            document.getElementById('statCustomer');

        const statPrice =
            document.getElementById('statPrice');

        const statStatus =
            document.getElementById('statStatus');

        const detNeedTitle =
            document.getElementById('detNeedTitle');

        const detNeedDesc =
            document.getElementById('detNeedDesc');

        const stepperContainer =
            document.getElementById('stepperContainer');

        const stepperSubtitle =
            document.getElementById('stepperSubtitle');

        const formSubtitle =
            document.getElementById('formSubtitle');

        const selectedStageBox =
            document.getElementById('selectedStageBox');

        const activeStageId =
            document.getElementById('activeStageId');

        const updateStatus =
            document.getElementById('updateStatus');

        const updateProgress =
            document.getElementById('updateProgress');

        const updateNote =
            document.getElementById('updateNote');

        const progressText =
            document.getElementById('progressText');

        const progressSliderBox =
            document.getElementById('progressSliderBox');

        const btnSimpanUpdate =
            document.getElementById('btnSimpanUpdate');


        let activeStage = null;


        if (heroOrderId) {
            heroOrderId.textContent =
                'ORD-' + String(orderId).padStart(3, '0');
        }


        if (heroStatusPesanan) {
            heroStatusPesanan.textContent =
                detailPage.dataset.statusPesanan || '-';
        }


        if (heroStatusPengerjaan) {
            heroStatusPengerjaan.textContent =
                stages.length > 0
                    ? getStatusPengerjaan(stages)
                    : 'Belum Dimulai';
        }


        if (heroTitle) {
            heroTitle.textContent =
                detailPage.dataset.productName || '-';
        }


        if (heroType) {
            heroType.textContent =
                detailPage.dataset.productType || '-';
        }


        if (heroCode) {
            heroCode.textContent =
                'Kode: ' +
                (detailPage.dataset.productCode || '-');
        }


        if (statDate) {
            statDate.textContent =
                formatTanggal(detailPage.dataset.orderDate);
        }


        if (statCustomer) {
            statCustomer.textContent =
                detailPage.dataset.customer || '-';
        }


        if (statPrice) {
            statPrice.textContent =
                formatRupiah(
                    Number(detailPage.dataset.totalPrice || 0)
                );
        }


        if (statStatus) {
            statStatus.textContent =
                stages.length > 0
                    ? getStatusPengerjaan(stages)
                    : 'Belum Dimulai';
        }


        if (detNeedTitle) {
            detNeedTitle.textContent =
                detailPage.dataset.productName || '-';
        }


        if (detNeedDesc) {
            detNeedDesc.textContent =
                detailPage.dataset.note || 'Tidak ada catatan dari pelanggan.';
        }


        function getStatusPengerjaan(data) {

            if (!data.length) {
                return 'Belum Dimulai';
            }

            const selesai = data.filter(function (stage) {
                return stage.status === 'Selesai';
            }).length;

            if (selesai === data.length) {
                return 'Selesai';
            }

            const revisi = data.find(function (stage) {
                return stage.status === 'Dalam Revisi';
            });

            if (revisi) {
                return 'Dalam Revisi';
            }

            const proses = data.find(function (stage) {
                return stage.status === 'Sedang Dikerjakan';
            });

            if (proses) {
                return 'Sedang Dikerjakan';
            }

            return 'Belum Dimulai';
        }


        function applySliderColor() {

            if (!updateProgress) {
                return;
            }

            const value =
                Number(updateProgress.value || 0);

            updateProgress.style.background =
                `linear-gradient(
                    to right,
                    var(--primary) ${value}%,
                    #E2E8F0 ${value}%
                )`;

            if (progressText) {
                progressText.textContent =
                    value + '%';
            }
        }


        function renderStepper() {

            if (!stepperContainer) {
                return;
            }

            stepperContainer.innerHTML = '';


            const totalSelesai =
                stages.filter(function (stage) {
                    return stage.status === 'Selesai';
                }).length;


            if (stepperSubtitle) {
                stepperSubtitle.textContent =
                    `${totalSelesai} dari ${stages.length} tahap selesai`;
            }


            if (stages.length === 0) {

                stepperContainer.innerHTML = `
                    <div style="
                        padding: 24px;
                        text-align: center;
                        color: var(--prod-text-sec);
                        font-size: 14px;
                    ">
                        Belum ada tahapan pengerjaan.
                    </div>
                `;

                return;
            }


            stages.forEach(function (stage, index) {

                let circleClass = 'belum';
                let icon = index + 1;
                let statusColor = 'var(--prod-text-sec)';


                if (stage.status === 'Selesai') {

                    circleClass = 'selesai';
                    icon = '<i class="ph ph-check"></i>';
                    statusColor = 'var(--prod-success)';

                } else if (
                    stage.status === 'Sedang Dikerjakan'
                ) {

                    circleClass = 'proses';
                    statusColor = 'var(--primary)';

                } else if (
                    stage.status === 'Dalam Revisi'
                ) {

                    circleClass = 'proses';
                    statusColor = '#D97706';
                }


                const isActive =
                    activeStage &&
                    Number(activeStage.id_tahapan) ===
                    Number(stage.id_tahapan);


                let extraContent = '';


                if (isActive || stage.status !== 'Belum Dimulai') {

                    if (
                        stage.status === 'Sedang Dikerjakan' ||
                        stage.status === 'Dalam Revisi'
                    ) {

                        extraContent = `
                            <div style="margin-top: 12px;">
                                <div class="mini-progress-bg">
                                    <div
                                        class="mini-progress-fill"
                                        style="width: ${stage.persentase_progress || 0}%;">
                                    </div>
                                </div>

                                <div style="
                                    font-size: 12px;
                                    color: var(--primary);
                                    font-weight: 600;
                                    margin-top: 5px;
                                ">
                                    Progress ${stage.persentase_progress || 0}%
                                </div>
                            </div>
                        `;
                    }

                }


                stepperContainer.innerHTML += `
                    <div
                        class="stepper-item ${isActive ? 'active-step' : ''}"
                        data-id="${stage.id_tahapan}"
                        style="cursor: pointer;"
                    >

                        <div class="stepper-line"></div>

                        <div class="stepper-circle ${circleClass}">
                            ${icon}
                        </div>

                        <div style="flex-grow: 1;">

                            <div style="
                                display: flex;
                                justify-content: space-between;
                                align-items: flex-start;
                                gap: 12px;
                            ">

                                <div>

                                    <div style="
                                        font-weight: 700;
                                        color: var(--prod-text-main);
                                        font-size: 15px;
                                        margin-bottom: 4px;
                                    ">
                                        Tahap ${index + 1}: ${stage.nama_tahapan}
                                    </div>

                                    <div style="
                                        font-size: 12px;
                                        color: ${statusColor};
                                    ">
                                        ${stage.status}
                                    </div>

                                </div>

                                <span style="
                                    font-size: 13px;
                                    color: ${statusColor};
                                    font-weight: 500;
                                ">
                                    ${stage.persentase_progress || 0}%
                                </span>

                            </div>

                            ${extraContent}

                        </div>
                    </div>
                `;
            });


            document
                .querySelectorAll('.stepper-item')
                .forEach(function (element) {

                    element.addEventListener(
                        'click',
                        function () {

                            const id =
                                Number(
                                    this.getAttribute('data-id')
                                );

                            activeStage =
                                stages.find(function (stage) {
                                    return Number(stage.id_tahapan) === id;
                                }) || null;

                            populateForm();
                            renderStepper();
                        }
                    );
                });
        }


        function populateForm() {

            if (!activeStage) {

                if (formSubtitle) {
                    formSubtitle.textContent =
                        'Belum ada tahap yang dipilih.';
                }

                if (selectedStageBox) {
                    selectedStageBox.textContent =
                        'Pilih tahap pengerjaan...';
                }

                if (updateStatus) {
                    updateStatus.disabled = true;
                }

                if (updateProgress) {
                    updateProgress.disabled = true;
                }

                if (updateNote) {
                    updateNote.disabled = true;
                }

                if (btnSimpanUpdate) {
                    btnSimpanUpdate.disabled = true;
                }

                if (progressSliderBox) {
                    progressSliderBox.style.display = 'none';
                }

                return;
            }


            const stageNumber =
                stages.findIndex(function (stage) {
                    return Number(stage.id_tahapan) ===
                        Number(activeStage.id_tahapan);
                }) + 1;


            if (formSubtitle) {
                formSubtitle.textContent =
                    `Memperbarui: Tahap ${stageNumber} — ${activeStage.nama_tahapan}`;
            }


            if (selectedStageBox) {
                selectedStageBox.textContent =
                    `Tahap ${stageNumber}: ${activeStage.nama_tahapan}`;
            }


            if (activeStageId) {
                activeStageId.value =
                    activeStage.id_tahapan;
            }


            if (updateStatus) {

                updateStatus.disabled = false;

                updateStatus.value =
                    activeStage.status;
            }


            if (updateProgress) {

                updateProgress.disabled =
                    activeStage.status === 'Selesai';

                updateProgress.value =
                    activeStage.status === 'Selesai'
                        ? 100
                        : Number(
                            activeStage.persentase_progress || 0
                        );
            }


            if (updateNote) {

                updateNote.disabled = false;

                updateNote.value = '';
            }


            if (btnSimpanUpdate) {
                btnSimpanUpdate.disabled = false;
            }


            if (
                activeStage.status === 'Belum Dimulai'
            ) {

                if (progressSliderBox) {
                    progressSliderBox.style.display = 'none';
                }

            } else {

                if (progressSliderBox) {
                    progressSliderBox.style.display = 'block';
                }

                if (updateProgress) {
                    updateProgress.disabled =
                        activeStage.status === 'Selesai';
                }

                applySliderColor();
            }
        }


        if (updateProgress) {

            updateProgress.addEventListener(
                'input',
                function () {
                    applySliderColor();
                }
            );
        }


        if (updateStatus) {

            updateStatus.addEventListener(
                'change',
                function () {

                    if (
                        this.value === 'Belum Dimulai'
                    ) {

                        if (progressSliderBox) {
                            progressSliderBox.style.display = 'none';
                        }

                        if (updateProgress) {
                            updateProgress.value = 0;
                        }

                    } else {

                        if (progressSliderBox) {
                            progressSliderBox.style.display = 'block';
                        }

                        if (
                            this.value === 'Selesai'
                        ) {

                            if (updateProgress) {
                                updateProgress.value = 100;
                                updateProgress.disabled = true;
                            }

                        } else {

                            if (updateProgress) {
                                updateProgress.disabled = false;
                            }
                        }

                        applySliderColor();
                    }
                }
            );
        }


        if (detailPage) {

            detailPage.addEventListener(
                'submit',
                function (event) {

                    event.preventDefault();

                    if (!activeStage) {
                        showToast(
                            'Pilih tahap pengerjaan terlebih dahulu.',
                            false
                        );

                        return;
                    }


                    const status =
                        updateStatus.value;

                    let percentage =
                        Number(updateProgress.value || 0);


                    if (
                        status === 'Belum Dimulai'
                    ) {
                        percentage = 0;
                    }


                    if (
                        status === 'Selesai'
                    ) {
                        percentage = 100;
                    }


                    const note =
                        updateNote.value.trim();


                    if (!note) {
                        showToast(
                            'Catatan / update wajib diisi.',
                            false
                        );

                        return;
                    }


                    submitForm(
                        detailPage.dataset.updateProgressUrl,
                        'POST',
                        {
                            persentase_progress: percentage,
                            keterangan_progress: note
                        }
                    );
                }
            );
        }


        renderStepper();


        if (stages.length > 0) {

            activeStage =
                stages.find(function (stage) {

                    return stage.status !== 'Selesai';

                }) || stages[stages.length - 1];

        }


        populateForm();
    }


    /*
     * MODAL KELOLA TAHAPAN
     */

    window.openModalTahapan = function () {

        const modal =
            document.getElementById('modalKelolaTahapan');

        if (!modal) {
            return;
        }

        modal.style.display = 'flex';

        renderTabelTahapan();
    };


    window.closeModalTahapan = function () {

        const modal =
            document.getElementById('modalKelolaTahapan');

        if (!modal) {
            return;
        }

        modal.style.display = 'none';
    };


    window.openFormTambahTahap = function () {

        const modal =
            document.getElementById('modalFormTahap');

        const title =
            document.getElementById('formTahapTitle');

        const editId =
            document.getElementById('editStageId');

        const nama =
            document.getElementById('inputNamaTahap');

        const status =
            document.getElementById('inputStatusTahap');


        if (title) {
            title.textContent =
                'Tambah Tahap Baru';
        }

        if (editId) {
            editId.value = '';
        }

        if (nama) {
            nama.value = '';
        }

        if (status) {
            status.value = 'Belum Dimulai';
        }

        if (modal) {
            modal.style.display = 'flex';
        }
    };


    window.closeFormTahap = function () {

        const modal =
            document.getElementById('modalFormTahap');

        if (!modal) {
            return;
        }

        modal.style.display = 'none';
    };


    function getDetailPage() {

        return document.getElementById(
            'formUpdateProgress'
        );
    }


    function getStagesFromPage() {

        const detailPage =
            getDetailPage();

        if (!detailPage) {
            return [];
        }

        try {

            return JSON.parse(
                detailPage.dataset.stages || '[]'
            );

        } catch (error) {

            return [];
        }
    }


    function renderTabelTahapan() {

        const tbody =
            document.getElementById('tabelTahapanBody');

        if (!tbody) {
            return;
        }


        const stages =
            getStagesFromPage();


        if (stages.length === 0) {

            tbody.innerHTML = `
                <tr>
                    <td
                        colspan="4"
                        style="
                            text-align: center;
                            padding: 20px;
                            color: var(--prod-text-sec);
                        "
                    >
                        Belum ada tahapan pengerjaan.
                    </td>
                </tr>
            `;

            return;
        }


        tbody.innerHTML = '';


        stages.forEach(function (stage, index) {

            tbody.innerHTML += `
                <tr
                    draggable="true"
                    data-id="${stage.id_tahapan}"
                    style="border-bottom: 1px solid var(--prod-border);"
                >

                    <td style="padding: 12px;">
                        ${index + 1}
                    </td>

                    <td style="
                        padding: 12px;
                        font-weight: 600;
                    ">
                        ${stage.nama_tahapan}
                    </td>

                    <td style="padding: 12px;">
                        ${stage.status}
                    </td>

                    <td style="
                        padding: 12px;
                        text-align: center;
                        white-space: nowrap;
                    ">

                        <button
                            type="button"
                            onclick="editTahapan(
                                ${stage.id_tahapan}
                            )"
                            style="
                                background: none;
                                border: none;
                                color: #2563EB;
                                cursor: pointer;
                                margin-right: 8px;
                            "
                        >
                            <i class="ph ph-pencil-simple"></i>
                        </button>

                        <button
                            type="button"
                            onclick="hapusTahapan(
                                ${stage.id_tahapan}
                            )"
                            style="
                                background: none;
                                border: none;
                                color: #DC2626;
                                cursor: pointer;
                            "
                        >
                            <i class="ph ph-trash"></i>
                        </button>

                    </td>
                </tr>
            `;
        });


        enableDragAndDrop();
    }


    window.editTahapan = function (id) {

        const stages =
            getStagesFromPage();

        const stage =
            stages.find(function (item) {
                return Number(item.id_tahapan) ===
                    Number(id);
            });


        if (!stage) {
            return;
        }


        const modal =
            document.getElementById('modalFormTahap');

        const title =
            document.getElementById('formTahapTitle');

        const editId =
            document.getElementById('editStageId');

        const nama =
            document.getElementById('inputNamaTahap');

        const status =
            document.getElementById('inputStatusTahap');


        if (title) {
            title.textContent =
                'Edit Tahap';
        }

        if (editId) {
            editId.value =
                stage.id_tahapan;
        }

        if (nama) {
            nama.value =
                stage.nama_tahapan;
        }

        if (status) {
            status.value =
                stage.status;
        }

        if (modal) {
            modal.style.display = 'flex';
        }
    };


    window.hapusTahapan = function (id) {

        const confirmed =
            confirm(
                'Yakin ingin menghapus tahapan ini?'
            );

        if (!confirmed) {
            return;
        }


        const detailPage =
            getDetailPage();

        if (!detailPage) {
            return;
        }


        submitForm(
            detailPage.dataset.deleteTahapanBaseUrl +
            '/' + id,
            'DELETE'
        );
    };


    const formSimpanTahap =
        document.getElementById(
            'formSimpanTahap'
        );


    if (formSimpanTahap) {

        formSimpanTahap.addEventListener(
            'submit',
            function (event) {

                event.preventDefault();


                const detailPage =
                    getDetailPage();

                if (!detailPage) {
                    return;
                }


                const editId =
                    document.getElementById(
                        'editStageId'
                    ).value;


                const nama =
                    document.getElementById(
                        'inputNamaTahap'
                    ).value.trim();


                const status =
                    document.getElementById(
                        'inputStatusTahap'
                    ).value;


                if (!nama) {

                    showToast(
                        'Nama tahapan wajib diisi.',
                        false
                    );

                    return;
                }


                if (editId) {

                    submitForm(
                        detailPage.dataset.updateTahapanBaseUrl +
                        '/' + editId,
                        'PUT',
                        {
                            nama_tahapan: nama,
                            status: status,
                            persentase_progress:
                                status === 'Selesai'
                                    ? 100
                                    : 0
                        }
                    );

                } else {

                    submitForm(
                        detailPage.dataset.storeTahapanUrl,
                        'POST',
                        {
                            nama_tahapan: nama,
                            status: status,
                            persentase_progress:
                                status === 'Selesai'
                                    ? 100
                                    : 0
                        }
                    );
                }
            }
        );
    }


    function enableDragAndDrop() {

        const tbody =
            document.getElementById(
                'tabelTahapanBody'
            );

        if (!tbody) {
            return;
        }


        let draggedRow = null;


        tbody
            .querySelectorAll('tr[data-id]')
            .forEach(function (row) {

                row.addEventListener(
                    'dragstart',
                    function () {
                        draggedRow = this;
                    }
                );


                row.addEventListener(
                    'dragover',
                    function (event) {

                        event.preventDefault();

                        if (
                            draggedRow &&
                            draggedRow !== this
                        ) {

                            const rect =
                                this.getBoundingClientRect();

                            const middle =
                                rect.top +
                                rect.height / 2;


                            if (
                                event.clientY <
                                middle
                            ) {

                                tbody.insertBefore(
                                    draggedRow,
                                    this
                                );

                            } else {

                                tbody.insertBefore(
                                    draggedRow,
                                    this.nextSibling
                                );
                            }
                        }
                    }
                );


                row.addEventListener(
                    'dragend',
                    function () {

                        saveTahapanOrder();
                    }
                );
            });
    }


    function saveTahapanOrder() {

        const detailPage =
            getDetailPage();

        const tbody =
            document.getElementById(
                'tabelTahapanBody'
            );


        if (!detailPage || !tbody) {
            return;
        }


        const ids = [];


        tbody
            .querySelectorAll('tr[data-id]')
            .forEach(function (row) {

                ids.push(
                    row.getAttribute('data-id')
                );
            });


        if (ids.length === 0) {
            return;
        }


        submitForm(
            detailPage.dataset.reorderTahapanUrl,
            'POST',
            {
                urutan: ids
            }
        );
    }


    /*
     * KATALOG PRODUSER
     *
     * Bagian katalog tidak lagi memakai localStorage.
     * Data katalog sekarang diberikan langsung oleh Laravel.
     */

    const katalogContainer =
        document.getElementById(
            'katalogContainer'
        );


    if (katalogContainer) {

        const searchInput =
            document.getElementById(
                'searchKatalogProduser'
            );

        const cards =
            katalogContainer.querySelectorAll(
                '[data-katalog-name]'
            );

        function filterKatalog() {

            const keyword =
                searchInput
                    ? searchInput.value
                        .toLowerCase()
                        .trim()
                    : '';


            cards.forEach(function (card) {

                const name =
                    (
                        card.dataset.katalogName ||
                        ''
                    ).toLowerCase();


                card.style.display =
                    name.includes(keyword)
                        ? ''
                        : 'none';
            });
        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                filterKatalog
            );
        }
    }


    /*
     * TUTUP MODAL SAAT KLIK AREA LUAR
     */

    document.addEventListener(
        'click',
        function (event) {

            const modalTahapan =
                document.getElementById(
                    'modalKelolaTahapan'
                );

            const modalForm =
                document.getElementById(
                    'modalFormTahap'
                );


            if (
                modalTahapan &&
                event.target === modalTahapan
            ) {

                window.closeModalTahapan();
            }


            if (
                modalForm &&
                event.target === modalForm
            ) {

                window.closeFormTahap();
            }
        }
    );

});