
document.addEventListener("DOMContentLoaded", () => {
    let tabs = document.querySelectorAll(".tabs h3 a");

    Array.from(tabs).forEach(tab => {
        tab.addEventListener('click', function (event) {
            event.preventDefault();

            document.querySelector(".tabs > h3 > a.active").classList.remove('active');
            event.target.classList.add('active');

            document.querySelector(".tabs-content div.active").classList.remove('active');

            const targetPath = event.target.getAttribute('href');
            document.querySelector(".tabs-content div[id='" + targetPath.substr(1) + "']").classList.add('active');
        });
    });

    const regUserBtn = document.getElementById('regUser');
    const authUserBtn = document.getElementById('authUser');

    regUserBtn.addEventListener('click', function (event) {
        event.preventDefault();

        const regForm = document.forms.regForm;
        const formData = new FormData(regForm);
        console.log(regForm);
        try {
            let response = fetch('index/registerUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: formData
            })
            .then(response => response.json());
            console.log(response);
        } catch (error) {
            console.error('Ошибка:', error);
        }

    });


    authUserBtn.addEventListener('click', function (event) {
        event.preventDefault();

        const authForm = document.forms.authForm;
        const formData = new FormData(authForm);

        try {
            let response = fetch('index/authUser', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: authForm
            })
            .then(response => response.json());
            console.log(response);
        } catch (error) {
            console.error('Ошибка:', error);
        }

    });


});

