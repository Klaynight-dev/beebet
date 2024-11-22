document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.getElementById('profile-image');
    const logoutButton = document.getElementById('logout-button');

    fetch('session_data.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                profileImage.src = data.avatar_url;
                document.querySelector('.coins').textContent = '$' + data.coins;
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des données de session:', error));

    profileImage.addEventListener('click', function() {
        window.location.href = 'profil.php';
    });

    logoutButton.addEventListener('click', function() {
        localStorage.removeItem('userToken');
        document.getElementById("login-button").style.display = "block"; 
        document.querySelector('.profile-section').style.display = 'none';
        document.querySelector('.coins').textContent = '$0';
    });

    const token = localStorage.getItem('userToken');
    if (token) {
        document.getElementById("login-button").style.display = "none"; 
        document.querySelector('.profile-section').style.display = 'flex';
        updateBalance();
    }

    document.getElementById("login-button").addEventListener("click", function() {
        const hidden = document.querySelector('.hidden');
        hidden.classList.replace('.hidden', 'login-box');
        hidden.classList.replace('.hidden', 'blur-background');

        blurBackground.addEventListener('click', function() {
            document.querySelector(".blur-background").classList.add(".hidden");
            document.querySelector(".login-box").classList.add(".hidden");
        });
    });

    document.getElementById("submit-login-button").addEventListener("click", function() {
        const token = document.getElementById('token').value;

        fetch('login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token: token }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.setItem('userToken', token);
                document.getElementById("login-button").style.display = "none"; 
                document.querySelector('.profile-section').style.display = 'flex';
                document.querySelector('.coins').textContent = '$' + data.coins;
                profileImage.src = data.avatar_url;
                document.querySelector('.login-box').classList.add('.hidden');
                document.querySelector('.blur-background').classList.add('.hidden');
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    });

    function updateBalance() {
        const token = localStorage.getItem('userToken');
        fetch('get_balance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ token: token }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur HTTP ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.coins !== undefined) {
                document.querySelector('.coins').textContent = `$${data.coins}`;
            } else {
                console.error('Erreur lors de la mise à jour du solde:', data.error);
            }
        })
        .catch(error => console.error('Erreur lors de la mise à jour du solde:', error));
    }

    updateBalance();
});