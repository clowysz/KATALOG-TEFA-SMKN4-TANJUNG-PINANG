function openPortoModal(id) {
document.getElementById(id).classList.add('active');
}

function closePortoModal(id) {
document.getElementById(id).classList.remove('active');
}

function openTambahPortoModal() {

document.getElementById('formPorto').reset();

document.getElementById('portoId').value = '';

document.getElementById('modalPortoTitle').textContent =
    'Tambah Portofolio';

document.getElementById('portoImg')
    .setAttribute('required', 'true');

if (window.uploadedFiles) {
    window.uploadedFiles = [];
}

const previewContainer =
    document.getElementById('imagePreviewContainer');

if (previewContainer) {
    previewContainer.innerHTML = '';
}

openPortoModal('modalAddPorto');

}

document.addEventListener('DOMContentLoaded', function () {

const container =
    document.getElementById('portoContainer');

const searchInput =
    document.getElementById('searchPorto');

const toast =
    document.getElementById('toastPorto');

const form =
    document.getElementById('formPorto');

const portoImg =
    document.getElementById('portoImg');


function showToast(message, type = 'success') {

    if (!toast) {
        return;
    }

    toast.textContent = message;

    toast.style.backgroundColor =
        type === 'error'
            ? '#dc3545'
            : '#28a745';

    toast.classList.add('show');

    setTimeout(function () {
        toast.classList.remove('show');
    }, 3000);
}


function getCsrfToken() {

    const meta =
        document.querySelector('meta[name="csrf-token"]');

    return meta
        ? meta.getAttribute('content')
        : '';
}


async function loadPortofolio(filterText = '') {

    try {

        const response = await fetch(
            '/jurusan-admin/portofolio'
        );

        if (!response.ok) {
            throw new Error(
                'Gagal mengambil data portofolio.'
            );
        }

        const result =
            await response.json();

        const dataPorto =
            result.data || [];

        renderPorto(
            dataPorto,
            filterText
        );

    } catch (error) {

        console.error(error);

        container.innerHTML = `
            <div style="
                grid-column: 1 / -1;
                text-align: center;
                padding: 80px 20px;
            ">
                <div style="
                    font-size: 56px;
                    margin-bottom: 16px;
                ">
                    ⚠️
                </div>

                <h3 style="
                    color: var(--text-dark);
                    margin-bottom: 8px;
                ">
                    Gagal memuat portofolio
                </h3>

                <p style="
                    color: var(--text-muted);
                ">
                    Silakan coba muat ulang halaman.
                </p>
            </div>
        `;
    }
}


function renderPorto(
    dataPorto,
    filterText = ''
) {

    container.innerHTML = '';

    const keyword =
        filterText.toLowerCase().trim();


    const filteredData =
        dataPorto.filter(function (item) {

            return item.judul
                .toLowerCase()
                .includes(keyword);

        });


    if (filteredData.length === 0) {

        container.innerHTML = `
            <div style="
                grid-column: 1 / -1;
                text-align: center;
                padding: 80px 20px;
            ">

                <div style="
                    font-size: 56px;
                    margin-bottom: 16px;
                ">
                    📂
                </div>

                <h3 style="
                    color: var(--text-dark);
                    margin-bottom: 8px;
                ">
                    Tidak ada portofolio ditemukan.
                </h3>

                <p style="
                    color: var(--text-muted);
                ">
                    Coba gunakan kata kunci pencarian yang lain.
                </p>

            </div>
        `;

        return;
    }


    filteredData.forEach(function (item) {

        const card =
            document.createElement('div');

        card.className =
            'portfolio-card';


        const gambar =
            item.gambars &&
            item.gambars.length > 0
                ? item.gambars[0]
                : null;


        const imageUrl =
            gambar
                ? '/storage/' + gambar.path_gambar
                : 'https://placehold.co/600x400/E2E8F0/1E3A8A?text=Portofolio';


        const tahun =
            item.tahun
                ? item.tahun
                : '-';


        const deskripsi =
            item.deskripsi
                ? item.deskripsi.substring(0, 80) +
                  (item.deskripsi.length > 80 ? '...' : '')
                : 'Tidak ada deskripsi.';


        card.innerHTML = `
            <img
                src="${imageUrl}"
                alt="${escapeHtml(item.judul)}"
                class="portfolio-img"
            >

            <div class="portfolio-content">

                <h4>
                    ${escapeHtml(item.judul)}
                </h4>

                <p>
                    ${escapeHtml(deskripsi)}
                </p>

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                ">

                    <span class="portfolio-badge">
                        ${escapeHtml(tahun)}
                    </span>

                </div>

                <div class="catalog-actions">

                    <button
                        type="button"
                        class="btn-outline btn-edit-porto"
                        data-id="${item.id_portfolio}"
                    >
                        Edit
                    </button>

                    <button
                        type="button"
                        class="btn-outline btn-delete-porto"
                        data-id="${item.id_portfolio}"
                        style="
                            color:#dc3545;
                            border-color:#dc3545;
                        "
                    >
                        Hapus
                    </button>

                </div>

            </div>
        `;


        container.appendChild(card);

    });


    document
        .querySelectorAll('.btn-edit-porto')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const id =
                        this.getAttribute(
                            'data-id'
                        );

                    const item =
                        filteredData.find(
                            function (data) {
                                return String(
                                    data.id_portfolio
                                ) === String(id);
                            }
                        );

                    if (!item) {
                        return;
                    }


                    document.getElementById(
                        'portoId'
                    ).value =
                        item.id_portfolio;


                    document.getElementById(
                        'portoTitle'
                    ).value =
                        item.judul;


                    document.getElementById(
                        'portoDesc'
                    ).value =
                        item.deskripsi;


                    document.getElementById(
                        'portoYear'
                    ).value =
                        item.tahun || '';


                    document.getElementById(
                        'portoImg'
                    ).removeAttribute(
                        'required'
                    );


                    document.getElementById(
                        'portoImg'
                    ).value = '';


                    if (window.uploadedFiles) {
                        window.uploadedFiles = [];
                    }


                    const previewContainer =
                        document.getElementById(
                            'imagePreviewContainer'
                        );


                    if (previewContainer) {

                        previewContainer.innerHTML = '';


                        if (
                            item.gambars &&
                            item.gambars.length > 0
                        ) {

                            item.gambars.forEach(
                                function (gambar) {

                                    const wrapper =
                                        document.createElement(
                                            'div'
                                        );

                                    wrapper.style.position =
                                        'relative';

                                    wrapper.style.display =
                                        'inline-block';


                                    const image =
                                        document.createElement(
                                            'img'
                                        );

                                    image.src =
                                        '/storage/' +
                                        gambar.path_gambar;

                                    image.style.width =
                                        '70px';

                                    image.style.height =
                                        '70px';

                                    image.style.objectFit =
                                        'cover';

                                    image.style.borderRadius =
                                        '8px';

                                    image.style.border =
                                        '1px solid #CBD5E1';


                                    const label =
                                        document.createElement(
                                            'div'
                                        );

                                    label.textContent =
                                        'Gambar Lama';

                                    label.style.fontSize =
                                        '11px';

                                    label.style.textAlign =
                                        'center';

                                    label.style.marginTop =
                                        '4px';

                                    label.style.color =
                                        '#64748b';


                                    wrapper.appendChild(
                                        image
                                    );

                                    wrapper.appendChild(
                                        label
                                    );

                                    previewContainer.appendChild(
                                        wrapper
                                    );

                                }
                            );

                        }

                    }


                    document.getElementById(
                        'modalPortoTitle'
                    ).textContent =
                        'Edit Portofolio';


                    openPortoModal(
                        'modalAddPorto'
                    );

                }
            );

        });


    document
        .querySelectorAll('.btn-delete-porto')
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const id =
                        this.getAttribute(
                            'data-id'
                        );

                    document.getElementById(
                        'deletePortoId'
                    ).value = id;

                    openPortoModal(
                        'modalDeletePorto'
                    );

                }
            );

        });

}


