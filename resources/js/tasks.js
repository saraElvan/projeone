document.addEventListener('DOMContentLoaded', function () {
    let searchTimeout = null;
    let fetchController = null;

    // SweetAlert2 CDN kontrolü/tanımlaması
    const Swal2 = window.Swal || Swal;

    // Toast Bildirim Fonksiyonu
    function showToast(message, type = 'success') {
        if (typeof Swal2 !== 'undefined') {
            Swal2.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: message,
                showConfirmButton: false,
                timer: 3000
            });
        }
    }

    // Dynamic Fetch Tasks (JSON Response)
    async function fetchTasks(customParams = {}, pushState = true) {
        if (fetchController) fetchController.abort();
        fetchController = new AbortController();

        const form = document.getElementById('filtersForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData);

        Object.keys(customParams).forEach(key => {
            params.set(key, customParams[key]);
        });

        try {
            const response = await fetch(`/tasks/data?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: fetchController.signal
            });

            if (!response.ok) {
                showToast('Failed to load tasks.', 'error');
                return;
            }

            const data = await response.json();
            document.getElementById('tasksTableContainer').innerHTML = data.html;

            if (pushState) {
                window.history.pushState({}, '', `${window.location.pathname}?${params.toString()}`);
            }
        } catch (err) {
            if (err.name !== 'AbortError') {
                console.error('Fetch error:', err);
            }
        }
    }

    // Debounce Search Input (350ms)
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchTasks({ page: 1 });
            }, 350);
        });
    }

    // Pagination Link Capture (Event Delegation)
    document.addEventListener('click', async function (e) {
        const pageLink = e.target.closest('#paginationWrapper a, .pagination a');
        if (pageLink) {
            e.preventDefault();
            const page = new URL(pageLink.href).searchParams.get('page') || '1';
            await fetchTasks({ page });
        }

        // SweetAlert2 ile Silme Onayı
        const deleteBtn = e.target.closest('.delete-btn');
        if (deleteBtn) {
            e.preventDefault();
            const deleteUrl = deleteBtn.dataset.url;

            const result = await Swal2.fire({
                title: 'Delete this task?',
                text: "You won't be able to undo this.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            });

            if (result.isConfirmed) {
                try {
                    const res = await fetch(deleteUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ _method: 'DELETE' })
                    });

                    if (res.ok) {
                        showToast('Task deleted successfully.');
                        await fetchTasks({}, false);
                    }
                } catch (err) {
                    showToast('Error deleting task.', 'error');
                }
            }
        }
    });
});