<script>
    let deviceIdToDelete = null;

    function activateDevice(deviceToken, buttonElement) {
        // Mendapatkan konteks Alpine.js untuk mengakses variabel state
        const alpineContext = Alpine.$data(buttonElement.closest('[x-data]'));

        alpineContext.loading = true; // Tampilkan loading
        alpineContext.isOpen = true; // Buka modal

        // Fetch request untuk mengaktifkan perangkat dan mendapatkan QR code
        fetch('/devices/activate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    token: deviceToken
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    const qrImage = `<img src="data:image/png;base64,${data.url}" alt="QR Code" style="width: 200px; height: 200px;">`;
                    alpineContext.qrCode = qrImage; // Atur QR Code ke variabel Alpine
                } else {
                    console.error('Error:', data.error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Gagal mengaktifkan perangkat: ' + data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    // alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengaktifkan perangkat: ' + error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                // alert('An error occurred while activating the device.');
            })
            .finally(() => {
                alpineContext.loading = false; // Sembunyikan loading
            });
    }

    function showModal() {
        const modal = document.getElementById('deviceModal');
        modal.classList.remove('hidden');
    }

    function disconnectDevice(deviceToken) {
        // Tampilkan loading pada tombol yang sesuai
        const disconnectButton = document.querySelector(`.disconnectButton[data-device-token="${deviceToken}"]`);
        const disconnectSpinner = disconnectButton.querySelector('.disconnectSpinner');

        disconnectButton.disabled = true; // Nonaktifkan tombol
        disconnectSpinner.classList.remove('hidden'); // Tampilkan spinner

        // Lakukan fetch untuk memproses disconnect
        fetch('/devices/disconnect', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    token: deviceToken
                })
            })
            .then(response => response.json()) // Parsing respons JSON
            .then(data => {
                if (data.message) {
                    console.log(data.message);
                    Swal.fire({
                        title: 'Success!',
                        text: 'Device successfully disconnected.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    // alert('Device successfully disconnected.');
                    location.reload(); // Refresh halaman setelah sukses
                } else if (data.error) {
                    console.error('Error:', data.error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to disconnect device: ' + data.error,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    // alert('Failed to disconnect device: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while disconnecting the device.');
            })
            .finally(() => {
                // Kembalikan tombol ke keadaan semula
                disconnectButton.disabled = false; // Aktifkan kembali tombol
                disconnectSpinner.classList.add('hidden'); // Sembunyikan spinner
            });
    }

    function confirmDelete(deviceId, deviceName) {
        deviceIdToDelete = deviceId; // Store the device ID to delete
        document.getElementById('confirmDeleteMessage').innerText =
            `Apakah Anda yakin ingin menghapus perangkat "${deviceName}"?`;
        document.getElementById('confirmDeleteModal').classList.remove('hidden'); // Show confirmation modal
    }

    function closeConfirmDeleteModal() {
        document.getElementById('confirmDeleteModal').classList.add('hidden'); // Hide confirmation modal
        deviceIdToDelete = null; // Reset the device ID
    }

    function deleteDevice(otp = null) {
        const errorContainer = document.getElementById('errorContainerOTP');
        const errorMessage = document.getElementById('errorMessageOTP');

        errorContainer.classList.remove('hidden');
        if (otp) {

            axios.post('/devices/' + deviceIdToDelete, {
                    '_token': "{{ csrf_token() }}",
                    '_method': "DELETE",
                    'otp': otp
                }).then((response) => {
                    document.getElementById('otpDeleteAuthorization').classList.add('hidden');
                    deviceIdToDelete = null
                    window.location.reload()
                    return;
                })
                .catch((error) => {
                    console.error('Error:', error);
                    errorMessage.innerText = 'Invalid OTP';
                    Swal.fire({
                        title: 'Error!',
                        text: 'OTP Invalid: ' + (error.response.data.error, error.message),
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    errorMessage.textContent = error.response.data.error;
                    errorContainer.classList.remove('hidden');
                    return;
                })
        }

        if (deviceIdToDelete) {
            document.getElementById('otpDeleteAuthorization').classList.remove('hidden');
            document.getElementById('confirmDeleteModal').classList.add('hidden'); // Hide confirmation modal

            let formData = new FormData();

            formData.append('_token', "{{ csrf_token() }}")
            formData.append('_method', "DELETE")

            try {
                const response = fetch('/devices/' + deviceIdToDelete, {
                    method: 'POST',
                    headers: {
                        'X-Requested-with': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = response.json();

                console.log(result)
            } catch (error) {
                console.error('Error:', error);
                // Swal.fire({
                //     title: 'Error!',
                //     text: 'Perangkat gagal dihapus: ' + error,
                //     icon: 'error',
                //     confirmButtonText: 'OK'
                // });
            }

            return;
        }
    }

    function openSendMessageModal(deviceToken) {
        document.getElementById('deviceToken').value = deviceToken;
        document.getElementById('sendMessageModal').classList.remove('hidden');
        clearError(); // Bersihkan error saat modal dibuka
    }

    function closeSendMessageModal() {
        document.getElementById('sendMessageModal').classList.add('hidden');
        clearError(); // Bersihkan error setelah modal ditutup
    }

    function closeOtpDeleteAuthorization() {
        document.getElementById('otpDeleteAuthorization').classList.add('hidden');
        clearError(); // Bersihkan error setelah modal ditutup
    }

    function clearError() {
        const errorContainer = document.getElementById('errorContainer');
        const errorMessage = document.getElementById('errorMessage');
        errorContainer.classList.add('hidden');
        errorMessage.textContent = '';
    }

    document.getElementById('otpAuthorizationForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        deleteDevice(formData.get('otp'))
    })

    document.getElementById('sendMessageForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const deviceToken = formData.get('device_token');
        const sendButton = document.getElementById('sendMessageButton');
        const buttonText = document.getElementById('buttonText');
        const spinner = document.getElementById('spinner');

        // Aktifkan animasi loading
        buttonText.textContent = 'Sending...';
        spinner.classList.remove('hidden');
        sendButton.disabled = true;

        try {
            const response = await fetch('/send-message', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Authorization': deviceToken, // Token dikirim di header
                },
                body: formData,
            });

            const result = await response.json();

            if (response.ok) {
                Swal.fire({
                    title: 'Success!',
                    text: 'Pesan Berhasil Dikirim!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                //alert('Pesan berhasil dikirim!');
                closeSendMessageModal(); // Tutup modal jika berhasil
            } else {
                // Tampilkan error di modal jika gagal
                // showError(result.error || 'Gagal mengirim pesan.');
                Swal.fire({
                    title: 'Error!',
                    text: 'Pesan Gagal Dikirim. Ulangi...',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Terjadi kesalahan. Coba lagi.');
        } finally {
            // Kembalikan tombol ke keadaan semula
            buttonText.textContent = 'Send';
            spinner.classList.add('hidden');
            sendButton.disabled = false;
        }
    });

    function showSuccess(message) {
        const messageContainer = document.getElementById('messageAlert');
        messageContainer.innerHTML = `<div class="p-4 mb-4 text-green-800 bg-green-100 rounded">${message}</div>`;
    }

    function showError(message) {
        const errorContainer = document.getElementById('errorContainer');
        const errorMessage = document.getElementById('errorMessage');
        errorMessage.textContent = message;
        errorContainer.classList.remove('hidden');
    }

    function copyToClipboard(token) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(token).then(() => {
                showNotification(token);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement("textarea");
            textArea.value = token;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                console.log('Fallback: Token copied successfully');
                showNotification(token);
            } catch (err) {
                console.error('Fallback: Failed to copy', err);
            }
            document.body.removeChild(textArea);
        }
    }

    function showNotification(token) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');
        if (notification && notificationMessage) {
            notificationMessage.innerText = 'Token copied to clipboard: ' + token;
            notification.classList.remove('hidden'); // Show the notification

            setTimeout(() => {
                notification.classList.add('hidden');
            }, 2000);
        }
    }
</script>