function escapeHtml(text) {

    const div =
        document.createElement('div');

    div.textContent =
        text ?? '';

    return div.innerHTML;
}


form.addEventListener(
    'submit',
    async function (event) {

        event.preventDefault();


        const id =
            document.getElementById(
                'portoId'
            ).value;


        const isEdit =
            id !== '';


        const formData =
            new FormData(form);


        if (isEdit) {

            formData.append(
                '_method',
                'PUT'
            );

        }


        try {

            const url =
                isEdit
                    ? `/jurusan-admin/portofolio/${id}`
                    : '/jurusan-admin/portofolio';


            const response =
                await fetch(url, {

                    method: 'POST',

                    headers: {
                        'X-CSRF-TOKEN':
                            getCsrfToken(),
                        'Accept':
                            'application/json'
                    },

                    body: formData

                });


            const result =
                await response.json();


            if (!response.ok) {

                if (result.errors) {

                    const firstError =
                        Object.values(
                            result.errors
                        )[0];

                    throw new Error(
                        firstError[0]
                    );

                }

                throw new Error(
                    result.message ||
                    'Gagal menyimpan portofolio.'
                );
            }


            showToast(
                result.message ||
                (
                    isEdit
                        ? 'Portofolio berhasil diperbarui.'
                        : 'Portofolio berhasil ditambahkan.'
                )
            );


            if (window.uploadedFiles) {
                window.uploadedFiles = [];
            }


            form.reset();

            document.getElementById(
                'portoId'
            ).value = '';


            document.getElementById(
                'imagePreviewContainer'
            ).innerHTML = '';


            closePortoModal(
                'modalAddPorto'
            );


            loadPortofolio(
                searchInput
                    ? searchInput.value
                    : ''
            );


        } catch (error) {

            console.error(error);

            showToast(
                error.message ||
                'Terjadi kesalahan.',
                'error'
            );

        }

    }
);


document
    .getElementById(
        'btnConfirmDeletePorto'
    )
    .addEventListener(
        'click',
        async function () {

            const id =
                document.getElementById(
                    'deletePortoId'
                ).value;


            if (!id) {
                return;
            }


            try {

                const response =
                    await fetch(
                        `/jurusan-admin/portofolio/${id}`,
                        {
                            method: 'DELETE',

                            headers: {
                                'X-CSRF-TOKEN':
                                    getCsrfToken(),

                                'Accept':
                                    'application/json'
                            }
                        }
                    );


                const result =
                    await response.json();


                if (!response.ok) {

                    throw new Error(
                        result.message ||
                        'Gagal menghapus portofolio.'
                    );

                }


                closePortoModal(
                    'modalDeletePorto'
                );


                showToast(
                    result.message ||
                    'Portofolio berhasil dihapus.'
                );


                loadPortofolio(
                    searchInput
                        ? searchInput.value
                        : ''
                );


            } catch (error) {

                console.error(error);

                showToast(
                    error.message ||
                    'Terjadi kesalahan.',
                    'error'
                );

            }

        }
    );


if (searchInput) {

    searchInput.addEventListener(
        'keyup',
        function () {

            loadPortofolio(
                this.value
            );

        }
    );

}


loadPortofolio();

});